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
                <div class="row text-center justify-content-center">
                    <div class="col-md-6">
                        <div class="card text-white bg-success mb-3">
                            <div class="card-header">
                                <h3>Total</h3>
                            </div>
                            <div class="card-body">
                                <h2>{{ $total }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-md-6">
                        <div class="card text-white bg-success mb-3">
                            <div class="card-header">
                                <h3>Disponíveis</h3>
                            </div>
                            <div class="card-body">
                                <h2>{{ $disponivel }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card text-white bg-success mb-3">
                            <div class="card-header">
                                <h3>Pagas</h3>
                            </div>
                            <div class="card-body">
                                <h2>{{ $paga }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card text-white bg-warning mb-3">
                            <div class="card-header">
                                <h3>Em análise</h3>
                            </div>
                            <div class="card-body">
                                <h2>{{ $analise }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card text-white bg-warning mb-3">
                            <div class="card-header">
                                <h3>Aguardando pagamento</h3>
                            </div>
                            <div class="card-body">
                                <h2>{{ $aguardando }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card text-white bg-danger mb-3">
                            <div class="card-header">
                                <h3>Em disputa</h3>
                            </div>
                            <div class="card-body">
                                <h2>{{ $disputa }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card text-white bg-danger mb-3">
                            <div class="card-header">
                                <h3>Devolvida</h3>
                            </div>
                            <div class="card-body">
                                <h2>{{ $devolvida }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card text-white bg-danger mb-3">
                            <div class="card-header">
                                <h3>Cancelada</h3>
                            </div>
                            <div class="card-body">
                                <h2>{{ $cancelada }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card text-white bg-danger mb-3">
                            <div class="card-header">
                                <h3>Debitado</h3>
                            </div>
                            <div class="card-body">
                                <h2>{{ $debitada }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card text-white bg-danger mb-3">
                            <div class="card-header">
                                <h3>Retenção temporária</h3>
                            </div>
                            <div class="card-body">
                                <h2>{{ $retencao }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card text-white bg-danger mb-3">
                            <div class="card-header">
                                <h3>Duplicados</h3>
                            </div>
                            <div class="card-body">
                                <h2>{{ count($duplicadas) }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
