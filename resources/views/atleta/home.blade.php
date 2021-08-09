@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 py-5">
            <div class="card">
                <div class="card-header">
                    <h2><small><small>Bem vindo</small></small> {{auth()->user()->nome_strava}}</h2>
                    <p>
                        <strong>Tamanho da camiseta:</strong> {{auth()->user()->tamanho}} <br>
                        <strong>Quilometragem Escolhida:</strong> {{auth()->user()->km}} <br>
                        <strong>Entrega:</strong>
                        @if (auth()->user()->metodo_envio == 'local')
                        Retirar com a Organização
                        @else
                        CEP: {{auth()->user()->cep}}<br>
                        {{auth()->user()->cidade}} - {{auth()->user()->estado}}<br>
                        {{auth()->user()->endereco}}, {{auth()->user()->numero}}<br>
                        {{auth()->user()->complemento}}
                        @endif
                    </p>
                    @if (auth()->user()->activities()->count())
                    <h4 class="alert alert-info">
                        <a target="_blank" href="https://www.strava.com/athletes/{{auth()->user()->id_athlete}}">Acesse
                            o seu Strava</a>
                    </h4>
                    @else
                    <h4>Alguns ciclistas se cadastraram no nosso sistema com o strava errado clique no link abaixo e
                        confirme se é o seu perfil.</h4>
                    <h4 class="alert alert-info">
                        <a target="_blank" href="https://www.strava.com/athletes/{{auth()->user()->id_athlete}}">Acesse
                            o seu Strava</a>
                    </h4>
                    <h4>Caso não seja o seu Strava, clique no botão abaixo acesse o strava correto e nos autorize
                        novamente.</h4>
                    <h4 class="alert alert-warning">
                        <a target="_blank"
                            href="https://www.strava.com/oauth/authorize?client_id=53290&response_type=code&redirect_uri=http://desafiomtb.rotaracttupipaulista.org.br/atleta/strava&approval_prompt=force&scope=activity:read">
                            Altere o seu Strava
                        </a>
                    </h4>
                    @endif
                </div>
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
                <div class="card-body">
                    <h3 class="card-title">Suas atividades</h3>
                    <p>Selcione as atividades que farão parte da competição. Lembrando que só aceitarremos uma atividade
                        por dia.</p>
                    <form @submit.prevent="post" action="{{ route('atleta.atividades') }}">
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
                                    <td>Distancia</td>
                                    <td>Elevação</td>
                                    <td>Tempo</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="alert alert-success">
                                    <td colspan="2" class="px-5">
                                        <h4>Total</h4>
                                    </td>
                                    <td>
                                        <h4>{{ auth()->user()->distanciaTotal }}</h4>
                                    </td>
                                    <td>
                                        <h4>{{ auth()->user()->elevacaoTotal }}</h4>
                                    </td>
                                    <td></td>
                                </tr>
                                @php $data = '' @endphp
                                @foreach ($atividades as $atividade)
                                @if ($data != $atividade->data)
                                @php $data = $atividade->data @endphp
                                <tr class="alert alert-primary">
                                    <td colspan="5" class="px-5">
                                        <h5>{{ $atividade->data }}</h5>
                                    </td>
                                </tr>
                                @endif
                                <tr class="alert {{ $atividade->active ? 'alert-info' : '' }}">
                                    <td>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" name="atividades[]" class="custom-control-input"
                                                value="{{ $atividade->id }}" id="atividade{{ $atividade->id }}"
                                                {{ $atividade->active ? 'checked' : '' }}>
                                            <label class="custom-control-label"
                                                for="atividade{{ $atividade->id }}"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <label class="w-100" for="atividade{{ $atividade->id }}">
                                            {{ $atividade->name }}
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
                    <h4>Boa sorte!</h4>
                </div>
                @if (count($atividades_reprovadas))
                <div class="card-body">
                    <h3 class="card-title">Atividades Reprovadas</h3>
                    <p>Estas atividades foram reprovadas manualmente, por alguma incoerência no registro do Strava, talvez algum erro do GPS do celular ou no envio dos dados.</p>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td>Data</td>
                                <td>Nome</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($atividades_reprovadas as $atividade)
                            <tr class="alert alert-danger">
                                <td>
                                    <a href="https://www.strava.com/activities/{{$atividade->strava_id}}" target="_blank">
                                        {{ $atividade->data }}
                                    </a>
                                </td>
                                <td>
                                    <a href="https://www.strava.com/activities/{{$atividade->strava_id}}" target="_blank">
                                        {{ $atividade->name }}
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script defer>
        window.sexo = '{{auth()->user()->sexo}}'
        window.km = '{{auth()->user()->km}}'
    </script>
@endpush
