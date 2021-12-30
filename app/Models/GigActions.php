<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GigActions extends Model
{
    use HasFactory;

    protected $fillable = [
        'action_title', 'slug', 'gig_status_id'
    ];

    public function status()
    {
        return $this->belongsTo(GigStatus::class);
    }
}
