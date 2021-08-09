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
use Illuminate\Support\Facades\Storage;

class AtletaController extends Controller
{
    public function strava(Request $request)
    {
        $token = Strava::getToken($request->get('code'));
        $subscription = Subscription::whereNomeStrava($token->athlete->firstname.' '.$token->athlete->lastname)->first();
        if (!$subscription) {
            session(['token' => json_encode((array) $token)]);
            return view('atleta.senha', [
                'action' => route('atleta.nao_encontrado'),
            ]);
        }
        $subscription->id_athlete = $token->athlete->id;
        $subscription->sexo = $token->athlete->sex;
        $subscription->access_token = $token->access_token;
        $subscription->refresh_token = $token->refresh_token;
        $subscription->senha = $token->athlete->id;
        $subscription->save();
        if ($subscription->tipo == 'Apenas Camiseta')
            return view('atleta.erro_apenas_camiseta');
        auth('subscription')->login($subscription);
        return redirect(route('atleta.senha'));
    }

    public function nao_encontrado(Senha $request)
    {
        $token = json_decode(session('token'));
        $token->senha = $request->senha;
        Storage::put($token->athlete->firstname.' '.$token->athlete->lastname.'.txt', print_r($token, true));
        return [
            'message' => 'Senha alterada com sucesso!',
            'redirect' => route('atleta.obrigado'),
        ];
    }

    public function obrigado()
    {
        return view('atleta.nao_encontrado');
    }

    public function senha()
    {
        return view('atleta.senha', [
            'action' => route('atleta.senha'),
        ]);
    }

    public function postSenha(Senha $request)
    {
        $atleta = Subscription::find(auth()->user()->id);
        if (!Hash::check(auth()->user()->id_athlete, $atleta->senha))
            abort(422, 'Senha inválida');
        $atleta->senha = $request->senha;
        $atleta->save();
        return [
            'message' => 'Senha alterada com sucesso!',
            'redirect' => route('atleta'),
        ];
    }

    public function home()
    {
        return view('atleta.home',[
            'atividades' => auth()->user()->activities,
            'atividades_reprovadas' => auth()->user()->activities()->withOutGlobalScopes()->whereStatus('Reprovado')->get(),
        ]);
    }

    public function postAtividades(Request $request)
    {
        $data = '';
        auth()->user()->activities->map(function ($activitie) {
            $activitie->active = false;
            $activitie->save();
        });
        auth()->user()->activities->map(function ($activitie) use ($request, &$data) {
            if (
                in_array($activitie->id, $request->atividades??[]) && $data != $activitie->data
                && auth()->user()->km_int+20000 >= auth()->user()->total_distance+$activitie->distance
            ) {
                $data = $activitie->data;
                $activitie->active = true;
                $activitie->save();
            }
        });
        return [
            'message' => 'Ranking atualizado com sucesso!',
            'redirect' => route('atleta'),
        ];
    }

    public function ranking()
    {
        return view('atleta.ranking', [
            'ciclistas' => Subscription::ranking(),
        ]);
    }

}
