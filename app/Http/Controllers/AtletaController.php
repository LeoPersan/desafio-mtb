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

    public function atividades()
    {
        return view('atleta.atividades',[
            'atividades' => auth()->user()->activities,
        ]);
    }

    public function postAtividades(Request $request)
    {
        auth()->user()->activities->map(function ($activitie) use ($request){
            $activitie->active = in_array($activitie->id, $request->atividades??[]);
            $activitie->save();
        });
        return [
            'message' => 'Ranking atualizado com sucesso!',
            'redirect' => route('atleta.atividades'),
        ];
    }

}
