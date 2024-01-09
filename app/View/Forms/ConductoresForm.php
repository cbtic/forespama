<?php

namespace App\View\Forms;

use App\Models\Conductores;
use App\Models\Persona;
use Grafite\Forms\Forms\ModelForm;
use Grafite\Forms\Fields\TextArea;
use Grafite\Forms\Fields\Text;
use Grafite\Forms\Fields\Email;
use Grafite\Forms\Fields\HasOne;
use Grafite\Forms\Fields\Date;
use Grafite\Forms\Fields\Select;

class ConductoresForm extends ModelForm
{
    /**
     * The model for the form
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $model = Conductores::class;

    public $routeParameters = ['id', 'licencia', 'fecha_licencia', 'estado'];
    //public $routeParameters = ['id'];

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
    public $routePrefix = 'frontend.conductores';

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
            Text::make('licencia', [
                'required' => true,
            ]),
            Date::make('fecha_licencia', [
                'required' => true,
            ]),
            Select::make('estado', [
                'required' => true
            ])->selectOptions(['ACTIVO' => 'ACTIVO', 'CANCELADO' => 'CANCELADO']) ,
            Date::make('created_at'),
            HasOne::make('persona', [
                'model' => Persona::class,
                'model_options' => [
                    'label' => 'nombre_completo',
                    'value' => 'id',
                    'method' => 'all',
                    'params' => null,
                ]
            ])
        ];
    }
}
