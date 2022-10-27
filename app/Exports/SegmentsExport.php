<?php

namespace App\Exports;

use App\Models\Segment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SegmentsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $return = Segment::select('name', 'status','created_at')->get();

        return $return;
    }
    public function headings(): array
    {
        return ['name', 'status','created_at'];
    }
}
