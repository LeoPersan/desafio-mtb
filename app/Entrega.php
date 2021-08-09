<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;

class Entrega extends Subscription
{
    protected $table = 'subscriptions';

    const PESOS = [
        'camiseta' => [
            'PP' => 131,
            'P' => 145,
            'M' => 157,
            'G' => 168,
            'GG' => 182,
            '3G' => 197,
            '4G' => 212,
            '5G' => 227,
            '6G' => 242,
            '7G' => 256,
        ],
        'medalha' => 51,
        'embalagem' => 11
    ];

    const ALTURAS = [
        'camiseta' => [
            'PP' => 3.7,
            'P' => 3.7,
            'M' => 3.7,
            'G' => 3.7,
            'GG' => 3.7,
            '3G' => 3.7,
            '4G' => 3.7,
            '5G' => 3.7,
            '6G' => 3.7,
            '7G' => 3.7,
        ],
        'medalha' => 0.1,
        'embalagem' => 0.2
    ];

    const REAIS = [
        'camiseta' => [
            'PP' => 40,
            'P' => 40,
            'M' => 40,
            'G' => 40,
            'GG' => 40,
            '3G' => 40,
            '4G' => 40,
            '5G' => 40,
            '6G' => 40,
            '7G' => 40,
        ],
        'medalha' => 10,
        'embalagem' => 0
    ];

    public function getInscricoesAttribute()
    {
        return collect([$this])->merge($this->order->subscriptions()->whereMetodoEnvio('anterior')->where('id','>', $this->id)->get());
    }

    public function getBensAttribute()
    {
        return $this->inscricoes->mapWithKeys(function ($inscricao) {
            return [$inscricao->nome_strava => [
                'camiseta' => $inscricao->tamanho ?? false,
                'medalha' => $inscricao->tipo != 'Apenas Camiseta',
            ]];
        });
    }

    public function getReaisAttribute()
    {
        return ceil($this->bens->sum(function ($bem) {
            return (static::REAIS['camiseta'][$bem['camiseta']] ?? 0) + (static::REAIS['medalha']*$bem['medalha']);
        }) + static::REAIS['embalagem']);
    }

    public function getGramasAttribute()
    {
        return $this->bens->sum(function ($bem) {
            return (static::PESOS['camiseta'][$bem['camiseta']] ?? 0) + (static::PESOS['medalha']*$bem['medalha']);
        }) + static::PESOS['embalagem'];
    }

    public function getAlturaAttribute()
    {
        return ceil($this->bens->sum(function ($bem) {
            return (static::ALTURAS['camiseta'][$bem['camiseta']] ?? 0) + (static::ALTURAS['medalha']*$bem['medalha']);
        }) + static::ALTURAS['embalagem']);
    }

    public function getLarguraAttribute()
    {
        return 16;
    }

    public function getComprimentoAttribute()
    {
        return 24;
    }

    public static function boot()
    {
        static::addGlobalScope('nao_postado', function (Builder $builder) {
            // return $builder->wherePostado(0);
        });

        static::addGlobalScope('frenet', function (Builder $builder) {
            return $builder->whereMetodoEnvio('frenet');
        });

        static::addGlobalScope('validas', function (Builder $builder) {
            return $builder->whereHas('order', function (Builder $builder) {
                return $builder->whereIn('status',[3,4]);
            });
        });

        parent::boot();
    }
}
