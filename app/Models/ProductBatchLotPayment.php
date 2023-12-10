<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductBatchLotPayment extends Model
{
    use HasFactory, SoftDeletes, HasApiTokens;

    const PENDING ='pending';
    const PAID ='paid';

    protected $fillable = [
        'payment_no',
        'lot_id',
        'batch_id',
        'payment_method',
        'payment_reference',
        'payment_status',
        'payment_amount',
        'payment_time',
        'payment_note',
    ];

    public function lot(){
        return $this->belongsTo(ProductBatchLot::class, 'lot_id', 'id');
    }
}
