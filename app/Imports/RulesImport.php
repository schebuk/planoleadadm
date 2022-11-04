<?php

namespace App\Imports;

use App\Models\Rules;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RulesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {        
        return new Segment([
            "rules" => $row['rules'],
            "menus" => $row['menus'],
            "widgets" => $row['widgets'],
            "status" => $row['status'],
            "trash" => 0,
            "deleted" => 0,
        ]);
    }
}