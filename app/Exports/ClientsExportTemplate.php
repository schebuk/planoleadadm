<?php

namespace App\Exports;

use App\Models\Clients;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClientsExportTemplate implements FromArray, WithHeadings
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