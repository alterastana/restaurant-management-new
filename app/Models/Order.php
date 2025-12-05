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
    public $incrementing = false;      // UUID bukan auto increment
    protected $keyType = 'string';     // UUID berbentuk string

    protected $fillable = [
        'order_id',
        'restaurant_id',
        'reservation_id',
        'order_type',
        'order_date',
        'total_amount',
        'status',
        'notes',
    ];

    /**
     * Auto-generate UUID saat create
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

    /** RELASI **/
    
    public function restaurant()
    {
        return $this->belongsTo(Restoran::class, 'restaurant_id', 'restaurant_id');
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id', 'reservation_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'order_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id', 'order_id');
    }
}
