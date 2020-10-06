@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="embed-responsive embed-responsive-16by9 header mb-5">
            <img class="embed-responsive-item" src="{{ asset('images/topo.jpg') }}" alt="">
        </div>
        <div class="col-3 text-center kms">
            <ul class="list-unstyled">
                <li>
                    <img src="{{ asset('images/icon.png') }}">
                </li>
                <li>3000 KM</li>
                <li>2000 KM</li>
                <li>1000 KM</li>
                <li>500 KM</li>
                <li>200 KM</li>
            </ul>
        </div>
        <div class="col-6 text-center premios">
            <ul>
                <li class="unstyled">
                    <img src="{{ asset('images/icon.png') }}">
                </li>
                <li>
                    Troféu para o 1º colocado <br>
                    <span class="small">(Feminino e Masculino)</span>
                </li>
                <li>Medalha para os participantes</li>
                <li>Camisa exclusiva</li>
                <li>Certificado</li>
            </ul>
        </div>
        <div class="col-3 text-center participe">
            <ul class="list-unstyled">
                <li>
                    <img src="{{ asset('images/icon.png') }}">
                </li>
                <li>Participe desse</li>
                <li>desafio</li>
                <li>você também</li>
            </ul>
        </div>
    </div>
@endsection
