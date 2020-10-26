@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 py-5">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <td>ID</td>
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
                                        <td>{{ $atividade->id }}</td>
                                        <td>{{ $atividade->name }}</td>
                                        <td>{{ $atividade->data }}</td>
                                        <td>{{ $atividade->distancia }}</td>
                                        <td>{{ $atividade->ganho_de_altitude }}</td>
                                        <td>{{ $atividade->tempo }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
