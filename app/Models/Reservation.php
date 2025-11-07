<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang digunakan.
     */
    protected $table = 'reservations';

    /**
     * Primary key tabel.
     */
    protected $primaryKey = 'reservation_id';
    public $incrementing = true;
    protected $keyType = 'int';

    /**
     * Kolom yang boleh diisi secara massal.
     */
    protected $fillable = [
        'table_id',
        'customer_id',
        'reservation_date',
        'reservation_time',
        'status',
    ];

    /**
     * Relasi ke Customer (Many to One)
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    /**
     * Relasi ke TableRestaurant (Many to One)
     */
    public function table()
    {
        return $this->belongsTo(TableRestaurant::class, 'table_id', 'table_id');
    }

    /**
     * Relasi ke Order (One to Many)
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'reservation_id', 'reservation_id');
    }
}
