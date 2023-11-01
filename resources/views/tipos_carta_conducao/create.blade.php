<?php

use App\Models\Customer;
use App\Models\Guarantor;
use App\Models\User;
use Illuminate\Support\Facades\Request;

?>


<x-app-layout>
    <x-slot name="title">
        Adicionar Novo Tipo de Carta de Condução
    </x-slot>

    @if (session('status'))
    <div class="alert alert-success">
         @if(!$isEdit) Criado. @else Editado. @endif 
    </div>
    @endif

   
    <form method="post" action="{{ route('tipos_carta_conducao.store') }}">
        @csrf
        <div class="form-group">
            <label for="name">Nome:</label>
            <input type="text" name="name" class="form-control">
        </div>
        <div class="form-group">
            <label for="custo">Custo:</label>
            <input type="number" name="custo" class="form-control">
        </div>
        <div class="form-group">
            <label for="description">Descrição:</label>
            <input type="text" name="description" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Adicionar Tipo de Carta</button>
    </form>




</x-app-layout>