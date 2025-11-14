<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductColor extends Pivot
{
    protected $table = 'product_color';
    public $incrementing = true; 

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_color_id');
    }

    public function color()
    {
        return $this->belongsTo(Colors::class, 'color_id');
    }
}

