@forelse ($menus as $index => $menu)
    <tr class="border-b hover:bg-gray-50">
        <td class="py-3 px-4">{{ $menus->firstItem() + $index }}</td>
        <td class="py-3 px-4 font-semibold">{{ $menu->name }}</td>
        <td class="py-3 px-4 text-gray-700">{{ $menu->description }}</td>
        <td class="py-3 px-4">Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
        <td class="py-3 px-4">{{ $menu->stock }}</td>
        <td class="py-3 px-4">{{ $menu->restaurant_id }}</td>
        <td class="py-3 px-4 text-center">
            <div class="flex justify-center gap-2">
                {{-- VIEW --}}
                <a href="{{ route('Dashboard.menu.show', $menu->menu_id) }}"
                   class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-center">
                    View
                </a>

                {{-- EDIT --}}
                <a href="{{ route('Dashboard.menu.edit', $menu->menu_id) }}"
                   class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-center">
                    Edit
                </a>

                {{-- DELETE --}}
                <form action="{{ route('Dashboard.menu.destroy', $menu->menu_id) }}"
                      method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            onclick="return confirm('Yakin ingin menghapus menu ini?')"
                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-center">
                        Delete
                    </button>
                </form>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="text-center py-4 text-gray-500">
            Tidak ada data menu.
        </td>
    </tr>
@endforelse