<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\Income;
use App\Models\Borrowtotal;
use App\Models\Lendtotal;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $admin = auth()->user()->id;
        $form = Form::where('admin_id',$admin)->sum('amount');
        $income = Income::where('admin_id',$admin)->sum('amount');
        $borrowtotal = Borrowtotal::where('admin_id',$admin)->sum('donetotal');
        $lendtotal = Lendtotal::where('admin_id',$admin)->sum('donetotal');
        $total = Form::where('admin_id',$admin)->where('date',date('Y-m-d'))->get();
        $incomes = Income::where('admin_id',$admin)->whereMonth('date',date('m'))->get();
        $mtotal = Form::where('admin_id',$admin)->whereMonth('date',date('m'))->sum('amount');
        $intotal = Income::where('admin_id',$admin)->whereMonth('date',date('m'))->sum('amount');
        return view('home',compact('form','income','borrowtotal','lendtotal','total','incomes','mtotal','intotal'));
    }


    public function adminHome()
    {
        return view('uselisting');
    }

    public function pmreport(Request $request)
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
            $status = 'get';
            // if (Income::where('admin_id',$admin)->orderBy('date','ASC')->exists()) {
            //     $from = Income::where('admin_id',$admin)->orderBy('date','ASC')->get()->first()->date;
            //     $to = Income::where('admin_id',$admin)->orderBy('date','ASC')->get()->first()->date;
            // }else{
                $from = date('2022-01-01');
                $to = date('2022-01-01');
            // }
            $incomes = Income::where('admin_id',$admin)->groupB->get();
            return view('Income.report',compact('from','to','status'));
        }
    }
}
