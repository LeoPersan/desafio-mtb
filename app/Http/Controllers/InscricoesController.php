<?php

namespace App\Http\Controllers;

use App\Order;
use Exception;
use Frenet\Frenet;
use Frenet\Shipping\Shipping;
use App\Http\Requests\Pagamento;
use Illuminate\Support\Facades\DB;
use Artistas\PagSeguro\PagSeguroFacade as PagSeguro;

class InscricoesController extends Controller
{
    public function inscricoes()
    {
        return view('inscricoes');
    }

    public function pagamento(Pagamento $request)
    {
        try {
            DB::beginTransaction();
            $order = Order::create($request->all());
            $order->subscriptions = $request->get('inscricoes');
            $config = Frenet::init([
                'service' => 'logistics',
                'method' => 'ShippingQuoteWS',
                'Username' => config('services.frenet.username'),
                'Password' => config('services.frenet.password'),
                'SellerCEP' => '17930000',
            ]);
            $frenet = new Shipping();
            $multiply = 1;
            $extraAmount = 0;
            $boleto = '';
            $pagseguro = PagSeguro::setReference('ID do pedido')
                ->setSenderInfo([
                    'senderName' => $request->get('nome'), //Deve conter nome e sobrenome
                    'senderPhone' => $request->get('telefone'), //Código de área enviado junto com o telefone
                    'senderEmail' => $request->get('email'),
                    'senderHash' => $request->get('senderHash'),
                    'senderCPF' => $request->get('cpf') //Ou CNPJ se for Pessoa Júridica
                ])
                ->setItems($order->subscriptions->reverse()->map(function ($inscricao) use ($config, $frenet, &$multiply, &$extraAmount) {
                    if ($inscricao['metodo_envio'] == 'anterior') $multiply++;
                    else if ($inscricao['metodo_envio'] == 'frenet') {
                        $response = $frenet::getShippingQuote($config, [
                            'itens' => [
                                [
                                    'weight' => 0.4 * ($multiply ?: 1),
                                    'height' => 2 * ($multiply ?: 1),
                                    'length' => 12,
                                    'width' => 12,
                                    'diameter' => 0,
                                    'sku' => $inscricao['tipo'],
                                    'category' => 'MTB',
                                    'isFragile' => false,
                                ]
                            ],
                            'cep' => preg_replace('/([^\d+]+)/', '', $inscricao['cep']),
                            'total' => 50 * ($multiply ?: 1),
                        ]);
                        $extraAmount += $response['data'][0]->ShippingPrice;
                        $multiply = 0;
                    }
                    return [
                        'itemId' => $inscricao->tipo,
                        'itemDescription' => $inscricao->descricao,
                        'itemAmount' => $inscricao->preco, //Valor unitário
                        'itemQuantity' => '1', // Quantidade de itens
                    ];
                })->toArray());
            $pagseguro = $pagseguro->setExtraAmount($extraAmount);
            $order->preco_envio = $extraAmount;
            $order->save();
            switch ($request->get('metodo_pagamento')) {
                case 'creditCard':
                    $order->endereco = $request->get('endereco') ?: $request->get('inscricoes')[0]['endereco'];
                    $order->numero = $request->get('numero') ?: $request->get('inscricoes')[0]['numero'];
                    $order->bairro = $request->get('bairro') ?: $request->get('inscricoes')[0]['bairro'];
                    $order->cep = $request->get('cep') ?: $request->get('inscricoes')[0]['cep'];
                    $order->cidade = $request->get('cidade') ?: $request->get('inscricoes')[0]['cidade'];
                    $order->estado = $request->get('estado') ?: $request->get('inscricoes')[0]['estado'];
                    $order->save();
                    $pagseguro = $pagseguro->setCreditCardHolder([
                        'creditCardHolderName' => $request->get('nome'), //Deve conter nome e sobrenome
                        'creditCardHolderPhone' => $request->get('telephone'), //Código de área enviado junto com o telefone
                        'creditCardHolderCPF' => $request->get('cpf'), //Ou CNPJ se for Pessoa Júridica
                        'creditCardHolderBirthDate' => preg_replace('/(\d{2})\/(\d{2})/', '01/$1/20$2', $request->get('vencimento_cartao')),
                    ])->setBillingAddress([
                        'billingAddressStreet' => $order->endereco,
                        'billingAddressNumber' => $order->numero,
                        'billingAddressDistrict' => $order->bairro,
                        'billingAddressPostalCode' => $order->cep,
                        'billingAddressCity' => $order->cidade,
                        'billingAddressState' => $order->estado,
                    ])->send([
                        'paymentMethod' => 'creditCard',
                        'creditCardToken' => $request->get('creditCardToken'),
                        'installmentQuantity' => $request->get('parcelas'),
                        'installmentValue' => $request->get('valor_com_juros'),
                    ]);
                    break;
                case 'boleto':
                    $pagseguro = $pagseguro->send([
                        'paymentMethod' => 'boleto'
                    ]);
                    $boleto = '?boleto=' . $pagseguro->paymentLink;
                    break;
            }
            $order->pagseguro_id = $pagseguro->code;
            $order->save();
            DB::commit();
            return ['message' => 'Inscricao feita com sucesso', 'redirect' => route('pagamento_sucesso') . $boleto];
        } catch (\Throwable $th) {
            DB::rollback();
            throw new Exception($th->getMessage(), 1);
        }
    }

    public function frenet($cep, $qtde = 1)
    {
        $config = Frenet::init([
            'service' => 'logistics',
            'method' => 'ShippingQuoteWS',
            'Username' => config('services.frenet.username'),
            'Password' => config('services.frenet.password'),
            'SellerCEP' => '17930000',
        ]);
        $test = new Shipping();

        return (array) $test::getShippingQuote($config, [
            'itens' => [
                [
                    'weight' => 0.4 * $qtde,
                    'height' => 2 * $qtde,
                    'length' => 12,
                    'width' => 12,
                    'diameter' => 0,
                    'sku' => 'Com Camiseta',
                    'category' => 'MTB',
                    'isFragile' => false,
                ]
            ],
            'cep' => preg_replace('/([^\d+]+)/', '', $cep),
            'total' => 50,
        ])['data'][0];
    }
}
