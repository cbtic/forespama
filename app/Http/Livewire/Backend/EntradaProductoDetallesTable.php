<?php

namespace App\Http\Livewire\Backend;

use App\Models\EntradaProducto;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\EntradaProductoDetalle;
use App\View\Forms\EntradaProductosForm;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Database\Eloquent\Builder;
use App\View\Forms\EntradaProductoDetallesForm;
// use App\Exports\ConductoresExport;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;

class EntradaProductoDetallesTable extends DataTableComponent
{
    public $deleteId = '';
    public $id_entrada_productos;

    protected $model = EntradaProductoDetalle::class;

    public function mount($entrada_producto)
    {
        $this->id_entrada_productos = $entrada_producto;
    }

    public function builder(): Builder
    {
        return EntradaProductoDetalle::where('id_entrada_productos','=', $this->id_entrada_productos);
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
        ->setTableRowUrl(function($row) {
            return route('frontend.entrada_producto_detalles.edit', [$row->id_entrada_productos, $row->id]);
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
                ->sortable()
                ->searchable(),
            Column::make('id_entrada_productos')
                ->sortable()
                ->searchable(),
            Column::make('Tipo Doc.', 'id_producto')
                ->sortable()
                ->searchable(),
            Column::make('item')
                ->sortable()
                ->searchable(),
            Column::make('cantidad')
                ->sortable(),
            Column::make('numero_lote')
                ->sortable()
                ->searchable(),
            Column::make('fecha_vencimiento')
                ->sortable(),
            Column::make('aplica_precio')
                ->sortable(),
            Column::make('id_um')
                ->sortable(),
            Column::make('id_estado_bien')
                ->sortable(),
            Column::make('id_marca')
                ->sortable(),
            Column::make('Estado'),
            Column::make('Acciones')
                ->unclickable()
                ->label(
                    function ($row, Column $column) {
                        $edit = '<button class="btn btn-xs btn-success text-white" onclick="window.location.href=\'' . route('frontend.entrada_producto_detalles.show', ['entrada_producto' => $row->id_entrada_productos, 'entrada_producto_detalles' => $row->id]) . '\'">Mostrar</button>';
                        $delete = '';// app(EntradaProductoDetallesForm::class)->delete($row)->modalTitle("Eliminar conductor: ")->confirmAsModal("Eliminar?", "Eliminar", "btn btn-danger");
                        return $edit . " " . $delete;
                    }
                )->html(),
        ];
    }
}
