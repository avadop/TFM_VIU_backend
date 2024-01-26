<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $primary_key = 'nif';

    protected $fillable = [     
        'nif',
        'nombre',
        'apellidos',
        'correo_electronico',
        'direccion',
        'codigo_postal',
        'poblacion',
        'provincia',
        'pais'
    ];
}
