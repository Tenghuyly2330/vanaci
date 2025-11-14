<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Size extends Model
{
    protected $fillable = ['size'];
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected static function booted()
    {
        static::creating(function ($size) {
            $size->id = $size->id ?? (method_exists(Str::class, 'cuid') ? Str::cuid() : Str::random(10));
        });
    }
}
