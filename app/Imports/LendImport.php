<?php

namespace App\Imports;

use App\Models\Lend;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class LendImport implements ToModel, WithHeadingRow
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
        if ($row['status'] == "Pending") {
            return  new Lend([
                "date" => $this->transformDate($row['date']),
                "name" => $row['name'],
                "amount" => $row['amount'],
                "status" => $row['status'],
                "description" => $row['description'],
                "admin_id" => $admin
            ]);
        }else{
            return  new Lend([
                "date" => $this->transformDate($row['date']),
                "name" => $row['name'],
                "amount" => $row['amount'],
                "status" => $row['status'],
                "description" => $row['description'],
                "donedate" => $this->transformDate($row['donedate']),
                "admin_id" => $admin
            ]);
        }
    }
}
