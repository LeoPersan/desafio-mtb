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

@if ($subscription->tipo != 'Apenas Camiseta')
@component('mail::button', ['url' => 'https://www.strava.com/oauth/authorize?client_id=53290&response_type=code&redirect_uri=http://desafiomtb.rotaracttupipaulista.org.br/atleta/strava&approval_prompt=force&scope=activity:read'])
Comece clicando aqui!
@endcomponent

Para que as suas atividades façam parte do nosso desafio nos autorize a acessar os dados das suas atividades no Strava.

Em seguida você será redirecionado para o painel do atleta para salvar a sua senha de acesso.

Obs.: Caso o seu nome no Strava seja diferente do que está no nosso banco de dados entraremos em contato para confirmar o seu acesso.


#### Painel do atleta: https://desafiomtb.rotaracttupipaulista.org.br/atleta
#### Login: {{$subscription->email}}
#### Senha: (Clique no botão abaixo e cadastre)
@endif

Atenciosamente,<br>
{{ config('app.name') }}
@endcomponent
