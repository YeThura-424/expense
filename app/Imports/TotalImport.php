<?php

namespace App\Imports;

use App\Models\Total;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TotalImport implements ToModel, WithHeadingRow
{
    public function transformDate($value, $format = 'Y-m-d')
    {
        try {
            return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\ErrorException $e) {
            return \Carbon\Carbon::createFromFormat($format, $value);
        }
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $admin = auth()->user()->id;
        if (Total::where('admin_id',$admin)->where('date',$this->transformDate($row['date']))->exists()) {
            return Total::updateOrCreate(
                [
                    "date" => $this->transformDate($row['date']),
                    "admin_id" => $admin,
                ],
                [   
                    $total = Total::where('date',$this->transformDate($row['date']))->get()->first(),
                    "total" => $total->total + $row['amount']
                ]
            );
        }else{
            return new Total([
                "date" => $this->transformDate($row['date']),
                "total" => $row['amount'],
                "admin_id" => $admin
            ]);
        }
    }
}
