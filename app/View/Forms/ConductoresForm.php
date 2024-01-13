<?php

namespace App\View\Forms;

use App\Models\Conductores;
use App\Models\Persona;
use Grafite\Forms\Forms\ModelForm;
use Grafite\Forms\Fields\TextArea;
use Grafite\Forms\Fields\Text;
use Grafite\Forms\Fields\Email;
use Grafite\Forms\Fields\HasOne;
use Grafite\Forms\Fields\HasMany;
use Grafite\Forms\Fields\Date;
use Grafite\Forms\Fields\Select;
use Grafite\Forms\Fields\PasswordWithReveal;
use Grafite\Forms\Fields\AutoSuggestSelect;
use Grafite\Forms\Fields\Hidden;

class ConductoresForm extends ModelForm
{
    /**
     * The model for the form
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $model = Conductores::class;

    public $routeParameters = ['id', 'licencia', 'fecha_licencia', 'estado'];

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
            AutoSuggestSelect::make('estado')->selectOptions(['ACTIVO' => 'ACTIVO', 'CANCELADO' => 'CANCELADO']),
            // HasOne::make('personas_id', [
            //     'model' => Persona::class,
            //     'model_options' => [
            //         'label' => 'nombre_completo',
            //         'value' => 'id',
            //         'method' => 'all',
            //         'params' => null,
            //     ]
            // ])->selectOptions(['Seleccione' => null])
            Hidden::make('personas_id', [
                'required' => true,
            ]),
            Text::make('persona', [
                'required' => true,
            ]),
        ];
    }
}
