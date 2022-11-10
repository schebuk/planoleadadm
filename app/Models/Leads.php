<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leads extends Model
{
    protected $table = 'leads';
    protected $fillable = [
        'name',
        'email',
        'telephone',
        'cityId',
        'adId',
        'negReason',
        'devReason',
        'negDate',
        'devDate',
        'category',
        'price',
        'clientId',
        'qualityId',
        'note',
        'font',
        'segmentId',
        'segmentCNPJType',
        'segmentPersonType',
        'segmentOperator',
        'segmentLives',
        'exibitionDate',
        'leadTypeId',
        'status',
        'trash',
        'delete',
    ];
    use HasFactory;
}
