<?php

namespace App\Exports;

use App\Models\Ads;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AdsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $return = Ads::select('name','price','codChannel', 'status','created_at')->get();

        return $return;
    }
    public function headings(): array
    {
        return ['name','price','codChannel', 'status','created_at'];
    }
}
