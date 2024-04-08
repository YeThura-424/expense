<?php

namespace App\Imports;

use App\Models\Form;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FormImport implements ToModel, WithHeadingRow
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
        return new Form([
            "date" => $this->transformDate($row['date']),
            "category" => $row['category'],
            "amount" => $row['amount'],
            "description" => $row['description'],
            "admin_id" => $admin
        ]);
    }
}
