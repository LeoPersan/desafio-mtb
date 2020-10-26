<?php

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group([], function () {
    Route::get('/', 'HomeController@home')->name('home');
    Route::get('/regulamento', 'HomeController@regulamento')->name('regulamento');
    Route::get('/contato', 'HomeController@contato')->name('contato');
    Route::post('/contato', 'HomeController@postContato');
});

Route::group(['prefix' => 'inscricoes'], function () {
    Route::get('/', 'InscricoesController@inscricoes')->name('inscricoes');
    Route::post('/pagamento', 'InscricoesController@pagamento')->name('pagamento');
    Route::get('/pagamento/sucesso', 'InscricoesController@pagamentoSucesso')->name('pagamento_sucesso');
    Route::post('/frenet/{cep}/{qtde?}', 'InscricoesController@frenet')->name('frenet');
});

Route::group(['prefix' => 'painel'], function () {
    Route::get('/', 'PainelController@painel')->name('painel');
    Route::get('/update', 'PainelController@update');
    Route::get('/pedidos', 'PainelController@pedidos')->name('painel.pedidos');
    Route::get('/inscricoes', 'PainelController@inscricoes')->name('painel.inscricoes');
    Route::get('/painel/diana', 'PainelController@diana')->name('painel.diana');
    Route::get('/config/cache', 'PainelController@configCache');
    Route::get('/migrate', 'PainelController@migrate');
    Route::get('/envio_emails', 'PainelController@envioEmails');
});

Route::group(['prefix' => 'atleta'], function () {
    Route::get('/login', 'AtletaLoginController@login')->name('atleta.login');
    Route::post('/login', 'AtletaLoginController@postLogin');
    Route::get('/logout', 'AtletaLoginController@logout')->name('logout');
    Route::get('/password/recover', 'AtletaLoginController@passwordRecover')->name('atleta.password.recover');
    Route::post('/password/recover', 'AtletaLoginController@postPasswordRecover');
    Route::get('/password/reset/{token?}', 'AtletaLoginController@passwordReset')->name('atleta.password.reset');
    Route::post('/password/reset/{token?}', 'AtletaLoginController@postPasswordReset');
    Route::get('/strava', 'AtletaController@strava');
    Route::group(['middleware' => 'auth:subscription'], function () {
        Route::get('/senha', 'AtletaController@senha')->name('atleta.senha');
        Route::post('/senha', 'AtletaController@postSenha');
        Route::get('', 'AtletaController@home')->name('atleta');
        Route::get('atvidades', 'AtletaController@atvidades')->name('atleta.atvidades');
    });
});
