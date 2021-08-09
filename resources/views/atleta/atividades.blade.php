@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 py-5">
                <div class="card">
                    <div class="card-header">
                        <h2>{{ __('Atividades') }}</h2>
                        <h4>Selecione as atividades que serão contabilizadas para o seu ranking.</h4>
                        <h4>Você poderá fazer quantas alterações quiser até o dia 30/11/2020.</h4>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="post">
                            @csrf
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td colspan="6">
                                            <button type="submit" class="btn btn-primary pull-right">Salvar</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="1px"></td>
                                        <td>Nome</td>
                                        <td>Data</td>
                                        <td>Distancia</td>
                                        <td>Elevação</td>
                                        <td>Tempo</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($atividades as $atividade)
                                        <tr>
                                            <td>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" name="atividades[]" class="custom-control-input" value="{{ $atividade->id }}" id="atividade{{ $atividade->id }}" {{ $atividade->active ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="atividade{{ $atividade->id }}"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <label class="w-100" for="atividade{{ $atividade->id }}">
                                                    {{ $atividade->name }}
                                                </label>
                                            </td>
                                            <td>
                                                <label class="w-100" for="atividade{{ $atividade->id }}">
                                                    {{ $atividade->data }}
                                                </label>
                                            </td>
                                            <td>
                                                <label class="w-100" for="atividade{{ $atividade->id }}">
                                                    {{ $atividade->distancia }}
                                                </label>
                                            </td>
                                            <td>
                                                <label class="w-100" for="atividade{{ $atividade->id }}">
                                                    {{ $atividade->ganho_de_altitude }}
                                                </label>
                                            </td>
                                            <td>
                                                <label class="w-100" for="atividade{{ $atividade->id }}">
                                                    {{ $atividade->tempo }}
                                                </label>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="6">
                                            <button type="submit" class="btn btn-primary pull-right">Salvar</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        tbody tr label {
            cursor: pointer;
        }
    </style>
@endpush

