<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerSkill extends Model
{
    use HasFactory;

    protected $fillable = [
        "seller_skill_title", "level", "users_id"
    ];
}
