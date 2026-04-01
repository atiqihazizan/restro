<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Foods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FoodsController extends Controller
{
    public function item_index(Request $request){
        $food = Foods::with('cate');
        if($request->cate??false) $food = $food->where('cate_id',$request->cate);
        $data = $food
            ->orderBy('cate_id')
            ->orderBy('sort')->get();
        return response($data);
    }
    public function item_store(Request $request){
        $data = new \stdClass();
        $data->name = $request->name;
        $data->subtext = $request->subtext;
        $data->price = $request->price;
        $data->cate_id = $request->cate_id;
        $data->sort = $request->sort;

        $valid = Validator::make($request->all(),[
            'name'=>'required',
            'subtext'=>'required',
            'price'=>'required',
            'cate_id'=>'required',
        ],[]);
        if($valid->fails()) return response()->json(['error'=>$valid->errors()]);

        Foods::create((array)$data);
        return response()->json(['success'=>'ok','message'=>'Store successfull']);
    }
    public function item_update(Foods $foods,Request $request){
        $foods->name = $request->name;
        $foods->subtext = $request->subtext;
        $foods->price = $request->price;
        $foods->cate_id = $request->cate_id;
        $foods->sort = $request->sort;
        $foods->save();
        return response()->json(['success'=>'ok','message'=>'Update successfull']);
    }
    public function item_delete(Foods $foods){
        $foods->delete();
        return response()->json(['success'=>'ok','message'=>'Delete successfull']);
    }
    public function cate_index(Request $request){
        $cate = Categories::all();
        return response($cate);
    }
    public function cate_store(Request $request){
        $data = new \stdClass();
        $data->name = $request->name;
        Categories::create((array)$data);
        return response()->json(['success'=>'ok']);
    }
    public function cate_update(Categories $cate,Request $request){
        $cate->name = $request->name;
        $cate->save();
        return response()->json(['success'=>'ok']);
    }
    public function cate_delete(Categories $cate){
        $cate->delete();
        return response()->json(['success'=>'ok']);
    }
}
