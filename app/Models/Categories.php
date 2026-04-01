<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $hidden = ['created_at','updated_at'];

    public function menu(){
        return $this->hasMany(Foods::class,'cate_id');
    }
}
