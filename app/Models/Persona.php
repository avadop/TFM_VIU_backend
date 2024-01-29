<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $primaryKey = 'nif';
    public $incrementing = false;
    protected $keyType = 'string';
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
