<?php

namespace App\Http\Controllers;

use App\Http\Traits\ReportTrait;
use App\Models\LedgerManager;
use App\Models\Billing;
use App\Models\Categories;
use App\Models\Desk;
use App\Models\Foods;
use App\Models\LedgerFood;
use App\Models\Restro;
use App\Models\Sales;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CounterController extends Controller
{
	use ReportTrait;

	public function index()
	{
		$nav = [
			(object) ['name' => 'Dashboard', 'id' => 'dashboard', 'fa' => '', 'sts' => 0],
			(object) ['name' => 'POS', 'id' => 'pos', 'fa' => 'fa fa-clipboard-list', 'sts' => 1], // point of sales
			(object) ['name' => 'Order', 'id' => 'order', 'fa' => 'fa fa-clipboard-list', 'sts' => 2], // ordering
			(object) ['name' => '銷售量', 'id' => 'salexpen', 'fa' => 'fas fa-utensils', 'sts' => 1], // sales and expense report
			(object) ['name' => '设置', 'id' => 'items', 'fa' => 'fa fa-cog', 'sts' => 1], // add item / food and adjust price
			//            (object) ['name'=>'Settings','id'=>'setting','fa'=>'fa fa fa-gear','sts'=>1], // setting tax and company profile
			//            (object) ['name'=>'Order Status','id'=>'ordersts','fa'=>'fa fa fa-hourglass-1','sts'=>1],
		];
		$comp = Restro::first();
		return view('counter.index', compact('nav', 'comp'));
	}
	public function receipt(Billing $bill, Request $request)
	{
		$desk = $bill->desk;
		$order = $bill->id;
		$item = $bill->item;
		$subt = number_format($bill->subtotal, 2);
		//        $gstx = number_format($bill->rest,2);
		//        $tota = number_format($bill->grandtotal,2);
		return response(compact('item', 'subt', 'order', 'desk'));
	}
	public function paid(Billing $bill, Request $request)
	{
		$today = date('Y-m-d');
		$todayt = date('Y-m-d H:i:s');
		$data = $request->paid;

		if ($data['amt'] == 0) return response()->json(['error' => 'bad', 'message' => 'Please enter amount to pay']);
		$item = $bill->item;
		$this->reportDet($item);

		$bill->rest = $data['tax'];
		$bill->tax = round($data['taxnum']);
		$bill->discount = round($data['discnum'] ?? 0);
		$bill->discamt = $data['disc'] ?? 0;
		$bill->grandtotal = $data['grand'];
		$bill->paid_at = $todayt;
		$bill->paid = $data['amt'];
		$bill->change = $data['bal'];
		$bill->save();
		Desk::where('id', $bill->desk_id)->update(['order_id' => 0, 'sts' => 0, 'odrcnt' => 0]);
		Restro::first()->update(['paysts' => 1, 'ordersts' => 1]);
		$man = $this->reportMan($today);
		return response()->json(['success' => 'ok', 'man' => $man, 'receipt' => Billing::with('desk', 'item')->where('id', $bill->id)->first()]);
	}
	public function reportDet($item)
	{
		$today = date('Y-m-d');

		$paidBillIds = Billing::whereDate('paid_at', $today)->pluck('id');

		$cate = [];
		foreach ($item as $i) {
			$cid = $i->cate_id;
			if (!isset($cate[$cid])) $cate[$cid] = (object)['cate_id' => $cid, 'sts' => 1, 'dtsale' => $today, 'qty' => 0, 'amount' => 0];
			$cate[$cid]->qty += $i->qty;
			$cate[$cid]->amount += $i->amount;
		}

		$ldgfood = LedgerFood::where('dtsale', $today)->get();
		foreach ($ldgfood ?? [] as $lf) {
			$cid = $lf->cate_id;
			if (isset($cate[$cid])) unset($cate[$cid]);
			$sale = Sales::whereIn('bill_id', $paidBillIds)->where('cate_id', $cid)->get();
			$lf->qty = $sale->sum('qty');
			$lf->amount = $sale->sum('amount');
			$lf->save();
		}

		foreach ($cate as $k => $c) {
			LedgerFood::create((array)$c);
		}
	}
	public function foods()
	{
		$cate = Categories::all();
		$item = Foods::all();
		return response(compact('cate', 'item'));
	}

	public function reprint(Billing $bill)
	{
		$data = Billing::with('desk', 'item')->where('id', $bill->id)->first();
		if (!$data) {
			return response()->json(['error' => 'not_found', 'message' => 'Bill not found'], 404);
		}
		return response()->json(['success' => 'ok', 'receipt' => $data]);
	}

	public function calculate(Billing $bill, Request $request)
	{
		$taxnum = (int)($request->taxnum ?? 0);
		$discnum = (int)($request->discnum ?? 0);
		
		if ($taxnum < 0 || $taxnum > 100) $taxnum = 0;
		if ($discnum < 0 || $discnum > 100) $discnum = 0;
		
		$subtotal = (float)$bill->subtotal;
		$taxamt = ($subtotal * $taxnum) / 100;
		$net = $subtotal + $taxamt;
		$discamt = ($net * $discnum) / 100;
		$grand = $net - $discamt;
		
		return response()->json([
			'success' => 'ok',
			'subtotal' => round($subtotal, 2),
			'taxnum' => $taxnum,
			'tax' => round($taxamt, 2),
			'net' => round($net, 2),
			'discnum' => $discnum,
			'disc' => round($discamt, 2),
			'grand' => round($grand, 2)
		]);
	}
}
