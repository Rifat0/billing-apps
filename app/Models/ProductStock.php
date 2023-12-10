<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductStock extends Model
{
    use HasFactory, SoftDeletes, HasApiTokens;

    const IN = 'in';
    const OUT = 'out';

    protected $fillable = [
        'product_id',
        'product_variation_id',
        'batch_id',
        'quantity',
        'type',
    ];

    public function batch(){
        return $this->belongsTo(ProductBatch::class, 'batch_id', 'id');
    }
}
