@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12 py-5 bg-white">
            <div class="container">
                <h1>Certificados</h1>
            </div>
        </div>
        <div class="col-12 py-5 bg-gray">
            <div class="container">
                <h3>Concluidos</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td>Nome de quem comprou</td>
                            <td>Nome do ciclista</td>
                            <td>E-mail</td>
                            <td>KM Escolhida</td>
                            <td>KM Percorridos</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($concluidos as $ciclista)
                            <tr>
                                <td>{{ $ciclista->order->nome }}</td>
                                <td>
                                    <a href="https://www.strava.com/athletes/{{ $ciclista->id_athlete }}" target="_blank">
                                        {{ $ciclista->nome_strava }}
                                    </a>
                                </td>
                                <td>{{ $ciclista->email }}</td>
                                <td>{{ $ciclista->km }}</td>
                                <td>{{ $ciclista->distancia_total }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <h3>Não Concluidos</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td>Nome</td>
                            <td>E-mail</td>
                            <td>KM Escolhida</td>
                            <td>KM Percorridos</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($nao_concluidos as $ciclista)
                            <tr>
                                <td>
                                    <a href="https://www.strava.com/athletes/{{ $ciclista->id_athlete }}" target="_blank">
                                        {{ $ciclista->nome_strava }}
                                    </a>
                                </td>
                                <td>{{ $ciclista->email }}</td>
                                <td>{{ $ciclista->km }}</td>
                                <td>{{ $ciclista->distancia_total }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
