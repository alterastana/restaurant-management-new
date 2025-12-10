<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loyalty extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang digunakan oleh model.
     */
    protected $table = 'loyalty_programs';

    /**
     * Primary key dari tabel.
     */
    protected $primaryKey = 'loyalty_id';

    /**
     * Kolom yang boleh diisi secara massal.
     */
    protected $fillable = [
        'customer_id',
        'points',
        'membership_level',
        'discount_amount',
    ];

    /**
     * Relasi ke model Customer (bukan User).
     * Loyalty program dimiliki oleh satu Customer.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    /**
     * Fungsi untuk menghitung level berdasarkan poin (otomatis).
     */
    public function updateMembershipLevel()
    {
        if ($this->points >= 200) {
            $this->membership_level = 'Platinum';
            $this->discount_amount = 10000;
        } elseif ($this->points >= 100) {
            $this->membership_level = 'Gold';
            $this->discount_amount = 5000;
        } else {
            $this->membership_level = 'Silver';
            $this->discount_amount = 2000;
        }

        $this->save();
    }
}
