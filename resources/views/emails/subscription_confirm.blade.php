@component('mail::message')
# Inscrição Confirmada

Segue abaixo os dados da sua inscrição.

@component('mail::table')
|   |   |
|---|---|
|Nome do Atleta:|**{{$subscription->nome_strava}}**|
@if ($subscription->tamanho)
|Tamanho da Camiseta:|**{{$subscription->tamanho}}**|
@endif
@if ($subscription->km)
|Quilometragem:|**{{$subscription->km}}**|
@endif
@if ($subscription->metodo_envio == 'local')
|Endereço de entrega:|**Retirar com a Organização**|
@else
|Endereço de entrega:|**CEP: {{$subscription->cep}}**<br>**{{$subscription->cidade}} - {{$subscription->estado}}**<br>**{{$subscription->endereco}}, {{$subscription->numero}}**<br>{{$subscription->complemento?'**'.$subscription->complemento.'**':''}}|
@endif
@endcomponent

Atenciosamente,<br>
{{ config('app.name') }}
@endcomponent
