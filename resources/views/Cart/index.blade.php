@extends('home')

@section('content')
<div class="container mt-4">
    <h2>Your Cart</h2>
    <ul id="cart" class="list-group">
        <!-- Cart items will be appended here by JavaScript -->
    </ul>
    <button class="btn btn-success mt-3 w-100" id="checkout-btn">Checkout</button>
</div>
<a href="{{ route('orders.index') }}" class="btn btn-success mb-3">Go back to Orders</a>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Load cart items from local storage
        var cart = JSON.parse(localStorage.getItem('cart')) || [];

        function updateCartView() {
            $('#cart').empty();
            cart.forEach(function(item) {
                var cartItem = '<li class="list-group-item d-flex justify-content-between align-items-center" data-id="' + item.id + '">' + item.name + ' - $' + item.price + '<button class="btn btn-danger btn-sm remove-from-cart">Remove</button></li>';
                $('#cart').append(cartItem);
            });
        }

        updateCartView();

        $(document).on('click', '.remove-from-cart', function() {
            var id = $(this).closest('li').data('id');
            cart = cart.filter(function(item) {
                return item.id !== id;
            });
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartView();
        });

        $('#checkout-btn').on('click', function() {
            var itemIds = cart.map(function(item) { return item.id; });

            // Ensure CSRF token is included in the data
            var token = '{{ csrf_token() }}';

            $.ajax({
                url: '{{ route('orders.store') }}',
                method: 'POST',
                data: {
                    _token: token,
                    items: itemIds
                },
                success: function(response) {
                    alert('Order placed successfully!');
                    localStorage.removeItem('cart');
                    updateCartView();
                },
                error: function(xhr) {
                    alert('Error placing order.');
                }
            });
        });
    });
</script>
@endsection
