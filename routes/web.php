<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')
    ->name('home');

Auth::routes([
    'reset' => false,
    'confirm' => false,
    'verify' => false,
]);
Route::group(
    [
        'middleware' => ['auth'],
    ],
    function() {
        Route::group(
            [
                'prefix' => 'orders',
            ],
            function () {
                Route::get('/', 'OrderController@index')
                    ->name('orders.index');
                Route::match(['post', 'get'], '/store', 'OrderController@store')
                    ->name('orders.store');
                Route::get('/{order}', 'OrderController@show')
                    ->where('order', '[0-9]+')
                    ->name('orders.show');
                Route::get('{order}/pay', 'OrderController@pay')
                    ->middleware('can:pay,order')
                    ->where('order', '[0-9]+')
                    ->name('orders.pay');
            }
        );
        Route::get('/notification/unread/{id}', 'HomeController@unreadNotification')
            ->name('notification.unread');
    }
);
Route::group(
    [
        'prefix' => 'transactions',
    ],
    function () {
        Route::get('/receive/{gateway}/{uuid}', 'TransactionController@receive')
            ->where([
                'uuid', '[0-9a-fA-F]{8}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{12}',
                'gateway' => implode('|', config('config.gateways')),
            ])
            ->name('transactions.receive');
    }
);