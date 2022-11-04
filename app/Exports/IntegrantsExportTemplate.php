<?php

namespace App\Exports;

use App\Models\Integrants;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class IntegrantsExportTemplate implements FromArray, WithHeadings
{
    
    /**
     * @return array
     */
    public function array(): array
    {
        return [];
    }
    
    /**
     * @return array
     */
    public function headings(): array
    {
        return ['name', 'status'];
    }
}