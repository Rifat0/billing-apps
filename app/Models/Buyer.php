<?php

namespace App\Models;

use App\Models\Transaction;
use App\Models\Scopes\BuyerScope;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Buyer extends User
{
    use HasFactory, HasApiTokens;

    protected $table = 'users';

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new BuyerScope);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'buyer_id', 'id');
    }
}
