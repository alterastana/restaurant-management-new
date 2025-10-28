<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Loyalty;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LoyaltyController extends Controller
{
    public function index()
    {
        $loyalties = Loyalty::all();
        return view('Dashboard.loyalty.index', compact('loyalties'));
    }

    public function create()
    {
        return view('Dashboard.loyalty.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|integer|exists:customers,customer_id',
            'points' => 'required|integer|min:0',
        ]);

        $existing = Loyalty::where('customer_id', $request->customer_id)->first();
        if ($existing) {
            return redirect()->back()->withErrors(['customer_id' => 'Customer ini sudah memiliki member loyalty'])->withInput();
        }

        Loyalty::create([
            'customer_id' => $request->customer_id,
            'points' => $request->points,
            'membership_level' => $this->getMembershipLevel($request->points),
        ]);

        return redirect()->route('Dashboard.loyalty.index')->with('success', 'Data loyalty berhasil ditambahkan!');
    }

    public function show($id)
    {
        $loyalty = Loyalty::findOrFail($id);
        return view('Dashboard.loyalty.show', compact('loyalty'));
    }

    public function edit($id)
    {
        $loyalty = Loyalty::findOrFail($id);
        return view('Dashboard.loyalty.edit', compact('loyalty'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'points' => 'required|integer|min:0'
        ]);

        $loyalty = Loyalty::findOrFail($id);
        $loyalty->update([
            'points' => $request->points,
            'membership_level' => $this->getMembershipLevel($request->points)
        ]);

        return redirect()->route('Dashboard.loyalty.index')->with('success', 'Data loyalty berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $loyalty = Loyalty::findOrFail($id);
        $loyalty->delete();

        return redirect()->route('Dashboard.loyalty.index')->with('success', 'Data loyalty berhasil dihapus!');
    }

    public function getLoyaltyByCustomerId(Request $request)
    {
        $customer_id = $request->input('customer_id');
        $loyalty = Loyalty::where('customer_id', $customer_id)->first();
        
        if ($loyalty) {
            return response()->json([
                'status' => 'found',
                'points' => $loyalty->points,
                'membership_level' => $loyalty->membership_level
            ]);
        }

        return response()->json([
            'status' => 'not_found',
            'points' => 0,
            'membership_level' => 'Non-member'
        ]);
    }

    private function getMembershipLevel($points)
    {
        if ($points == 0) return 'Non-member';
        if ($points < 100) return 'Silver';
        if ($points < 200) return 'Gold';
        return 'Platinum';
    }
}
