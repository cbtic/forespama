<?php

namespace App\View\Forms;

use App\Models\EntradaProductoDetalle;
use Grafite\Forms\Forms\ModalForm;
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
use TablaMaestra;

class EntradaProductoDetallesForm extends ModelForm
{
    /**
     * The model for the form
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $model = EntradaProductoDetalle::class;

    public $routeParameters = ['id', 'id_entrada_productos'];

    public $entradaproducto;

    public $columns = 3;

    public $hasFiles = true;

    public $instance;

    public $disableOnSubmit = true;

    /**
     * Required prefix of routes
     *
     * Can be `user` for all `user.`
     * name routes.
     *
     * @var string
     */
    public $routePrefix = 'frontend.entrada_producto_detalles';

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
        'submit' => 'Guardar',
        'delete' => 'Borrar'
    ];

    /**
     * Set the desired fields for the form
     *
     * @return array
     */
    public function fields()
    {
        return [
            Text::make('id', [
                'required' => true,
            ]),
            Text::make('id_entrada_productos', [
                'required' => true,
                'value' => array_reverse(explode('/',\Request::getRequestUri()))[0]
            ]),
            Text::make('id_producto', [
                'required' => true,
            ]),
            Text::make('item', [
                'required' => true,
            ]),
            Text::make('cantidad', [
                'required' => true,
            ]),
            Text::make('numero_lote', [
                'required' => true,
            ]),
            Date::make('fecha_vencimiento', [
                'required' => true,
            ]),
            Text::make('aplica_precio', [
                'required' => true,
            ]),
            Text::make('id_um', [
                'required' => true,
            ]),
            Text::make('id_estado_bien', [
                'required' => true,
            ]),
            Text::make('id_marca', [
                'required' => true,
            ]),
            Text::make('cerrado', [
                'required' => true,
            ]),
            Select::make('estado')->selectOptions(['ACTIVO' => '1', 'CANCELADO' => '0']),
        ];
    }
}
