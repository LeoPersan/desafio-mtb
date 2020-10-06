<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activitie extends Model
{
    const STATUS = ['Em análise', 'Inválida', 'Aprovada - Ativa', 'Aprovada - Inativa'];

    protected $fillable = ['subscription_id', 'strava_id', 'name', 'date', 'distance', 'gain_elevation', 'time', 'status'];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
