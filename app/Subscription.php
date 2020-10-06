<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    const SIZES = ['PP', 'P', 'M', 'G', 'GG', '3G', '4G', '5G', '6G', '7G'];

    const TIPES = ['Com Camiseta', 'Sem Camiseta', 'Apenas Camiseta'];

    const KMS = ['3000 KM', '2000 KM', '1000 KM', '500 KM', '200 KM'];

    const STATES = ['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'];

    protected $fillable = ['order_id', 'tipo', 'km', 'tamanho', 'nome_strava', 'email', 'metodo_envio', 'cep', 'estado', 'cidade', 'bairro', 'endereco', 'numero', 'complemento'];

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

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function activities()
    {
        return $this->hasMany(Activitie::class);
    }
}
