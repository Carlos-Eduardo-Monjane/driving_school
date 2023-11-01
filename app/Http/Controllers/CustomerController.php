<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use App\Models\TipoCartaConducao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (empty($request->ajax))
            return view('customers.index');

        $user = User::find(Auth::id());

        $customers = $user->hasRole('rep') ? $user->customers : Customer::all();

        return compact('customers');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customers.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $isEdit = !empty($request->id);

        $request->validate([
            'full_name' => ['required', 'max:255'],
            'nic' => 'required',
            'email' => 'email' . $isEdit ? '' : '|unique:customers'
        ]);

        $customer = $isEdit ? Customer::find($request->id) : new Customer();

        $tipoCartaConducao = TipoCartaConducao::find($request->carta);


        $customer->full_name = $request->full_name;
        $customer->email = $request->email;
        $customer->nic = $request->nic;
        $customer->address = $request->address;
        $customer->address_nic = $request->address_nic;
        $customer->address_bus = $request->address_bus;
        $customer->profession = $request->profession;
        $customer->phone_num = $request->phone_num;
        $customer->carta = $request->carta;


        if ($tipoCartaConducao) {
            $customer->custo_total = $tipoCartaConducao->custo;
            $customer->carta_nome = $tipoCartaConducao->name;

            $customer->pendente = $tipoCartaConducao->custo;
        }
        $customer->id_user_login = Auth::user()->id;

        $customer->save();

        return redirect()->back()->with('status', "success");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }



public function showAluno($id)
{
    $aluno = Customer::find($id);

    if (!$aluno) {
        return response()->json(['error' => 'Aluno não encontrado'], 404);
    }

    return response()->json(['aluno' => $aluno]);
}


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return view('customers.form', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')->with('status', "$customer->full_name was deleted.");
    }
}
