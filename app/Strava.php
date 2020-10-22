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
        $activities = $this->get('activities?per_page=200&after=' . strtotime('2020-08-01') . '&before=' . strtotime('2020-08-30'));

        return collect($activities)->filter(function ($activitie) {
            return ($activitie->type == 'Ride' && $activitie->workout_type == 10 && $activitie->resource_state == 2);
        })->map(function ($activitie) {
            $this->subscription->activities()->create([
                'name' => $activitie->name,
                'distance' => $activitie->distance,
                'time' => $activitie->elapsed_time,
                'gain_elevation' => $activitie->total_elevation_gain,
                'date'=> date('Y-m-d', strtotime($activitie->start_date_local)),
                'strava_id'=>$activitie->id,
                'status'=>'Em análise',
            ]);
            return $activitie;
        })->count();
    }

    public function get($uri, array $options = [])
    {
        return json_decode((string) $this->__call('get', [
            $uri,
            $options
        ])->getBody());
    }

    public function post($uri, array $options = [])
    {
        return json_decode((string) $this->__call('post', [
            $uri,
            $options
        ])->getBody());
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
