<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ncm extends Model
{
    use HasFactory;

    protected $fillable = [
        'ncm',
        'created_at',
        'updated_at',
    ];

}
