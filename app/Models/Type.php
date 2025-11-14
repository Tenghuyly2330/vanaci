<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'types';
    public $timestamps = false;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'type',
        'slug',
    ];

    protected static function booted()
    {
        static::creating(function ($type) {
            if (empty($type->id)) {
                if (method_exists(Str::class, 'cuid')) {
                    $type->id = (string) Str::cuid();
                } else {
                    $type->id = strtolower(Str::random(10));
                }
            }
        });
    }
}
