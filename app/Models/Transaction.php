<?php

namespace App\Models;

use App\Models\Buyer;
use App\Models\Product;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory, SoftDeletes, HasApiTokens;

    protected $fillable=[
        'quantity',
        'buyer_id',
        'product_id'
    ];

    public function buyer()
    {
        return $this->belongsTo(Buyer::class, 'buyer_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
