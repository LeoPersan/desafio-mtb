<?php

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Artisan;
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

Route::group(['prefix' => 'atletas'], function () {
    Route::get('/ranking', 'PainelController@ranking');
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
    Route::get('/sem_senha', 'PainelController@semSenha');
    Route::get('/sem_atividades', 'PainelController@semAtividades');
    Route::get('/email_duplicado', 'PainelController@emailDuplicado');
    Route::get('/validar_atividades', 'PainelController@validarAtividades')->name('validar_atividades');
    Route::post('/validar_atividades', 'PainelController@postValidarAtividades');
    Route::get('/selecionar_atividades', 'PainelController@selecionarAtividades');
    Route::get('/certificados', 'PainelController@certificados')->name('certificados');
    Route::get('/ranking', 'PainelController@ranking');
    Route::get('/local', 'PainelController@local');
    Route::get('/etiquetas', 'PainelController@etiquetas');
    Route::post('/etiquetas/{entrega}', 'PainelController@etiquetaEntrega')->name('entregue');
    Route::get('/teste', function () {
        Artisan::call('atleta:atividades');
    });
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
    Route::post('/strava', 'AtletaController@nao_encontrado')->name('atleta.nao_encontrado');
    Route::get('/obrigado', 'AtletaController@obrigado')->name('atleta.obrigado');
    Route::get('/ranking', 'AtletaController@ranking')->name('atleta.ranking');
    Route::group(['middleware' => 'auth:subscription'], function () {
        Route::get('/senha', 'AtletaController@senha')->name('atleta.senha');
        Route::post('/senha', 'AtletaController@postSenha');
        Route::get('', 'AtletaController@home')->name('atleta');
        Route::post('atividades', 'AtletaController@postAtividades')->name('atleta.atividades');
    });
});
