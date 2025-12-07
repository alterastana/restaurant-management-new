<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menus';
    protected $primaryKey = 'menu_id'; // kalau nama PK bukan 'id'
    public $timestamps = true;

    protected $fillable = [
        'restaurant_id',
        'name',
        'description',
        'price',
        'stock',
    ];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'menu_id', 'menu_id');
    }
}
