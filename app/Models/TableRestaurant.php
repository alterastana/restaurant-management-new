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

    public $timestamps = false; // Tambahkan jika tabel tidak punya created_at & updated_at

    /**
     * Relasi ke model Restaurant.
     */
    public function restaurant()
    {
        // Hubungkan 'restaurant_id' di tabel ini ke 'restaurant_id' di tabel 'restaurants'
        return $this->belongsTo(Restoran::class, 'restaurant_id', 'restaurant_id');
    }
}
