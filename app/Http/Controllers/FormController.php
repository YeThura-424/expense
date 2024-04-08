<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\Category;
use App\Models\Total;
use App\Exports\FormExport;
use App\Exports\TotalExport;
use App\Imports\FormImport;
use App\Imports\TotalImport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $admin = auth()->user()->id;
        $total = Total::where('admin_id',$admin)->orderBy('date', 'DESC')->get();
        return view('uselisting',compact('total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $admin = auth()->user()->id;
        $cat = Category::where('admin_id',$admin)->get();
        return view('createuselist',compact('cat'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'date' => ['required'],
            'category' => ['required'],
            'amount' => ['required']
        ]);
            // dd($request);
        $date = $request->date;
        $category = $request->category;        
        $amount = $request->amount;
        $description = $request->description;
        $admin = auth()->user()->id;

        if (Total::where('admin_id',$admin)->where('date', $date)->exists()) {
            $total = Total::where('admin_id',$admin)->where('date',$date)->get()->first();
            $t2 = $total->total;
            $t3 = $t2 + $amount;
            $total->total = $t3;
            $total->save();
        }else{
            $total = new Total();
            $total->date = $date;
            $total->total= $amount;
            $total->admin_id = $admin;
            $total->save();
        }
        $form = new Form();
        $form->date = $date;
        $form->category = $category;
        $form->amount = $amount;
        $form->description = $description;
        $form->admin_id = $admin;
        $form->save();
        return redirect()->back()->with('successMsg','One new uselist is ADDED in your data');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {

    }

    public function report(Request $request)
    {
        // dd($request->from);
        $admin = auth()->user()->id;
        if ($request->data == 'get') {
            $from = $request->fromdate;
            $to = $request->todate;
        // dd($from);
            if ($to >= $from) {
                $status = 'get';
                $maintotal = Total::where('admin_id',$admin)->whereBetween('date', [$from, $to])->sum('total');
                $total = Total::where('admin_id',$admin)->whereBetween('date', [$from, $to])->take('100')->get();
                if (Total::where('admin_id',$admin)->whereBetween('date', [$from, $to])->exists()) {
                    return view('uselistreport',compact('total','maintotal','from','to','status'));
                }else{
                    return redirect()->back()->with('errorMsg','There is no data found. Please change the filter to get data.');
                }                
            }else{
                $status = 'notget';
                if (Total::where('admin_id',$admin)->orderBy('date','ASC')->exists()) {
                    $from = Total::where('admin_id',$admin)->orderBy('date','ASC')->get()->first()->date;
                    $to = Total::where('admin_id',$admin)->orderBy('date','ASC')->get()->first()->date;
                }else{
                    $from = date('2022-01-01');
                    $to = date('2022-01-01');
                }
                return redirect()->back()->with('errorMsg','From Date must be less than To Date!',compact('status','from','to'));
            }
        }else{
            $status = 'notget';
            if (Total::where('admin_id',$admin)->orderBy('date','ASC')->exists()) {
                $from = Total::where('admin_id',$admin)->orderBy('date','ASC')->get()->first()->date;
                $to = Total::where('admin_id',$admin)->orderBy('date','ASC')->get()->first()->date;
            }else{
                $from = date('2022-01-01');
                $to = date('2022-01-01');
            }
            return view('uselistreport',compact('status','from','to'));
        }
    }
    public function detailreport(Request $request)
    {
        $admin = auth()->user()->id;
        $cat = Category::where('admin_id',$admin)->get();
        if ($request->data == 'get') {
            $from = $request->fromdate;
            $to = $request->todate;
            $cate = $request->category;
            // dd($category);
            if ($to >= $from) {
                if ($cate == 'choose') {
                    $status = 'get';
                    $maintotal = Form::where('admin_id',$admin)->whereBetween('date', [$from, $to])->sum('amount');
                    $total = Form::where('admin_id',$admin)->whereBetween('date', [$from, $to])->take('100')->get();
                    if (Form::where('admin_id',$admin)->whereBetween('date', [$from, $to])->exists()) {
                    return view('detailreport',compact('total','maintotal','from','to','status','cat','cate'));
                    }else{
                        return redirect()->back()->with('errorMsg','There is no data found. Please change the filter to get data.');
                    }
                }else{
                    $status = 'get';
                    $maintotal = Form::where('admin_id',$admin)->where('category',$cate)->whereBetween('date', [$from, $to])->sum('amount');
                    $total = Form::where('admin_id',$admin)->where('category',$cate)->whereBetween('date', [$from, $to])->take('100')->get();
                    if (Form::where('admin_id',$admin)->where('category',$cate)->whereBetween('date', [$from, $to])->exists()) {
                    return view('detailreport',compact('total','maintotal','from','to','status','cat','cate'));
                    }else{
                        return redirect()->back()->with('errorMsg','There is no data found. Please change the filter to get data.');
                    }
                }
            }else{
                $status = 'notget';
                if (Form::where('admin_id',$admin)->orderBy('date','ASC')->exists()) {
                    $from = Form::where('admin_id',$admin)->orderBy('date','ASC')->get()->first()->date;
                    $to = Form::where('admin_id',$admin)->orderBy('date','ASC')->get()->first()->date;
                }else{
                    $from = date('2022-01-01');
                    $to = date('2022-01-01');
                }
                return redirect()->back()->with('errorMsg','From Date must be less than To Date!',compact('status','cat','from','to'));
            }
        }else{
            $status = 'notget';
            if (Form::orderBy('date','ASC')->exists()) {
                $from = Form::where('admin_id',$admin)->orderBy('date','ASC')->get()->first()->date;
                $to = Form::where('admin_id',$admin)->orderBy('date','ASC')->get()->first()->date;
            }else{
                $from = date('2022-01-01');
                $to = date('2022-01-01');
            }
            return view('detailreport',compact('status','cat','from','to'));
        }
    }
    
    public function excelimport(Request $request) 
    {
        Excel::import(new FormImport, $request->file);
        Excel::import(new TotalImport, $request->file);
        return redirect()->back()->with('successMsg','Data is uploaded');
    }

    public function excelexport(Request $request)
    {
        // dd($request);
        return Excel::download(new FormExport($request->from,$request->to,$request->cat), 'Uselist details from '.$request->from.' to '.$request->to.'.xlsx');
    }

    public function pdfexport(Request $request)
    {   
        $admin = auth()->user()->id;
        $from = $request->from;
        $to = $request->to;
        $cat = $request->cat;
        if ($cat == 'choose') {
            $data = Form::where('admin_id',$admin)->whereBetween('date', [$from, $to])->get();
        }else{
            $data = Form::where('admin_id',$admin)->where('category',$cat)->whereBetween('date', [$from, $to])->get();
        }
        $pdf = PDF::loadView('uselistdetailpdf', compact('data'));
    
        return $pdf->download('Uselist details from '.$from.' to '.$to.'.pdf');
    }

    public function totalpdfexport(Request $request)
    {   
        $admin = auth()->user()->id;
        $from = $request->from;
        $to = $request->to;
        $data = Total::where('admin_id',$admin)->whereBetween('date', [$from, $to])->get();
        $pdf = PDF::loadView('uselistpdf', compact('data'));
    
        return $pdf->download('Uselist from '.$from.' to '.$to.'.pdf');
    }

    public function totalexport(Request $request)
    {
        // dd($request->total);
        return Excel::download(new TotalExport($request->from,$request->to), 'Uselists from '.$request->from.' to '.$request->to.'.xlsx');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $total = Total::find($id);
        $date = $total->date;
        $form = Form::where('date',$date)->get();
        dd($form);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        dd($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
