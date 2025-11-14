<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'discount',
        'type_id',
        'category_id'
    ];

    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected static function booted()
    {
        static::creating(function ($product) {
            $product->id = $product->id ?? (method_exists(Str::class, 'cuid') ? Str::cuid() : Str::random(10));
        });
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_size', 'product_id', 'size_id');
    }

    public function colors()
    {
        return $this->belongsToMany(Colors::class, 'product_color', 'product_id', 'color_id')
            ->withPivot('id')
            ->using(ProductColor::class);
    }

    public function images()
    {
        return $this->hasManyThrough(
            ProductImage::class,
            ProductColor::class,
            'product_id',
            'product_color_id',
            'id',
            'id'
        );
    }

    public function productColors()
    {
        return $this->hasMany(ProductColor::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
