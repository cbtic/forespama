<?php

namespace App\Http\Livewire\Backend;

use App\Models\Almacene;
use Grafite\Forms\Fields\Bootstrap\HasOne;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class AlmacenesTable extends DataTableComponent
{
    protected $model = Almacene::class;

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return Almacene::when($this->getFilter('search'), fn ($query, $term) => $query->search($term));
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
        ->setTableRowUrl(function($row) {
            return route('frontend.almacenes.edit', $row);
        })
        ->setTableRowUrlTarget(function($row) {
            return '_self';
        });
    }

    public function delete($id) {

        if(intval($id) == 0){
            return;
        }
        $types = Almacene::findOrFail(intval($id));
        $types->delete();

    }


    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable(),
            Column::make('codigo')
                ->sortable()
                ->searchable(),
            Column::make('denominacion')
                ->sortable(),
            Column::make('Ubigeo', 'ubigeos.desc_ubigeo')
                ->sortable()
                ->searchable(),
            Column::make('Acciones')
                ->unclickable()
                ->label(
                    function ($row, Column $column) {
                        $edit = '<button class="btn btn-xs btn-success text-white" onclick="window.location.href=\'' . route('frontend.almacenes.show', $row->id) . '\'">Mostrar</button>';
                        $delete = '<button class="btn btn-xs btn-danger text-white" wire:click="delete(' . $row->id . ')">Eliminar</button>';
                        return $edit . " " . $delete;
                    }
                )->html(),
        ];
    }
}
