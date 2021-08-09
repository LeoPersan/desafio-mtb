@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 py-5">
            <div class="card">
                <table class="table table-bordered">
                    @foreach ($entregas as $entrega)
                    <tbody>
                        <tr><td colspan="12"></td></tr>
                        <tr>
                            <td colspan="6">Nome de quem comprou: <b>{{$entrega->order->nome}}</b></td>
                            <td colspan="6">Valor que pagou pelo envio: <b>R$ {{number_format($entrega->order->preco_envio, 2, ',', '.')}}</b></td>
                        </tr>
                        <tr>
                            <td colspan="2">CEP: <b>{{$entrega->cep}}</b></td>
                            <td colspan="2">Peso: <b>{{number_format($entrega->gramas/1000, 3, ',', '.')}}</b></td>
                            <td colspan="2">Altura: <b>{{$entrega->altura}}</b></td>
                            <td colspan="2">Largura: <b>{{$entrega->largura}}</b></td>
                            <td colspan="2">Comprimento: <b>{{$entrega->comprimento}}</b></td>
                            <td colspan="2">Valor Total: <b>R$ {{number_format($entrega->reais, 2, ',', '.')}}</b></td>
                        </tr>
                        <tr>
                            <td colspan="6">Nome: <b>{{$entrega->nome_strava}}</b></td>
                            <td colspan="6">E-mail: <b>{{$entrega->email}}</b></td>
                        </tr>
                        <tr>
                            <td colspan="4">Endereço: <b>{{$entrega->endereco}}</b></td>
                            <td colspan="4">Número: <b>{{$entrega->numero}}</b></td>
                            <td colspan="4">Complemento: <b>{{$entrega->complemento}}</b></td>
                        </tr>
                        <tr>
                            <td colspan="4">Bairro: <b>{{$entrega->bairro}}</b></td>
                            <td colspan="4">Cidade: <b>{{$entrega->cidade}}</b></td>
                            <td colspan="4">Estado: <b>{{$entrega->estado}}</b></td>
                        </tr>
                        <tr>
                            <td colspan="3">Identificação dos bens</td>
                            <td colspan="9">
                                <b>
                                    @php $medalhas = 0 @endphp
                                    @foreach ($entrega->bens as $ciclista => $bem)
                                        {{$bem['camiseta'] ? $bem['camiseta'] . ' / ' : ''}}
                                        @if ($bem['medalha'])
                                            @php $medalhas++ @endphp
                                        @endif
                                    @endforeach
                                    - {{$medalhas}} Medalha
                                </b>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="12">
                                <form action="{{route('entregue', [$entrega->id])}}" @submit.prevent="post">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-check"></i>
                                        Enviado
                                    </button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
