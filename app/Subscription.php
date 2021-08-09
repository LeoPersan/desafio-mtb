<?php

namespace App;

use DateTime;
use Illuminate\Support\Str;
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

    public function capitile($texto)
    {
        $partes = explode(' ', Str::lower($texto));
        foreach ($partes as &$parte) {
            if (in_array($parte, ['de', 'dos', 'do', 'da'])) continue;
            $parte = Str::ucfirst($parte);
        }
        return implode(' ', $partes);
    }

    public function getNomeStravaAttribute()
    {
        return $this->capitile($this->attributes['nome_strava']);
    }

    public function getDescricaoAttribute()
    {
        return 'Inscrição de ' . $this->nome_strava . ' - ' . $this->tipo;
    }

    public function getKmIntAttribute()
    {
        return ((int) $this->attributes['km'])*1000;
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
                $this->fill([
                    'cep' => '17930000',
                    'estado' => 'SP',
                    'cidade' => 'Tupi Paulista',
                    'endereco' => 'Rua Francisco Perpétuo Júnior',
                    'numero' => '270',
                    'complemento' => 'Sede do Rotary',
                ]);
                break;
            case 'anterior':
                if (!isset($this->id)) break;
                $anterior = Order::find($this->order_id)->subscriptions()->where('id','<',$this->id)->whereMetodoEnvio('frenet')->orderBy('id', 'desc')->first();
                $this->fill([
                    'cep' => $anterior->cep ?? null,
                    'estado' => $anterior->estado ?? null,
                    'cidade' => $anterior->cidade ?? null,
                    'endereco' => $anterior->endereco ?? null,
                    'numero' => $anterior->numero ?? null,
                    'complemento' => $anterior->complemento ?? null,
                ]);
                break;
        }
        $this->save();
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
        return $this->capitile($this->address->attributes['cidade']);
    }

    public function getEnderecoAttribute()
    {
        return $this->capitile($this->address->attributes['endereco']);
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
            return $builder->whereIn('status',[3,4]);
        });
    }

    public function getItensAttribute()
    {
        $itens = [];
        $itens[$this->nome_strava]['camiseta'] = $this->tamanho;
        $itens[$this->nome_strava]['medalha'] = $this->km != null;
        $this->order->subscriptions()->whereMetodoEnvio('anterior')->where('id','>', $this->id)->get()->map(function ($subscription) use (&$itens) {
            $itens[$subscription->nome_strava]['camiseta'] = $subscription->tamanho;
            $itens[$subscription->nome_strava]['medalha'] = $subscription->km != null;
        });
        return $itens;
    }

    public function getTotalDistanceAttribute()
    {
        return $this->activities()->ativos()->sum('distance');
    }

    public function getDistanciaTotalAttribute()
    {
        return number_format($this->total_distance/1000, 1, ',', '.').' km';
    }

    public function getTotalElevationAttribute()
    {
        return $this->activities()->ativos()->sum('gain_elevation');
    }

    public function getElevacaoTotalAttribute()
    {
        return number_format($this->total_elevation, 1, ',', '.').' m';
    }

    public function scopeConcluidos(Builder $builder)
    {
        return $builder->where('tipo', '!=', 'Apenas Camiseta')->get()->filter(function ($subscription) {
            return $subscription->total_distance >= $subscription->km_int;
        });
    }

    public function scopeNaoConcluidos(Builder $builder)
    {
        return $builder->where('tipo', '!=', 'Apenas Camiseta')->get()->filter(function ($subscription) {
            return $subscription->total_distance < $subscription->km_int;
        });
    }

    public function scopeRanking(Builder $builder, $params = [])
    {
        $request = array_merge(request()->all(),$params);
        $builder = isset($request['km']) ? $builder->whereKm($request['km']) : $builder;
        $builder = isset($request['sexo']) ? $builder->whereSexo($request['sexo']) : $builder;
        $models = $builder->valids()->where('tipo', '!=', 'Apenas Camiseta')->get()->filter(function ($subscription) {
            return $subscription->total_distance >= $subscription->km_int;
        })->sortByDesc(function ($subscription) {
            return $subscription->total_elevation;
        });
        if (!$models->count())
            $models = $models->merge([new Subscription(['nome_strava' => 'Ninguém completou a quilometragem!'])]);
        $models = $models->merge($builder->valids()->where('tipo', '!=', 'Apenas Camiseta')->get()->filter(function ($subscription) {
            return $subscription->total_distance < $subscription->km_int;
        })->sortByDesc(function ($subscription) {
            return $subscription->total_elevation;
        }));
        return $models->forPage($request['page'] ?? 1, $request['take'] ?? 1000);
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
