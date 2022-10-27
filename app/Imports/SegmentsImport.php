<?php

namespace App\Imports;

use App\Models\Segment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SegmentsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {        
        return new Segment([
            "name" => $row['name'],
            "status" => $row['status'],
            "trash" => 0,
            "deleted" => 0,
        ]);
    }
}