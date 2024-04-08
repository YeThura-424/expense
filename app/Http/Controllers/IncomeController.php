<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use App\Exports\IncomeExport;
use App\Imports\IncomeImport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = auth()->user()->id;
        $income = Income::where('admin_id',$admin)->orderBy('date', 'DESC')->get();
        return view('Income.index',compact('income'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Income.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreIncomeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $date = $request->date;       
        $amount = $request->amount;
        $description = $request->description;
        $admin = auth()->user()->id;

        $income = new Income();
        $income->date = $date;
        $income->amount = $amount;
        $income->description = $description;
        $income->admin_id = $admin;
        $income->save();
        return redirect()->back()->with('successMsg','One new Income is ADDED in your data');
    }

    public function incomereport(Request $request)
    {
        $admin = auth()->user()->id;
        if ($request->data == 'get') {
            $from = $request->fromdate;
            $to = $request->todate;
            $status = 'get';    
            if ($to >= $from) {
                $total = Income::where('admin_id',$admin)->whereBetween('date',[$from,$to])->sum('amount');
                $income = Income::where('admin_id',$admin)->whereBetween('date',[$from,$to])->take('100')->get();
                if(Income::where('admin_id',$admin)->whereBetween('date',[$from,$to])->exists()){
                    return view('Income.report',compact('from','to','status','total','income'));
                }else{
                    return redirect()->back()->with('errorMsg','There is no data found. Please change the filter to get data.');
                }
            }else{
                return redirect()->back()->with('errorMsg','There is no data found. Please change the filter to get data.');
            }
        }else{
            $status = 'notget';
            if (Income::where('admin_id',$admin)->orderBy('date','ASC')->exists()) {
                $from = Income::where('admin_id',$admin)->orderBy('date','ASC')->get()->first()->date;
                $to = Income::where('admin_id',$admin)->orderBy('date','ASC')->get()->first()->date;
            }else{
                $from = date('2022-01-01');
                $to = date('2022-01-01');
            }
            return view('Income.report',compact('from','to','status'));
        }
    }

    public function incomeimport(Request $request) 
    {
        Excel::import(new IncomeImport, $request->file);
        return redirect()->back()->with('successMsg','Data is uploaded');
    }

    public function incomeexport(Request $request)
    {
        // dd($request);
        return Excel::download(new IncomeExport($request->from,$request->to), 'My Income from '.$request->from.' to '.$request->to.'.xlsx');
    }

    public function incomepdfexport(Request $request)
    {   
        $admin = auth()->user()->id;
        $from = $request->from;
        $to = $request->to;
        $data = Income::where('admin_id',$admin)->whereBetween('date', [$from, $to])->get();
        $pdf = PDF::loadView('Income.incomepdf', compact('data'));
    
        return $pdf->download('Income from '.$from.' to '.$to.'.pdf');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Income  $income
     * @return \Illuminate\Http\Response
     */
    public function show(Income $income)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Income  $income
     * @return \Illuminate\Http\Response
     */
    public function edit(Income $income)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateIncomeRequest  $request
     * @param  \App\Models\Income  $income
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateIncomeRequest $request, Income $income)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Income  $income
     * @return \Illuminate\Http\Response
     */
    public function destroy(Income $income)
    {
        //
    }
}
