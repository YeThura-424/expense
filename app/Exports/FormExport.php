<?php

namespace App\Exports;

use App\Models\Form;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FormExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array{
        return[
            'Date',
            'Category',
            'Amount',
            'Description' 
        ];
    } 

    protected $from,$to,$cat;

    function __construct($from,$to,$cat) {
        $this->from = $from;
        $this->to = $to;
        $this->cat = $cat;
    }

    public function collection()
    {
        $admin = auth()->user()->id;
        if ($this->cat == 'choose') {
            return Form::select('date','category','amount','description')->where('admin_id',$admin)->whereBetween('date', [$this->from, $this->to])->get();
        }else{
            return Form::select('date','category','amount','description')->where('admin_id',$admin)->where('category',$this->cat)->whereBetween('date', [$this->from, $this->to])->get();
        }
    }
}
