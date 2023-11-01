<?php

use App\Models\Customer;
use App\Models\Guarantor;
use App\Models\User;
use Illuminate\Support\Facades\Request;

?>


<x-app-layout>
    <x-slot name="title">
        Editar Tipo de Carta de Condução
    </x-slot>


    <form method="post" action="{{ route('tipos_carta_conducao.update', $tipoCartaConducao->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nome:</label>
            <input type="text" name="name" value="{{ $tipoCartaConducao->name }}" class="form-control">
        </div>
        <div class="form-group">
            <label for="custo">Custo:</label>
            <input type="number" name="custo" value="{{ $tipoCartaConducao->custo }}" class="form-control">
        </div>
        <div class="form-group">
            <label for="description">Descrição:</label>
            <input type="text" name="description" value="{{ $tipoCartaConducao->description }}" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Atualizar Tipo de Carta</button>
    </form>




</x-app-layout>