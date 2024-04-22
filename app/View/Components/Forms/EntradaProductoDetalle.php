<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

use App\View\Forms\EntradaProductoDetallesForm;

class EntradaProductoDetalle extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $entradaproductodetalles;
    public $entradaproducto;

    public function __construct($entradaproductodetalles = null, $entradaproducto = null)
    {
        $this->entradaproductodetalles = $entradaproductodetalles;
        $this->entradaproducto = $entradaproducto;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        // return view('components.forms.productos');
        if ($this->entradaproductodetalles) {
            return app(EntradaProductoDetallesForm::class)->edit($this->entradaproductodetalles)->asModal($triggerContent = 'Nuevo #'.$this->entradaproducto, $triggerClass = 'btn btn-default', $message = 'Ingresar nuevo producto', $modalTitle = 'Nuevo Producto');
        } else {
            $this->entradaproductodetalles["id_entrada_productos"] = "1";
            return app(EntradaProductoDetallesForm::class)->create()->asModal($triggerContent = 'Nuevo #'.$this->entradaproducto, $triggerClass = 'btn btn-default', $message = 'Ingresar nuevo producto', $modalTitle = 'Nuevo Producto');
        }
    }
}
