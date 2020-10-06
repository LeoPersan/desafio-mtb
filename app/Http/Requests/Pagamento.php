<?php

namespace App\Http\Requests;

use App\Subscription;
use Illuminate\Foundation\Http\FormRequest;

class Pagamento extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $cartao = $this->metodo_pagamento == 'creditCard' ? 'required' : 'nullable';
        $cartao_endereco = $this->metodo_pagamento == 'creditCard' && $this->inscricoes[0]['metodo_envio'] == 'local' ? 'required' : 'nullable';
        $rules = [
            'regulamento' => 'required',
            'nome' => 'required|regex:/(\w+\s)+/',
            'telefone' => 'required|regex:/\(\d{2}\) \d{4,5}-\d{4}/',
            'email' => 'required|email',
            'senderHash' => 'required|min:10',
            'cpf' => 'required|regex:/\d{3}\.\d{3}\.\d{3}-\d{2}/',
            'inscricoes' => 'required|array|min:1',
            'metodo_pagamento' => 'required|in:boleto,creditCard',
            'vencimento_cartao' => $cartao . '|regex:#\d{2}/\d{2}#',
            'cep' => $cartao_endereco . '|regex:/\d{5}-\d{3}/',
            'estado' => $cartao_endereco . '|in:' . implode(',', Subscription::STATES),
            'cidade' => $cartao_endereco . '|min:3',
            'bairro' => $cartao_endereco . '|min:3',
            'endereco' => $cartao_endereco . '|regex:/(\w+\s)+/',
            'numero' => $cartao_endereco . '|min:2',
            'complemento' => 'nullable|min:2',
            'creditCardToken' => $cartao . '|min:10',
            'parcelas' => $cartao . '|min:1|max:12',
            'valor_com_juros' => $cartao . '|numeric',
        ];
        $inscricoes = $this->inscricoes ?: [];
        foreach ($inscricoes as $i => $inscricao) {
            $envio = $inscricao['metodo_envio'] == 'frenet' ? 'required' : 'nullable';
            $km = $inscricao['tipo'] == 'Apenas Camiseta' ? 'nulalble' : 'required';
            $tamanho = $inscricao['tipo'] == 'Sem Camiseta' ? 'nulalble' : 'required';
            $metodos_envio = 'frenet,local';
            if ($i > 0) {
                $i_b = $i - 1;
                while ($i_b > -1) {
                    if ($inscricoes[$i_b]['metodo_envio'] == 'frenet')
                        $metodos_envio = 'frenet,local,anterior';
                    $i_b--;
                }
            }
            $rules['inscricoes.' . $i . '.tipo'] = 'required|in:"' . implode('","', Subscription::TIPES) . '"';
            $rules['inscricoes.' . $i . '.km'] = $km . '|in:"' . implode('","', Subscription::KMS) . '"';
            $rules['inscricoes.' . $i . '.tamanho'] = $tamanho . '|in:' . implode(',', Subscription::SIZES);
            $rules['inscricoes.' . $i . '.nome_strava'] = 'required|min:3';
            $rules['inscricoes.' . $i . '.email'] = 'required|email';
            $rules['inscricoes.' . $i . '.metodo_envio'] = 'required|in:' . $metodos_envio;
            $rules['inscricoes.' . $i . '.cep'] = $envio . '|regex:/\d{5}-\d{3}/';
            $rules['inscricoes.' . $i . '.estado'] = $envio . '|in:' . implode(',', Subscription::STATES);
            $rules['inscricoes.' . $i . '.cidade'] = $envio . '|min:3';
            $rules['inscricoes.' . $i . '.bairro'] = $envio . '|min:3';
            $rules['inscricoes.' . $i . '.endereco'] = $envio . '|regex:/(\w+\s)+/';
            $rules['inscricoes.' . $i . '.numero'] = $envio . '|min:2';
            $rules['inscricoes.' . $i . '.complemento'] = 'nullable|min:2';
        }
        return $rules;
    }
}
