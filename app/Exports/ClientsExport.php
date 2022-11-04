<?php

namespace App\Exports;

use App\Models\Clients;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClientsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $return = Clients::select('name', 'status','created_at')->get();

        return $return;
    }
    public function headings(): array
    {
        return ['name', 'status','created_at'];
    }
}
