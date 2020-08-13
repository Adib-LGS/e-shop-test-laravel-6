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
Route::get('/boutique', 'ProductController@index')->name('products.index');
Route::get('/boutique/{slug}', 'ProductController@show')->name('products.show');

/**Cart Routes (Shopping Cart) */
Route::get('/panier', 'CartController@index')->name('cart.index');
Route::post('/panier/ajouter', 'CartController@store')->name('cart.store');
Route::delete('/panier/{rowId}', 'CartController@destroy')->name('cart.destroy');

Route::get('/videpanier', function () {
    Cart::destroy();
});

/**Checkout Routes */
Route::get('/paiement', 'CheckoutController@index')->name('checkout.index');