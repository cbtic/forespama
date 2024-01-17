<?php

namespace App\View\Forms;

use App\Models\Vehiculo;
use Grafite\Forms\Forms\ModelForm;
use Grafite\Forms\Fields\Text;
use Grafite\Forms\Fields\Select;

class VehiculoForm extends ModelForm
{
    /**
     * The model for the form
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $model = Vehiculo::class;

    public $routeParameters = [
                                'id',
                                'placa',
                                'ejes',
                                'peso_tracto',
                                'peso_carreta',
                                'peso_seco',
                                'estado',
                            ];
    public $columns = 1;

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
    public $routePrefix = 'frontend.vehiculos';

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
            Text::make('placa', [
                'required' => true,
            ]),
            Text::make('ejes', [
                'required' => true,
            ]),
            Text::make('peso_tracto', [
                'required' => false,
            ]),
            Text::make('peso_carreta', [
                'required' => false,
            ]),
            Text::make('peso_seco', [
                'required' => false,
            ]),
            Select::make('estado')->selectOptions(['ACTIVO' => '1', 'CANCELADO' => '2']),
        ];
    }
}
