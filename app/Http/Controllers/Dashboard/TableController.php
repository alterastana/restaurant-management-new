<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\TableRestaurant;
use App\Models\Restoran;
use Illuminate\Http\Request;

class TableController extends Controller
{
    /**
     * 'READ' (Index): Menampilkan semua data meja di file read.blade.php
     */
    public function index(Request $request)
    {
        $perPage = $request->input('show_more') ? 100 : 10;
        $tables = TableRestaurant::with('restaurant')->latest()->paginate($perPage);
        
        if ($request->ajax()) {
            return view('Dashboard.table.table', compact('tables'))->render();
        }
        return view('Dashboard.table.read', compact('tables'));
    }

    /**
     * 'CREATE': Menampilkan form tambah
     */
    public function create()
    {
        $restorans = Restoran::all();
        return view('Dashboard.table.create', compact('restorans'));
    }

    /**
     * Store (Proses Create): Menyimpan data baru
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // DIUBAH DI SINI: Sesuaikan dengan Model Restoran
            'restaurant_id' => 'required|exists:restaurants,restaurant_id',
            'table_number' => 'required|integer',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|string',
        ]);

        TableRestaurant::create($validatedData);
        return redirect()->route('Dashboard.table.index')->with('success', 'Meja baru berhasil ditambahkan.');
    }

    /**
     * 'SHOW' (View): Menampilkan halaman detail (view.blade.php)
     */
    public function show(TableRestaurant $table)
    {
        return view('Dashboard.table.view', compact('table'));
    }

    /**
     * 'UPDATE' (Edit): Menampilkan form edit di update.blade.php
     */
    public function edit(TableRestaurant $table)
    {
        $restorans = Restoran::all();
        return view('Dashboard.table.update', compact('table', 'restorans'));
    }

    /**
     * Update (Proses Update): Memperbarui data
     */
    public function update(Request $request, TableRestaurant $table)
    {
        $validatedData = $request->validate([
            // DIUBAH DI SINI: Sesuaikan dengan Model Restoran
            'restaurant_id' => 'required|exists:restaurants,restaurant_id',
            'table_number' => 'required|integer',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|string',
        ]);

        $table->update($validatedData);
        return redirect()->route('Dashboard.table.index')->with('success', 'Data meja berhasil diperbarui.');
    }

    /**
     * 'DELETE' (Confirm): Menampilkan halaman konfirmasi hapus
     */
    public function confirmDelete(TableRestaurant $table)
    {
        return view('Dashboard.table.delete', compact('table'));
    }

    /**
     * Destroy (Proses Delete): Menghapus data
     */
    public function destroy(TableRestaurant $table)
    {
        $table->delete();
        return redirect()->route('Dashboard.table.index')->with('success', 'Data meja berhasil dihapus.');
    }
}