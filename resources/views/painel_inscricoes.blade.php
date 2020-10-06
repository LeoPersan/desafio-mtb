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
                <table class="table table-bordered table-responsive">
                    <thead>
                        <tr>
                            <td>Nome</td>
                            <td>Método Pagamento</td>
                            <td>Telefone</td>
                            <td>CEP</td>
                            <td>Estado</td>
                            <td>Valor com Juros</td>
                            <td>Status</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->nome }}</td>
                                <td>{{ $order->metodo_pagamento }}</td>
                                <td>{{ $order->telefone }}</td>
                                <td>{{ $order->cep }}</td>
                                <td>{{ $order->estado }}</td>
                                <td>{{ $order->valor_com_juros }}</td>
                                <td>{{ $order->status }}</td>
                            </tr>
                            <tr>
                                <td colspan="7">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td>Tipo</td>
                                                <td>Camiseta</td>
                                                <td>KM</td>
                                                <td>Nome</td>
                                                <td>E-mail</td>
                                                <td>Método Envio</td>
                                                <td>Telefone</td>
                                                <td>CEP</td>
                                                <td>Estado</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order->subscriptions as $subscription)
                                                <tr>
                                                    <td>{{ $subscription->tipo }}</td>
                                                    <td>{{ $subscription->tamanho }}</td>
                                                    <td>{{ $subscription->km }}</td>
                                                    <td>{{ $subscription->nome_strava }}</td>
                                                    <td>{{ $subscription->email }}</td>
                                                    <td>{{ $subscription->metodo_envio }}</td>
                                                    <td>{{ $subscription->telefone }}</td>
                                                    <td>{{ $subscription->cep }}</td>
                                                    <td>{{ $subscription->estado }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
