<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Integrants extends Model
{
    protected $table = 'integrant';
    protected $fillable = [
        'name',
        'status',
        'trash',
        'delete',
    ];
    use HasFactory;
}
