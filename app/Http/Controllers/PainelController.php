<?php

namespace App\Http\Controllers;

use App\Activitie;
use App\Entrega;
use App\Order;
use App\Subscription;
use App\Mail\ValidSubscription;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PainelController extends Controller
{
    public function painel()
    {
        return view('painel', [
            'total' => Subscription::whereHas('order', function (Builder $builder) {
                return $builder->whereIn('status', [3, 4]);
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
        return view('pedidos', [
            'camisetas' => Subscription::where('tipo', '!=', 'Sem Camiseta')->whereHas('order', function (Builder $builder) {
                return $builder->whereIn('status',[3,4]);
            })->groupBy('tamanho')->selectRaw('tamanho, count(*) as qtde')->get(),
            'camisetas_a_parte' => [
                'GG' => 1, // Carlos
                'G' => 1, // Leonardo
                'M' => 1, // Leticia
            ],
            'camisetas_pedidas' => [
                '3G' => 2,
                '4G' => 1,
                '6G' => 3,
                '7G' => 1,
                'G' => 19,
                'GG' => 10,
                'M' => 15,
                'P' => 15,
                'PP' => 6,
            ],
            'qtde_medalhas' => Subscription::where('tipo', '!=', 'Apenas Camiseta')->whereHas('order', function (Builder $builder) {
                return $builder->whereIn('status',[3,4]);
            })->count(),
        ]);
    }

    public function inscricoes()
    {
        return view('painel.inscricoes', ['orders' => Order::search()->get()]);
    }

    public function diana()
    {
        return view('painel.diana', ['orders' => Order::whereStatus(7)->get()]);
    }

    public function update()
    {
        Order::all()->map(function ($order) {
            $order->updateStatus();
        });
    }

    public function configCache()
    {
        Artisan::call('config:cache');
    }

    public function migrate()
    {
        Artisan::call('migrate');
    }

    public function envioEmails()
    {
        set_time_limit(100000);
        $subscriptions = Subscription::valids()->where('tipo','!=','Apenas Camiseta')->whereNull('senha')->get()->map(function ($subscription) {
            Mail::send(new ValidSubscription($subscription));
            $subscription->email_enviado = 1;
            $subscription->save();
            return $subscription;
        });
        return $subscriptions->count();
    }

    public function semSenha()
    {
        $subscriptions = Subscription::valids()->where('tipo','!=','Apenas Camiseta')->whereNull('senha')->whereNull('subscriptions.updated_at')->take(1)->get()->map(function ($subscription) {
            $subscription->touch();
            return $subscription;
        });
        return view('painel.sem_senha', ['subscriptions' => $subscriptions]);
    }

    public function semAtividades()
    {
        $subscriptions = Subscription::valids()->where('tipo','!=','Apenas Camiseta')->whereNull('subscriptions.updated_at')->doesntHave('activities')->take(1)->get()->map(function ($subscription) {
            $subscription->touch();
            return $subscription;
        });
        return view('painel.sem_atividades', ['subscriptions' => $subscriptions]);
    }

    public function emailDuplicado()
    {
        $orders = collect([]);
        foreach (Subscription::valids()->select('email')->groupBy('email')->whereNull('subscriptions.updated_at')->havingRaw('COUNT(email) > ?',[1])->take(1)->get() as $subscription) {
            Subscription::valids()->whereEmail($subscription->email)->get()->map(function ($subsription) {
                $subsription->touch();
            });
            $orders[$subscription->email] = Subscription::valids()->whereEmail($subscription->email)->first()->order;
        }
        return view('painel.email_duplicado', ['orders' => $orders]);
    }

    public function validarAtividades()
    {
        $atletas = collect();
        foreach (['200 KM', '500 KM', '1000 KM', '3000 KM'] as $km) {
            foreach (['F', 'M'] as $sexo) {
                $atletas = $atletas->merge(Subscription::ranking([
                    'sexo' => $sexo,
                    'km' => $km,
                    'take' => 1,
                ])->map(function ($subscription) {
                    return $subscription->id ?? null;
                }));
            }
        }
        // $atletas = [81];
        return view('painel.validar_atividades', [
            'atividade' => Activitie::whereIn('subscription_id', $atletas)->analisando()->whereActive(1)->inRandomOrder()->first(),
        ]);
    }

    public function postValidarAtividades(Request $request)
    {
        if ($request->has('status') && $request->has('id'))
            Activitie::whereId($request->id)->update(['status' => $request->status]);
        return [
            'redirect' => route('validar_atividades'),
        ];
    }

    public function certificados()
    {
        return view('painel.certificados', [
            'concluidos' => Subscription::concluidos(),
            'nao_concluidos' => Subscription::naoConcluidos(),
        ]);
    }

    public function ranking()
    {
        return view('painel.ranking');
    }

    public function etiquetas()
    {
        // $atletas = collect();
        // foreach (['200 KM', '500 KM', '1000 KM', '3000 KM'] as $km) {
        //     foreach (['F', 'M'] as $sexo) {
        //         $atletas = $atletas->merge(Subscription::ranking([
        //             'sexo' => $sexo,
        //             'km' => $km,
        //             'take' => 1,
        //         ])->map(function ($subscription) {
        //             return $subscription->id ?? null;
        //         }));
        //     }
        // }
        return view('painel.etiquetas', [
            'entregas' => Entrega::orderBy('nome_strava')->get(),
            // 'entregas' => Entrega::withoutGlobalScope('nao_postado')->wherePostado(1)->get()->sortByDesc(function ($entrega) {
            //     return $entrega->gramas;
            // }),
            // 'entregas' => Entrega::withoutGlobalScopes()->whereIn('id', $atletas)->get(),
        ]);
    }

    public function local()
    {
        return view('painel.local', [
            'inscricoes' => Subscription::whereMetodoEnvio('local')->orderBy('nome_strava')->get(),
        ]);
    }

    public function etiquetaEntrega(Entrega $entrega)
    {
        $entrega->postado = 1;
        $entrega->save();
        return [
            'message' => 'Salvo',
        ];
    }

    public function selecionarAtividades()
    {
        Subscription::valids()->where('tipo','!=','Apenas Camiseta')->has('activities')->get()->filter(function ($subscription) {
            return $subscription->total_distance < $subscription->km_int;
        })->map(function ($subscription) {
            $data = '';
            $subscription->activities->map(function ($activitie) use (&$data, &$subscription) {
                if ($data != $activitie->data && $subscription->km_int+20000 >= $subscription->total_distance+$activitie->distance) {
                    $data = $activitie->data;
                    $activitie->active = true;
                    $activitie->save();
                }
            });
        });
    }
}
