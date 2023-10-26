<?php

use App\Models\Customer;

$isEdit = !empty($customer);
?>


<x-app-layout>
    <x-slot name="title">
        @if(!$isEdit)Criar um @else Editar @endif cliente
    </x-slot>

    @if (session('status'))
    <div class="alert alert-success">
        O cliente foi @if(!$isEdit) criado com sucesso. @else editado com sucesso. @endif <u><a href="{{route('customers.index')}}">Ver a lista</a></u>
    </div>
    @endif

    <div class="row">
        <div class="col-8 mx-auto">
            <div class="card">
                <div class="card-body">

                    <form action="{{route('customers.store')}}" method="POST">
                        @csrf

                        @if($isEdit)
                        <input type="hidden" name="id" value="{{$customer->id}}" />
                        @endif

                        @foreach(Customer::entityFields() as $field)
                        <div class="row mt-2">
                            <div class="col-12 col-md-3">
                                <label class="col-form-label">{{@$field['label']}}</label>
                            </div>
                            <div class="col">
                                <input class="form-control @error($field['name']) border border-danger @enderror" name="{{$field['name']}}" {{@$field['attributes']}} value="@if($isEdit){{ $customer[$field['name']] }}@else{{ old($field['name']) }}@endif">
                            </div>
                        </div>
                        @endforeach
                        <div class="row mt-3">

                            <div class="col text-center">
                                <button type="submit" class="btn btn-block btn-primary">Submeter</button>
                            </div>
                            @if($isEdit)
                            <div class="col-1 text-center">
                                <a href="#" class="btn btn-danger" onclick="triggerDeleteForm(event, 'customer-delete-form')"><i class="fa fa-trash"></i> Deletar</a>
                            </div>
                            @endif
                        </div>
                    </form>
                    @if($isEdit)
                    <form id="customer-delete-form" action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="d-none">
                        @method('DELETE')
                        @csrf
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>