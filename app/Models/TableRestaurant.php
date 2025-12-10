<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableRestaurant extends Model
{
    use HasFactory;

    protected $table = 'table_restaurants';
    protected $primaryKey = 'table_id';

    /**
     * Kolom yang boleh diisi secara massal.
     */
    protected $fillable = [
        'restaurant_id',
        'table_number',
        'capacity',
        'status',
    ];

    /**
     * Menonaktifkan timestamps jika tabel 'table_restaurants' tidak memiliki kolom created_at dan updated_at.
     */
    public $timestamps = false; 
    
    /**
     * Relasi ke model Restaurant (Many to One).
     */
    public function restaurant()
    {
        // Asumsi model Restaurant bernama 'Restaurant' dan menggunakan 'restaurant_id'
        // Jika nama model Anda benar-benar 'Restoran', ganti 'Restaurant::class' menjadi 'Restoran::class'
        return $this->belongsTo(Restoran::class, 'restaurant_id', 'restaurant_id');
    }

    /**
     * Relasi ke Reservation (One to Many).
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'table_id', 'table_id');
    }

    /**
     * Relasi ke Order (One to Many).
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'table_id', 'table_id');
    }
}