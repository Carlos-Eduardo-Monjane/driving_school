<?php

use App\Models\Customer;
use App\Libraries\Common;
?>
<x-app-layout>

    <x-slot name="title">
        Cliente #{{$customer->id}}
        <a href="{{route('customers.edit', $customer->id)}}" class="btn btn-success btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-edit"></i>
            </span>
            <span class="text">Editar</span>
        </a>
    </x-slot>

    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-body">
                    @foreach(Customer::entityFields() as $field)
                    <div class="row mt-2">
                        <div class="col-12 col-md-3">
                            <label class="col-form-label font-weight-bold">{{ @$field['label'] }}</label>
                        </div>
                        <div class="col mt-2">
                            : {{ $customer[$field['name']] }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
            <div class="card-header">
                    <h6 class="font-weight-bold text-primary">Empréstimos Contínuos</h6>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @if($customer->loans->count() == 0)
                        <li class="list-group-item">Sem empréstimos ativos</li>
                        @else
                        @foreach($customer->loans as $loan)
                        @if(!$loan->is_active) @continue @endif
                        <li class="list-group-item">
                            <a href="{{ route('loans.show', $loan->id )}}">
                                @if($loan->is_an_overdue_loan)
                                {{ $loan->full_loan_amount }} MZN - imediatamente
                                @else
                                {{ $loan->loan_amount }} MZN :  {{ ceil($loan->full_loan_amount / $loan->installments)  }} MZN em {{ $loan->installments }} dias ({{ $loan->full_loan_amount }} MZN) 
                                @endif
                            </a>
                        </li>
                        @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>