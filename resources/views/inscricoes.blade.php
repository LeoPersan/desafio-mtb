@extends('layouts.app')

@section('content')
    <form action="{{ route('pagamento') }}" @submit.prevent="post">
        @csrf
        <input type="hidden" name="senderHash">
        <input type="hidden" name="metodo_pagamento" v-model="metodo_pagamento">
        <div class="row">
            @if ($errors->any())
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Quantidade de Inscrições</h3>
                    </div>
                    <div class="card-body">
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
                                        <img class="card-img-top" src="{{ asset('images/com_camiseta.png') }}"
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
                                        <img class="card-img-top" src="{{ asset('images/sem_camiseta.png') }}"
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
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Dados das Inscrições</h3>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="total" v-model="total">
                        <table class="table table-bordered" v-for="(inscricao, id) in inscricoes">
                            <thead>
                                <tr>
                                    <td>Tipo de Inscrição</td>
                                    <td>Quilometragem</td>
                                    <td>Tamanho da Camiseta</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        @{{ inscricao . tipo }}
                                        <input type="hidden" :name="`inscricoes[${id}][tipo]`" :value="`${inscricoes[id].tipo}`">
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select class="form-control" :name="`inscricoes[${id}][km]`" required
                                                v-if="inscricoes[id].tipo != 'Apenas Camiseta'">
                                                <option value="">Escolha uma Quilometragem</option>
                                                @foreach (App\Subscription::KMS as $km)
                                                    <option>{{ $km }}</option>
                                                @endforeach
                                            </select>
                                            <input type="text" readonly class="form-control" v-else value="Sem Inscrição">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select class="form-control" :name="`inscricoes[${id}][tamanho]`" required
                                                v-if="inscricoes[id].tipo != 'Sem Camiseta'">
                                                <option value="">Escolha um Tamanho</option>
                                                @foreach (App\Subscription::SIZES as $size)
                                                    <option>{{ $size }}</option>
                                                @endforeach
                                            </select>
                                            <input type="text" readonly class="form-control" v-else value="Sem Camiseta">
                                        </div>

                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <input type="text" class="form-control"
                                                    :name="`inscricoes[${id}][nome_strava]`"
                                                    placeholder="Seu nome no Strava">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <input type="email" class="form-control" :name="`inscricoes[${id}][email]`"
                                                    placeholder="Seu e-mail">
                                            </div>
                                            <input type="hidden" :name="`inscricoes[${id}][metodo_envio]`"
                                                v-model="inscricoes[id].metodo_envio">
                                            <input type="hidden" frenet="preco" :name="`inscricoes[${id}][preco_envio]`"
                                                v-model="inscricoes[id].preco_envio">
                                            <ul class="nav nav-tabs col-12">
                                                <li class="nav-item">
                                                    <a class="nav-link active" @click="inscricoes[id].metodo_envio = 'frenet'"
                                                        data-toggle="tab">
                                                        Receba em casa
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link"
                                                        @click="inscricoes[id].metodo_envio = 'local';inscricoes[id].preco_envio = 0;frenet();"
                                                        data-toggle="tab">
                                                        Retire com a Organização (gratúito)
                                                    </a>
                                                </li>
                                                <li class="nav-item"
                                                    v-show="id > 0 && (inscricoes[id-1]?.metodo_envio == 'frenet' || inscricoes[id-2]?.metodo_envio == 'frenet' || inscricoes[id-3]?.metodo_envio == 'frenet')">
                                                    <a class="nav-link" data-toggle="tab"
                                                    @click="inscricoes[id].metodo_envio = 'anterior';inscricoes[id].preco_envio = 0;frenet();">
                                                        Igual ao endereço anterior
                                                    </a>
                                                </li>
                                            </ul>
                                            <div class="col-12" v-if="inscricoes[id].metodo_envio == 'frenet'">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <div class="row">
                                                            <div class="form-group col-md-6 col-xl-3">
                                                                <input type="text" class="form-control"
                                                                    :name="`inscricoes[${id}][cep]`" v-model="inscricoes[id].cep"
                                                                    @change="buscaCep($event);frenet();" :i_id="'id'"
                                                                    placeholder="CEP" v-mask="'#####-###'" required>
                                                            </div>
                                                            <div class="form-group col-md-6 col-xl-3">
                                                                <select :name="`inscricoes[${id}][estado]`"
                                                                    class="form-control" viacep="uf" required>
                                                                    <option value="">Selecione o seu Estado</option>
                                                                    @foreach (App\Subscription::STATES as $state)
                                                                        <option>{{ $state }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-6 col-xl-3">
                                                                <input type="text" class="form-control"
                                                                    :name="`inscricoes[${id}][cidade]`" viacep="localidade"
                                                                    placeholder="Cidade" required>
                                                            </div>
                                                            <div class="form-group col-md-6 col-xl-3">
                                                                <input type="text" class="form-control"
                                                                    :name="`inscricoes[${id}][bairro]`" viacep="bairro"
                                                                    placeholder="Bairro" required>
                                                            </div>
                                                            <div class="form-group col-md-12 col-xl-6">
                                                                <input type="text" class="form-control"
                                                                    :name="`inscricoes[${id}][endereco]`"
                                                                    viacep="logradouro" placeholder="Endereço" required>
                                                            </div>
                                                            <div class="form-group col-md-6 col-xl-3">
                                                                <input type="text" class="form-control"
                                                                    :name="`inscricoes[${id}][numero]`" viacep="complemento"
                                                                    placeholder="Número" required>
                                                            </div>
                                                            <div class="form-group col-md-6 col-xl-3">
                                                                <input type="text" class="form-control"
                                                                    :name="`inscricoes[${id}][complemento]`"
                                                                    placeholder="Complemento">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 d-flex justfy-content-center align-items-center">
                                                        <h4>
                                                            Preço do Envio: R$
                                                            @{{ parseFloat(inscricao . preco_envio) . toFixed(2) . replace('.', ',') }}
                                                        </h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Dados de quem irá pagar</h3>
                    </div>
                    <div class="card-body row">
                        <div class="form-group col-md-6 col-xl-3">
                            <input type="text" class="form-control" name="nome" placeholder="Nome completo" required>
                        </div>
                        <div class="form-group col-md-6 col-xl-3">
                            <input type="tel" class="form-control" name="telefone" placeholder="Telefone com DDD"
                                v-mask="['(##) ####-####','(##) #####-####']" required>
                        </div>
                        <div class="form-group col-md-6 col-xl-3">
                            <input type="email" class="form-control" name="email" placeholder="E-mail" required>
                        </div>
                        <div class="form-group col-md-6 col-xl-3">
                            <input type="tel" class="form-control" name="cpf" placeholder="CPF" v-mask="'###.###.###-##'"
                                required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <h3 class="col-md-8">
                                Método de Pagamento
                            </h3>
                            <div class="col-md-4 text-right">
                                <img src="{{ asset('images/pagseguro.png') }}" alt="PagSeguro" style="max-width: 150px;">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs">
                            <li class="nav-item" @click="metodo_pagamento='creditCard'">
                                <a class="nav-link active" data-toggle="tab" href="#creditCard">
                                    Cartão de Crédito
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" v-if="metodo_pagamento == 'creditCard'">
                                <div class="row">
                                    <input type="hidden" name="brand">
                                    <input type="hidden" name="creditCardToken">
                                    <input type="hidden" name="valor_com_juros">
                                    <div class="form-group col-md-6 col-xl-3">
                                        <input type="tel" class="form-control" name="numero_cartao" @change="getBrand"
                                            placeholder="Número do Cartão de Crédito" v-mask="'#### #### #### ####'"
                                            required>
                                    </div>
                                    <div class="form-group col-md-6 col-xl-3">
                                        <input type="tel" class="form-control" name="cvv" placeholder="CVV" v-mask="'###'"
                                            @change="getCreditCardToken" required>
                                    </div>
                                    <div class="form-group col-md-6 col-xl-3">
                                        <input type="tel" class="form-control" name="vencimento_cartao"
                                            @change="getCreditCardToken" placeholder="Vencimento do Cartão de Crédito"
                                            v-mask="'##/##'" required>
                                    </div>
                                    <div class="form-group col-md-6 col-xl-3">
                                        <select name="parcelas" class="form-control" required>
                                            <option value="">Selecione um Parcelamento</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12" v-if="metodo_pagamento == 'creditCard' && inscricoes[0]?.metodo_envio != 'frenet'">
                <div class="card">
                    <div class="card-header">
                        <h3>Endereço de Faturamento</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6 col-xl-3">
                                <input type="tel" class="form-control" name="cep" @change="buscaCep" placeholder="CEP"
                                    v-mask="'#####-###'" required>
                            </div>
                            <div class="form-group col-md-6 col-xl-3">
                                <select name="estado" class="form-control" viacep="uf" required>
                                    <option value="">Selecione o seu Estado</option>
                                    @foreach (App\Subscription::STATES as $state)
                                        <option>{{ $state }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6 col-xl-3">
                                <input type="text" class="form-control" name="cidade" viacep="localidade"
                                    placeholder="Cidade" required>
                            </div>
                            <div class="form-group col-md-6 col-xl-3">
                                <input type="text" class="form-control" name="bairro" viacep="bairro" placeholder="Bairro"
                                    required>
                            </div>
                            <div class="form-group col-md-12 col-xl-6">
                                <input type="text" class="form-control" name="endereco" viacep="logradouro"
                                    placeholder="Endereço" required>
                            </div>
                            <div class="form-group col-md-6 col-xl-3">
                                <input type="text" class="form-control" name="numero" viacep="complemento"
                                    placeholder="Número" required>
                            </div>
                            <div class="form-group col-md-6 col-xl-3">
                                <input type="text" class="form-control" name="complemento" placeholder="Complemento">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-check text-right pb-3">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="regulamento" value="1" checked>
                                Li e concordo com o
                                <a href="{{ route('regulamento') }}">Regulamento</a>
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary float-right">Enviar Pagamento</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script type="text/javascript" src="{{ PagSeguro::getUrl()['javascript'] }}"></script>
    <script>
        window.onload = () => {
            window.frenet_token = "{{ config('services.frenet.token') }}"
            PagSeguroDirectPayment.setSessionId('{{ PagSeguro::startSession() }}')
            let getSenderHash = setInterval(() => {
                if(document.querySelector('[name=senderHash]').value.length > 0) clearInterval(getSenderHash)
                document.querySelector('[name=senderHash]').value = PagSeguroDirectPayment.getSenderHash()
            }, 1000);

                document.querySelector('[name=parcelas]').addEventListener('change', () => {
                    document.querySelector('[name=valor_com_juros]').value = document.querySelector(
                        '[name=parcelas]').selectedOptions[0].getAttribute('installmentamount')
                })
        }

        window.getBrand = function() {
            if (document.querySelector('[name=numero_cartao]').value.length < 7) return
            PagSeguroDirectPayment.getBrand({
                cardBin: document.querySelector('[name=numero_cartao]').value.replace(
                        ' ', '')
                    .substring(0, 6),
                success: response => {
                    document.querySelector('[name=brand]').value = response['brand']['name'];
                    document.querySelector('[name=cvv]').setAttribute(
                        'size',
                        response['brand']['cvvSize']
                    );
                    window.getCreditCardToken()
                },
                error: response => console.log(response)
            })
        }

        window.getInstallments = function(total) {
            if (
                document.querySelector('[name=brand]').value == '' ||
                document.querySelector('[name=total]').value == ''
            ) return false;
            var brand = document.querySelector('[name=brand]').value;
            PagSeguroDirectPayment.getInstallments({
                amount: total ?? document.querySelector('[name=total]').value,
                brand: brand,
                success: response => {
                    document.querySelector("[name=parcelas]").innerHTML = ''
                    response['installments'][brand].forEach(value => {
                        let option = document.createElement('option')
                        option.value = value['quantity']
                        option.setAttribute('installmentAmount', value['installmentAmount'])
                        option.textContent = value['quantity'] + "x de " +
                            value['installmentAmount'].toFixed(2) + " - Total de " +
                            value['totalAmount'].toFixed(2)
                        document.querySelector("[name=parcelas]").appendChild(option);
                    })
                    document.querySelector('[name=valor_com_juros]').value = document.querySelector(
                        '[name=parcelas]').selectedOptions[0].getAttribute('installmentamount')
                },
                error: response => console.error(response)
            })
        }

        window.getCreditCardToken = function() {
            if (
                document.querySelector('[name=numero_cartao]').value.length < 19 ||
                document.querySelector('[name=vencimento_cartao]').value.length < 5 ||
                document.querySelector('[name=cvv]').value.length < 3
            ) return false;
            [mes, ano] = document.querySelector('[name=vencimento_cartao]').value.split('/')
            PagSeguroDirectPayment.createCardToken({
                cardNumber: document.querySelector('[name=numero_cartao]').value.replace(/ /g, ''),
                cvv: document.querySelector('[name=cvv]').value,
                expirationMonth: mes,
                expirationYear: '20' + ano,
                brand: document.querySelector('[name=brand]').value,
                success: response => {
                    document.querySelector('[name=creditCardToken]').value = response['card']['token']
                    window.getInstallments()
                },
                error: response => console.log(response)
            })
        }

    </script>
@endpush
