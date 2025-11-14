<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductImage extends Model
{
    protected $fillable = ['product_color_id', 'image_path'];
    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function booted()
    {
        static::creating(function ($image) {
            $image->id = $image->id ?? (method_exists(Str::class, 'cuid') ? Str::cuid() : Str::random(10));
        });
    }

    public function productColor()
    {
        return $this->belongsTo(ProductColor::class, 'product_color_id');
    }
}

