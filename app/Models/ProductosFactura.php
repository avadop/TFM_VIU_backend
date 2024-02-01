<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductosFactura extends Model
{
    use HasFactory;

    protected $table = 'productos_en_facturas';
    protected $primaryKey = 'id_productos_factura';

    protected $fillable = [     
        'cantidad',
        'id_factura',
        'id_producto'
    ];

    public static function getAllProductosFatura($id_factura) {
        return self::where('id_factura', $id_factura)->get();
    }

    public static function getProductosFacturaById($id) {
        return self::findOrFail($id);
    }

    public function createProductosFactura() {
        return self::save();
    }

    public function updateProductosFactura() {
        return self::save();
    }

    public function deleteProductosFactura() {
        return self::delete();
    }
}
