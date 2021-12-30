<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GigStatus extends Model
{
    use HasFactory;

    // admin controlls this
    protected $fillable = [
        'status',
    ];

    public function gigs(){
        return $this->hasMany(Gig::class);
    }

    public function actions(){
        return $this->hasMany(GigActions::class);
    }

    public function gigStatusDetails(){
        return $this->hasMany(GigStatusDetail::class);
    }
}
