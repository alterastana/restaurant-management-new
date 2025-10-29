@forelse($rewards as $i => $data)
    <tr class="hover:bg-gray-50">
        <td class="px-6 py-4">{{ $rewards->firstItem() + $i }}</td>
        <td class="px-6 py-4 font-medium">{{ $data->customer->name ?? 'Customer Dihapus' }}</td>
        <td class="px-6 py-4">{{ number_format($data->points) }}</td>
        <td class="px-6 py-4">{{ $data->membership_level }}</td>
        <td class="px-6 py-4 text-center">
            <div class="flex justify-center space-x-2">
                <a href="{{ route('Dashboard.loyalty.edit', $data) }}" class="py-2 px-3 bg-yellow-500 text-white rounded">Edit</a>
                <form action="{{ route('Dashboard.loyalty.destroy', $data) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="py-2 px-3 bg-red-500 text-white rounded">Hapus</button>
                </form>
            </div>
        </td>
    </tr>
@empty
    <tr><td colspan="5" class="text-center py-12">Belum ada data poin.</td></tr>
@endforelse