@extends('home')
@section('content')
<div class="container mt-4">
    <h2>Order Now!</h2>
    <div class="cart-notification">
            Item added to cart
        </div>
    <a href="{{ route('cart.index') }}" class="btn btn-success mb-3">Go to Cart</a>
    <div class="row" id="product-list">
        @foreach($items as $item)
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="{{ asset($item->image) }}" class="card-img-top" alt="{{ $item->name }}" width="50">

                <div class="card-body">
                    <h5 class="card-title">{{ $item->name }}</h5>
                    <p class="card-text">{{ $item->description }}</p>
                    <p class="card-text"><strong>${{ $item->price }}</strong></p>
                    <button class="btn btn-warning btn-sm add-to-cart" data-id="{{ $item->id }}" data-name="{{ $item->name }}" data-price="{{ $item->price }}">Add to Cart</button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <a href="{{ route('cart.index') }}" class="btn btn-success mb-3">Go to Cart</a>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('.add-to-cart').on('click', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var price = $(this).data('price');

            var cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart.push({ id: id, name: name, price: price });
            localStorage.setItem('cart', JSON.stringify(cart));

            // Show success notification

            var notification = $('.cart-notification');
            notification.addClass('show-notification');
            setTimeout(function() {
                notification.removeClass('show-notification');
            }, 1500); // Hide after 1.5 seconds
        });
    });
</script>
@endsection
