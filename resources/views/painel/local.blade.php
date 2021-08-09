@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 py-5">
            <div class="card">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td>Ciclista</td>
                            <td>Medalha</td>
                            <td>Camiseta</td>
                            <td>Comprador</td>
                            <td>Telefone <small>(comprador)</small></td>
                        </tr>
                    </thead>
                    @foreach ($inscricoes as $inscricao)
                    <tbody>
                        <tr>
                            <td>{{$inscricao->nome_strava}}</td>
                            <td>{{$inscricao->tipo != 'Apenas Camiseta' ? 'Sim' : 'Não'}}</td>
                            <td>{{$inscricao->tamanho}}</td>
                            <td>{{$inscricao->order->nome}}</td>
                            <td>{{$inscricao->order->telefone}}</td>
                        </tr>
                    </tbody>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
