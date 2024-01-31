<?php

namespace App\Http\Livewire\Backend;

use App\Models\TablaMaestra;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class TablaMaestraTable extends DataTableComponent
{
    protected $model = TablaMaestra::class;

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return TablaMaestra::when($this->getFilter('search'), fn ($query, $term) => $query->search($term));
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
        ->setTableRowUrl(function($row) {
            return route('frontend.tablamaestras.edit', $row);
        })
        ->setTableRowUrlTarget(function($row) {
            return '_self';
        });
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Tipo", "tipo")
                ->sortable(),
            Column::make("Denominacion", "denominacion")
                ->searchable()
                ->sortable(),
            Column::make("Orden", "orden")
                ->sortable(),
            Column::make("Estado", "estado")
                ->sortable(),
            Column::make("Codigo", "codigo")
                ->sortable(),
            Column::make("Tipo nombre", "tipo_nombre")
                ->searchable()
                ->sortable(),
            Column::make("Estado"),
        ];
    }
}
