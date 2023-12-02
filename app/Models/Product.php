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
        'name',
        'description',
        'quantity',
        'status',
        'image',
        'seller_id'
    ];

    protected $hidden=[
        'pivot'
    ];

    public function isAvailable()
    {
        return $this->status == Product::AVIALABLE_PRODUCT;
    }

    public function seller()
    {
        return $this->belongsto(Seller::class, 'seller_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'product_id', 'id');
    }

    public function categories()
    {
        return $this->belongstoMany(Category::class, 'category_product', 'product_id', 'category_id');
    }
}
