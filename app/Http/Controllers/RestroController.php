<?php

namespace App\Http\Controllers;

use App\Models\Restro;
use Illuminate\Http\Request;

class RestroController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Restro $restro)
    {
        //
    }

    public function edit(Restro $restro)
    {
        //
    }

    public function update(Request $request, Restro $restro)
    {
        $restro->update($request->all());
        return redirect()->route('main');
    }

    public function destroy(Restro $restro)
    {
        //
    }
}
