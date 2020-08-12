@extends('layouts.app')

@section('content')
<div class="col-md-12">
      <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
        <div class="col p-4 d-flex flex-column position-static">
          <strong class="d-inline-block mb-2 text-success">Design</strong>
          <h5 class="mb-0">{{ $product->title }}</h5>
          <div class="mb-1 text-muted">{{ $product->created_at->format('d/m/Y') }}</div>
          <p class="mb-auto">{{ $product->description }}</p>
          <strong class="mb-auto">{{ $product->getFormatedPrice() }} </strong>
          <form action="{{ route('cart.store') }}" method="post">
            @csrf
            <input type="hidden" name="id" value="{{ $product->id }}">
            <input type="hidden" name="title" value="{{ $product->title }}">
            <input type="hidden" name="price" value="{{ $product->price }}">
              <button type="submit" class="btn btn-dark">Add to Wish List</button>
          </form>
        </div>
        <div class="col-auto d-none d-lg-block">
          <img src="{{ $product->image }}" alt="">
        </div>
      </div>
</div>
@endsection