@extends('layouts.master')

@section('content')
  <div class="col-md-12">
    <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
      <div class="col p-3 d-flex flex-column position-static">
        <strong class="d-inline-block mb-2 text-success">
        <div class="badge badge-pill badge-info">{{ $stock }}</div>
          @foreach ($product->categories as $category)
            {{ $category->slug }}
          @endforeach
        </strong>
        <h5 class="mb-0">{{ $product->title }}</h5>
        <hr>
        <p class="mb-4">{{ $product->description }}</p><!--Production Mode <p class="mb-auto text-muted">//!! $product->description !!</p>-->
        <strong class="mb-4 display-4text-secondary">{{ $product->getFormatedPrice() }}</strong>
        @if ($stock === 'In stock')
        <form action="{{ route('cart.store') }}" method="POST">
          @csrf
          <input type="hidden" name="product_id" value="{{ $product->id }}">
          <button type="submit" class="btn btn-success"><i class="fa fa-shopping-bag" aria-hidden="true"></i> Ajouter au panier</button>
        </form>
        @endif
      </div>
      <div class="col-auto d-none d-lg-block">
        <img src="{{ asset('storage/' . $product->image) }}" width="300" height="140" id="mainImage"><!--Production Mode <img src=" //asset('storage/' . $product->image) " alt=""--> <!--Dev Mode <img src="$product->image" alt=""> -->
        <div class="mt-2">
        @if ($product->images)
          <img src="{{ asset('storage/' . $product->image) }}" class="img-thumbnail" width="150" height="90">
          @foreach (json_decode($product->images, true) as $image)
            <img src="{{ asset('storage/' . $image) }}" width="150" height="90" class="img-thumbnail">
          @endforeach
        @endif
        </div>
      </div>
    </div>
  </div>
@endsection

@section('extra-js')
    <script>
      const mainImage = document.querySelector('#mainImage');
      const thumbnails = document.querySelectorAll('.img-thumbnail');

      thumbnails.forEach((element) => element.addEventListener('click', changeImage));
      function changeImage(e) {
        mainImage.src = this.src;
      }
    </script>
@endsection