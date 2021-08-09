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
                            <td>Nome</td>
                            <td>Email</td>
                            <td>Telefone</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            @php $nomes = ''; @endphp
                            @foreach ($order->subscriptions as $subscription)
                                @php $nomes .= '*'.$subscription->nome_strava.'*%0A'; @endphp
                            @endforeach
                            <tr>
                                <td>{{ $order->nome }}</td>
                                <td>{{ $order->email }}</td>
                                <td>
                                    <a target="_blank"
                                        href="https://api.whatsapp.com/send?phone={{ $order->telefone_whatsApp }}&text=Olá {{ $order->nome }}, tudo bem?%0A%0AFaço parte do 2º Desafio de MTB do Rotaract de Tupi Paulista.%0A%0AVerificamos que os inscritos:%0A{{ $nomes }}%0AEstão cadastrados com o mesmo e-mail (*{{ $order->email }}*). Isso irá impossibilitar que pelo menos ciclista acesse o seu Painel do Atleta.%0A%0A*Poderia nos passar os e-mails pessoais de cada um?*">
                                        {{ $order->telefone }}
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
