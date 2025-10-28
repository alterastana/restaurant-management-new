<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loyalty extends Model
{
    use HasFactory;

    protected $table = 'loyalty_programs';
    protected $primaryKey = 'loyalty_id';
    protected $fillable = ['customer_id', 'points', 'membership_level'];
}
