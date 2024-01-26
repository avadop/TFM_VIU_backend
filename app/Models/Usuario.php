<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuario extends Persona
{
    use HasFactory;

    protected $table = 'usuarios';

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->fillable = array_merge($this->fillable, ['contrasenya']);
    }
}