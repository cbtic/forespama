<?php

namespace App\Http\Livewire\Backend;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\TablaMaestra;

class TablaMaestraTable extends DataTableComponent
{
    protected $model = TablaMaestra::class;

    public function query(): Builder
    {
        return TablaMaestra::when($this->getFilter('search'), fn ($query, $term) => $query->search($term));
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Tipo", "tipo")
                ->sortable(),
            Column::make("Denominacion", "denominacion")
                ->sortable(),
            Column::make("Orden", "orden")
                ->sortable(),
            Column::make("Estado", "estado")
                ->sortable(),
            Column::make("Codigo", "codigo")
                ->sortable(),
            Column::make("Tipo nombre", "tipo_nombre")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
    }
}
