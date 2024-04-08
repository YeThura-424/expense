<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lend;
use App\Models\Lendtotal;
use App\Exports\LendExport;
use App\Imports\LendImport;
use App\Imports\LendtotalImport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class LendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $admin = auth()->user()->id;
        // $lend = Lend::where('admin_id',$admin)->get();
        // return view('lend.lendlist',compact('lend'));
    }

    public function lendreport(Request $request)
    {
        $admin = auth()->user()->id;
        $name = Lend::distinct()->select('name')->where('admin_id',$admin)->get();
        if ($request->data == 'get') {
            $from = $request->fromdate;
            $to = $request->todate;
            $con1 = $request->name;
            $con2 = $request->status;
            if ($to >= $from) {                
                $status = 'get';
                if ($con1 == 'choose') {
                    if ($con2 == 'choose') {
                        $total = Lend::where('admin_id',$admin)->whereBetween('date', [$from, $to])->take('100')->get();
                        if (Lend::where('admin_id',$admin)->whereBetween('date', [$from, $to])->exists()) {
                            return view('Lend.lendreport',compact('total','from','to','status','name','con1','con2'));
                        }else{
                            return redirect()->back()->with('errorMsg','There is no data found. Please change the filter to get data.');
                        }
                    }else{
                        $total = Lend::where('admin_id',$admin)->where('status',$con2)->whereBetween('date', [$from, $to])->take('100')->get();
                        if (Lend::where('admin_id',$admin)->where('status',$con2)->whereBetween('date', [$from, $to])->exists()) {
                            return view('Lend.lendreport',compact('total','from','to','status','name','con1','con2'));
                        }else{
                            return redirect()->back()->with('errorMsg','There is no data found. Please change the filter to get data.'); 
                        }
                    }
                }else{
                    if($con2 == 'choose'){
                        $total = Lend::where('admin_id',$admin)->where('name',$con1)->whereBetween('date', [$from, $to])->take('100')->get();
                        if (Lend::where('admin_id',$admin)->where('name',$con1)->whereBetween('date', [$from, $to])->exists()) {
                            return view('Lend.lendreport',compact('total','from','to','status','name','con1','con2'));    
                        }else{
                            return redirect()->back()->with('errorMsg','There is no data found. Please change the filter to get data.');
                        }
                    }else{
                        $total = Lend::where('admin_id',$admin)->where('name',$con1)->where('status',$con2)->whereBetween('date', [$from, $to])->take('100')->get();
                        if (Lend::where('admin_id',$admin)->where('name',$con1)->where('status',$con2)->whereBetween('date', [$from, $to])->exists()) {
                            return view('Lend.lendreport',compact('total','from','to','status','name','con1','con2'));
                        }else{
                            return redirect()->back()->with('errorMsg','There is no data found. Please change the filter to get data.'); 
                        }
                    }
                }
                
            }else{
                $status = 'notget';
                if (Lend::where('admin_id',$admin)->orderBy('date','ASC')->exists()) {
                    $from = Lend::where('admin_id',$admin)->orderBy('date','ASC')->get()->first()->date;
                    $to = Lend::where('admin_id',$admin)->orderBy('date','ASC')->get()->first()->date;
                }else{
                    $from = date('2022-01-01');
                    $to = date('2022-01-01');
                }
                return redirect()->back()->with('errorMsg','From Date must be less than To Date!',compact('status','name','from','to'));
            }
        }else{
            $status = 'notget';
            if (Lend::where('admin_id',$admin)->orderBy('date','ASC')->exists()) {
                $from = Lend::where('admin_id',$admin)->orderBy('date','ASC')->get()->first()->date;
                $to = Lend::where('admin_id',$admin)->orderBy('date','ASC')->get()->first()->date;
            }else{
                $from = date('2022-01-01');
                $to = date('2022-01-01');
            }
            return view('Lend.lendreport',compact('status','name','from','to'));
        }
    }

    public function lendimport(Request $request) 
    {
        Excel::import(new LendImport, $request->file);
        Excel::import(new LendtotalImport, $request->file);
        return redirect()->back()->with('successMsg','Data is uploaded');
    }

    public function lendexport(Request $request)
    {
        // dd($request->total);
        // $request->from = date('2022-01-01');
        // $request->to = date('2022-01-31');
        return Excel::download(new LendExport($request->from,$request->to,$request->name,$request->status), 'Lend details from '.$request->from.' to '.$request->to.'.xlsx');
    }

    public function lendpdfexport(Request $request)
    {   
        $admin = auth()->user()->id;
        $from = $request->from;
        $to = $request->to;
        $con1 = $request->name;
        $con2 = $request->status;
        if ($con1 == 'choose') {
            if ($con2 == 'choose') {
                $data = Lend::where('admin_id',$admin)->whereBetween('date', [$from, $to])->get();
            }else{
                $data = Lend::where('admin_id',$admin)->where('status',$con2)->whereBetween('date', [$from, $to])->get();
            }
        }else{
            if ($con2 == 'choose') {
                $data = Lend::where('admin_id',$admin)->where('name',$con1)->whereBetween('date', [$from, $to])->get();
            }else{
                $data = Lend::where('admin_id',$admin)->where('name',$con1)->where('status',$con2)->whereBetween('date', [$from, $to])->get();
            }
        }        
        $pdf = PDF::loadView('Lend.lendpdf', compact('data'));
        return $pdf->download('Lend details from '.$from.' to '.$to.'.pdf');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Lend.createlend');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLendRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            $date = $request->date;
            $name = $request->name;        
            $amount = $request->amount;
            $status = $request->status;
            $description = $request->description;
            $admin = auth()->user()->id;

            $lend = new Lend();
            $lend->date = $date;
            $lend->name = $name;
            $lend->amount = $amount;
            $lend->status = $status;
            $lend->description = $description;
            $lend->admin_id = $admin;
            $lend->save();
            if (Lendtotal::where('admin_id',$admin)->where('name',$name)->exists()) {
                $lendtotal = Lendtotal::where('admin_id',$admin)->where('name',$name)->get()->first();
                $lendtotal->total = $lendtotal->total + $amount;
                $lendtotal->donetotal = $lendtotal->donetotal + $amount;
                $lendtotal->save();
                
            }else{
                $lendtotal = new Lendtotal();
                $lendtotal->name = $name;
                $lendtotal->total = $amount;
                $lendtotal->donetotal = $amount;
                $lendtotal->admin_id = $admin;
                $lendtotal->save();
            }
            return redirect()->route('lend.create')->with('successMsg','One new Lend is ADDED in your data');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lend  $lend
     * @return \Illuminate\Http\Response
     */
    public function show(Lend $lend)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lend  $lend
     * @return \Illuminate\Http\Response
     */
    public function edit(Lend $lend)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLendRequest  $request
     * @param  \App\Models\Lend  $lend
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($id);
        $lend = Lend::find($id);
        $name = $lend->name;
        $amount = $lend->amount;
        $lend->status = $request->status;
        $lend->donedate = date("Y-m-d");
        $lend->save();
        $lendtotal = Lendtotal::where('name',$name)->get()->first();            
        $lendtotal->donetotal = $lendtotal->donetotal - $amount;
        $lendtotal->save();
        // dd($lendtotal->total);
        return redirect()->back()->with('successMsg','One Lend is Done');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lend  $lend
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lend $lend)
    {
        //
    }
}
