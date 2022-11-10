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
            'email' => $row['email'],
            'telephone' => $row['telephone'],
            'cityId' => $row['cityId'],
            'adId' => $row['adId'],
            'negReason' => $row['negReason'],
            'devReason' => $row['devReason'],
            'negDate' => $row['negDate'],
            'devDate' => $row['devDate'],
            'category' => $row['category'],
            'price' => $row['price'],
            'clientId' => $row['clientId'],
            'qualityId' => $row['qualityId'],
            'integrantId' => $row['integrantId'],
            'note' => $row['note'],
            'font' => $row['font'],
            'segmentId' => $row['segmentId'],
            'segmentCNPJType' => $row['segmentCNPJType'],
            'segmentPersonType' => $row['segmentPersonType'],
            'segmentOperator' => $row['segmentOperator'],
            'segmentLives' => $row['segmentLives'],
            'exibitionDate' => $row['exibitionDate'],
            'status' => $row['status'],
            'created_at' => $row['created_at'],
            'leadTypeId' => $row['leadTypeId'],
            'status' => $row['status'],
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s"),
            "trash" => 0,
            "deleted" => 0,
        ]);
    }
}