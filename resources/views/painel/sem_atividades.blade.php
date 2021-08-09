@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12 py-5 bg-white">
            <div class="container">
                <h1>Painel</h1>
            </div>
        </div>
        <div class="col-12 py-5 bg-gray">
            <div class="container">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td>Nome Inscrito</td>
                            <td>Nome Telefone</td>
                            <td>Telefone</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subscriptions as $subscription)
                            <tr>
                                <td>{{ $subscription->nome_strava }}</td>
                                <td>{{ $subscription->order->nome }}</td>
                                <td>
                                    <a target="_blank" class="btn btn-success"
                                        href="https://api.whatsapp.com/send?phone={{ $subscription->order->telefone_whatsApp }}&text=Olá {{ $subscription->order->nome }}, tudo bem?%0A%0AFaço parte do 2º Desafio de MTB do Rotaract de Tupi Paulista.%0A%0AVerificamos que o inscrito *{{ $subscription->nome_strava }}* ainda não enviou nenhuma atividade.%0A%0APosso ajudar de alguma forma?">
                                        <i class="fa fa-whatsapp" aria-hidden="true"></i>
                                        {{ $subscription->order->telefone }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .fa {
            background: none;
            font-size: 1.5em;
            padding: 0;
            color: #ffffff;
            width: auto;
        }
    </style>
@endpush
