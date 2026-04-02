<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Billing extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public function item(){
        return $this->hasMany(Sales::class,'bill_id');
    }
    public function desk(){
        return $this->belongsTo(Desk::class,'desk_id');
    }
}
