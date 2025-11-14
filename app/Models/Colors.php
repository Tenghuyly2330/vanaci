<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Colors extends Model
{
    protected $fillable = ['color_name', 'color_code'];
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected static function booted()
    {
        static::creating(function ($color) {
            $color->id = $color->id ?? (method_exists(Str::class, 'cuid') ? Str::cuid() : Str::random(10));
        });
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_color', 'color_id', 'product_id');
    }

    public function productColors()
    {
        return $this->hasMany(ProductColor::class, 'color_id');
    }

    public function images()
    {
        // go through the pivot table to access all product images related to this color
        return $this->hasManyThrough(
            ProductImage::class,
            ProductColor::class,
            'color_id',        // Foreign key on product_colors table
            'product_color_id',// Foreign key on product_images table
            'id',              // Local key on colors table
            'id'               // Local key on product_colors table
        );
    }
}
