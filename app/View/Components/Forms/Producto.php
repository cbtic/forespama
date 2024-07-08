<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

use App\View\Forms\ProductoForm;
use App\View\Forms\ProductoModalForm;

class Producto extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $productos;
    public $modal;

    public function __construct($productos = null, $modal = null)
    {
        $this->productos = $productos;
        $this->modal = $modal;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        // return view('components.forms.productos');
        if ($this->modal) {
            return app(ProductoModalForm::class)->create()->render();
        }
        if ($this->productos) {
            return app(ProductoForm::class)->edit($this->productos)->render();
        } else {
            // return app(ProductoForm::class)->create()->render();
            return app(ProductoForm::class)->create()->asModal($triggerContent = 'Nuevo Producto', $triggerClass = 'btn btn-success', $message = null, $modalTitle = 'Nuevo Tipo de Producto');
        }
    }
}
