<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductBatchLot extends Model
{
    use HasFactory, SoftDeletes, HasApiTokens;

    protected $fillable = [
        'batch_id',
        'lot_no',
    ];

    public function payments(){
        return $this->hasMany(ProductBatchLotPayment::class, 'lot_id', 'id');
    }
}
