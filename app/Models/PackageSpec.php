<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageSpec extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     // table containing the constant specifications and co for
    protected $fillable = [
        'specification','type','extra_spec_title','drop_down_range','sub_category_id'
    ];

    public function subCategory(){
        return $this->belongsTo(SubCategory::class);
    }
}
