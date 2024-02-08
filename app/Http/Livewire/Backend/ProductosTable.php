<?php

namespace App\Http\Livewire\Backend;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Builder;

class ProductosTable extends DataTableComponent
{
    protected $model = Producto::class;

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return Producto::when($this->getFilter('search'), fn ($query, $term) => $query->search($term));
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
        ->setTableRowUrl(function($row) {
            return route('frontend.productos.edit', $row);
        })
        ->setTableRowUrlTarget(function($row) {
            return '_self';
        });
    }

    public function delete($id) {

        if(intval($id) == 0){
            return;
        }
        $types = Producto::findOrFail(intval($id));
        $types->delete();

    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            // Column::make("numero_serie")
            //     ->label(fn ($row) => $row->empresas->pluck('nombre_comercial')->implode(', ')),
            // Column::make("codigo")
            //     ->sortable()
            //     ->label(fn ($row) => $row->conductores->pluck('licencia')->implode(', ')),
            // Column::make("Conductor")
            //     ->sortable()
            //     ->label(fn ($row) => Producto::find(($row->conductores->pluck('id')[0]))->personas['nombre_completo_sin_dni']),
            Column::make("Serie", "numero_serie")
                ->sortable(),
            Column::make("Codigo", "codigo")
                ->sortable(),
            Column::make("Denominacion", "denominacion")
                ->sortable(),
            Column::make("Unidad", "id_unidad_medida")
                ->sortable(),
            Column::make("Stock", "stock_actual")
                ->sortable(),
            Column::make("Precio", "precio_unitario")
                ->sortable(),
            Column::make("Moneda", "id_moneda")
                ->sortable(),
            Column::make("Tipo Producto", "id_tipo_producto")
                ->sortable(),
            Column::make("Vencimiento", "fecha_vencimiento")
                ->sortable(),
            Column::make("Estado del bien", "id_estado_bien")
                ->sortable(),
            Column::make("Stock mínimo", "stock_minimo")
                ->sortable(),
            Column::make("Marca", "id_marca")
                ->sortable(),
            Column::make("Seccion", "id_seccion")
                ->sortable(),
            Column::make("Anaquel", "id_anaquel")
                ->sortable(),
            Column::make("Stock Actual", "stock_actual")
                ->sortable(),
            Column::make("Estado", "estado")
                ->sortable(),
            Column::make('Acciones')
                ->unclickable()
                ->label(
                    function ($row, Column $column) {
                        $edit = '<button class="btn btn-xs btn-success text-white" onclick="window.location.href=\'' . route('frontend.productos.show', $row) . '\'">Mostrar</button>';
                        $delete = '<button class="btn btn-xs btn-danger text-white" wire:click="delete(' . $row->id . ')">Eliminar</button>';
                        return $edit . " " . $delete;
                    }
                )->html(),
        ];
    }
}
