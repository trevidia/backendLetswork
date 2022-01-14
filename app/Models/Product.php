<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'gig_id', 'product_title'
    ];

    public function package(){
        return $this->hasOne(Package::class);
    }

}
