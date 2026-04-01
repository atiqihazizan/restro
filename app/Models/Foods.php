<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foods extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $hidden = ['created_at','updated_at'];
    public function cate(){
        return $this->belongsTo(Categories::class,'cate_id');
    }
}
