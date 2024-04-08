<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lendtotal;
use App\Models\Lend;

class LendtotalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = auth()->user()->id;
        $lendtotal = Lendtotal::where('admin_id',$admin)->get();
        return view('Lend.lendtotal',compact('lendtotal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLendtotalRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLendtotalRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lendtotal  $lendtotal
     * @return \Illuminate\Http\Response
     */
    public function show(Lendtotal $lendtotal)
    {
        $admin = auth()->user()->id;
        $name = $lendtotal->name;
        $lend = Lend::where('admin_id',$admin)->where('name',$name)->orderBy('date', 'DESC')->get();
        return view('Lend.lenddetail',compact('lend','lendtotal'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lendtotal  $lendtotal
     * @return \Illuminate\Http\Response
     */
    public function edit(Lendtotal $lendtotal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLendtotalRequest  $request
     * @param  \App\Models\Lendtotal  $lendtotal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lendtotal  $lendtotal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lendtotal $lendtotal)
    {
        //
    }
}
