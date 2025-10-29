<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
 {
     protected $primaryKey = 'customer_id';
     public $incrementing = true;
     protected $keyType = 'int';

     protected $fillable = [
         'name',
         'email',
         'phone',
         'address',
     ];
 }