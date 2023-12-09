<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariation extends Model
{
    use HasFactory, SoftDeletes, HasApiTokens;

    protected $fillable = [
        'image',
        'product_id',
        'name',
        'unit_id',
    ];

    public function getImageAttribute($image)
    {
        return url('image'.'/'.$image);
    }

    public function product()
    {
        return $this->belongsto(Product::class, 'product_id', 'id');
    }

    public function unit()
    {
        return $this->hasOne(Unit::class, 'unit_id', 'id');
    }
}
