@component('mail::message')
# Recuperação de senha para {{$subscription->nome_strava}}

Clique no botão abaixo para recuperar a sua senha

@component('mail::button', ['url' => route('atleta.password.reset',[md5($subscription->senha)])])
Recuperar senha
@endcomponent

**Obs.: Caso não tenha solicitado a recuperação de senha, apenas desconsidere este e-mail.**

Atenciosamente,<br>
{{ config('app.name') }}
@endcomponent
