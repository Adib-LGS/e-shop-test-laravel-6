<?php

namespace App\Http\Controllers;

use App\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        //Shopping Cart content
        //dd(Cart::content());
        if($request->category){
            $products = Product::with('categories')->whereHas('categories', function ($query) {
                $query->where('slug', request()->category);
            })->orderBy('created_at', 'DESC')->paginate(6);
        }else{
            $products = Product::with('categories')->orderBy('created_at', 'DESC')->paginate(6);
        }
        //dd($products);
        return view('products.index')->with('products', $products);
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $stock = $product->stock === 0 ? 'Not available' : 'In stock'; 

        return view('products.show', ['product' => $product, 'stock' => $stock]);
    }

    public function search()
    {
        request()->validate([
            'q' => 'required|min:3'
        ]);

        $q = request()->input('q');
        //dd($q);

        $products = Product::where('title', 'like', "%$q%")->orWhere('description', 'like', '%$q%')->paginate(6);

        return view('products.search')->with('products', $products);
    }
}
