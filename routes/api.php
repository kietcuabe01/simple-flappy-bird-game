<?php


use Illuminate\Support\Facades\Route;


Route::group([

    'namespace' => 'App\Http\Controllers\Api\V1'
], function () {
    Route::post('/init-user', 'UserController@init')->name('init.user');

    Route::post('/report', 'ReportController@store')->name('report.create');
    Route::get('/report/{uuid}', 'ReportController@show')->name('report.check');
});

Route::group([
    'namespace' => 'App\Http\Controllers\Api\V1'
], function () {
    Route::post('/game', 'GameController@init')->name('game.init');
    Route::post('/game/pass-pillar/{game}', 'GameController@passPillar')->name('game.pillar.pass');
    Route::post('/game/hit-pillar/{game}', 'GameController@hitPillar')->name('game.pillar.hit');
})->middleware([
    \App\Http\Middleware\VerifyJwt::class,
    \Illuminate\Foundation\Http\Middleware\TrimStrings::class,
]);


