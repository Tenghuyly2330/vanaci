<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    public $timestamps = false;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'slug',
        'type_id',
    ];

    protected static function booted()
    {
        static::creating(function ($category) {
            if (empty($category->id)) {
                if (method_exists(Str::class, 'cuid')) {
                    $category->id = (string) Str::cuid();
                } else {
                    $category->id = strtolower(Str::random(10));
                }
            }
        });
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'category_id', 'id');
    }

    public function getByType($typeId)
    {
        $categories = Category::where('type_id', $typeId)->get();

        return response()->json($categories);
    }
}
