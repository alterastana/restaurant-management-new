<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restoran extends Model
{
    use HasFactory;

    /**
     * Memberitahu Laravel nama tabel yang benar di database.
     * @var string
     */
    protected $table = 'restaurants';

    /**
     * Memberitahu Laravel nama primary key yang benar.
     * @var string
     */
    protected $primaryKey = 'restaurant_id';

    /**
     * Kolom-kolom yang diizinkan untuk diisi secara massal (mass assignment).
     * @var array
     */
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
    ];
}