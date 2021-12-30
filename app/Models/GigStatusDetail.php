<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GigStatusDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'message', 'gig_id', 'gig_status_id'
    ];

    public function gig(){
        return $this->belongsTo(Gig::class);
    }

}
