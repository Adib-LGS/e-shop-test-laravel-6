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

use Gloudemans\Shoppingcart\Facades\Cart;

Route::get('/', function () {
    return view('welcome');
});

/**Products Routes */
Route::get('/shop', 'ProductController@index')->name('products.index');
Route::get('/shop/{slug}', 'ProductController@show')->name('products.show');
Route::get('/search', 'ProductController@search')->name('products.search');

/**Cart Routes (Shopping Cart) */
Route::get('/panier', 'CartController@index')->name('cart.index');
Route::post('/panier/ajouter', 'CartController@store')->name('cart.store');
Route::put('/panier/{rowId}', 'CartController@update')->name('cart.update');
Route::delete('/panier/{rowId}', 'CartController@destroy')->name('cart.destroy');

/**Checkout Routes */
Route::get('/paiement', 'CheckoutController@index')->name('checkout.index');
Route::post('/paiement', 'CheckoutController@store')->name('checkout.store');
Route::get('/thanks', 'CheckoutController@thankYou')->name('checkout.thankYou');
/*Route::get('/thanks', function () {
    return view('checkout.thx');
});*/

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
