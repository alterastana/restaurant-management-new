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
        'menu_id',
        'quantity',
        'price',
    ];

    protected $casts = [
        'order_id' => 'string', // penting untuk UUID
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'menu_id');
    }
}
