<?php

use App\Models\Customer;
use App\Models\Loan;
use App\Models\Payment;
use App\Models\Guarantor;
use App\Models\User;
use Illuminate\Support\Facades\Request;

$isEdit = !empty($payment);
?>


<x-app-layout>
    <x-slot name="title">
        @if(!$isEdit)Criar um @else Editar @endif pagamento
    </x-slot>

    @if (session('status'))
    <div class="alert alert-success">
        Pagamento @if(!$isEdit) criado. @else editado. @endif <u><a href="{{route('payments.show', session('status')->id)}}">Ver</a></u>
    </div>
    @endif

    <form action="{{route('payments.store')}}" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">

                        @csrf

                        @if($isEdit)
                        <input type="hidden" name="id" value="{{$payment->id}}" />
                        @endif

                        @foreach(Payment::entityFields() as $field)
                        <div class="row mt-2">
                            @if(@$field['type'] != "hidden")
                            <div class="col-12 col-md-3">
                                <label class="col-form-label">{{@$field['label']}}</label>
                            </div>
                            @endif
                            <div class="col">
                                @switch(@$field['type'])
                                @case('select')
                                <select class="form-control @error($field['name']) border border-danger @enderror" name="{{$field['name']}}" {{@$field['attributes']}} value="{{ old($field['name'] , @$payment[$field['name']]) }}">
                                    <option value="">Selecionar {{@$field['label']}}</option>
                                    @foreach($field['selectOptions'] as $option)
                                    <option value="{{$option->id}}" @if($isEdit && $option->id == $payment[$field['name']] || $option->id == old($field['name']) ){{ 'selected' }}@endif>{{$option[$field['selectOptionNameField']]}}</option>
                                    @endforeach
                                </select>
                                @break
                                @default
                                <input class="form-control @error($field['name']) border border-danger @enderror" name="{{$field['name']}}" type="{{@$field['type']}}" {{@$field['attributes']}} @if(!in_array($field['name'], ['proof_doc'])) value="{{ old($field['name'] , @$payment[$field['name']]) }}" @endif>
                                @endswitch
                            </div>
                        </div>
                        @endforeach
                        <div class="row mt-3">

                            <div class="col text-center">
                                <button type="submit" class="btn btn-block btn-primary">Submeter</button>
                            </div>
                            @if($isEdit)
                            <div class="col-2">
                                <a href="#" class="btn btn-danger" onclick="triggerDeleteForm(event, 'payment-delete-form')"><i class="fa fa-trash"></i> Deletar</a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-5">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Detalhes do cliente</h5>
                        <hr class="mb-2" />
                        @foreach(Customer::entityFields() as $field)
                        <div class="row">
                            <div class="col-12 col-md-3">
                                <label class="col-form-label font-weight-bold">{{ $field['label'] }}</label>
                            </div>
                            <div class="col mt-2" data-customer-field="{{ $field['name'] }}">
                                : [Selecione Nº do Empréstimo]
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
                       <div class="col-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Detalhes do emprestimo</h5>
                        <hr class="mb-2" />
                        
                        <div class="row">
                            <div class="col-12 col-md-3">
                                <label class="col-form-label font-weight-bold">Total Emprestado</label>
                            </div>
                            <div class="col mt-2">
                                <input readonly type="text" placeholder="--" name="total_credito">
                            </div>
                            
                             <div class="col-12 col-md-3">
                                <label class="col-form-label font-weight-bold">Total a Pagar</label>
                            </div>
                            <div class="col mt-2">
                                <input readonly type="text" placeholder="--" name="total_a_pagar">
                            </div>
                            
                             <div class="col-12 col-md-3">
                                <label class="col-form-label font-weight-bold">Total Pedente</label>
                            </div>
                            <div class="col mt-2">
                                <input readonly type="text" placeholder="--" name="total_pedente">
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </form>

    @if($isEdit)
    <form id="payment-delete-form" action="{{ route('payments.destroy', $payment->id) }}" method="POST" class="d-none">
        @method('DELETE')
        @csrf
    </form>
    @endif

    @section('scripts')
    <script src="{{asset('lib/jquery-maskmoney/jquery.maskMoney.min.js')}}"></script>

    <script>
        $(document).ready(function() {
            $('[mask-money]').maskMoney();

            $('form').on('submit', function(e) {
                $('[mask-money]').each(function() {
                    var v = $(this).maskMoney('unmasked')[0];
                    $(this).val(v);
                });

            });

            $('[name="loan_id"]').change(function() {
                $('[data-customer-field]').each(function() {
                    $(this).html('Processando...');
                });
                
                console.log("ID: CLIENTE");
                console.log($(this).val());
                var id_emp = $(this).val();

                $.ajax({
                    url: "{{route('loans.index')}}/customer/" + id_emp,
                    success: function(data) {
                    console.log(data);
                        $('[data-customer-field]').each(function() {
                            $(this).html(data['customer'][$(this).data('customer-field')]);
                        });
                
                        		      	
		      var formatedTPagar = parseFloat(data.total_to_be_paid).toLocaleString(undefined, {minimumFractionDigits:2});
		      var formatedTCredito = parseFloat(data.loan_amount).toLocaleString(undefined, {minimumFractionDigits:2});
		      var formatedTPedente = parseFloat(data.outstanding_amount).toLocaleString(undefined, {minimumFractionDigits:2});
                        
                        $('[name="total_a_pagar"').val(formatedTPagar+' MZN');
                        $('[name="total_credito"').val(formatedTCredito+' MZN');
                        $('[name="total_pedente"').val(formatedTPedente+' MZN');
                        $('[name="rep_id"').val(data.rep_id);
                        $('[name="amount"').val(formatedTPedente);
                        
                        // console.log(data.customer_id);
                    }
                });
                
                
            });

             <?php if (Request::has('loan-id')) { ?>
                $('[name="loan_id"]').val("{{Request::get('loan-id')}}").trigger('change');
            <?php } ?>
        });
    </script>
    @endsection
</x-app-layout>