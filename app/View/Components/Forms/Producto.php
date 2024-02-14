<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

use App\View\Forms\ProductoForm;

class Producto extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $productos;

    public function __construct($productos = null)
    {
        $this->productos = $productos;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        // return view('components.forms.productos');
        if ($this->productos) {
            return app(ProductoForm::class)->edit($this->productos)->render();
        } else {
            return app(ProductoForm::class)->create()->render();
        }
    }
}
