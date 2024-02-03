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
            Column::make("Empresa")
                ->label(fn ($row) => $row->empresas->pluck('nombre_comercial')->implode(', ')),
            Column::make("Licencia")
                ->sortable()
                ->label(fn ($row) => $row->conductores->pluck('licencia')->implode(', ')),
            Column::make("Conductor")
                ->sortable()
                ->label(fn ($row) => Producto::find(($row->conductores->pluck('id')[0]))->personas['nombre_completo_sin_dni']),
            Column::make("Placa", "placa")
                ->sortable(),
            Column::make("Ejes", "ejes")
                ->sortable(),
            Column::make("Peso tracto", "peso_tracto")
                ->sortable(),
            Column::make("Peso carreta", "peso_carreta")
                ->sortable(),
            Column::make("Peso seco", "peso_seco")
                ->sortable(),
            Column::make("Estado", "estado")
                ->sortable(),
            Column::make('Acciones')
                ->unclickable()
                ->label(
                    function ($row, Column $column) {
                        $edit = '<button class="btn btn-xs btn-success text-white" onclick="window.location.href=\'' . route('frontend.vehiculos.show', $row) . '\'">Mostrar</button>';
                        $delete = '<button class="btn btn-xs btn-danger text-white" wire:click="delete(' . $row->id . ')">Eliminar</button>';
                        return $edit . " " . $delete;
                    }
                )->html(),
        ];
    }
}
