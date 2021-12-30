<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'image_url', 'slug', 'category_id'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function gigs()
    {
        return $this->hasMany(Gig::class);
    }

    public function specs(){
        return $this->hasMany(PackageSpec::class);
    }
}
