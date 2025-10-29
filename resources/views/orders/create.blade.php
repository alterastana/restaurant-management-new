<!-- resources/views/orders/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">Place Your Order</h1>

        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">{{ $restaurant->name }}</h2>
            
            <form action="{{ route('orders.store') }}" method="POST" id="orderForm">
                @csrf
                <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">

                <!-- Table Selection -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Select Table</label>
                    <select name="table_id" class="w-full border rounded-md px-3 py-2" required>
                        <option value="">Choose a table...</option>
                        @foreach($tables as $table)
                            <option value="{{ $table->id }}">Table {{ $table->table_number }} ({{ $table->capacity }} seats)</option>
                        @endforeach
                    </select>
                </div>

                <!-- Menu Selection -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-4">Menu Items</h3>
                    <div class="space-y-4" id="menuItems">
                        @foreach($menus as $menu)
                        <div class="flex items-center justify-between border-b pb-4">
                            <div>
                                <h4 class="font-medium">{{ $menu->name }}</h4>
                                <p class="text-gray-600 text-sm">{{ $menu->description }}</p>
                                <p class="text-brand font-semibold">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <button type="button" class="quantity-btn" data-action="decrease" data-menu-id="{{ $menu->id }}">-</button>
                                <input type="number" name="menu_items[{{ $menu->id }}][quantity]" 
                                       value="0" min="0" class="w-16 text-center border rounded-md"
                                       data-price="{{ $menu->price }}">
                                <button type="button" class="quantity-btn" data-action="increase" data-menu-id="{{ $menu->id }}">+</button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Order Notes -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Special Instructions</label>
                    <textarea name="notes" rows="3" class="w-full border rounded-md px-3 py-2" 
                              placeholder="Any special requests or allergies?"></textarea>
                </div>

                <!-- Order Summary -->
                <div class="bg-gray-50 p-4 rounded-md mb-6">
                    <h3 class="font-semibold mb-2">Order Summary</h3>
                    <div id="orderSummary" class="space-y-2">
                        <!-- Filled dynamically via JavaScript -->
                    </div>
                    <div class="border-t mt-4 pt-4">
                        <div class="flex justify-between font-bold">
                            <span>Total</span>
                            <span id="totalAmount">Rp 0</span>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-brand text-white py-3 px-6 rounded-md font-semibold hover:bg-brand-dark transition-colors">
                    Proceed to Payment
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const menuItems = document.getElementById('menuItems');
    const orderSummary = document.getElementById('orderSummary');
    const totalAmountElement = document.getElementById('totalAmount');

    function updateQuantity(btn, action) {
        const container = btn.closest('div');
        const input = container.querySelector('input');
        let value = parseInt(input.value);

        if (action === 'increase') {
            value++;
        } else if (action === 'decrease' && value > 0) {
            value--;
        }

        input.value = value;
        updateOrderSummary();
    }

    function updateOrderSummary() {
        const inputs = menuItems.querySelectorAll('input[type="number"]');
        let total = 0;
        let summaryHTML = '';

        inputs.forEach(input => {
            const quantity = parseInt(input.value);
            if (quantity > 0) {
                const container = input.closest('div').parentElement;
                const name = container.querySelector('h4').textContent;
                const price = parseFloat(input.dataset.price);
                const subtotal = price * quantity;
                total += subtotal;

                summaryHTML += `
                    <div class="flex justify-between text-sm">
                        <span>${quantity}x ${name}</span>
                        <span>Rp ${subtotal.toLocaleString('id-ID')}</span>
                    </div>
                `;
            }
        });

        orderSummary.innerHTML = summaryHTML;
        totalAmountElement.textContent = `Rp ${total.toLocaleString('id-ID')}`;
    }

    // Event listeners for quantity buttons
    document.querySelectorAll('.quantity-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            updateQuantity(btn, btn.dataset.action);
        });
    });

    // Event listeners for manual input
    document.querySelectorAll('input[type="number"]').forEach(input => {
        input.addEventListener('change', updateOrderSummary);
    });

    // Initialize order summary
    updateOrderSummary();
});
</script>
@endpush
@endsection