<?php

namespace App\Http\Controllers;

use App\Order;
use App\Subscription;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Eloquent\Builder;

class PainelController extends Controller
{
    public function painel()
    {
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
    }

    public function pedidos()
    {
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
    }

    public function inscricoes()
    {
        return view('painel_inscricoes', ['orders' => Order::search()->get()]);
    }

    public function diana()
    {
        return view('painel_diana', ['orders' => Order::whereStatus(7)->get()]);
    }

    public function configCache()
    {
        Artisan::call('config:cache');
    }

    public function migrate()
    {
        Artisan::call('migrate');
    }
}
