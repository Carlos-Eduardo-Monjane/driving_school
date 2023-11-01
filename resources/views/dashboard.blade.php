<?php

use Illuminate\Support\Carbon;
use App\Libraries\Common;
?>
<x-app-layout>

  <x-slot name="title">
    Visão Geral
  </x-slot>

  @if (session('status'))
  <div class="alert alert-success">
    {{session('status')}}
  </div>
  @endif
  <div class="row">
    <div class="col-xl-1 col-md-6 mb-4">
   
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                Todos Pagamentos  </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{number_format($paymentTotal, 2)}} MZN</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-calendar fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                Pagamentos do mês </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{number_format($monthPaymentTotal, 2)}} MZN</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-calendar fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                Alunos activos
              </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalActiveCustomers}}</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-user fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-1 col-md-6 mb-4">
   
    </div>

  </div>

{{-- Grafico --}}
  <div class="row my-3">
    <div class="col">
      <div class="card">
        <div class="card-header">
          <h6 class="font-weight-bold text-primary">Desempenho geral</h6>
        </div>
        <div class="card-body">
          <canvas id="grafico-pagamentos"></canvas>
        </div>
      </div>
    </div>
  </div>
{{--  --}}





  @section('scripts')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
    // Seu JSON de pagamentos
    var pagamentos =  @json($pagamentos);

    var meses = [
            "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho",
            "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"
        ];
        var totalPorMes = new Array(12).fill(0);
        
    pagamentos.forEach(function(pagamento) {
        var data = new Date(pagamento.created_at);
        var mes = data.getMonth();
        totalPorMes[mes] += pagamento.amount;
    });
// Criar o gráfico de barras
var ctx = document.getElementById('grafico-pagamentos').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: meses,
        datasets: [{
            label: 'Total de Pagamentos',
            data: totalPorMes,
            backgroundColor: 'rgba(75, 000, 192, 0.2)',
            borderColor: 'rgba(000, 000, 000, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Total de Pagamentos'
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Mês'
                }
            }
        },
        plugins: {
            legend: {
                display: true, // Exibir a legenda
                position: 'top', // Posição da legenda (pode ser 'top', 'bottom', 'left', 'right')
            }
        },
        maintainAspectRatio: false, // Reduz a altura do gráfico
        responsive: true, // Permite que o gráfico seja responsivo
        height: 500, 
    }
});


</script>

  @endsection
</x-app-layout>