<?php

namespace App\Http\Controllers;

use DateTime;
use App\Order;
use App\Product;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Cart::count() <= 0){
            return redirect()->route('products.index');
        }
        // Set your secret key. Remember to switch to your live secret key in production!
        \Stripe\Stripe::setApiKey('');

        $intent = PaymentIntent::create([
            'amount' => round(Cart::total()),
            'currency' => 'usd',
        ]);

        //dd($intent);
        $clientSecret = Arr::get($intent,'client_secret');

        return view('checkout.index', [
            'clientSecret' => $clientSecret,
        ]);
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
        if($this->chechIfNotAvailable()){
            Session::flash('error', 'this Product is no more availble');
            return response()->json(['success' => false], 400);
        }

        $data = $request->json()->all();

        $order = new Order();

        $order->payment_intent_id = $data['paymentIntent']['id'];
        $order->amount = $data['paymentIntent']['amount'];

        $order->payment_created_at = (new DateTime())
            ->setTimestamp($data['paymentIntent']['created'])
            ->format('Y-m-d H:i:s');

        $products = [];
        $i = 0;

        foreach (Cart::content() as $product) {
            $products['product_' . $i][] = $product->model->title;
            $products['product_' . $i][] = $product->model->price;
            $products['product_' . $i][] = $product->qty;
            $i++;
        }

        $order->products = serialize($products);
        $order->user_id = Auth()->user()->id;
        $order->save();


        $order->products = serialize($products);
        $order->user_id = 15;
        $order->save();

        if ($data['paymentIntent']['status'] === 'succeeded') {
            $this->updateStock();
            Cart::destroy();
            Session::flash('succes', 'Your order has been succesfully traited.');
            return response()->json(['success' => 'Payment Intent Succeded']);
        }else {
            return response()->json(['error' => 'Payment Intent failed']);
        }

    }

    public function thankYou()
    {
        return Session::has('success') ? view('checkout.thx') : view('checkout.thx'); //dd(Session::has('succes'))
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function chechIfNotAvailable()
    {
        foreach (Cart::content() as $item) {
            $product = Product::find($item->model->id);

            if($product->stock < $item->qty){
                return true;
            }
        }

        return false;
    }

    private function updateStock()
    {
        foreach(Cart::content() as $item) {
            $product = Product::find($item->model->id);
            $product->update(['stock' => $product->stock - $item->qty]);
        }
    }
}
