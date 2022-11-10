<?php

namespace App\Exports;

use App\Models\Leads;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LeadsExportTemplate implements FromArray, WithHeadings
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
        return ['name','email','telephone','cityId','adId','negReason','devReason','negDate','devDate','category','price','clientId','qualityId','note','font','segmentId','segmentCNPJType','segmentPersonType','segmentOperator','segmentLives','exibitionDate','status','leadTypeId'];
    }
}