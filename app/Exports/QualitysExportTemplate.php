<?php

namespace App\Exports;

use App\Models\Qualitys;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class QualitysExportTemplate implements FromArray, WithHeadings
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