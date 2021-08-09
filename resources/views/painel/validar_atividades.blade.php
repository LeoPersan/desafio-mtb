@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12 bg-white">
            <div class="container">
                <h2>Validar Atividades</h2>
            </div>
        </div>
        <div class="col-12 py-5 bg-gray">
            <div class="container">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td colspan="2">
                                <div class="row justify-content-center">
                                    <div class="col-md-6">
                                        <form action="{{ route('validar_atividades') }}" @submit.prevent="post">
                                            <input type="hidden" name="id" value="{{ $atividade->id }}">
                                            <input type="hidden" name="status" value="Reprovado">
                                            <button class="btn btn-lg btn-block btn-danger">Reprovar</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @if ($atividade->distance < 150000)
                        <tr class="alert alert-success">
                        @elseif ($atividade->distance < 250000)
                        <tr class="alert alert-warning">
                        @else
                        <tr class="alert alert-danger">
                        @endif
                            <td>Distância:</td>
                            <td><strong>{{$atividade->distancia}}</strong></td>
                        </tr>
                        @if ($atividade->time < 14400)
                        <tr class="alert alert-success">
                        @elseif ($atividade->time < 21600)
                        <tr class="alert alert-warning">
                        @else
                        <tr class="alert alert-danger">
                        @endif
                            <td>Tempo:</td>
                            <td><strong>{{$atividade->tempo}}</strong></td>
                        </tr>
                        @if ($atividade->velocidade_media < 10)
                        <tr class="alert alert-danger">
                        @elseif ($atividade->velocidade_media < 30)
                        <tr class="alert alert-success">
                        @elseif ($atividade->velocidade_media < 40)
                        <tr class="alert alert-warning">
                        @else
                        <tr class="alert alert-danger">
                        @endif
                            <td>Velocidade média:</td>
                            <td><strong>{{$atividade->velocidade_media_formatado}}</strong></td>
                        </tr>
                        {{-- @if ($atividade->max_speed < 10)
                        <tr class="alert alert-danger">
                        @elseif ($atividade->max_speed < 45)
                        <tr class="alert alert-success">
                        @elseif ($atividade->max_speed < 65)
                        <tr class="alert alert-warning">
                        @else
                        <tr class="alert alert-danger">
                        @endif
                            <td>Velocidade máxima:</td>
                            <td><strong>{{$atividade->velocidade_maxima}}</strong></td>
                        </tr> --}}
                        @if ($atividade->media_elevacao < 0.02)
                        <tr class="alert alert-success">
                        @elseif ($atividade->media_elevacao < 0.05)
                        <tr class="alert alert-warning">
                        @else
                        <tr class="alert alert-danger">
                        @endif
                            <td>Ganho de elevação:</td>
                            <td><strong>{{$atividade->ganho_de_altitude}}</strong></td>
                        </tr>
                        <tr>
                            <td>Data:</td>
                            <td><strong>{{$atividade->data}}</strong></td>
                        </tr>
                        <tr>
                            <td>Ciclista:</td>
                            <td>
                                <a href="https://www.strava.com/athlete/{{$atividade->subscription->id_athlete}}" target="atleta">
                                    <strong>{{$atividade->subscription->nome_strava}}</strong>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Atividade:</td>
                            <td>
                                <a href="https://www.strava.com/activities/{{$atividade->strava_id}}" target="atividade">
                                    <strong>{{$atividade->name}}</strong>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="row justify-content-center">
                                    <div class="col-sm-6">
                                        <form action="{{ route('validar_atividades') }}" @submit.prevent="post">
                                            <input type="hidden" name="id" value="{{ $atividade->id }}">
                                            <input type="hidden" name="status" value="Em análise">
                                            <button class="btn btn-lg btn-block btn-info">Não Sei</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="row justify-content-center">
                                    <div class="col-md-6">
                                        <form action="{{ route('validar_atividades') }}" @submit.prevent="post">
                                            <input type="hidden" name="id" value="{{ $atividade->id }}">
                                            <input type="hidden" name="status" value="Aprovado">
                                            <button class="btn btn-lg btn-block btn-success">Aprovar</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        table.table {
            table-layout: fixed !important;
            width: 100% !important;
        }
    </style>
@endpush
