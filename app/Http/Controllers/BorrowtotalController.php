<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrowtotal;
use App\Models\Borrow;

class BorrowtotalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = auth()->user()->id;
        $borrowtotal = Borrowtotal::where('admin_id',$admin)->get();
        return view('borrow.borrowtotal',compact('borrowtotal'));
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
     * @param  \App\Http\Requests\StoreBorrowtotalRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBorrowtotalRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Borrowtotal  $borrowtotal
     * @return \Illuminate\Http\Response
     */
    public function show(Borrowtotal $borrowtotal)
    {
        $admin = auth()->user()->id;
        $name = $borrowtotal->name;
        $borrow = Borrow::where('admin_id',$admin)->where('name',$name)->orderBy('date', 'DESC')->get();
        return view('Borrow.borrowdetail',compact('borrow','borrowtotal'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Borrowtotal  $borrowtotal
     * @return \Illuminate\Http\Response
     */
    public function edit(Borrowtotal $borrowtotal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBorrowtotalRequest  $request
     * @param  \App\Models\Borrowtotal  $borrowtotal
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBorrowtotalRequest $request, Borrowtotal $borrowtotal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Borrowtotal  $borrowtotal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Borrowtotal $borrowtotal)
    {
        //
    }
}
