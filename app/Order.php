<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Artistas\PagSeguro\PagSeguroFacade as PagSeguro;
use Illuminate\Database\Eloquent\Builder;

class Order extends Model
{
    protected $fillable = ['nome', 'telefone', 'email', 'cpf', 'metodo_pagamento', 'vencimento_cartao', 'cep', 'estado', 'cidade', 'bairro', 'endereco', 'numero', 'complemento', 'parcelas', 'valor_com_juros', 'preco_envio', 'pagseguro_id', 'status'];

    public function setSubscriptionsAttribute($values)
    {
        foreach ($values as $subscription) {
            $this->subscriptions()->create($subscription);
        }
    }

    public function scopeSearch(Builder $builder)
    {
        if (!request()->has('status')) return;
        return $builder->whereStatus(request()->get('status'));
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function updateStatus()
    {
        if (!$this->pagseguro_id or $this->status == 3) return false;
        if (strlen($this->pagseguro_id) < 39)
            $this->status = PagSeguro::transaction($this->pagseguro_id, 'transaction')->status;
        else
            $this->status = PagSeguro::notification($this->pagseguro_id, 'transaction')->status;
        $this->save();
    }
}
