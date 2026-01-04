<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
    'product_name',
    'product_image',
    'brand_name',
    'product_description',
    'product_condition',
    'price',
    'user_id',
    ];



    public function nices()
{
    return $this->hasMany(Nice::class);
}



}
