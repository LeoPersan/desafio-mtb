<?php

namespace App\Http\Controllers;

use App\Strava;
use App\Subscription;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Mail\Atleta\NaoEncontrado;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Atleta\Senha;

class AtletaController extends Controller
{
    public function strava(Request $request)
    {
        $token = Strava::getToken($request->get('code'));
        $subscription = Subscription::whereNomeStrava($token->athlete->firstname.' '.$token->athlete->lastname)->first();
        if (!$subscription) {
            Mail::send(new NaoEncontrado($token));
            return view('atleta.nao_encontrado');
        }
        $subscription->id_athlete = $token->athlete->id;
        $subscription->sexo = $token->athlete->sex;
        $subscription->access_token = $token->access_token;
        $subscription->refresh_token = $token->refresh_token;
        $subscription->senha = $token->athlete->id;
        $subscription->save();
        auth('subscription')->login($subscription);
        return redirect(route('atleta.senha'));
        $strava = new Client([
            'base_uri' => 'https://www.strava.com/api/v3/',
            'headers' => [
                'Authorization' => 'Bearer ' . $token->access_token
            ]
        ]);

        // $activities = collect(json_decode((string) $strava->get('activities?per_page=200&after=' . strtotime('2020-08-01') . '&before=' . strtotime('2020-08-30'))->getBody()));

        // $days = [];
        // $sum_distance = 0;
        // $max_distance = 80000;
        // $activities = $activities->sort(function ($a, $b) {
        //     return $a->total_elevation_gain < $b->total_elevation_gain;
        // })->filter(function ($activitie) use (&$days, &$sum_distance, $max_distance) {
        //     $day = date('Y-m-d', strtotime($activitie->start_date_local));
        //     if (
        //         $activitie->type != 'Ride' ||
        //         $activitie->workout_type != 10 ||
        //         $activitie->resource_state != 2 ||
        //         in_array($day, $days) ||
        //         $sum_distance >= $max_distance
        //     ) return false;
        //     $days[] = $day;
        //     $sum_distance += $activitie->distance;
        //     return true;
        // });

        // return view('activities', ['activities' => $activities]);
    }

    public function senha()
    {
        return view('atleta.senha');
    }

    public function postSenha(Senha $request)
    {
        $atleta = Subscription::find(auth()->user()->id);
        if (!Hash::check(auth()->user()->id_athlete, $atleta->senha))
            abort(422, 'Senha inválida');
        $atleta->senha = $request->senha_nova;
        $atleta->save();
        return [
            'message' => 'Senha alterada com sucesso!',
            'redirect' => route('atleta'),
        ];
    }

    public function home()
    {
        return view('atleta.home');
    }

}
