<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang digunakan oleh model ini.
     */
    protected $table = 'customers';

    /**
     * Primary key dari tabel.
     */
    protected $primaryKey = 'customer_id';
    public $incrementing = true;
    protected $keyType = 'int';

    /**
     * Kolom yang boleh diisi secara massal.
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
    ];

    /**
     * Relasi ke tabel LoyaltyProgram (One to One).
     */
    public function loyalty()
    {
        return $this->hasOne(Loyalty::class, 'customer_id', 'customer_id');
    }

    /**
     * Relasi ke tabel Order (One to Many).
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id', 'customer_id');
    }

    /**
     * Relasi ke tabel Reservation (One to Many).
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'customer_id', 'customer_id');
    }
}
