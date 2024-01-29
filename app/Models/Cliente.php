<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Persona
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'clientes';

    protected $dates = ['deleted_at'];

    public function __construct(array $attributes = []) {
        $this->fillable = array_merge($this->fillable, ['id_usuario']);
        parent::__construct($attributes);
    }

    public static function getAllClientesUsuario($id_usuario) {
        return self::where('id_usuario', $id_usuario)->get();
    }

    public static function getClienteById($id) {
        return self::findOrFail($id);
    }

    public static function getDeletedClienteById($id) {
        return self::onlyTrashed()->findOrFail($id);
    }

    public function createCliente() {
        return self::save();
    }

    public function restoreCliente() {
        return self::restore();
    }

    public function updateCliente() {
        return self::save();
    }

    public function deleteCliente() {
        return self::delete();
    }
}
