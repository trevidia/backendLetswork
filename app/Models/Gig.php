<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gig extends Model
{
    use HasFactory;

    protected $fillable = [
      'title',
      'description',
      'requirements',
      'slug', 'sub_category_id', 'user_id', 'gig_status_id'
    ];

    public function tags(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(GigTags::class);
    }

    public function packages(){
        return $this->hasManyThrough(Packages::class, Product::class);
    }

    public function product(){
        return $this->hasOne(Product::class);
    }

    public function status(){
        return $this->belongsTo(GigStatus::class);
    }

    public function statusDetails(){
        return $this->hasOne(GigStatusDetail::class);
    }
}
