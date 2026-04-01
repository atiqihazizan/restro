<?php

namespace App\Http\Controllers;

use App\Models\Desk;
use Illuminate\Http\Request;

class DeskController extends Controller
{
    public function index()
    {
//        $color = ['border border-success','bg-success border border-success','bg-warning border border-warning','bg-danger border border-danger'];
//        // sts = 0: no order 1:pre-order 2:confirm/cooking 3:ready delivery 4:to pay
//        $table = Desk::all();
//        return view('ordering.table',['table'=>$table,'sts'=>$color]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Desk $desk)
    {
        //
    }

    public function edit(Desk $desk)
    {
        //
    }

    public function update(Request $request, Desk $desk)
    {
        //
    }

    public function destroy(Desk $desk)
    {
        //
    }
}
