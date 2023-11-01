<x-app-layout>

  <x-slot name="title">
    Lista de  @if($reportType=='excess') empréstimos excessos @else empréstimos atrasados @endif 
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
            <th>Nome do aluno</th>
            <th>Ultimo pagamento</th>
            <th>Valor devido</th>
            <th>Valor do empréstimo</th>
            <th>Total pago</th>
            <th>Parcelas (dias)</th>
            <th>Diário</th>
            <th>Data de início</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>

  @section('scripts')
  <script>
    $(document).ready(function() {
      var table = $('#loan-list').DataTable({
        ajax: {
          url: '{{route("reports.show",["type" => $reportType, "ajax" => true])}}',
          dataSrc: 'loans'
        },
        columns: [{
            data: 'id'
          },
          {
            data: 'customer.full_name'
          },
          {
            data: 'last_payment.created_at'
          },
          {
            data: 'total_due_todate'
          },
          {
            data: 'loan_amount'
          },
          {
            data: 'total_paid'
          },
          {
            data: 'installments'
          },
          {
            data: 'rental'
          },
          {
            data: 'start_date'
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