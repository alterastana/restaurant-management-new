<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang digunakan.
     */
    protected $table = 'orders';

    /**
     * Primary key tabel.
     */
    protected $primaryKey = 'order_id';
    public $incrementing = true;
    protected $keyType = 'int';

    /**
     * Kolom yang boleh diisi secara massal.
     */
    protected $fillable = [
        'restaurant_id',
        'reservation_id',
        'order_type',
        'order_date',
        'total_amount',
        'status',
        'notes',
    ];

    /**
     * Relasi ke Customer (Many to One)
     */

    /**
     * Relasi ke Restaurant (Many to One)
     */
    public function restaurant()
    {
        return $this->belongsTo(Restoran::class, 'restaurant_id', 'restaurant_id');
    }

    /**
     * Relasi ke Reservation (One to One - optional)
     */
    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id', 'reservation_id');
    }

    /**
     * Relasi ke OrderDetail (One to Many)
     */
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'order_id');
    }

    /**
     * Relasi ke Payment (One to One)
     */
    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id', 'order_id');
    }
}
