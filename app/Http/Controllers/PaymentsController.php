<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Payment;
use App\Models\User;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \PDF;


class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (empty($request->ajax))
            return view('payments.index');

        $user = User::find(Auth::id());

        $payments = Payment::all();


        return compact('payments');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Obtenha a lista de alunos para preencher o campo de seleção
        $alunos = Customer::all(); // Ou outra forma de obter a lista de alunos
    
        return view('payments.form', [
            'alunos' => $alunos, // Passe a lista de alunos para a view
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        // return;
  
        $isEdit = !empty($request->id);

        $request->validate([
            'amount' => 'required',
        ]);

        $payment = $isEdit ? Payment::find($request->id) : new Payment();

        $payment->aluno_id = $request->aluno_id;
        $payment->amount = $request->amount;
        $payment->obs = $request->obs;
        $payment->id_user_login = Auth::user()->id;

        $payment->name = $request->aluno_name;
        $payment->carta = $request->carta;



        // "total_da_carta" => "5,000.00 MZN"
        // "total_pago" => "0.00 MZN"
        // "total_pedente" => "0.00 MZN"
        

        if($payment->save()){

           $aluno = Customer::find($request->aluno_id);
           $aluno->pago = $aluno->pago + $request->amount;
           $aluno->pendente = $aluno->pendente - $request->amount;
           $aluno->save();

        }else{
            return redirect()->back()->with('status', 'Erro');
        }

        return redirect()->back()->with('status', $payment);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        return view('payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     *@param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        return view('payments.form', compact('payment'));
    }

    public function edit1(Payment $payment)
{
    // Obtenha a lista de alunos para preencher o campo de seleção
    $alunos = Customer::all(); // Ou outra forma de obter a lista de alunos

    return view('payments.edit', [
        'payment' => $payment, // Passe o pagamento a ser editado para a view
        'alunos' => $alunos, // Passe a lista de alunos para a view
    ]);
}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('payments.index')->with('status', "Payment ID #$payment->id was deleted.");
    }

    /**
     * Return payment receipt in PDF
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function receipt(Payment $payment)
    {
        $user = User::find(Auth::id());
        if ($user->hasRole('rep') && $payment->rep_id != $user->id)
            return abort(403);

        $loanStart = $payment->loan->start_date->format('Y-m-d 00:00:00');
        $endOfToday = Carbon::now()->format('Y-m-d 23:59:59');

        $totalPaid = Loan::find($payment->loan->id)
            ->payments
            ->sum('amount');

        $paidToday = Loan::find($payment->loan->id)
            ->payments
            ->whereBetween('created_at', [$loanStart, $endOfToday])
            ->sum('amount');

        $now = Carbon::now();
        $dayDiff = $payment->loan->start_date->diffInDays($now);

        $arrears = $dayDiff * $payment->loan->daily_rental;

        $pdf = PDF::loadView('payments.invoice', compact('payment', 'totalPaid', 'paidToday', 'arrears'));
        return $pdf->download("invoice-{$payment->id}-{$payment->created_at}.pdf");
    }
}
