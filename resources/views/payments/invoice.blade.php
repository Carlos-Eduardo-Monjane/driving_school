<?php 
use App\Libraries\Common;
?>
<html>

<body style="width:200px; padding: 10px;">
    <center>
        <h3>AC FINANCE, E.I</h3>
    </center>

    <p>Recibo de Parcelamento</p>
    <p>Tel: +258 87 44 85 040</p>
    <p>Faturado em: {{$payment->created_at}}</p>
    <center> <p>----------------------------------</p> </center>
    <p>aluno: {{$payment->loan->customer->full_name}}</p>
    <p>Nº do Empréstimo: #{{$payment->loan->id}}</p>
    <p>Valor do empréstimo: {{$payment->loan->loan_amount}}</p>
    <p>Diário: {{$payment->loan->daily_rental}} MZN</p>
    <p>Remanescente: {{$payment->loan->remaining_days}}/{{$payment->loan->installments}}</p>
    <p>Data de início: {{$payment->loan->start_date->format('Y-m-d')}}</p>
    <p>Data de fim: {{$payment->loan->start_date->addDays($payment->loan->installments)->format('Y-m-d')}}</p>
    <center> <p>----------------------------------</p> </center>
    <p>Total pago: {{Common::getInCurrencyFormat($payment->amount)}} MZN</p>
    <p>Total devido: {{$payment->loan->loan_amount - $totalPaid}} MZN</p>
    <p>Pago hoje: {{$paidToday}} MZN</p>
    <p>Atrasados: {{$arrears}} MZN</p>
    <center> <p>----------------------------------</p> </center>
</body>

</html>