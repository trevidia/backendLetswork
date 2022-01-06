<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number', 'product_id'
    ];

    public function status(){
        return $this->hasOne(OrderStatus::class);
    }

    public function items(){
        $gigExtra = $this->hasMany(GigExtra::class);
        $gigPackage = $this->hasOne(Packages::class);
        // $gigPackage = $this->hasOne(::class);
        return [$gigExtra, $gigPackage];
    }
}
