<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact;
use App\Mail\ContactAdmin;
use App\Mail\ContactUser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function home()
    {
        if (date('Y-m-d H:i:s') > '2020-10-31 23:00:00')
            return view('encerradas');
        return redirect(route('inscricoes'));
        return view('home');
    }

    public function regulamento()
    {
        return view('regulamento');
    }

    public function contato()
    {
        return view('contato');
    }

    public function postContato(Contact $request) {
        $token = Str::random(5);
        Mail::send(new ContactUser($request, $token));
        Mail::send(new ContactAdmin($request, $token));
        return [
            'message' => 'E-mail enviado com sucesso!'
        ];
    }
}
