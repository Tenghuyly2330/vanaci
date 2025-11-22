<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $table = 'subcategories';
    public $timestamps = false;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'type_id',
    ];

    protected static function booted()
    {
        static::creating(function ($subcategory) {
            if (empty($subcategory->id)) {
                if (method_exists(Str::class, 'cuid')) {
                    $subcategory->id = (string) Str::cuid();
                } else {
                    $subcategory->id = strtolower(Str::random(10));
                }
            }
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

    public function items()
    {
        return $this->hasMany(Item::class, 'subcategory_id', 'id');
    }
}
