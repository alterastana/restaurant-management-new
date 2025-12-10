<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $primaryKey = 'order_id';
    public $incrementing = false; 
    protected $keyType = 'string';

    protected $fillable = [
        'order_id',
        'customer_id',
        'restaurant_id', // Pastikan nama kolom sesuai DB
        'table_id',
        'reservation_id',
        'order_type',
        'order_date',
        'status',
        'payment_status',
        'payment_token',
        'paid_at',
        'total_amount',
        'notes',
    ];

    /**
     * Casting otomatis kolom ke tipe data yang benar.
     */
    protected $casts = [
        'order_date' => 'datetime',
        'paid_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Generate UUID otomatis saat membuat order
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->order_id) {
                $model->order_id = (string) Str::uuid();
            }
        });
    }

    /* ==============================
     * RELASI
     * ==============================
     */

    // Customer yang memesan
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    // Restoran tempat order dilakukan
    public function restoran()
    {
        return $this->belongsTo(Restoran::class, 'restaurant_id');
    }

    // Meja yang digunakan
    public function table()
    {
        return $this->belongsTo(TableRestaurant::class, 'table_id');
    }

    // Reservasi terkait (opsional)
    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id');
    }

    // Detail item makanan/minuman
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'order_id');
    }

    // Data pembayaran order
    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id', 'order_id');
    }
}
