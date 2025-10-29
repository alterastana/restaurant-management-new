<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Loyalty;
use App\Models\User;
use Illuminate\Http\Request;

class LoyaltyController extends Controller
{
    /**
     * Menampilkan daftar data loyalty.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('show_more') ? 100 : 10;
        $loyaltyData = Loyalty::with('customer')->latest()->paginate($perPage);
        
        if ($request->ajax()) {
            return view('Dashboard.loyalty.table', ['rewards' => $loyaltyData])->render();
        }
        return view('Dashboard.loyalty.index', ['rewards' => $loyaltyData]);
    }

    /**
     * Menampilkan form untuk membuat data loyalty baru.
     */
    public function create()
    {
        $customers = User::whereHas('role', function ($query) {
            $query->where('name', 'customer');
        })->whereDoesntHave('loyalty')->get();

        return view('Dashboard.loyalty.create', compact('customers'));
    }

    /**
     * Menyimpan data loyalty baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:users,id|unique:loyalty_programs,customer_id',
            'points' => 'required|integer|min:0',
            'membership_level' => 'required|string|max:255',
        ]);

        Loyalty::create($validatedData);

        return redirect()->route('Dashboard.loyalty.index')->with('success', 'Data loyalty berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data loyalty.
     */
    public function edit(Loyalty $loyalty)
    {
        $customers = User::whereHas('role', function ($query) {
            $query->where('name', 'customer');
        })->whereDoesntHave('loyalty')
          ->orWhere('id', $loyalty->customer_id)
          ->get();

        // Mengarahkan ke view 'update.blade.php' sesuai permintaan Anda
        return view('Dashboard.loyalty.update', [
            'loyalty' => $loyalty,
            'customers' => $customers
        ]);
    }

    /**
     * Memperbarui data loyalty di database.
     */
    public function update(Request $request, Loyalty $loyalty)
    {
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:users,id|unique:loyalty_programs,customer_id,' . $loyalty->loyalty_id . ',loyalty_id',
            'points' => 'required|integer|min:0',
            'membership_level' => 'required|string|max:255',
        ]);

        $loyalty->update($validatedData);

        return redirect()->route('Dashboard.loyalty.index')->with('success', 'Data loyalty berhasil diperbarui.');
    }

    /**
     * Menghapus data loyalty dari database.
     */
    public function destroy(Loyalty $loyalty)
    {
        $loyalty->delete();
        return redirect()->route('Dashboard.loyalty.index')->with('success', 'Data loyalty berhasil dihapus.');
    }
}