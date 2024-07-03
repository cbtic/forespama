<?php

namespace App\Http\Livewire\Backend;

use App\Models\EntradaProducto;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
// use App\Exports\ConductoresExport;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use App\View\Forms\EntradaProductosForm;

class EntradaProductosTable extends DataTableComponent
{
    public $deleteId = '';

    protected $model = EntradaProducto::class;

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return EntradaProducto::when($this->getFilter('search'), fn ($query, $term) => $query->search($term));
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
        ->setTableRowUrl(function($row) {
            return route('frontend.entrada_productos.edit', $row);
        })
        ->setTableRowUrlTarget(function($row) {
            return '_self';
        });
    }

    // public function deleteId($id)
    // {
    //     $this->deleteId = $id;
    // }

    // public function delete()
    // {
    //     Conductores::find($this->deleteId)->delete();
    // }

    public function bulkActions(): array
    {
        return [
        ];
    }


    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable(),
            Column::make('Ingreso', 'fecha_ingreso')
                ->sortable()
                ->searchable(),
            Column::make('Tipo Doc.', 'id_tipo_documento')
                ->sortable()
                ->searchable(),
            Column::make('Unidad Origen', 'unidad_origen')
                ->sortable()
                ->searchable(),
            Column::make('Proveedor', 'id_proveedor')
                ->sortable(),
            Column::make('Nro. Comprobante', 'numero_comprobante')
                ->sortable()
                ->searchable(),
            Column::make('Fecha Comprobante', 'fecha_comprobante')
                ->sortable(),
            Column::make('Estado'),
            Column::make('Acciones')
                ->unclickable()
                ->label(
                    function ($row, Column $column) {
                        $edit = '<button class="btn btn-xs btn-success text-white" onclick="window.location.href=\'' . route('frontend.entrada_productos.show', $row->id) . '\'">Mostrar</button>';
                        $delete = app(EntradaProductosForm::class)->delete($row)->modalTitle("Eliminar conductor: ")->confirmAsModal("Eliminar?", "Eliminar", "btn btn-danger");
                        return $edit . " " . $delete;
                    }
                )->html(),
        ];
    }
}
