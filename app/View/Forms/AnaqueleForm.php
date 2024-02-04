<?php

namespace App\View\Forms;

use App\Models\Anaquele;
use App\Models\Almacene;
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

class AnaqueleForm extends ModelForm
{
    /**
     * The model for the form
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $model = Anaquele::class;

    public $routeParameters = [
                                'codigo',
                                'denominacion',
                                'id_seccion',
                                'id_almacen',
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
    public $routePrefix = 'frontend.anaqueles';

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
            HasOne::make('id_almacen', [
                'label' => 'Almacenen',
                'model' => Almacene::class,
                'model_options' => [
                    'label' => 'nombre_completo',
                    'value' => 'id',
                    'method' => 'all',
                    'params' => null,
                ]
            ])->selectOptions(['Seleccione' => null]),
            Text::make('codigo', [
                'required' => true,
            ]),
            Date::make('denominacion', [
                'label' => 'denominacion',
                'required' => true,
            ]),
            Select::make('estado')->selectOptions(['1' => 'ACTIVO', '0' => 'CANCELADO']),
            // AutoSuggestSelect::make('estado')->selectOptions(['ACTIVO' => 'ACTIVO', 'CANCELADO' => 'CANCELADO']),
            // Hidden::make('personas_id', [
            //     'required' => true,
            // ]),
            // Text::make('persona', [
            //     'required' => true,
            // ]),
        ];
    }
}
