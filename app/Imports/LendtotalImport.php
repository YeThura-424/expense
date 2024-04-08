<?php

namespace App\Imports;

use App\Models\Lendtotal;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LendtotalImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $admin = auth()->user()->id;
        if(Lendtotal::where('admin_id',$admin)->where('name',$row['name'])->exists()){
            if ($row['status'] == "Pending") {
                return Lendtotal::updateOrCreate(
                    [
                        "name" => $row['name'],
                        "admin_id" => $admin,
                    ],
                    [   
                        $total = Lendtotal::where('admin_id',$admin)->where('name',$row['name'])->get()->first(),
                        "total" => $total->total + $row['amount'],
                        "donetotal" =>$total->donetotal + $row['amount']
                    ]
                );    
            }else{
                return Lendtotal::updateOrCreate(
                    [
                        "name" => $row['name'],
                        "admin_id" => $admin,
                    ],
                    [   
                        $total = Lendtotal::where('admin_id',$admin)->where('name',$row['name'])->get()->first(),
                        "total" => $total->total + $row['amount'],
                        "donetotal" =>$total->donetotal + $row['amount']
                    ]
                );
            }
        }else{
            if ($row['status'] == "Pending") {
                return  new Lendtotal([
                    "name" => $row['name'],
                    "total" => $row['amount'],
                    "donetotal" => $row['amount'],
                    "admin_id" => $admin
                ]);
            }else{
                return  new Lendtotal([
                    "name" => $row['name'],
                    "total" => $row['amount'],
                    "admin_id" => $admin
                ]);
            }
        }
    }
}
