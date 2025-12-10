<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Customer;
use App\Models\TableRestaurant;

class ReservationController extends Controller
{
    /**
     * Tampilkan daftar semua reservasi
     */
    public function index()
    {
        // Ambil semua reservasi dengan relasi customer dan table
        $reservations = Reservation::with(['customer', 'tableRestaurant'])->get();

        return view('Dashboard.reservation.index', compact('reservations'));
    }

    /**
     * Form untuk membuat reservasi baru
     */
    public function create()
    {
        $customers = Customer::all();
        $tables = TableRestaurant::all();

        return view('Dashboard.reservation.create', compact('customers', 'tables'));
    }

    /**
     * Simpan reservasi baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,customer_id',
            'table_id' => 'required|exists:table_restaurants,table_id',
            'reservation_date' => 'required|date',
            'reservation_time' => 'required',
        ]);

        Reservation::create([
            'customer_id' => $request->customer_id,
            'table_id' => $request->table_id,
            'reservation_date' => $request->reservation_date,
            'reservation_time' => $request->reservation_time,
        ]);

        return redirect()->route('Dashboard.reservation.index')
                         ->with('success', 'Reservasi berhasil dibuat.');
    }

    /**
     * Form edit reservasi
     */
    public function edit(Reservation $reservation)
    {
        $customers = Customer::all();
        $tables = TableRestaurant::all();

        return view('Dashboard.reservation.edit', compact('reservation', 'customers', 'tables'));
    }

    /**
     * Update data reservasi
     */
    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,customer_id',
            'table_id' => 'required|exists:table_restaurants,table_id',
            'reservation_date' => 'required|date',
            'reservation_time' => 'required',
        ]);

        $reservation->update($request->all());

        return redirect()->route('Dashboard.reservation.index')
                         ->with('success', 'Reservasi berhasil diupdate.');
    }

    /**
     * Hapus reservasi
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return redirect()->route('Dashboard.reservation.index')
                         ->with('success', 'Reservasi berhasil dihapus.');
    }
}
