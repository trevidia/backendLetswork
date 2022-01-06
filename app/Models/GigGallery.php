<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GigGallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'image1_location', 'image2_location', 'image3_location', 'location', 'gig_id'
    ];

    
}
