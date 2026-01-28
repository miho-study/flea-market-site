<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
         protected $fillable = [
     'user_id',
     'product_id',
     'payment_method',
     'shipping_postcode',
     'shipping_address',
     'shipping_building',

     ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}