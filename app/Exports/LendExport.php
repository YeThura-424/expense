<?php

namespace App\Exports;

use App\Models\Lend;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LendExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array{
        return[
            'Date',
            'To',
            'Amount',
            'Status',
            'Description',
            'Done Date' 
        ];
    } 

    protected $from,$to,$name,$status;

    function __construct($from,$to,$name,$status) {
        $this->from = $from;
        $this->to = $to;
        $this->name = $name;
        $this->status = $status;
    }

    public function collection()
    {
        $admin = auth()->user()->id;
        if ($this->name == 'choose') {
            if ($this->status = 'choose') {
                return Lend::select('date','name','amount','status','description','donedate')->where('admin_id',$admin)->whereBetween('date', [$this->from, $this->to])->get();    
            }else{
                return Lend::select('date','name','amount','status','description','donedate')->where('admin_id',$admin)->where('status',$this->status)->whereBetween('date', [$this->from, $this->to])->get();
            }
        }else{
            if ($this->status == 'choose') {
                return Lend::select('date','name','amount','status','description','donedate')->where('admin_id',$admin)->where('name',$this->name)->whereBetween('date', [$this->from, $this->to])->get();   
            }else{
                return Lend::select('date','name','amount','status','description','donedate')->where('admin_id',$admin)->where('name',$this->name)->where('status',$this->status)->whereBetween('date', [$this->from, $this->to])->get();
            }
        }
        
    }
}
