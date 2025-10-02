<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManagerController extends Controller
{
    // Tampilkan semua manager
    public function index()
    {
        $managers = User::where('role_id', 2)->get();
        return view('Dashboard.manager.index', compact('managers'));
    }

    // Form tambah manager
    public function create()
    {
        return view('Dashboard.manager.create');
    }

    // Simpan manager baru
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'phone'    => 'nullable|string|max:20',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role_id'  => 2, // role manager
        ]);

        return redirect()->route('Dashboard.manager.index')
                         ->with('success', 'Manager berhasil ditambahkan.');
    }

    public function show($id)
    {
        $manager = User::where('role_id', 2)->findOrFail($id);
        return view('Dashboard.manager.read', compact('manager'));
    }


    // Form edit manager
    public function edit($id)
    {
        $manager = User::where('role_id', 2)->findOrFail($id);
        return view('Dashboard.manager.update', compact('manager'));
    }

    // Update manager
    public function update(Request $request, $id)
    {
        $manager = User::where('role_id', 2)->findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $manager->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $manager->update([
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->password 
                           ? Hash::make($request->password) 
                           : $manager->password,
        ]);

        return redirect()->route('Dashboard.manager.index')
                         ->with('success', 'Data manager berhasil diperbarui.');
    }

    // Hapus manager
    public function destroy($id)
    {
        $manager = User::where('role_id', 2)->findOrFail($id);
        $manager->delete();

        return redirect()->route('Dashboard.manager.index')
                         ->with('success', 'Manager berhasil dihapus.');
    }
}
