<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'numero_serie' => ['required', 'string'],
            'codigo' => ['required', 'string'],
            'denominacion' => ['required', 'string'],
            'id_unidad_medida' => ['required', 'string'],
            'stock_actual' => ['required', 'string'],
            'precio_unitario' => ['required', 'string'],
            'id_moneda' => ['required', 'string'],
            'id_tipo_producto' => ['required', 'string'],
            'fecha_vencimiento' => ['', 'string'],
            'id_estado_bien' => ['required', 'string'],
            'stock_minimo' => ['required', 'string'],
            'id_marca' => ['required', 'string'],
            'id_seccion' => ['required', 'string'],
            'id_anaquel' => ['', 'string'],
            'estado' => ['required', 'string'],
        ];
    }
}
