<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuario extends Persona
{
    use HasFactory;

    protected $table = 'usuarios';

    protected $hidden = ['contrasenya'];

    public function __construct(array $attributes = []) {
        $this->fillable = array_merge($this->fillable, ['contrasenya']);
        parent::__construct($attributes);
    }

    public static function getUsuarioById($id) {
        return self::findOrFail($id);
    }

    public function createUsuario() {
        return self::save();
    }

    public function updateUsuario() {
        return self::save();
    }

    public function deleteUsuario() {
        return self::delete();
    }
}
