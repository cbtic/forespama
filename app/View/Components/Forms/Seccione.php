<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

use App\View\Forms\SeccioneForm;

class Seccione extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $secciones;
    public $almacen;

    public function __construct($secciones = null, $almacen = null)
    {
        $this->almacen = $almacen;
        $this->secciones = $secciones;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {

        // return view('components.forms.productos');
        if ($this->secciones) {
            return app(SeccioneForm::class)->edit($this->secciones)->asModal($triggerContent = 'Editar secciond del almacem: #'.$this->almacen, $triggerClass = 'btn btn-default', $message = null, $modalTitle = 'Editar Seccion');
        } else {
            // return app(EntradaProductoDetallesForm::class)->viaAjax()->create();
            return app(SeccioneForm::class)->viaAjax()->create()->asModal($triggerContent = '+ Nueva seccion', $triggerClass = 'btn btn-default', $message = null, $modalTitle = 'Nueva Sección (Almacen #'.$this->almacen.')');
        }
    }
}
