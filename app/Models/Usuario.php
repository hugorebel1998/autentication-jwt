<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usuario extends Model
{
    
    protected $table = 'usuarios';
    
    
    protected $fillable = [
        'nombre',
        'paterno',
        'materno',
        'username',
        'email',
        'password',
        'estatus',
    ];


    use HasFactory, HasUlids, SoftDeletes;
}
