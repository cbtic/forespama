<?php

namespace App\Http\Livewire\Backend;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Anaquele;
use Illuminate\Database\Eloquent\Builder;

class AnaqueleTable extends DataTableComponent
{
    protected $model = Anaquele::class;

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return Anaquele::when($this->getFilter('search'), fn ($query, $term) => $query->search($term));
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
        ->setTableRowUrl(function($row) {
            return route('frontend.anaqueles.edit', $row);
        })
        ->setTableRowUrlTarget(function($row) {
            return '_self';
        });
    }

    public function delete($id) {

        if(intval($id) == 0){
            return;
        }
        $types = Anaquele::findOrFail(intval($id));
        $types->delete();

    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Almacen")
                ->label(fn ($row) => $row->almacenes->pluck('denominacion')->implode(', ')),
            Column::make("Seccion")
                ->sortable()
                ->label(fn ($row) => $row->secciones->pluck('denominacion')->implode(', ')),
            // Column::make("Conductor")
            //     ->sortable()
            //     ->label(fn ($row) => Anaquele::find(($row->conductores->pluck('id')[0]))->personas['nombre_completo_sin_dni']),
            // Column::make("Placa", "placa")
                // ->sortable(),
            Column::make("codigo", "codigo")
                ->sortable(),
            Column::make("denominacion", "denominacion")
                ->sortable(),
            Column::make("Estado", "estado")
                ->sortable(),
            Column::make('Acciones')
                ->unclickable()
                ->label(
                    function ($row, Column $column) {
                        $edit = '<button class="btn btn-xs btn-success text-white" onclick="window.location.href=\'' . route('frontend.anaqueles.show', $row) . '\'">Mostrar</button>';
                        $delete = '<button class="btn btn-xs btn-danger text-white" wire:click="delete(' . $row->id . ')">Eliminar</button>';
                        return $edit . " " . $delete;
                    }
                )->html(),
        ];
    }
}
