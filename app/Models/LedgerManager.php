<?php

namespace App\Models;

use App\Models\LedgerFood;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LedgerManager extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function ledger(){
        return $this->hasMany(LedgerFood::class,'man_id');
    }
}
