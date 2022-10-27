<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        
        $exists = User::where('email',$row['email'])->orWhere('user',$row['user'])->first();
        if ($exists) {
            //LOGIC HERE TO UPDATE
            return null;
        }
        
        return new User([
            "name" => $row['name'],
            "email" => $row['email'],
            "password" => Hash::make('password'),
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s"),
            "user" => $row['user'],
            "telephone" => $row['telephone'],
            "regraId" => $row['regraid'],
            "status" => $row['status'],
            "trash" => 0,
            "deleted" => 0,
        ]);
    }
}