<?php

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Route;

Route::group([], function () {
    Route::get('/', 'HomeController@home')->name('home');
    Route::get('/regulamento', 'HomeController@regulamento')->name('regulamento');
    Route::get('/contato', 'HomeController@contato')->name('contato');
    Route::post('/contato', 'HomeController@postContato');
});

Route::group(['prefix' => 'inscricoes'], function () {
    Route::get('/', 'InscricoesController@inscricoes')->name('inscricoes');
    Route::post('/pagamento', 'InscricoesController@pagamento')->name('pagamento');
    Route::get('/pagamento/sucesso', 'InscricoesController@pagamentoSucesso')->name('pagamento_sucesso');
    Route::post('/frenet/{cep}/{qtde?}', 'InscricoesController@frenet')->name('frenet');
});

Route::group(['prefix' => 'painel'], function () {
    Route::get('/', 'PainelController@painel')->name('painel');
    Route::get('/update', 'PainelController@update');
    Route::get('/pedidos', 'PainelController@pedidos')->name('painel.pedidos');
    Route::get('/inscricoes', 'PainelController@inscricoes')->name('painel.inscricoes');
    Route::get('/painel/diana', 'PainelController@diana')->name('painel.diana');
    Route::get('/config/cache', 'PainelController@configCache');
    Route::get('/migrate', 'PainelController@migrate');
    Route::get('/envio_emails', 'PainelController@envioEmails');
});

Route::group(['prefix' => 'atleta'], function () {
    Route::get('/strava', function () {
        // dd(request()->all());
        $token = json_decode((string) (new Client)->post('https://www.strava.com/oauth/token', [
            'form_params' => [
                'client_id' => '53290',
                'client_secret' => '17a8e260be0ffac7d8102d5b44131001afb1ed5e',
                'code' => request()->get('code'),
                'grant_type' => 'authorization_code',
            ],
        ])->getBody());
        dd($token);
        // $token = new stdClass();
        // $token->access_token = '4d3ea421698e702d9ee78ed9c35e9ffa1c8275f2';
        $strava = new Client([
            'base_uri' => 'https://www.strava.com/api/v3/',
            'headers' => [
                'Authorization' => 'Bearer ' . $token->access_token
            ]
        ]);

        $activities = collect(json_decode((string) $strava->get('activities?per_page=200&after=' . strtotime('2020-08-01') . '&before=' . strtotime('2020-08-30'))->getBody()));

        $days = [];
        $sum_distance = 0;
        $max_distance = 80000;
        $activities = $activities->sort(function ($a, $b) {
            return $a->total_elevation_gain < $b->total_elevation_gain;
        })->filter(function ($activitie) use (&$days, &$sum_distance, $max_distance) {
            $day = date('Y-m-d', strtotime($activitie->start_date_local));
            if (
                $activitie->type != 'Ride' ||
                $activitie->workout_type != 10 ||
                $activitie->resource_state != 2 ||
                in_array($day, $days) ||
                $sum_distance >= $max_distance
            ) return false;
            $days[] = $day;
            $sum_distance += $activitie->distance;
            return true;
        });

        return view('activities', ['activities' => $activities]);
    });
});
