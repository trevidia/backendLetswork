<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerInfo extends Model
{
    use HasFactory;
    protected $fillable = [
        "seller_label", "description", "seller_level", "location", "recent_delivery", "sub_category_id", "users_id"
    ];
}
