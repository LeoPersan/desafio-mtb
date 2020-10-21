<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Subscription extends Authenticatable
{
    const SIZES = ['PP', 'P', 'M', 'G', 'GG', '3G', '4G', '5G', '6G', '7G'];

    const TIPES = ['Com Camiseta', 'Sem Camiseta', 'Apenas Camiseta'];

    const KMS = ['3000 KM', '2000 KM', '1000 KM', '500 KM', '200 KM'];

    const STATES = ['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'];

    protected $fillable = ['order_id', 'tipo', 'km', 'tamanho', 'nome_strava', 'email', 'metodo_envio', 'cep', 'estado', 'cidade', 'bairro', 'endereco', 'numero', 'complemento', 'id_athlete', 'access_token', 'refresh_token'];

    public function setSenhaAttribute($value)
    {
        $this->attributes['senha'] = bcrypt($value);
    }

    public function getDescricaoAttribute()
    {
        return 'Inscrição de ' . $this->nome_strava . ' - ' . $this->tipo;
    }

    public function getPrecoAttribute()
    {
        switch ($this->tipo) {
            case 'Com Camiseta':
                return 80;
            case 'Sem Camiseta':
                return 40;
            case 'Apenas Camiseta':
                return 60;
        }
    }

    public function getAddressAttribute()
    {
        switch ($this->metodo_envio) {
            case 'local':
                return $this->fill([
                    'cep' => '17930000',
                    'estado' => 'SP',
                    'cidade' => 'Tupi Paulista',
                    'endereco' => 'Rua Francisco Perpétuo Júnior',
                    'numero' => '270',
                    'complemento' => 'Sede do Rotary',
                ]);
            case 'anterior':
                if (!isset($this->id)) break;
                $anterior = Order::find($this->order_id)->subscriptions()->where('id','<',$this->id)->whereMetodoEnvio('frenet')->orderBy('id', 'desc')->first();
                return $this->fill([
                    'cep' => $anterior->cep,
                    'estado' => $anterior->estado,
                    'cidade' => $anterior->cidade,
                    'endereco' => $anterior->endereco,
                    'numero' => $anterior->numero,
                    'complemento' => $anterior->complemento,
                ]);
        }
        return $this;
    }

    public function getCepAttribute()
    {
        return $this->address->attributes['cep'];
    }

    public function getEstadoAttribute()
    {
        return $this->address->attributes['estado'];
    }

    public function getCidadeAttribute()
    {
        return $this->address->attributes['cidade'];
    }

    public function getEnderecoAttribute()
    {
        return $this->address->attributes['endereco'];
    }

    public function getNumeroAttribute()
    {
        return $this->address->attributes['numero'];
    }

    public function getComplementoAttribute()
    {
        return $this->address->attributes['complemento'];
    }

    public function scopeValids(Builder $builder)
    {
        return $builder->whereHas('order', function (Builder $builder) {
            return $builder->whereStatus(3);
        });
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function activities()
    {
        return $this->hasMany(Activitie::class);
    }
}
