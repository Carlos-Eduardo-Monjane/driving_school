<?php

use App\Models\Customer;
use App\Libraries\Common;
?>
<x-app-layout>

    <x-slot name="title">
        aluno #{{$customer->id}}
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
    </div>
</x-app-layout>