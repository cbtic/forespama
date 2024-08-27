<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EntradaProductoDetalle extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_entrada_productos',
        'id_producto',
        'item',
        'cantidad',
        'numero_lote',
        'fecha_vencimiento',
        'aplica_precio',
        'id_um',
        'id_estado_bien',
        'id_marca',
        'estado'
    ];

    public function productos()
    {
        return $this->hasOne('Producto');
    }

    function getDetalleProductoId($id){

        $cad = "select epd.item, '11' cnd, epd.id_producto, '11' ubicacion_fisica, '11' anaquel, p.codigo, p.id_unidad_medida, epd.cantidad , epd.cantidad, epd.cantidad, '12' stock_actual, epd.costo, '123' subtotal, '124' igv, '125' total from entrada_producto_detalles epd 
        inner join productos p on epd.id_producto = p.id
        where id_entrada_productos ='".$id."'
        and epd.estado='1'";

		$data = DB::select($cad);
        return $data;
    }

}
