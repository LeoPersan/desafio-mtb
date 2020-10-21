<?php

namespace App;

use GuzzleHttp\Client;

class Strava extends Client
{
    public function post($uri, array $options = [])
    {
        return json_decode((string) $this->__call('post', [
            $uri,
            $options
        ])->getBody());
    }

    public static function getToken($code)
    {
        return (new self())->post('https://www.strava.com/oauth/token', [
            'form_params' => [
                'client_id' => config('services.strava.id'),
                'client_secret' => config('services.strava.secret'),
                'code' => $code,
                'grant_type' => 'authorization_code',
            ],
        ]);
    }
}
