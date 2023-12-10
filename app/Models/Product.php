<?php

namespace App\Models;

use App\Models\Category;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes, HasApiTokens;

    const AVIALABLE_PRODUCT='available';
    const UNAVIALABLE_PRODUCT='unavailable';

    protected $fillable=[
        'image',
        'name',
        'description',
        'company_id',
        'generic_id',
        'unit_id',
        'status',
    ];

    protected $hidden=[
        'pivot'
    ];

    public function isAvailable()
    {
        return $this->status == Product::AVIALABLE_PRODUCT;
    }

    public function getImageAttribute($image)
    {
        return url('image'.'/'.$image);
    }

    public function generic()
    {
        return $this->belongsto(Generic::class, 'generic_id', 'id');
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class, 'product_id', 'id');
    }

    public function categories()
    {
        return $this->belongstoMany(Category::class, 'category_product', 'product_id', 'category_id');
    }

    public function company()
    {
        return $this->belongsto(Company::class, 'company_id', 'id');
    }

    public function unit()
    {
        return $this->hasOne(Unit::class, 'unit_id', 'id');
    }

    public function batches()
    {
        return $this->hasMany(ProductBatch::class, 'product_id', 'id');
    }
}
