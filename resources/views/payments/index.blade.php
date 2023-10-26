<?php

use App\Models\User;
?>

<x-app-layout>

  <x-slot name="title">
    Lista de pagamentos
    <a href="{{route('payments.create')}}" class="btn btn-success btn-icon-split">
      <span class="icon text-white-50">
        <i class="fas fa-plus"></i>
      </span>
      <span class="text">Criar</span>
    </a>
  </x-slot>

  @if (session('status'))
  <div class="alert alert-success">
    {{session('status')}}
  </div>
  @endif

  <div class="card">
    <div class="card-body">

      <form id="payment-filter-form" action="">
        @csrf

        <div class="row mb-3">
          @role('admin')
          <div class="col-3">
            <select class="form-control" name="rep_id">
              <option value="">Filtrar por promotor</option>
              @foreach(User::whereRoleIs('rep')->get() as $rep)
              <option value="{{$rep->id}}" @if(Request::get('rep_id')==$rep->id) selected @endif>{{$rep->name}}</option>
              @endforeach
            </select>
          </div>
          @endrole
          
          <div class="col">
            <div class="form-check form-check-inline">
              <label class="mx-2" for="from">De</label>
              <input class="form-control" id="from" name="from" value="{{ Request::get('from') }}" autocomplete="off">
              <label class="mx-2" for="to">a</label>
              <input class="form-control" id="to" name="to" value="{{ Request::get('to') }}" autocomplete="off">
            </div>
          </div>
        </div>
      </form>

      <table id="payment-list" class="display">
        <thead>
          <tr>
            <th>#</th>
            <th>Valor</th>
            <th>Pago em</th>
            <th>Diário de Empréstimo</th>
            <th>Nome do promotor</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
          <tfoot>
	    	<th></th>
	    	<th></th>
	    	<th></th>
	    	<th></th>
	    	<th></th>
	    </tfoot>
      </table>
    </div>
  </div>

  @section('styles')
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
  @endsection

  @section('scripts')
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.11.5/api/sum().js"></script>


  <script>
    $(document).ready(function() {
      var table = $('#payment-list').DataTable({
        ajax: {
          url: "{!! url()->current().'?'.http_build_query(array_merge(request()->all(),['ajax'=>true])) !!}",
          dataSrc: 'payments'
        },
        
                drawCallback: function () {
		      var api = this.api();
		      var sum = 0;
		      var formated = 0;
		      //to show first th
		      $(api.column(0).footer()).html('Total');

		      //for(var i=1; i<=4;i++)
		      //{
		        var i=1;
		        
		      	sum = api.column(i, {page:'current'}).data().sum();
		      	//to format this sum
		      	formated = parseFloat(sum).toLocaleString(undefined, {minimumFractionDigits:2});
		      	$(api.column(i).footer()).html(formated+' MZN');
		  // }
		      
		      
		    },
        
        columns: [{
            data: 'id'
          },
          {
            data: 'amount',
            className: 'dt-body-right',
            render: $.fn.dataTable.render.number(',', '.', 2, 'MZN ')
          },
          {
            data: 'created_at'
          },
          {
            data: 'loan.rental',
            className: 'dt-body-right',
            render: $.fn.dataTable.render.number(',', '.', 2, 'MZN ')
          },
          {
            data: 'rep.name'
          },
        ]
      });


      $('#payment-list tbody').on('click', 'tr', function() {
        var data = table.row(this).data();

        window.location.href = `{{route('payments.index')}}/${data.id}`;
      });

      var dateFormat = "yy-mm-dd",
        datePickerOptions = {
          numberOfMonths: 2,
          dateFormat
        },
        from = $("#from")
        .datepicker(datePickerOptions)
        .on("change", function() {
          to.datepicker("option", "minDate", getDate(this));
        }),
        to = $("#to")
        .datepicker(datePickerOptions)
        .on("change", function() {
          from.datepicker("option", "maxDate", getDate(this));
        });

      function getDate(element) {
        var date;
        try {
          date = $.datepicker.parseDate(dateFormat, element.value);
        } catch (error) {
          date = null;
        }

        return date;
      }

      $('[name="rep_id"]').change(function() {
        $('#payment-filter-form').submit();
      });

      $('#from, #to').change(function() {
        if ($('#from').val() == "" || $('#to').val() == "") return;

        $('#payment-filter-form').submit();
      })
    });
  </script>
  @endsection
</x-app-layout>