@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 py-5">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <ul class="nav nav-tabs">
                                @foreach (['200 KM', '500 KM', '1000 KM', '3000 KM'] as $km)
                                <li class="nav-item">
                                    <a class="nav-link" :class="{active:km == '{{$km}}'}" @click="km = '{{$km}}'">{{$km}}</a>
                                </li>
                                @endforeach
                            </ul>
                            <ul class="nav nav-tabs">
                                @foreach (['F' => 'Feminino','M' => 'Masculino'] as $sexo => $label)
                                <li class="nav-item">
                                    <a class="nav-link" :class="{active:sexo == '{{$sexo}}'}" @click="sexo = '{{$sexo}}'">{{$label}}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="ranking"></div>
            </div>
        </div>
    </div>
</div>
@endsection
