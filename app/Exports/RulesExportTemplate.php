<?php

namespace App\Exports;

use App\Models\Rules;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RulesExportTemplate implements FromArray, WithHeadings
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
        return ['rules', 'menus', 'widgets', 'status'];
    }
}