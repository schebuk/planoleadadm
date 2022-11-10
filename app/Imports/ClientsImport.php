<?php

namespace App\Imports;

use App\Models\Clients;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ClientssImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {        
        return new Clients([
            "name" => $row['name'],
            'firstName' => $row['firstName'],
            'lastName' => $row['lastName'],
            'clientUserId' => $row['clientUserId'],
            'email' => $row['email'],
            'telephone' => $row['telephone'],
            'telephoneBusiness' => $row['telephoneBusiness'],
            'personType' => $row['personType'],
            'documentNumber' => $row['documentNumber'],
            'corporateName' => $row['corporateName'],
            'CEP' => $row['CEP'],
            'adress' => $row['adress'],
            'adressComplement' => $row['adressComplement'],
            'district' => $row['district'],
            'cityId' => $row['cityId'],
            'segmentId' => $row['segmentId'],
            'balance' => $row['balance'],
            'status' => $row['status'],
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s"),
            "trash" => 0,
            "deleted" => 0,
        ]);
    }
}