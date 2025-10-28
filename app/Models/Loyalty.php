<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loyalty extends Model
{
    use HasFactory;

    /**
     * Menentukan nama tabel yang digunakan oleh model ini secara eksplisit.
     */
    protected $table = 'loyalty_programs';

    /**
     * Menentukan primary key tabel, karena bukan 'id'.
     */
    protected $primaryKey = 'loyalty_id';

    /**
     * Atribut yang boleh diisi secara massal (mass assignable).
     */
    protected $fillable = [
        'customer_id',
        'points',
        'membership_level',
    ];

    /**
     * Mendefinisikan relasi "belongsTo" ke model User.
     * Ini memungkinkan kita untuk mengambil data customer dari data loyalty.
     */
    public function customer()
    {
        // Menghubungkan 'customer_id' di tabel ini dengan 'id' di tabel users.
        return $this->belongsTo(User::class, 'customer_id');
    }
}