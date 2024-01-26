<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;
    
    protected $table = 'facturas';
    protected $primary_key = 'id_factura';

    protected $fillable = [     
        'fecha_emision',
        'fecha_vencimiento',
        'estado_pago',
        'precio_total',
        'id_receptor',
        'id_emisor'
    ];
}
