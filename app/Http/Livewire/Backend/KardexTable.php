<?php

namespace App\Http\Livewire\Backend;

use App\Models\Kardex;
use App\Models\Producto;
use App\Models\TablaMaestra;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;

class KardexTable extends DataTableComponent
{
    protected $model = Kardex::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function query(): Builder
    {
        return Kardex::when($this->getFilter('search'), fn ($query, $term) => $query->search($term));
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("id_producto")
                ->hideIf(true)
                ->sortable(),
            Column::make("Producto")
                ->label(fn ($row) => Producto::find($row->id_producto)->denominacion)
                ->sortable(),
            Column::make("Unidades", "id_unidad_medida")
                ->hideIf(true)
                ->sortable(),
            Column::make("Unidad")
                ->label(fn ($row) => TablaMaestra::find($row->id_unidad_medida)->denominacion)
                ->sortable(),
            Column::make("entradas_cantidad")
                ->sortable(),
            Column::make("costo_entradas_cantidad")
                ->sortable(),
            Column::make("total_entradas_cantidad")
                ->sortable(),
            Column::make("salidas_cantidad")
                ->sortable(),
            Column::make("costo_salidas_cantidad")
                ->sortable(),
            Column::make("total_salidas_cantidad")
                ->sortable(),
            Column::make("saldos_cantidad")
                ->sortable(),
            Column::make("costo_saldos_cantidad")
                ->sortable(),
            Column::make("total_saldos_cantidad")
            ->sortable()
        ];
    }
}
