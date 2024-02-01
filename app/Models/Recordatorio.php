<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recordatorio extends Model
{
    use HasFactory;

    protected $table = 'recordatorios';
    protected $primaryKey = 'id_recordatorio';

    protected $fillable = [     
        'mensaje',
        'fecha_creacion',
        'periodo_recordatorio',
        'id_usuario'
    ];

    public static function getAllRecordatoriosUsuario($id_usuario) {
        return self::where('id_usuario', $id_usuario)->get();
    }

    public static function getRecordatorioById($id) {
        return self::findOrFail($id);
    }

    public function createRecordatorio() {
        return self::save();
    }

    public function updateRecordatorio() {
        return self::save();
    }

    public function deleteRecordatorio() {
        return self::delete();
    }
}
