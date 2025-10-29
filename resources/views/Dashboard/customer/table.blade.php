@forelse($customers as $i => $customer)
    <tr class="hover:bg-gray-50">
        <td class="px-4 py-3">{{ $customers->firstItem() + $i }}</td>
        <td class="px-4 py-3 font-medium">{{ $customer->name }}</td>
        <td class="px-4 py-3">{{ $customer->email }}</td>
        <td class="px-4 py-3">{{ $customer->phone }}</td>
        <td class="px-4 py-3">{{ \Illuminate\Support\Str::limit($customer->address, 60) }}</td>
        <td class="px-4 py-3 text-center">
            <div class="flex items-center justify-center gap-2">
                <a href="{{ route('Dashboard.customer.show', $customer->customer_id) }}" class="px-3 py-1 rounded bg-gray-200">View</a>
                <a href="{{ route('Dashboard.customer.edit', $customer->customer_id) }}" class="px-3 py-1 rounded bg-yellow-400 text-white">Edit</a>
                <form action="{{ route('Dashboard.customer.destroy', $customer->customer_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this customer?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-3 py-1 rounded bg-red-500 text-white">Hapus</button>
                </form>
            </div>
        </td>
    </tr>
@empty
    <tr><td colspan="6" class="text-center py-8 text-gray-500">No customers found.</td></tr>
@endforelse