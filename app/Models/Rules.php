<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rules extends Model
{
    protected $fillable = [
        'rules',
        'status',
        'menus',
        'widgets',
    ];
    use HasFactory;
}
