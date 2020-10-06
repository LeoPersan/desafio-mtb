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
                            <td>Quantidade</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($camisetas as $camiseta)
                            <tr>
                                <td>{{ $camiseta->tamanho }}</td>
                                <td>{{ $camiseta->qtde }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
