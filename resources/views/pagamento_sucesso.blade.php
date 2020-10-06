@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12 py-5 bg-white">
            <div class="container text-center">
                <h1 class="alert alert-success my-4">Inscrição feita com sucesso!</h1>
                @if ($link_boleto)
                    <h2 class="my-4">
                        <a href="{{ $link_boleto }}" target="_blank">Clique para ver o seu boleto</a>
                    </h2>
                @endif
                <h3 class="my-4">
                    <a href="{{ asset('Regulamento MTB Termo de Autorizacao.pdf') }}" target="_blank">
                        Se necessário faça o download do Termo de Autorização para Menores junto com o Regulamento
                    </a>
                </h3>
                <h4 class="my-4">Dentro de duas semanas enviaremos o link de autorização do Strava, para os e-mails
                    cadastrados!</h4>
            </div>
        </div>
    </div>
@endsection
