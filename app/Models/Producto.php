<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';
    protected $primaryKey = 'id_producto';

    protected $fillable = [     
        'nombre',
        'descripcion',
        'precio_unidad',
        'impuesto',
        'stock',
        'id_usuario'
    ];

    public static function getAllProductosUsuario($id_usuario) {
        return self::where('id_usuario', $id_usuario)->get();
    }

    public static function getProductoById($id) {
        return self::findOrFail($id);
    }

    public function createProducto() {
        return self::save();
    }

    public function updateProducto() {
        return self::save();
    }

    public function deleteProducto() {
        return self::delete();
    }
}
