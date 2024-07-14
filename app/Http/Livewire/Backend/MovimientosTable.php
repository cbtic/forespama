<?php

namespace App\Http\Livewire\Backend;

use App\Models\Movimiento;
use App\Models\Producto;
use App\Models\TablaMaestra;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;

class MovimientosTable extends DataTableComponent
{
    protected $model = Movimiento::class;

    public function configure(): void
    {
        $this->setPerPageAccepted([25, 50, 100]);

        $this->setPerPage(25);

        $this->setPrimaryKey('id');
          // Takes a callback that gives you the current row and its index

        $this->setTrAttributes(function($row, $index) {
            if ($row["tipo_movimiento"] == 'ENTRADA') {
                return [
                'class' => 'entrada',
                ];
            }

            return [
                'class' => 'salida',
                ];
        });
        }

    public function query(): Builder
    {
        return Movimiento::when($this->getFilter('search'), fn ($query, $term) => $query->search($term));
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
            Column::make("numero_lote")
                ->sortable(),
            Column::make("tipo_movimiento")
                ->sortable(),
            Column::make("entrada_salida_cantidad")
                ->sortable(),
            Column::make("costo_entrada_salida")
                ->sortable(),
            Column::make("id_users")
                ->sortable(),
            Column::make("id_personas")
                ->sortable(),
            Column::make("fecha_movimiento")
                ->sortable()
        ];
    }
}
