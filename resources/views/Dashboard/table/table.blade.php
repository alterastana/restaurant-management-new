@forelse($tables as $index => $table)
<tr class="hover:bg-gray-50">
    <td class="px-6 py-4">{{ $table->table_number }}</td>
    <td class="px-6 py-4">{{ $table->restoran->name ?? 'Restaurant deleted' }}</td>
    <td class="px-6 py-4">{{ $table->capacity }} people</td>
    <td class="px-6 py-4">
        <span class="px-2 py-1 rounded-full text-sm 
            @if($table->status == 'Available') bg-green-100 text-green-800
            @elseif($table->status == 'Reserved') bg-yellow-100 text-yellow-800
            @else bg-red-100 text-red-800
            @endif">
            {{ $table->status }}
        </span>
    </td>
    <td class="px-6 py-4 text-center">
        <div class="flex justify-center space-x-2">
            <a href="{{ route('Dashboard.table.show', $table) }}" 
               class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 text-gray-800 rounded">
                View
            </a>
            <a href="{{ route('Dashboard.table.edit', $table) }}"
               class="px-3 py-1 text-sm bg-yellow-400 hover:bg-yellow-500 text-white rounded">
                Update
            </a>
            <button onclick="confirmDelete({{ $table->table_id }})"
                    class="px-3 py-1 text-sm bg-red-500 hover:bg-red-600 text-white rounded">
                Delete
            </button>
        </div>
    </td>
</tr>
@empty
<tr><td colspan="5" class="text-center py-12">No tables found.</td></tr>
@endforelse