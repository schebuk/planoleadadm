<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class States extends Model
{
    protected $table = 'state';
    protected $fillable = [
        'name',
        'abreviation',
        'status',
        'trash',
        'delete',
    ];
    use HasFactory;
}
