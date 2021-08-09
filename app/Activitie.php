<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Activitie extends Model
{
    const STATUS = ['Em análise', 'Reprovado', 'Aprovada'];

    protected $fillable = ['subscription_id', 'strava_id', 'name', 'date', 'distance', 'gain_elevation', 'time', 'status', 'active', 'max_speed'];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function getDataAttribute()
    {
        return date('d/m/Y', strtotime($this->attributes['date']));
    }

    public function getDistanciaAttribute()
    {
        return number_format($this->attributes['distance']/1000, 1, ',', '.').' km';
    }

    public function getVelocidadeMaximaAttribute()
    {
        return number_format($this->attributes['max_speed'], 2, ',', '.').' km/h';
    }

    public function getMediaElevacaoAttribute()
    {
        return $this->attributes['gain_elevation']/$this->attributes['distance'];
    }

    public function getGanhoDeAltitudeAttribute()
    {
        return number_format($this->attributes['gain_elevation'], 1, ',', '.').' m';
    }

    public function getTempoAttribute()
    {
        return gmdate('H:i:s', $this->attributes['time']);
    }

    public function getVelocidadeMediaAttribute()
    {
        return ($this->attributes['distance']/1000)/($this->attributes['time']/3600);
    }

    public function getVelocidadeMediaFormatadoAttribute()
    {
        return number_format($this->velocidade_media).' km/h';
    }

    public function scopeAnalisando(Builder $builder)
    {
        return $builder->whereStatus('Em análise');
    }

    public function scopeAtivos(Builder $builder)
    {
        return $builder->whereActive(1);
    }

    protected static function boot()
    {
        static::addGlobalScope('nao_reprovado', function (Builder $builder) {
            return $builder->where('status','!=','Reprovado');
        });
        static::addGlobalScope('ordem', function (Builder $builder) {
            return $builder->orderBy('date','desc')->orderBy('gain_elevation','desc');
        });

        parent::boot();
    }
}
