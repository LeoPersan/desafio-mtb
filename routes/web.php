<?php

use App\Order;
use App\Subscription;
use GuzzleHttp\Client;
use App\Mail\ContactUser;
use App\Mail\ContactAdmin;
use Illuminate\Support\Str;
use App\Http\Requests\Contact;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Eloquent\Builder;

Route::get('/config/cache', function () {
    Artisan::call('config:cache');
});
Route::get('/migrate', function () {
    Artisan::call('migrate');
});
Route::post('/frenet/{cep}/{qtde?}', 'InscricoesController@frenet');
Route::get('/frenet/{cep}/{qtde?}', 'InscricoesController@frenet');

Route::get('/', function () {
    return redirect(route('inscricoes'));
    return view('home');
})->name('home');

Route::get('/regulamento', function () {
    return view('regulamento');
})->name('regulamento');

Route::get('/painel', function () {
    Order::all()->map(function ($order) {
        $order->updateStatus();
    });
    return view('painel', [
        'total' => Subscription::whereHas('order', function (Builder $builder) {
            return $builder->whereIn('status', [1, 3]);
        })->count(),
        'duplicadas' => Subscription::groupBy('nome_strava')->whereHas('order', function (Builder $builder) {
            return $builder->whereNotNull('status');
        })->select(DB::raw('count(*) as total'))->havingRaw('total > 1 ')->get(),
        'aguardando' => Subscription::whereHas('order', function (Builder $builder) {
            return $builder->whereStatus(1);
        })->count(),
        'analise' => Subscription::whereHas('order', function (Builder $builder) {
            return $builder->whereStatus(2);
        })->count(),
        'paga' => Subscription::whereHas('order', function (Builder $builder) {
            return $builder->whereStatus(3);
        })->count(),
        'disponivel' => Subscription::whereHas('order', function (Builder $builder) {
            return $builder->whereStatus(4);
        })->count(),
        'disputa' => Subscription::whereHas('order', function (Builder $builder) {
            return $builder->whereStatus(5);
        })->count(),
        'devolvida' => Subscription::whereHas('order', function (Builder $builder) {
            return $builder->whereStatus(6);
        })->count(),
        'cancelada' => Subscription::whereHas('order', function (Builder $builder) {
            return $builder->whereStatus(7);
        })->count(),
        'debitada' => Subscription::whereHas('order', function (Builder $builder) {
            return $builder->whereStatus(8);
        })->count(),
        'retencao' => Subscription::whereHas('order', function (Builder $builder) {
            return $builder->whereStatus(9);
        })->count(),
    ]);
})->name('painel');

Route::get('/pedidos', function () {
    Order::all()->map(function ($order) {
        $order->updateStatus();
    });
    return view('pedidos', [
        'camisetas' => Subscription::where('tipo', '!=', 'Sem Camiseta')->whereHas('order', function (Builder $builder) {
            return $builder->whereStatus(3);
        })->groupBy('tamanho')->selectRaw('tamanho, count(*) as qtde')->get(),
        'qtde_medalhas' => Subscription::where('tipo', '!=', 'Apenas Camiseta')->whereHas('order', function (Builder $builder) {
            return $builder->whereStatus(3);
        })->count(),
    ]);
})->name('painel');

Route::get('/painel/inscricoes', function () {
    return view('painel_inscricoes', ['orders' => Order::search()->get()]);
})->name('painel');

Route::get('/painel/diana', function () {
    return view('painel_diana', ['orders' => Order::whereStatus(7)->get()]);
})->name('painel');

Route::get('/contato', function () {
    return view('contato');
})->name('contato');

Route::post('/contato', function (Contact $request) {
    $token = Str::random(5);
    Mail::send(new ContactUser($request, $token));
    Mail::send(new ContactAdmin($request, $token));
    return [
        'message' => 'E-mail enviado com sucesso!'
    ];
});

Route::get('/inscricoes', 'InscricoesController@inscricoes')->name('inscricoes');

Route::post('/pagamento', 'InscricoesController@pagamento')->name('pagamento');

Route::get('/pagamento/sucesso', function () {
    $boleto = ['link_boleto' => false];
    if (request()->has('boleto'))
        $boleto['link_boleto'] = request()->get('boleto');
    return view('pagamento_sucesso', $boleto);
})->name('pagamento_sucesso');

Route::get('/pagseguro', function () {
    // mail
    // https://www.strava.com/oauth/authorize?client_id=53290&response_type=code&redirect_uri=http://desafiomtb.rotaracttupipaulista.org.br/strava/strava&approval_prompt=force&scope=activity:read_all;&teste=teste
})->name('pagseguro');

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
