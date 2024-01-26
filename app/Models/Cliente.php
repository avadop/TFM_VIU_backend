<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cliente extends Persona
{
    use HasFactory;

    protected $table = 'clientes';

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->fillable = array_merge($this->fillable, ['id_usuario']);
    }

    public static function getAllClientesUsuario($id_usuario) {
        return self::where('id_usuario', $id_usuario)->get();
    }

    public static function getClienteById($id) {
        return self::findOrFail($id);
    }

    public function createCliente() {
        return self::save();
    }

    public function updateCliente() {
        return self::save();
    }

    public function deleteCliente() {
        return self::delete();
    }
}
