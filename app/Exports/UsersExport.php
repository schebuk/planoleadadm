<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $return = User::select('name', 'email', 'user', 'telephone', 'regraId', 'status','created_at')->get();

        return $return;
    }
    public function headings(): array
    {
        return ['name', 'email', 'user', 'telephone', 'regraId', 'status','created_at'];
    }
}
