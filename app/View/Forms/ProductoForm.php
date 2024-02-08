<?php

namespace App\View\Forms;

use App\Models\Producto;
use App\Models\Almacene;
use App\Models\Anaquele;
use Grafite\Forms\Forms\ModelForm;
use Grafite\Forms\Fields\TextArea;
use Grafite\Forms\Fields\Text;
use Grafite\Forms\Fields\Email;
use Grafite\Forms\Fields\HasOne;
use Grafite\Forms\Fields\HasMany;
use Grafite\Forms\Fields\Date;
use Grafite\Forms\Html\Button;
use Grafite\Forms\Fields\Select;
use Grafite\Forms\Fields\PasswordWithReveal;
use Grafite\Forms\Fields\AutoSuggestSelect;
use Grafite\Forms\Fields\Hidden;

class ProductoForm extends ModelForm
{
    /**
     * The model for the form
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $model = Producto::class;

    public $routeParameters = ['id',
                                'codigo',
                                'denominacion',
                                'estado'];

    public $columns = 2;

    public $hasFiles = true;

    public $instance;

    /**
     * Required prefix of routes
     *
     * Can be `user` for all `user.`
     * name routes.
     *
     * @var string
     */
    public $routePrefix = 'frontend.productos';

    /**
     * Buttons and values
     *
     * You can add a `cancel => Cancel`
     * which will create a cancel button.
     * Then you can set it's route with the
     * `buttonLinks` property.
     *
     * @var array
     */
    public $buttons = [
        'cancel' => 'Cancelar',
        'submit' => 'Guardar'
    ];

    /**
     * Set the desired fields for the form
     *
     * @return array
     */
    public function fields()
    {
        return [
            Text::make('numero_serie', [
                'required' => true,
            ]),
            Text::make('codigo', [
                'required' => true,
            ]),
            Text::make('denominacion', [
                'required' => true,
            ]),
            Text::make('id_unidad_medida', [
                'required' => true,
            ]),
            Text::make('stock_actual', [
                'required' => true,
            ]),
            Text::make('precio_unitario', [
                'required' => true,
            ]),
            Text::make('id_moneda', [
                'required' => true,
            ]),
            Text::make('id_tipo_producto', [
                'required' => true,
            ]),
            Date::make('fecha_vencimiento', [
                'required' => true,
            ]),
            Text::make('id_estado_bien', [
                'required' => true,
            ]),
            Text::make('stock_minimo', [
                'required' => true,
            ]),
            Text::make('id_marca', [
                'required' => true,
            ]),
            Text::make('id_seccion', [
                'required' => true,
            ]),
            Text::make('id_anaquel', [
                'required' => true,
            ]),
            Select::make('estado')->selectOptions(['ACTIVO' => '1', 'CANCELADO' => '0']),
            // HasMany::make('id_anaqueles', [
            //     'label' => 'Escoja los anaqueles que tendrá en la sección',
            //     'model' => Anaquele::class,
            //     'model_options' => [
            //         'label' => 'codigo',
            //         'value' => 'id',
            //         'method' => 'all',
            //         'params' => null,
            //     ]
            // ])->selectOptions(['Sin anaquel' => null]),
        ];
    }
}
