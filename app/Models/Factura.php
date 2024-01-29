<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;
    
    protected $table = 'facturas';
    protected $primaryKey = 'id_factura';

    protected $fillable = [     
        'fecha_emision',
        'fecha_vencimiento',
        'estado_pago',
        'precio_total',
        'id_receptor',
        'id_emisor'
    ];

    public static function getAllFacturasReceptor($id_receptor) {
        return self::where('id_receptor', $id_receptor)->get();
    }

    public static function getAllFacturasEmisor($id_emisor) {
        return self::where('id_emisor', $id_emisor)->get();
    }

    public static function getFacturaById($id) {
        return self::findOrFail($id);
    }

    public function createFactura() {
        return self::save();
    }

    public function updateFactura() {
        return self::save();
    }

    public function deleteFactura() {
        return self::delete();
    }
}
