<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'gig_id', 'basic_id', 'standard_id', 'premium_id'
    ];

    public function packages(){
        return $this->hasMany(Packages::class);
    }
}
