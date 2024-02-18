<?php

namespace App\Http\Livewire\Backend;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Lote;
use Illuminate\Database\Eloquent\Builder;

class LoteTable extends DataTableComponent
{
    protected $model = Lote::class;

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return Lote::when($this->getFilter('search'), fn ($query, $term) => $query->search($term));
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
        ->setTableRowUrl(function($row) {
            return route('frontend.lotes.edit', $row);
        })
        ->setTableRowUrlTarget(function($row) {
            return '_self';
        });
    }

    public function delete($id) {

        if(intval($id) == 0){
            return;
        }
        $types = Lote::findOrFail(intval($id));
        $types->delete();

    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            // Column::make("Empresa")
            //     ->label(fn ($row) => $row->empresas->pluck('nombre_comercial')->implode(', ')),
            // Column::make("Licencia")
            //     ->sortable()
            //     ->label(fn ($row) => $row->conductores->pluck('licencia')->implode(', ')),
            // Column::make("Conductor")
            //     ->sortable()
            //     ->label(fn ($row) => Conductores::find(($row->conductores->pluck('id')[0]))->personas['nombre_completo_sin_dni']),
            Column::make("id_producto", "id_producto")
                ->sortable(),
            Column::make("Numero Lote", "numero_lote")
                ->sortable(),
            Column::make("Numero Serie", "numero_serie")
                ->sortable(),
            Column::make("Unidad", "id_unidad_medida")
                ->sortable(),
            Column::make("Cantidad", "cantidad")
                ->sortable(),
            Column::make("Costo", "costo")
                ->sortable(),
            Column::make("id_moneda", "id_moneda")
                ->sortable(),
            Column::make("fecha_fabricacion", "fecha_fabricacion")
                ->sortable(),
            Column::make("fecha_vencimiento", "fecha_vencimiento")
                ->sortable(),
            Column::make("id_anaquel", "id_anaquel")
                ->sortable(),
            Column::make("Estado", "estado")
                ->sortable(),
            Column::make('Acciones')
                ->unclickable()
                ->label(
                    function ($row, Column $column) {
                        $edit = '<button class="btn btn-xs btn-success text-white" onclick="window.location.href=\'' . route('frontend.lotes.show', $row) . '\'">Mostrar</button>';
                        $delete = '<button class="btn btn-xs btn-danger text-white" wire:click="delete(' . $row->id . ')">Eliminar</button>';
                        return $edit . " " . $delete;
                    }
                )->html(),
        ];
    }
}
