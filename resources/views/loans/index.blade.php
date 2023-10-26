<x-app-layout>

  <x-slot name="title">
    Lista de empréstimos
    <a href="{{route('loans.create')}}" class="btn btn-success btn-icon-split">
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
      <table id="loan-list" class="display">
        <thead>
          <tr>
            <th>#</th>
            <th>Cliente</th>
            <th>Credito</th>
            <th>A pagar</th>
            <th>Valor Pedente</th>
            <th>Juros</th>
            <th>Diário</th>
            <th>Dias</th>

            <th>Início</th>
            <th>Vencimento</th>
            <th>Status</th>
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
	    	<th></th>
	    	<th></th>
        <th></th>
	    </tfoot>
      </table>
    </div>
  </div>

  @section('scripts')
  <script src="{{asset('lib/moment/moment.min.js')}}"></script>
  	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.11.5/api/sum().js"></script>

  <script>
    $(document).ready(function() {
        
      var table = $('#loan-list').DataTable({
        ajax: {
          url: '{{route("loans.index",["ajax"=>true])}}',
          dataSrc: 'loans'
        },
        drawCallback: function () {
		      var api = this.api();
		      var sum = 0;
		      var formated = 0;
		      //to show first th
		      $(api.column(0).footer()).html('Total');

		      for(var i=2; i<=4;i++)
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
            data: 'customer.full_name'
          },
          {
            data: 'loan_amount',
            className: 'dt-body-right',
            render: $.fn.dataTable.render.number(',', '.', 2, ' MZN ')
          },
               {
            data: 'total_to_be_paid',
            className: 'dt-body-right',
            render: $.fn.dataTable.render.number(',', '.', 2, ' MZN ')
          },
          {
            data: 'outstanding_amount',
            className: 'dt-body-right',
            render: $.fn.dataTable.render.number(',', '.', 2, ' MZN ')
          },
          {
            data: 'int_rate_mo',
            className: 'dt-body-right',
            render: function (data){
              return data+'%';
            }
          },
          {
            data: 'rental',
            className: 'dt-body-right',
            render: $.fn.dataTable.render.number(',', '.', 2, ' MZN ')
          },
          {
            data: 'installments',
            className: 'dt-body-right'
          },
          {
            data: 'start_date',
            render: function(data) {
              return moment(data).format('DD/MM/YY');
            }
          },
          {
            data: 'remaining_days',
            render: function(data){

              if(data == 0){
                return '<strong style="color:black;">'+data+' últ. dia </strong>';
              }else if(data < 0){
                return '<strong style="color:red;">'+(data*-1)+' em atraso </strong>';
              }else if(data > 0){
                return '<strong style="color:green;">'+data+' em dia </strong>'; 
              }else 
              return data;
            } 
          },
          {
            data: 'status_text',
            render: function(data){

              if(data === 'Fechado'){
                return '<strong style="color:black;">'+data+'</strong>';
              }else if(data === 'Aberto'){
                return '<strong style="color:blue;">'+data+'</strong>';
              }else 
              return data;
            }
          },
        ]
      });


      $('#loan-list tbody').on('click', 'tr', function() {
        var data = table.row(this).data();

        window.location.href = `{{route('loans.index')}}/${data.id}`;
      });
      

  
  
    });
  </script>
  @endsection
</x-app-layout>