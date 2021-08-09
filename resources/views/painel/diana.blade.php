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
                            <td>Telefone</td>
                            <td>Camiseta</td>
                            <td>KM</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->nome }}</td>
                                <td>{{ $order->telefone }}</td>
                                @foreach ($order->subscriptions as $subscription)
                                    <td>{{ $subscription->tamanho }}</td>
                                    <td>{{ $subscription->km }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
