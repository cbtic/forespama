<?php

namespace App\View\Forms;

use App\Models\Conductores;
use Grafite\Forms\Forms\ModelForm;
use Grafite\Forms\Fields\TextArea;
use Grafite\Forms\Fields\Text;
use Grafite\Forms\Fields\Email;
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

    /**
     * Required prefix of routes
     *
     * Can be `user` for all `user.`
     * name routes.
     *
     * @var string
     */
    public $routePrefix = 'conductores';

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
        'submit' => 'Save'
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
        ];
    }
}
