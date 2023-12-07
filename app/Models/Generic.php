<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class Generic extends Model
{
    use HasFactory, SoftDeletes, HasApiTokens;

    protected $fillable=[
        'name'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'generic_id', 'id');
    }
}
