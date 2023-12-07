<?php

namespace App\Models;

use App\Models\Product;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, SoftDeletes, HasApiTokens;

    protected $fillable=[
        'name',
        'description',
    ];

    protected $hidden=[
        'pivot'
    ];

    public function products()
    {
        return $this->belongstoMany(Product::class, 'category_product', 'category_id', 'product_id');
    }
}
