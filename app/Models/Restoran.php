<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restoran extends Model
{
    use HasFactory;

    protected $table = 'restaurants';
    protected $primaryKey = 'restaurant_id';

    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
    ];

    // Relasi ke TableRestaurant (jika diperlukan)
    public function tables()
    {
        // Hubungkan 'restaurant_id' di tabel ini ke 'restaurant_id' di tabel 'table_restaurants'
        return $this->hasMany(TableRestaurant::class, 'restaurant_id', 'restaurant_id');
    }
}