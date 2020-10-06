@component('mail::message')
# Contato de: {{$nome}}

## Mensagem
{{$mensagem}}

Atenciosamente,<br>
{{ config('mail.from.name') }}
@endcomponent
