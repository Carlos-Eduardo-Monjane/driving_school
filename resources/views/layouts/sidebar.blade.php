<?php

use App\Libraries\Common;

?>

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('dashboard')}}">
        <div class="sidebar-brand-text mx-3">
            <x-application-logo class="fill-current text-gray-500 rounded-md" width="200" />
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('dashboard')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item @if(Common::isRoute('customers')) active @endif">
        <a class="nav-link @if(!Common::isRoute('customers')) collapsed @endif" href="#" data-toggle="collapse" data-target="#collapseCustomers" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-user"></i>
            <span>Clientes</span>
        </a>
        <div id="collapseCustomers" class="collapse @if(Common::isRoute('customers')) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{route('customers.index')}}">Listar todos</a>
                <a class="collapse-item" href="{{route('customers.create')}}">Criar</a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider">

    <li class="nav-item @if(Common::isRoute('loans')) active @endif">
        <a class="nav-link @if(!Common::isRoute('loans')) collapsed @endif" href="#" data-toggle="collapse" data-target="#collapseLoans" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-money-bill"></i>
            <span>Empréstimos</span>
        </a>
        <div id="collapseLoans" class="collapse @if(Common::isRoute('loans')) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{route('loans.index')}}">Listar todos</a>
                {{-- <a class="collapse-item" href="{{route('loans.opened')}}">Listar Abertos</a>
                <a class="collapse-item" href="{{route('loans.closed')}}">Listar Fechados</a> --}}
                <a class="collapse-item" href="{{route('loans.create')}}">Criar</a>
            </div>
        </div>
    </li>
    <li class="nav-item @if(Common::isRoute('payments')) active @endif">
        <a class="nav-link @if(!Common::isRoute('payments')) collapsed @endif" href="#" data-toggle="collapse" data-target="#collapsePayments" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-file-invoice-dollar"></i>
            <span>Pagts de empréstimos</span>
        </a>
        <div id="collapsePayments" class="collapse @if(Common::isRoute('payments')) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{route('payments.index')}}">Listar todos</a>
                <a class="collapse-item" href="{{route('payments.create')}}">Add pagamento</a>
            </div>
        </div>
    </li>

    @role('admin')
    <hr class="sidebar-divider">

    <li class="nav-item @if(Common::isRoute('users')) active @endif">
        <a class="nav-link @if(!Common::isRoute('users')) collapsed @endif" href="#" data-toggle="collapse" data-target="#collapseUsers" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-user"></i>
            <span>Promotores</span>
        </a>
        <div id="collapseUsers" class="collapse @if(Common::isRoute('users')) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{route('users.index')}}">Listar todos</a>
                <a class="collapse-item" href="{{route('users.create')}}">Criar</a>
            </div>
        </div>
    </li>
    <li class="nav-item @if(Common::isRoute('commissions')) active @endif">
        <a class="nav-link @if(!Common::isRoute('commissions')) collapsed @endif" href="#" data-toggle="collapse" data-target="#collapseCommissions" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-file-invoice-dollar"></i>
            <span>Comissões de promtr.</span>
        </a>
        <div id="collapseCommissions" class="collapse @if(Common::isRoute('commissions')) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{route('commissions.index')}}">Listar todos</a>
                <a class="collapse-item" href="{{route('commissions.create')}}">Fazer o pagamento</a>
            </div>
        </div>
    </li>
    @endrole
    
    <hr class="sidebar-divider">

    {{-- <li class="nav-item @if(Common::isRoute('reports')) active @endif">
        <a class="nav-link @if(!Common::isRoute('reports')) collapsed @endif" href="#" data-toggle="collapse" data-target="#collapseReports" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-scroll"></i>
            <span>Relatórios</span>
        </a>
        <div id="collapseReports" class="collapse @if(Common::isRoute('reports')) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('reports.show', 'excess') }}">Relatório de Excesso</a>
                <a class="collapse-item" href="{{ route('reports.show', 'arrears') }}">Relatório de Activos</a>
            </div>
        </div>
    </li> --}}

</ul>
<!-- End of Sidebar -->