@extends('layouts.master')

@section('content')
    <div class="col-md-12">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="jumbotron text-center">
            <h1 class="displey-3">Hey ThankYou</h1>
            <p class="lead"><strong>your order has been received</strong></p>
            <p>Issue ? <a href="#"></a>Contact us</p>

            <p class="lead">
            <a class="btn btn-primary btn-sm" href="{{ route ('products.index') }}" role="button">Go to Shop</a>
            </p>
        </div>
    </div>
@endsection