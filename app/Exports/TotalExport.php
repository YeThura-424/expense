<?php

namespace App\Exports;

use App\Models\Total;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TotalExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array{
        return[
            'Date',
            'Total'
        ];
    } 

    protected $from,$to;

    function __construct($from,$to) {
        $this->from = $from;
        $this->to = $to;
    }

    public function collection()
    {
        $admin = auth()->user()->id;
        return Total::select('date','total')->where('admin_id',$admin)->whereBetween('date', [$this->from, $this->to])->get();
    }
}
