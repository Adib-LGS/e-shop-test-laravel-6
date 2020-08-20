<?php

namespace App\Http\Controllers;

use App\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cart.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       //dd($request->id, $request->title, $request->price);

       $duplicate = Cart::search(function ($cartItem, $rowId) use ($request){
           return $cartItem->id == $request->product_id;
       });
       
       if($duplicate->isNotEmpty()){
        return redirect()->route('products.index')->with('success', 'product has already been added in your shopping cart');
       }

       $product = Product::find($request->product_id);
       
       Cart::add($product->id, $product->title, 1, $product->price)
        ->associate('App\Product');

        return redirect()->route('products.index')->with('success', 'product has been added in your shopping cart');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $rowId)
    {
        $data = $request->json()->all();

        $validate = Validator::make($request->all(), [
            'qty' => 'required|numeric|between:1,5',
        ]);

        if($validate->fails()) {
            Session::flash('error', 'Quantity must be between 1 and 5');

            return response()->json(['error' => 'Cart Quantity Hasn\'t Been Updated']);
        }

        Cart::update($rowId, $data['qty']);

        Session::flash('success', 'You have change the quantity of product ' . $data['qty'] . '.');

        return response()->json(['success' => 'Cart Quantity Has Been Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($rowId)
    {
        Cart::remove($rowId);

        return back()->with('success', 'Product has been deleted');
    }
}
