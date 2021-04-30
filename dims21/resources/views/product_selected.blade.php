@extends('layouts.app')

@section('content')
<div class="container">
    <h3>{{ $product->title }}</h3>
    <div class="row">
        <div class="col-md-4">
            <img src="{{ asset('images/' . $product->imageName) }}" alt="product" class="img-responsive">
        </div>
        <div class="col-md-8">
            <h3>R{{ $product->productPrice }}</h3>
            <form action="{{ url('/cart') }}" method="POST" class="side-by-side">
                {!! csrf_field() !!}
                <input type="hidden" name="id" value="{{ $product->productCode }}">
                <input type="hidden" name="name" value="{{ $product->title }}">
                <input type="hidden" name="price" value="{{ $product->productPrice }}">
                <input type="text" name="qty" placeholder="Quantity"><br><br>
                <input type="submit" class="btn btn-success btn-lg" value="Add to Cart">
            </form>

            <br><br>

            {{ $product->description }}
        </div>
    </div>

    <div class="spacer"></div>

    <div class="row">
        <h3>You may also like...</h3>

        @foreach ($interested as $product)
            <div class="col-md-3">
                <div class="thumbnail">
                    <div class="caption text-center">
                        <a href="{{ url('shop', [$product->productCode]) }}"><img src="{{ asset('images/' . $product->imageName) }}" alt="product" class="img-responsive"></a>
                        <a href="{{ url('shop', [$product->productCode]) }}"><h3>{{ $product->title }}</h3>
                            <p class="price">{{ $product->productPrice }}</p>
                        </a>
                    </div> <!-- end caption -->

                </div> <!-- end thumbnail -->
            </div> <!-- end col-md-3 -->
        @endforeach

    </div> <!-- end row -->
</div>
@endsection