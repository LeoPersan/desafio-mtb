<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Activitie extends Model
{
    const STATUS = ['Em análise', 'Reprovado', 'Aprovada'];

    protected $fillable = ['subscription_id', 'strava_id', 'name', 'date', 'distance', 'gain_elevation', 'time', 'status', 'active'];

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
        return number_format($this->attributes['distance']/1000, 3, ',', '.').' km';
    }

    public function getGanhoDeAltitudeAttribute()
    {
        return number_format($this->attributes['gain_elevation'], 1, ',', '.').' m';
    }

    public function getTempoAttribute()
    {
        return gmdate('H:i:s', $this->attributes['time']);
    }

    protected static function boot()
    {
        static::addGlobalScope('nao_reprovado', function (Builder $builder) {
            return $builder->where('status','!=','Reprovado');
        });

        parent::boot();
    }
}
