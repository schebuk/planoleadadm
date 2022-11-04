<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qualitys extends Model
{
    protected $table = 'quality';
    protected $fillable = [
        'name',
        'status',
        'trash',
        'delete',
    ];
    use HasFactory;
}
