<?php

namespace App\Http\Controllers;

use App\Product;
//use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        //Shopping Cart content
        //dd(Cart::content());

        $products = Product::inRandomOrder()->take(6)->get();
        //dd($products);
        return view('products.index')->with('products', $products);
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        return view('products.show')->with('product', $product);
    }

}
