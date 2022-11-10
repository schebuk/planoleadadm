<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    protected $table = 'clients';
    protected $fillable = [
        'name',
        'firstName',
        'lastName',
        'userId',
        'email',
        'telephone',
        'telephoneBusiness',
        'personType',
        'documentNumber',
        'corporateName',
        'CEP',
        'adress',
        'adressComplement',
        'district',
        'cityId',
        'segmentId',
        'balance',
        'status',
        'trash',
        'delete',
    ];
    use HasFactory;
}
