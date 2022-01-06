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

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function tags(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(GigTags::class);
    }

    public function product(){
        return $this->hasMany(Product::class);
    }

    public function orders(){
        return $this->hasManyThrough(Order::class, Product::class);
    }

    public function packages(){
        return $this->hasManyThrough(Packages::class, Product::class);
    }

    public function views(){
        return $this->hasMany(View::class);
    }

    public function gigExtras(){
        return $this->hasMany(GigExtra::class);
    }

    public function gigFaqs(){
        return $this->hasMany(GigFAQ::class);
    }

    public function gallery(){
        return $this->hasOne(GigGallery::class);
    }

    public function statusDetails(){
        return $this->hasOne(GigStatusDetail::class);
    }

    public function subCategory(){
        return $this->belongsTo(SubCategory::class);
    }
}
