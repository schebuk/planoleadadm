<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Segment extends Model
{
    protected $table = 'segment';
    protected $fillable = [
        'name',
        'status',
        'trash',
        'delete',
    ];
    use HasFactory;
}
