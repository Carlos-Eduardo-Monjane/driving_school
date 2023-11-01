<?php use App\Models\User; ?>

<x-app-layout>

  <x-slot name="title">
    Tipos de Carta de Condução
    <a href="{{ route('tipos_carta_conducao.create') }}" class="btn btn-success btn-icon-split">
      <span class="icon text-white-50">
        <i class="fas fa-plus"></i>
      </span>
      <span class="text">Criar</span>
    </a>
  </x-slot>

  <div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Custo</th>
                    <th colspan="3">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tiposCartaConducao as $tipoCarta)
                    <tr>
                        <td>{{ $tipoCarta->id }}</td>
                        <td>{{ $tipoCarta->name }}</td>
                        <td>{{ $tipoCarta->custo }}</td>
                        <td >
                            <a href="{{ route('tipos_carta_conducao.show', $tipoCarta->id) }}" class="btn btn-info">Ver</a>
                            
                        </td>
                        <td >
                            <a href="{{ route('tipos_carta_conducao.edit', $tipoCarta->id) }}" class="btn btn-warning">Editar</a>
                            
                        </td>
                        <td >
                            <form action="{{ route('tipos_carta_conducao.destroy', $tipoCarta->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
  </div>

</x-app-layout>
