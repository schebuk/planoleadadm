<?php

namespace App\Imports;

use App\Models\Ads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AdsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {        
        return new Ads([
            "name" => $row['name'],
            "status" => $row['status'],
            "price" => $row['price'],
            "codChannel" => $row['codChannel'],
            "trash" => 0,
            "deleted" => 0,
        ]);
    }
}