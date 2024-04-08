<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrow;
use App\Models\Borrowtotal;
use App\Exports\BorrowExport;
use App\Imports\BorrowImport;
use App\Imports\BorrowtotalImport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class BorrowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        
    }

    public function borrowreport(Request $request)
    {
        $admin = auth()->user()->id;
        $name = Borrow::distinct()->select('name')->where('admin_id',$admin)->get();
        if ($request->data == 'get') {
            $from = $request->fromdate;
            $to = $request->todate;
            $con1 = $request->name;
            $con2 = $request->status;
            if ($to >= $from) {
                $status = 'get';
                if ($con1 == 'choose') {
                    if ($con2 == 'choose') {
                        $total = Borrow::where('admin_id',$admin)->whereBetween('date', [$from, $to])->take('100')->get();
                        if (Borrow::where('admin_id',$admin)->whereBetween('date', [$from, $to])->exists()) {
                            return view('Borrow.borrowreport',compact('total','from','to','status','name','con1','con2'));
                        }else{
                            return redirect()->back()->with('errorMsg','There is no data found. Please change the filter to get data.');                          
                        }
                    }else{
                        $total = Borrow::where('admin_id',$admin)->where('status',$con2)->whereBetween('date', [$from, $to])->take('100')->get();
                        if (Borrow::where('admin_id',$admin)->where('status',$con2)->whereBetween('date', [$from, $to])->exists()) {
                            return view('Borrow.borrowreport',compact('total','from','to','status','name','con1','con2'));
                        }else{
                            return redirect()->back()->with('errorMsg','There is no data found. Please change the filter to get data.');
                        }
                    }
                }else{
                    if ($con2 == 'choose') {
                        $total = Borrow::where('admin_id',$admin)->where('name',$con1)->whereBetween('date', [$from, $to])->take('100')->get();
                        if (Borrow::where('admin_id',$admin)->where('name',$con1)->whereBetween('date', [$from, $to])->exists()) {
                            return view('Borrow.borrowreport',compact('total','from','to','status','name','con1','con2'));
                        }else{
                            return redirect()->back()->with('errorMsg','There is no data found. Please change the filter to get data.');
                        }
                    }else{
                        $total = Borrow::where('admin_id',$admin)->where('name',$con1)->where('status',$con2)->whereBetween('date', [$from, $to])->take('100')->get();
                        if (Borrow::where('admin_id',$admin)->where('name',$con1)->where('status',$con2)->whereBetween('date', [$from, $to])->exists()) {
                            return view('Borrow.borrowreport',compact('total','from','to','status','name','con1','con2'));
                        }else{
                            return redirect()->back()->with('errorMsg','There is no data found. Please change the filter to get data.');
                        }
                    }
                }
                $total = Borrow::where('admin_id',$admin)->whereBetween('date', [$from, $to])->take('100')->get();
                return view('Borrow.borrowreport',compact('total','from','to','status','name','con1','con2'));
            }else{
                $status = 'notget';
                if (Borrow::where('admin_id',$admin)->orderBy('date','ASC')->exists()) {
                    $from = Borrow::where('admin_id',$admin)->orderBy('date','ASC')->get()->first()->date;
                    $to = Borrow::where('admin_id',$admin)->orderBy('date','ASC')->get()->first()->date;
                }else{
                    $from = date('2022-01-01');
                    $to = date('2022-01-01');
                }
                return redirect()->back()->with('errorMsg','From Date must be less than To Date!',compact('status','name','from','to'));
            }
        }else{
            $status = 'notget';
            if (Borrow::where('admin_id',$admin)->orderBy('date','ASC')->exists()) {
                $from = Borrow::where('admin_id',$admin)->orderBy('date','ASC')->get()->first()->date;
                $to = Borrow::where('admin_id',$admin)->orderBy('date','ASC')->get()->first()->date;
            }else{
                $from = date('2022-01-01');
                $to = date('2022-01-01');
            }
            return view('Borrow.borrowreport',compact('status','name','from','to'));
        }
    }

    public function borrowimport(Request $request) 
    {
        Excel::import(new BorrowImport, $request->file);
        Excel::import(new BorrowtotalImport, $request->file);
        return redirect()->back()->with('successMsg','Data is uploaded');
    }

    public function borrowexport(Request $request)
    {
        // dd($request->total);
        return Excel::download(new BorrowExport($request->from,$request->to,$request->name,$request->status), 'Borrow details from '.$request->from.' to '.$request->to.'.xlsx');
    }

    public function borrowpdfexport(Request $request)
    {   
        $admin = auth()->user()->id;
        $from = $request->from;
        $to = $request->to;
        $con1 = $request->name;
        $con2 = $request->status;
        if ($con1 == 'choose') {
            if ($con2 == 'choose') {
                $data = Borrow::where('admin_id',$admin)->whereBetween('date', [$from, $to])->get();
            }else{
                $data = Borrow::where('admin_id',$admin)->where('status',$con2)->whereBetween('date', [$from, $to])->get();
            }
        }else{
            if ($con2 == 'choose') {
                $data = Borrow::where('admin_id',$admin)->where('name',$con1)->whereBetween('date', [$from, $to])->get();
            }else{
                $data = Borrow::where('admin_id',$admin)->where('name',$con1)->where('status',$con2)->whereBetween('date', [$from, $to])->get();
            }
        }
        $pdf = PDF::loadView('Borrow.borrowpdf', compact('data'));
        return $pdf->download('Borrow details from '.$from.' to '.$to.'.pdf');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Borrow.createborrow');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBorrowRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            // dd($request);
            $date = $request->date;
            $name = $request->name;        
            $amount = $request->amount;
            $status = $request->status;
            $description = $request->description;
            $admin = auth()->user()->id;

            $borrow = new Borrow();
            $borrow->date = $date;
            $borrow->name = $name;
            $borrow->amount = $amount;
            $borrow->status = $status;
            $borrow->description = $description;
            $borrow->admin_id = $admin;
            $borrow->save();
            if (Borrowtotal::where('admin_id',$admin)->where('name',$name)->exists()) {
                $borrowtotal = Borrowtotal::where('name',$name)->get()->first();
                $borrowtotal->total = $borrowtotal->total + $amount;
                $borrowtotal->donetotal = $borrowtotal->donetotal + $amount;
                $borrowtotal->save();
                
            }else{
                $borrowtotal = new Borrowtotal();
                $borrowtotal->name = $name;
                $borrowtotal->total = $amount;
                $borrowtotal->donetotal = $amount;
                $borrowtotal->admin_id = $admin;
                $borrowtotal->save();
            }
            return redirect()->route('borrow.create')->with('successMsg','One new Borrow is ADDED in your data');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Borrow  $borrow
     * @return \Illuminate\Http\Response
     */
    public function show(Borrow $borrow)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Borrow  $borrow
     * @return \Illuminate\Http\Response
     */
    public function edit(Borrow $borrow)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBorrowRequest  $request
     * @param  \App\Models\Borrow  $borrow
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($id);
        $borrow = Borrow::find($id);
        $name = $borrow->name;
        $amount = $borrow->amount;
        $borrow->status = $request->status;
        $borrow->donedate = date("Y-m-d");
        $borrow->save();
        $borrowtotal = Borrowtotal::where('name',$name)->get()->first();            
        $borrowtotal->donetotal = $borrowtotal->donetotal - $amount;
        $borrowtotal->save();
        return redirect()->back()->with('successMsg','One Borrow is Done');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Borrow  $borrow
     * @return \Illuminate\Http\Response
     */
    public function destroy(Borrow $borrow)
    {
        //
    }
}
