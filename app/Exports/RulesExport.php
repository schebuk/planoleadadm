<?php

namespace App\Exports;

use App\Models\Rules;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RulesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $return = Rules::select('rules', 'menus', 'widgets', 'status','created_at')->get();

        return $return;
    }
    public function headings(): array
    {
        return ['rules', 'menus', 'widgets', 'status','created_at'];
    }
}
