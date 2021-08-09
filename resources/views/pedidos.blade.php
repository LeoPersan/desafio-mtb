@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12 py-5 bg-white">
            <div class="container">
                <h1>Pedidos</h1>
            </div>
        </div>
        <div class="col-12 bg-gray">
            <div class="container">
                <h2>Medalhas</h2>
                <h2>{{$qtde_medalhas}}</h2>
            </div>
        </div>
        <div class="col-12 bg-white">
            <div class="container">
                <h2>Camisetas</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td>Tamanho</td>
                            <td>1º Pedido</td>
                            <td>2º Pedido</td>
                            <td>Total</td>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $pedido1 = 0;
                            $pedido2 = 0;
                            $total = 0;
                        @endphp
                        @foreach ($camisetas as $camiseta)
                        @php
                            $pedido1 += ($camisetas_pedidas[$camiseta->tamanho] ?? 0);
                            $pedido2 += $camiseta->qtde - ($camisetas_pedidas[$camiseta->tamanho] ?? 0) + ($camisetas_a_parte[$camiseta->tamanho] ?? 0);
                            $total += $camiseta->qtde + ($camisetas_a_parte[$camiseta->tamanho] ?? 0);
                        @endphp
                            <tr>
                                <td>{{ $camiseta->tamanho }}</td>
                                <td>{{ ($camisetas_pedidas[$camiseta->tamanho] ?? 0) }}</td>
                                <td>{{ $camiseta->qtde - ($camisetas_pedidas[$camiseta->tamanho] ?? 0) + ($camisetas_a_parte[$camiseta->tamanho] ?? 0) }}</td>
                                <td>{{ $camiseta->qtde + ($camisetas_a_parte[$camiseta->tamanho] ?? 0) }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td>Total</td>
                            <td>{{ $pedido1 }}</td>
                            <td>{{ $pedido2 }}</td>
                            <td>{{ $total }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
