<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    /**
     * 🧾 Tampilkan semua data menu
     */
    public function index()
    {
        $menus = Menu::latest()->get(); // lebih ringkas dari orderBy('created_at', 'desc')
        return view('Dashboard.menu.index', compact('menus'));
    }

    /**
     * ➕ Form tambah menu baru
     */
    public function create()
    {
        return view('Dashboard.menu.create');
    }

    /**
     * 💾 Simpan menu baru ke database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'restaurant_id' => 'required|integer',
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'price'         => 'required|numeric|min:0',
            'stock'         => 'required|integer|min:0',
        ]);

        Menu::create($validated);

        return redirect()
            ->route('Dashboard.menu.index')
            ->with('success', '✅ Menu berhasil ditambahkan!');
    }

    /**
     * 🔍 Tampilkan detail menu
     */
    public function show($menu_id)
    {
        $menu = Menu::findOrFail($menu_id);
        return view('Dashboard.menu.show', compact('menu'));
    }

    /**
     * ✏️ Form edit menu
     */
    public function edit($menu_id)
    {
        $menu = Menu::findOrFail($menu_id);
        return view('Dashboard.menu.edit', compact('menu'));
    }

    /**
     * 🔄 Update data menu di database
     */
    public function update(Request $request, $menu_id)
    {
    $validated = $request->validate([
        'name'        => 'required|string|max:255',
        'description' => 'nullable|string',
        'price'       => 'required|numeric|min:0',
        'stock'       => 'required|integer|min:0',
    ]);

    $menu = Menu::findOrFail($menu_id);
    $menu->update($validated);

    return redirect()
        ->route('Dashboard.menu.index')
        ->with('success', '✅ Menu berhasil diperbarui!');
    }


    /**
     * 🗑️ Hapus menu
     */
    public function destroy($menu_id)
    {
        $menu = Menu::findOrFail($menu_id);
        $menu->delete();

        return redirect()
            ->route('Dashboard.menu.index')
            ->with('success', '🗑️ Menu berhasil dihapus!');
    }
}
