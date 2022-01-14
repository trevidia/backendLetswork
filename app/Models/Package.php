<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
      /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'package_description','days_to_completion','revision_count','price','product_id'
    ];

    public function attributes(){
        return $this->hasMany(PackageSpecDetails::class);
    }
}
