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
        Subscription::valids()->whereNotNull('refresh_token')->whereEmail('nathalia_mj@hotmail.com')->get()->map(function ($subscription) {
            getActivities:
            try {
                $this->info($subscription->nome_strava);
                $this->info((new Strava($subscription))->getActivities());
            } catch (\Throwable $th) {
                if (preg_match('/429 Too Many Requests/', $th->getMessage())) {
                    for ($i=0; $i < 15; $i++) {
                        $this->line('Esperando: faltam '.(15-$i).' minutos');
                        sleep(60);
                    }
                    goto getActivities;
                } else {
                    $this->error(print_r([
                        'erro' => $th->getMessage(),
                        'subscription' => $subscription->toArray(),
                    ]));
                }
            }
        });
    }
}
