<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Restoran;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RestoranController extends Controller
{
    use AuthorizesRequests;

    /**
     * Menampilkan daftar semua restoran.
     */
    public function index()
    {
        $user = auth()->user();
        
        // Filter berdasarkan role
        if ($user->role?->name === 'admin') {
            // Admin melihat semua restoran
            $restorans = Restoran::latest()->paginate(10);
        } elseif ($user->role?->name === 'manager') {
            // Manager melihat semua restoran
            $restorans = Restoran::latest()->paginate(10);
        } else {
            // Customer melihat semua restoran
            $restorans = Restoran::latest()->paginate(10);
        }

        return view('Dashboard.restoran.index', compact('restorans'));
    }

    /**
     * Menampilkan form untuk membuat restoran baru.
     */
    public function create()
    {
        // Cek role - hanya admin yang bisa create
        if (auth()->user()->role?->name !== 'admin') {
            abort(403, 'Anda tidak memiliki akses untuk menambah restoran.');
        }

        return view('Dashboard.restoran.create');
    }

    /**
     * Menyimpan data restoran baru ke database.
     */
    public function store(Request $request)
    {
        // Cek role - hanya admin yang bisa create
        if (auth()->user()->role?->name !== 'admin') {
            abort(403, 'Anda tidak memiliki akses untuk menambah restoran.');
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|email|unique:restaurants,email',
        ]);

        Restoran::create($validatedData);
        
        return redirect()
            ->route('Dashboard.restoran.index')
            ->with('success', 'Restoran baru berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail satu restoran.
     */
    public function show(Restoran $restoran)
    {
        return view('Dashboard.restoran.read', compact('restoran'));
    }

    /**
     * Menampilkan form untuk mengedit data.
     */
    public function edit(Restoran $restoran)
    {
        // Admin dan Manager bisa edit
        $user = auth()->user();
        
        if (!in_array($user->role?->name, ['admin', 'manager'])) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit restoran.');
        }

        return view('Dashboard.restoran.update', compact('restoran'));
    }

    /**
     * Mengupdate data restoran di database.
     */
    public function update(Request $request, Restoran $restoran)
    {
        // Admin dan Manager bisa edit
        $user = auth()->user();
        
        if (!in_array($user->role?->name, ['admin', 'manager'])) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit restoran.');
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|email|unique:restaurants,email,' . $restoran->restaurant_id . ',restaurant_id',
        ]);

        $restoran->update($validatedData);
        
        return redirect()
            ->route('Dashboard.restoran.index')
            ->with('success', 'Data restoran berhasil diperbarui!');
    }

    /**
     * Menghapus data restoran dari database.
     */
    public function destroy(Restoran $restoran)
    {
        // Hanya admin yang bisa delete
        if (auth()->user()->role?->name !== 'admin') {
            abort(403, 'Anda tidak memiliki akses untuk menghapus restoran.');
        }

        $restoran->delete();
        
        return redirect()
            ->route('Dashboard.restoran.index')
            ->with('success', 'Restoran berhasil dihapus!');
    }
}