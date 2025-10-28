<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableRestaurant extends Model
{
    use HasFactory;

    protected $table = 'table_restaurants';
    protected $primaryKey = 'table_id';

    protected $fillable = [
        'restaurant_id',
        'table_number',
        'capacity',
        'status',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restoran::class, 'restaurant_id', 'restaurant_id');
    }
}
