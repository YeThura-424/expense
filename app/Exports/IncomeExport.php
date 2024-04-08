<?php

namespace App\Exports;

use App\Models\Income;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class IncomeExport implements FromCollection,WithHeadings
{
    public function headings():array{
        return[
            'Date',
            'Amount',
            'Description'
        ];
    } 

    protected $from,$to;

    function __construct($from,$to) {
        $this->from = $from;
        $this->to = $to;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {   
        $admin = auth()->user()->id;
        return Income::select('date','amount','description')->where('admin_id',$admin)->whereBetween('date', [$this->from, $this->to])->get();
    }
}
