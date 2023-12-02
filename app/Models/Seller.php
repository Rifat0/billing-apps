<?php

namespace App\Models;

use App\Models\Scopes\SellerScope;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Seller extends User
{
    use HasFactory, HasApiTokens;

    protected $table = 'users';

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new SellerScope);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'seller_id', 'id');
    }
}
