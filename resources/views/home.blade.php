@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @foreach (Auth()->user()->orders as $order)
                        <div class="card">
                            <div class="card-header">
                                Order passed the {{ Carbon\Carbon::parse
                                ($order->payment_created_at)->format('d/m/Y H:i') }} amount of <strong> {{ getPrice($order->amount) }} </strong>
                            </div>
                            <div class="card-body">
                                <h6>Orders List</h6>
                                @foreach (unserialize($order->products) as $product)
                                    <div>Product Name: {{ $product[0] }}</div>
                                    <div>Price: {{ getPrice($product[1]) }}</div>
                                    <div>Quantity: {{ $product[2] }}</div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
