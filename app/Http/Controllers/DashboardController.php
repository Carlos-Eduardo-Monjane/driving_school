<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Payment;
use App\Models\User;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    /**
     * Display dashboard reports
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = User::find(Auth::id());


        $startOfTheMonth = Carbon::now()->startOfMonth()->format('Y-m-d 00:00:00');
        $endOfTheMonth = Carbon::now()->endOfMonth()->format('Y-m-d 23:59:59');

        $startOfTheDay = Carbon::now()->format('Y-m-d 00:00:00');
        $endOfTheDay = Carbon::now()->format('Y-m-d 23:59:59');

        $monthPaymentTotal = Payment::whereBetween('created_at', [
                $startOfTheMonth,
                $endOfTheMonth
            ]);

            $totalActiveCustomers = Customer::all()->count();

            $monthPaymentTotal = $monthPaymentTotal->sum('amount');

            

            $totalActiveCustomers = Customer::all()->count();

            $pagamentos = Payment::all();

            $paymentTotal = $pagamentos->sum('amount');
       

        return view('dashboard', compact(
            'monthPaymentTotal',
            'paymentTotal',
            'totalActiveCustomers',
            'pagamentos'
        ));
    }
}
