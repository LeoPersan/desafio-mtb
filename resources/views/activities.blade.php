@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
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
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($activities as $activitie)
                                    <tr>
                                        <td>{{ $activitie->id }}</td>
                                        <td>{{ $activitie->name }}</td>
                                        <td>{{ $activitie->start_date_local }}</td>
                                        <td>{{ $activitie->distance }}</td>
                                        <td>{{ $activitie->total_elevation_gain }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ dd($activitie) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
