<?php

namespace App\Http\Controllers;

use App\Models\Total;
use App\Models\Form;
use App\Http\Requests\StoreTotalRequest;
use App\Http\Requests\UpdateTotalRequest;

class TotalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreTotalRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTotalRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Total  $total
     * @return \Illuminate\Http\Response
     */
    public function show(Total $total)
    {   
        $admin = auth()->user()->id;
        $date  = $total->date;
        $form = Form::where('admin_id',$admin)->where('date',$date)->get();
        return view('detail',compact('form','total'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Total  $total
     * @return \Illuminate\Http\Response
     */
    public function edit(Total $total)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTotalRequest  $request
     * @param  \App\Models\Total  $total
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTotalRequest $request, Total $total)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Total  $total
     * @return \Illuminate\Http\Response
     */
    public function destroy(Total $total)
    {
        //
    }
}
