<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GigTags extends Model
{
    use HasFactory;
    protected $fillable = [
        'tag_title','gig_id'
    ];

    public function gig()
    {
        return $this->belongsTo(Gig::class);
    }
}
