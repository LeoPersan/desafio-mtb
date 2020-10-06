@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12 py-5 bg-white">
            <div class="container">
                <h1>Inscrições</h1>
            </div>
        </div>
        <div class="container">
            <div class="row justify-content-around my-3">
                <div class="col-12 my-5">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td colspan="2">
                                    Tipo de Inscrições
                                </td>
                                <td>
                                    Descrição
                                </td>
                                <td>
                                    Valor
                                </td>
                                <td>
                                    Quantidade
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <img class="card-img-top" src="{{ asset('images/kit-com-camiseta.jpg') }}"
                                        alt="Kit com Camiseta">
                                </td>
                                <td>
                                    <h4 class="card-title">Inscrição com Camiseta</h4>
                                </td>
                                <td>
                                    <ul>
                                        <li>Inscrição no evento</li>
                                        <li>Medalha</li>
                                        <li>Certificado</li>
                                        <li>Camiseta</li>
                                    </ul>
                                </td>
                                <td>
                                    <h5>R$ 80,00</h5>
                                </td>
                                <td>
                                    <input class="form-control" type="number" min="0" v-model="qtde_com_camiseta">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img class="card-img-top" src="{{ asset('images/kit-sem-camiseta.png') }}"
                                        alt="Kit sem Camiseta">
                                </td>
                                <td>
                                    <h4 class="card-title">Inscrição sem Camiseta</h4>
                                </td>
                                <td>
                                    <ul>
                                        <li>Inscrição no evento</li>
                                        <li>Medalha</li>
                                        <li>Certificado</li>
                                    </ul>
                                </td>
                                <td>
                                    <h5>R$ 40,00</h5>
                                </td>
                                <td>
                                    <input class="form-control" type="number" min="0" v-model="qtde_sem_camiseta">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img class="card-img-top" src="{{ asset('images/camiseta.png') }}" alt="Camiseta">
                                </td>
                                <td>
                                    <h4 class="card-title">Apenas Camiseta</h4>
                                </td>
                                <td>
                                    <ul>
                                        <li>Camiseta</li>
                                    </ul>
                                </td>
                                <td>
                                    <h5>R$ 60,00</h5>
                                </td>
                                <td>
                                    <input class="form-control" type="number" min="0" v-model="qtde_camiseta">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12 py-5 bg-white">
            <div class="container">
                <form action="{{ route('inscricoes') }}" @submit.prevent="post">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td width="50px">Tipo de inscrição</td>
                                <td width="50px">Tamanho camiseta</td>
                                <td width="50px">Quilometragem</td>
                                <td width="55px">Valor</td>
                                <td width="55px">Frete</td>
                            </tr>
                        </thead>
                        <tbody v-for="subscription in com_camiseta.concat(sem_camiseta.concat(camiseta))">
                            <tr>
                                <td>
                                    <input type="hidden" :name="`subscriptions[${subscription.id}][type]`"
                                        :value="`${subscription.type}`">
                                    @{{ subscription . type }}
                                </td>
                                <td>
                                    <div class="form-group">
                                        <select class="form-control" name="`subscriptions[${subscription.id}][km]`"
                                            required>
                                            <option value="">Escolha um tamanho</option>
                                            @foreach (App\Subscription::SIZES as $size)
                                                <option>{{ $size }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <select class="form-control" name="`subscriptions[${subscription.id}][km]`"
                                            required>
                                            <option value="">Escolha uma quilometragem</option>
                                            @foreach (App\Subscription::KMS as $km)
                                                <option>{{ $km }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                                <td>R$ @{{ subscription . value . toFixed(2) . replace('.', ',') }}</td>
                                <td>R$ @{{ subscription . ship_cost . toFixed(2) . replace('.', ',') }}</td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <input type="text" class="form-control"
                                                :name="`subscriptions[${subscription.id}][name_strava]`"
                                                placeholder="Seu nome no Strava" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="email" class="form-control" required
                                                :name="`subscriptions[${subscription.id}][email]`" placeholder="E-mail">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <input type="text" class="form-control" viacep="cep" required
                                                :name="`subscriptions[${subscription.id}][zip_code]`" placeholder="CEP"
                                                v-mask="'#####-###'" @change="buscaCep">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <select :name="`subscriptions[${subscription.id}][state]`" viacep="uf"
                                                class="form-control" required>
                                                @foreach (App\Subscription::STATES as $state)
                                                    <option>{{ $state }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="text" class="form-control" viacep="localidade" required
                                                :name="`subscriptions[${subscription.id}][city]`" placeholder="Cidade">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="text" class="form-control" viacep="logradouro" required
                                                :name="`subscriptions[${subscription.id}][address]`" placeholder="Endereço">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <input type="text" class="form-control" viacep="complement" required
                                                :name="`subscriptions[${subscription.id}][number]`" placeholder="Número">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input type="text" class="form-control" placeholder="Complemento"
                                                :name="`subscriptions[${subscription.id}][complemento]`">
                                        </div>
                                    </div>
                                </td>
                                <td colspan="2">
                                    <div class="form-group ">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input"
                                                    :name="`subscriptions[${subscription.id}][ship_method]`"
                                                    value="organization" cost="0" checked>
                                                Retirar com a organização
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input"
                                                    :name="`subscriptions[${subscription.id}][ship_method]`" value="frenet"
                                                    cost="0">
                                                Envio pelos correios R$ @{{ frenet[subscription . id] }}
                                            </label>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-primary">Salvar Pedido</button>
                </form>
            </div>
        </div>
    </div>
@endsection
