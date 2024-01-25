<?php

namespace App\Http\Livewire\Backend;

use App\Models\Conductores;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class ConductoresTable extends DataTableComponent
{
    protected $model = Conductores::class;

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return Conductores::when($this->getFilter('search'), fn ($query, $term) => $query->search($term));
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
        ->setTableRowUrl(function($row) {
            return route('frontend.conductores.edit', $row);
        })
        ->setTableRowUrlTarget(function($row) {
            return '_self';
        });
    }

    public function delete($id) {

        if(intval($id) == 0){
            return;
        }
        $types = Conductores::findOrFail(intval($id));
        $types->delete();

    }


    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable(),
            Column::make('Nombre', 'personas.nombres')
                ->sortable()
                ->searchable(),
            Column::make('Ap. Pat.', 'personas.apellido_paterno')
                ->sortable()
                ->searchable(),
            Column::make('Ap. Mat.', 'personas.apellido_materno')
                ->sortable()
                ->searchable(),
            Column::make('Documento', 'personas.numero_documento')
                ->sortable(),
            Column::make('Licencia')
                ->sortable()
                ->searchable(),
            Column::make('Fecha Emision', 'fecha_licencia')
                ->sortable(),
            Column::make('Acciones')
                ->unclickable()
                ->label(
                    function ($row, Column $column) {
                        $edit = '<button class="btn btn-xs btn-success text-white" onclick="window.location.href=\'' . route('frontend.conductores.show', $row->id) . '\'">Mostrar</button>';
                        $delete = '<button class="btn btn-xs btn-danger text-white" wire:click="delete(' . $row->id . ')">Eliminar</button>';
                        return $edit . " " . $delete;
                    }
                )->html(),
        ];
    }
}
