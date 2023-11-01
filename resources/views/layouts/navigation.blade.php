<?php

use Illuminate\Support\Str; ?>

<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav">

        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <span class="btn btn-dark">Início</span>
            </a>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Botão Novo Aluno -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('customers.create') }}">
                <span class="btn btn-danger">Novo Aluno</span>
            </a>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>
        <!-- Botão Lista de Alunos -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('customers.index') }}">
                
                <span class="btn btn-danger">Lista de Alunos</span>
            </a>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>
        
        <!-- Botão  de Novo Pagamentos -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('payments.create') }}">
                <span class="btn btn-danger">Fazer Pagamento</span>
            </a>
        </li>

        <!-- Botão Todos os Pagamentos -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('payments.index') }}">
                <span class="btn btn-danger">Todos Pagamentos</span>
            </a>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('tipos_carta_conducao.index') }}">
                <span class="btn btn-info">Configurações</span>
            </a>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>
        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{auth()->user()->username}}</span>
                <img class="img-profile rounded-circle" src="https://dummyimage.com/100x100/000/fff&text={{Str::limit(Str::upper(auth()->user()->username),1,'')}}">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Sair

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </a>
            </div>
        </li>

    </ul>

</nav>
<!-- End of Topbar -->
