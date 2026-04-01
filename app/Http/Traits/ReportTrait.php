<?php

namespace App\Http\Traits;

use App\Models\LedgerManager;
use App\Models\Billing;
use App\Models\LedgerFood;

trait ReportTrait
{
    public function reportMan($today){
        if($today == '') return false;
        $man = LedgerManager::where('dmy',$today)->first();
        $bill = Billing::whereDate('paid_at',$today)->get();
        $tax = $bill->sum('rest');
        $discount = $bill->sum('discamt');
        $lfamt = LedgerFood::where('dtsale',$today)->sum('amount');
        $total = (float)$lfamt + (float)$tax - (float)$discount;
        if($man){
            $man->subtotal = $lfamt;
            $man->tax = $tax;
            $man->discount = $discount;
            $man->total = $total;
            $man->save();
        } else{
            $arr = ['dmy'=>$today,'subtotal'=>$lfamt,'tax'=>$tax,'discount'=>$discount,'total'=>$total];
            $man = LedgerManager::create($arr);
        }
        return $man;
    }
    public function reportManMonth($today){
        if($today == '') return false;
        $yrmth = explode('-',$today);
        $yr = $yrmth[0];
        $mth = $yrmth[1];

        $man = LedgerManager::where('dmy',$today)->first();
        $bill = Billing::whereYear('paid_at',$yr)->whereMonth('paid_at',$mth)->get();
        $tax = $bill->sum('rest');
        $discount = $bill->sum('discamt');
        $lfamt = LedgerFood::whereYear('dtsale',$yr)->whereMonth('dtsale',$mth)->sum('amount');
        $total = (float)$lfamt + (float)$tax - (float)$discount;
        if($man){
            $man->subtotal = $lfamt;
            $man->tax = $tax;
            $man->discount = $discount;
            $man->total = $total;
            $man->save();
        } else{
            $arr = ['dmy'=>$today,'subtotal'=>$lfamt,'tax'=>$tax,'discount'=>$discount,'total'=>$total];
            $man = LedgerManager::create($arr);
        }
        return $man;
    }
    public function reportManYear($year = 0){
        if($year == 0) return false;

        $man = LedgerManager::where('dmy',$year)->first();
        $bill = Billing::whereYear('paid_at',$year)->get();
        $tax = $bill->sum('rest');
        $discount = $bill->sum('discamt');
        $lfamt = LedgerFood::whereYear('dtsale',$year)->sum('amount');
        $total = (float)$lfamt + (float)$tax - (float)$discount;
        if($man){
            $man->subtotal = $lfamt;
            $man->tax = $tax;
            $man->discount = $discount;
            $man->total = $total;
            $man->save();
        } else{
            $arr = ['dmy'=>$year,'subtotal'=>$lfamt,'tax'=>$tax,'discount'=>$discount,'total'=>$total];
            $man = LedgerManager::create($arr);
        }
        return $man;
    }
}
