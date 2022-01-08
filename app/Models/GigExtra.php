<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GigExtra extends Model
{
    use HasFactory;

    protected $fillable = [
        'gig_extra_title', 'price', 'additional_days', 'custom_extra', 'product_id', 'gig_id'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }


}
