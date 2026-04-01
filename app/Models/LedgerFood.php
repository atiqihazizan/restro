<?php

namespace App\Models;

use App\Models\LedgerManager;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LedgerFood extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $attributes = [
        'man_id' => 0
    ];

    public function cate(){
        return $this->belongsTo(Categories::class,'cate_id');
    }
    public function man(){
        return $this->belongsTo(LedgerManager::class,'man_id');
    }
}
