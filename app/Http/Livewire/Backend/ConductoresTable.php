<?php

namespace App\Http\Livewire\Backend;

use App\Models\Conductores;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

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
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable(),
            Column::make('Licencia')
                ->sortable()
                ->searchable(),
            Column::make('Fecha Emision', 'fecha_licencia')
                ->sortable()
                ->searchable(),
        ];
    }
}
