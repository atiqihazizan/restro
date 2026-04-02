<?php

namespace App\Http\Controllers;

use App\Http\Traits\ReportTrait;
use App\Models\Billing;
use App\Models\Categories;
use App\Models\LedgerFood;
use App\Models\Sales;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SalesController extends Controller
{
    use ReportTrait;
    public function sales(Request $request){
        $today = $request->find??date('Y-m-d');
        $data = Billing::with('desk','item')->whereDate('paid_at',$today)->get();
        return response($data);
    }
    public function daily(Request $request){
        $today = $request->find??date('Y-m-d');
        $this->recalcDet($today);
        $man = $this->reportMan($today);
        $data = LedgerFood::with('cate')
            ->whereDate('dtsale',$today)
            ->get();
        $c = $data->groupBy('cate_id');
        $rt = $c->mapWithKeys(function($grp,$key){
            return [
                $key => [
                    'id'=>$key,
                    'amount'=>round($grp->sum('amount'),2),
                    'qnt'=>$grp->sum('qty'),
                    'cate'=> trim( $grp->first()['cate']->name??'')
                ]
            ];
        });
        $data = [
            'man'=>$man,
            'det'=>$rt->values()
        ];
        return response()->json($data);
    }
    public function monthly(Request $request){
        $fdate = $request->find??date('Y-m');
        $man = $this->reportManMonth($fdate);
        $yrmth = explode('-',$fdate);
        $yr = $yrmth[0];
        $mth = $yrmth[1];

        $data = LedgerFood::with('cate')
            ->whereYear('dtsale',$yr)
            ->whereMonth('dtsale',$mth)
            ->get();
        $c = $data->groupBy('cate_id');
        $rt = $c->mapWithKeys(function($grp,$key){
            return [
                $key => [
                    'id'=>$key,
                    'amount'=>round($grp->sum('amount'),2),
                    'qnt'=>$grp->sum('qty'),
                    'cate'=> trim( $grp->first()['cate']->name??'')
                ]
            ];
        });
        $data = [
            'man'=>$man,
            'det'=>$rt->values()
        ];
        return response()->json($data);
    }
    public function yearly(Request $request){
        $yr = $request->find??date('Y');
        $man = $this->reportManYear($yr);
        $data = LedgerFood::with('cate')
            ->whereYear('dtsale',$yr)
            ->get();
        $c = $data->groupBy('cate_id');
        $rt = $c->mapWithKeys(function($grp,$key){
            return [
                $key => [
                    'id'=>$key,
                    'amount'=>round($grp->sum('amount'),2),
                    'qnt'=>$grp->sum('qty'),
                    'cate'=> trim( $grp->first()['cate']->name??'')
                ]
            ];
        });
        $data = [
            'man'=>$man,
            'det'=>$rt->values()
        ];
        return response()->json($data);
    }

    public function deleteSale(Billing $bill)
    {
        if (!$bill->paid_at) {
            return response()->json(['error' => 'bad', 'message' => 'Cannot delete unpaid bill'], 400);
        }

        $date = Carbon::parse($bill->paid_at)->format('Y-m-d');
        
        $bill->delete();
        
        $this->recalcDet($date);
        $this->reportMan($date);
        
        return response()->json(['success' => 'ok', 'message' => 'Receipt deleted successfully']);
    }
}
