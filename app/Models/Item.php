<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'size',
        'color',
        'description',
        'price',
        'discount',
        'image',
        'status',
        'type_id',
        'category_id'
    ];

    protected $casts = [
        // 'image' => 'array',
        'color' => 'array',
        'size' => 'array',
        'status' => 'boolean',
    ];

    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected static function booted()
    {
        static::creating(function ($item) {
            $item->id = $item->id ?? (method_exists(Str::class, 'cuid') ? Str::cuid() : Str::random(10));
        });
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
