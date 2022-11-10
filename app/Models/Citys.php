<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citys extends Model
{
    protected $table = 'city';
    protected $fillable = [
        'name',
        'status',
        'trash',
        'delete',
    ];
    use HasFactory;
}
