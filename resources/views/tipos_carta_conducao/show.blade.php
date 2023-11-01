<?php

use App\Models\Customer;
use App\Models\Guarantor;
use App\Models\User;
use Illuminate\Support\Facades\Request;

?>


<x-app-layout>
    <x-slot name="title">
        Detalhes do Tipo de Carta de Condução
    </x-slot>


    <p><strong>Nome:</strong> {{ $tipoCartaConducao->name }}</p>
    <p><strong>Custo:</strong> {{ $tipoCartaConducao->custo }}</p>
    <p><strong>Descrição:</strong> {{ $tipoCartaConducao->description }}</p>

    <a href="{{ route('tipos_carta_conducao.edit', $tipoCartaConducao->id) }}" class="btn btn-warning">Editar</a>
    <form action="{{ route('tipos_carta_conducao.destroy', $tipoCartaConducao->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Excluir</button>
    </form>





</x-app-layout>