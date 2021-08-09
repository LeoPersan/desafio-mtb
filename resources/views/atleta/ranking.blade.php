<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <td>Colocação</td>
            <td>Nome</td>
            <td>Distancia Percorrida</td>
            <td>Ganho de Elevação</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($ciclistas as $ciclista)
        <tr>
            <td>{{ $loop->iteration+((request()->page ?? 1)-1)*10 }}º</td>
            <td>{{ $ciclista->nome_strava }}</td>
            <td>{{ $ciclista->distancia_total }}</td>
            <td>{{ $ciclista->elevacao_total}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
