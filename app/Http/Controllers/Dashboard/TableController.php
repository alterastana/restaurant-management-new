<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\TableRestaurant;
use App\Models\Restoran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TableController extends Controller
{
    // Tampilkan semua meja
    public function index()
    {
        $tables = TableRestaurant::with('restaurant')->get();
        // dd($tables);
        return view('Dashboard.table.index', compact('tables'));
    }

    // Form tambah meja
    public function create()
    {
        $restaurants = Restoran::all();
        return view('Dashboard.table.create', compact('restaurants'));
    }

    // Simpan meja baru
    public function store(Request $request)
    {
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,restaurant_id',
            'table_number' => 'required|integer',
            'capacity' => 'required|integer',
            'status' => 'required|in:available,reserved,occupied',
        ]);

        TableRestaurant::create($request->all());

        return redirect()->route('Dashboard.table.index')->with('success', 'Table created successfully.');
    }

    // Form edit meja
    public function edit(string $id)
    {
        $table = TableRestaurant::findOrFail($id);
        $restaurants = Restoran::all();
        return view('Dashboard.table.update', compact('table', 'restaurants'));
    }

    // Update meja
    public function update(Request $request, string $id)
    {
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,restaurant_id',
            'table_number' => 'required|integer',
            'capacity' => 'required|integer',
            'status' => 'required|in:available,reserved,occupied',
        ]);

        $table = TableRestaurant::findOrFail($id);
        $table->update($request->all());

        return redirect()->route('Dashboard.table.index')->with('success', 'Table updated successfully.');
    }

    // Hapus meja
    public function destroy(string $id)
    {
        $table = TableRestaurant::findOrFail($id);
        $table->delete();

        // Reset SQLite sequence to the maximum ID + 1
        $maxId = TableRestaurant::max('table_id') ?? 0;
        \DB::statement("UPDATE sqlite_sequence SET seq = ? WHERE name = ?", [$maxId, 'table_restaurants']);

        return redirect()->route('Dashboard.table.index')->with('success', 'Table deleted successfully.');
    }

    public function show(string $id)
    {
        $table = TableRestaurant::with('restaurant')->findOrFail($id);
    
        return view('Dashboard.table.read', compact('table'));
    }
}
