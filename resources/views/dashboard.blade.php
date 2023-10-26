<?php

use Illuminate\Support\Carbon;
use App\Libraries\Common;
?>
<x-app-layout>

  <x-slot name="title">
    Dashboard
  </x-slot>

  @if (session('status'))
  <div class="alert alert-success">
    {{session('status')}}
  </div>
  @endif
  <div class="row">
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
                 TOTAL DE EMPRÉSTIMOS</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{number_format($monthlyTotalLoanValue, 2)}} MZN</div>
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
                EMPRÉSTIMOS ATIVOS</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalActiveLoans}}</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-file-invoice-dollar fa-2x text-gray-300"></i>
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
                CLIENTES ATIVOS</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalActiveCustomers}}</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-user fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
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
          <div id="overall-payments-vs-loans"></div>
        </div>
      </div>
    </div>
  </div>
{{--  --}}
  <div class="row">
    <div class="col">
      <div class="card">
        <div class="card-header">
          <h6 class="font-weight-bold text-primary">Pagamentos recebidos hoje</h6>
        </div>
        <div class="card-body">
          @if($dailyPayments->count() == 0)
          Nada
          @else
          <ul>
            @foreach($dailyPayments as $payment)
            <li>{{$payment->loan->customer->full_name}} - MZN {{$payment->amount}}</li>
            @endforeach
          </ul>
          @endif
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card">
        <div class="card-header">
          <h6 class="font-weight-bold text-primary">Pagamentos a receber hoje</h6>
        </div>
        <div class="card-body">
          @if($unpaidCustomers->count() == 0)
          Nada
          @else
          <ul>
            @foreach($unpaidCustomers as $loan)
            <li>{{$loan->customer->full_name}} -  MZN {{$loan->daily_rental}}</li>
            @endforeach
          </ul>
          @endif
        </div>
      </div>
    </div>
  </div>



  @section('scripts')
  <script src="https://code.highcharts.com/highcharts.js"></script>

  <script>
    $(document).ready(function() {
      var overallPaymentsVSLoans = chartData(<?php echo json_encode($overallPaymentsVSLoans) ?>);

      let seriesData = [
        overallPaymentsVSLoans.months,
        [{
            name: 'Empréstimos',
            data: overallPaymentsVSLoans.loans
          },
          {
            name: 'Pagamentos',
            data: overallPaymentsVSLoans.payments
          }
          
        ]
      ];

      Highcharts.chart('overall-payments-vs-loans', {
        chart: {
          type: 'column'
        },
        title: {
          text: '',
        },
        xAxis: {
          categories: seriesData[0]
        },
        yAxis: {
          min: 0,
          title: {
            text: 'Valor (MZN)'
          }
        },
        series: seriesData[1]
      });

      function chartData(data) {
        var monthArray = [];
        var paymentData = [];
        var loanData = [];

        $.map(data.loans, function(val) {
          loanData.push(val.sum);
        });

        $.map(data.payments, function(val) {
          monthArray.push(val.month);
          paymentData.push(val.sum);
        });

        return {
          months: monthArray,
          payments: paymentData,
          loans: loanData
        };
      }
    });
  </script>
  @endsection
</x-app-layout>