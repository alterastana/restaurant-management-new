<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_detail_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'order_id',
        'product_name',
        'quantity',
        'price',

    ];

    // Relasi ke tabel Orders
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
}
