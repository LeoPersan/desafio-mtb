<?php

namespace App\Console\Commands;

use App\Strava;
use App\Subscription;
use Illuminate\Console\Command;

class AtletaAtividades extends Command
{
    protected $signature = 'atleta:atividades';

    protected $description = 'Atualizar as atividades dos atletas cadastrados!';

    public function handle()
    {
        dd(Subscription::valids()->whereNotNull('refresh_token')->get()->map(function ($subscription) {
            return (new Strava($subscription))->getActivities();
        }));
    }
}
