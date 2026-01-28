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
        'category_id',
        'is_sold',
    ];

    protected $casts = [
        'is_sold' => 'boolean',
    ];



    public function nices()
    {
        return $this->hasMany(Nice::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    public function comments()
    {
    return $this->hasMany(Comment::class);
    }




}
