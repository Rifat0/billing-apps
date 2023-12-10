<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductBatch extends Model
{
    use HasFactory, SoftDeletes, HasApiTokens;

    const RECEIVE_PENDING ='receive_pending';
    const RECEIVED ='received';
    const ACTIVE ='active';
    const INACTIVE ='inactive';
    const EXPIRED ='expired';
    const SOLD ='sold';

    protected $fillable = [
        'batch_no',
        'product_id',
        'product_variation_id',
        'supplier_id',
        'quantity',
        'purchase_price',
        'sale_price',
        'manufacturing_date',
        'expire_date',
        'status',
        'receive_time',
        'purchase_time',
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function variation(){
        return $this->belongsTo(ProductVariation::class, 'product_variation_id', 'id');
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function stocks(){
        return $this->hasMany(ProductStock::class, 'batch_id', 'id');
    }

    public function scopeActive($query){
        return $query->where('status', ProductBatch::ACTIVE);
    }

    public function scopeInactive($query){
        return $query->where('status', ProductBatch::INACTIVE);
    }

    public function availableStock(){
        $in = $this->stocks()->where('type', ProductStock::IN)->sum('quantity');
        $out = $this->stocks()->where('type', ProductStock::OUT)->sum('quantity');
        return $in - $out;
    }

    public function lot(){
        return $this->hasOne(ProductBatchLot::class, 'batch_id', 'id');
    }

    // public function payments(){
    //     return $this->hasMany(ProductBatchPayment::class, 'batch_id', 'batch_no');
    // }
}
