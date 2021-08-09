<?php

namespace App;

use GuzzleHttp\Client;

class Strava extends Client
{
    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
        parent::__construct(['base_uri' => 'https://www.strava.com/api/v3/']);
        $token = $this->post('oauth/token',[
            'form_params' => [
                'client_id' => config('services.strava.id'),
                'client_secret' => config('services.strava.secret'),
                'grant_type' => 'refresh_token',
                'refresh_token' => $subscription->refresh_token,
            ],
        ]);
        $subscription->access_token = $token->access_token;
        $subscription->refresh_token = $token->refresh_token;
        $subscription->save();
        $config = [
            'base_uri' => 'https://www.strava.com/api/v3/',
            'headers' => [
                'Authorization' => 'Bearer ' . $subscription->access_token
            ]
        ];
        parent::__construct($config);
    }

    public function getActivities()
    {
        $activities = $this->get('activities?per_page=200&after=' . strtotime('2020-11-01') . '&before=' . strtotime('2020-11-30 23:59:59'));
        return collect($activities)->filter(function ($activitie) {
            return ($activitie->type == 'Ride' && $activitie->resource_state == 2);
        })->map(function ($activitie) {
            $this->subscription->activities()->withoutGlobalScopes()->updateOrCreate(
                ['strava_id'=>$activitie->id],[
                'name' => $activitie->name,
                'distance' => $activitie->distance,
                'time' => $activitie->moving_time,
                'gain_elevation' => $activitie->total_elevation_gain,
                'max_speed' => $activitie->max_speed,
                'date'=> date('Y-m-d', strtotime('+3 hours', strtotime($activitie->start_date_local))),
            ]);
            return $activitie;
        })->count();
    }

    public function __call($method, $args)
    {
        return json_decode((string) parent::__call($method,$args)->getBody());
    }

    public static function getToken($code)
    {
        return json_decode((string) (new parent())->post('https://www.strava.com/oauth/token', [
            'form_params' => [
                'client_id' => config('services.strava.id'),
                'client_secret' => config('services.strava.secret'),
                'code' => $code,
                'grant_type' => 'authorization_code',
            ],
        ])->getBody());
    }
}
