<x-app-layout>

  <x-slot name="title">
    Lista de alunos
    <a href="{{route('customers.create')}}" class="btn btn-success btn-icon-split">
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
      <table id="customer-list" class="display">
        <thead>
          <tr>
            <th>Ficha Nr</th>
            <th>Nome Completo</th>
            <th>Carta</th>
            <th>Valor a pagar</th>
            <th>Valor pago</th>
            <th>Valor pendente</th>
            <th>Endereço</th>
            <th>Endereço</th>
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
          <th></th>
          <th></th>
          <th></th>
        </tfoot>
      </table>
    </div>
  </div>

  @section('scripts')
  <script>
    <script src="{{asset('lib/moment/moment.min.js')}}"></script>
  	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.11.5/api/sum().js"></script>

  <script>
    $(document).ready(function() {
        
      var table = $('#customer-list').DataTable({
        ajax: {
          url: '{{route("customers.index",["ajax"=>true])}}',
          dataSrc: 'customers'
        },
        drawCallback: function () {
		      var api = this.api();
		      var sum = 0;
		      var formated = 0;
		      //to show first th
		      $(api.column(0).footer()).html('Total');

		      for(var i=3; i<=5;i++)
		      {
		          
		      	sum = api.column(i, {page:'current'}).data().sum();
		      	//to format this sum
		      	formated = parseFloat(sum).toLocaleString(undefined, {minimumFractionDigits:2});
		      	$(api.column(i).footer()).html(formated+' MZN');
		   }
		      
		      
		    },
        
        
        columns: [{
            data: 'id'
          },
          {
            data: 'full_name'
          },
          {
            data: 'carta_nome'
          },
          {
            data: 'custo_total',
            className: 'dt-body-left',
            render: $.fn.dataTable.render.number(',', '.', 2, ' MZN ')
          },
          {
            data: 'pago',
            className: 'dt-body-left',
            render: $.fn.dataTable.render.number(',', '.', 2, ' MZN ')
          },
          {
            data: 'pendente',
            className: 'dt-body-left text text-warning',
            render: $.fn.dataTable.render.number(',', '.', 2, ' MZN ')
          },
          
          {
            data: 'phone_num'
          },
          {
            data: 'address'
          },
          
          
        ]
      });


      $('#customer-list tbody').on('click', 'tr', function() {
        var data = table.row(this).data();

        window.location.href = `{{route('customers.index')}}/${data.id}`;
      });
      

  
  
    });
  </script>

  






  </script>
  @endsection
</x-app-layout>