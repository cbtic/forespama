<?php

namespace App\Http\Livewire\Backend;

use App\Models\Producto;
use App\Models\TablaMaestra;
use App\Models\EntradaProducto;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\EntradaProductoDetalle;
use App\View\Forms\EntradaProductosForm;
use RealRashid\SweetAlert\Facades\Alert;
// use App\Exports\ConductoresExport;
use Illuminate\Database\Eloquent\Builder;
use App\View\Forms\EntradaProductoDetallesForm;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;

class EntradaProductoDetallesTable extends DataTableComponent
{
    public $deleteId = '';
    public $id_entrada_productos;
    protected $index = 0;

    protected $model = EntradaProductoDetalle::class;

    public function mount($entrada_producto)
    {
        $this->id_entrada_productos = $entrada_producto;
    }

    public function builder(): Builder
    {
        return EntradaProductoDetalle::where('id_entrada_productos','=', $this->id_entrada_productos);
        // return EntradaProductoDetalle::withRowNumber()->where('id_entrada_productos','=', $this->id_entrada_productos);
    }

    public function configure(): void
    {
        $this->index++;

        $this->setPerPageAccepted([25, 50, 100]);

        $this->setPerPage(25);

        $this->setPrimaryKey('id')
        ->setTableRowUrl(function($row) {
            return "javascript:'); rowclick(this); ('";
        });

        // ->setTableRowUrlTarget(function($row) {
        //     return '_self';
        // });
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
            // Column::make('row_number')
            //     ->hideIf(true)
            //     ->sortable(),
            // Column::make('no')
            //     ->label(function ( $row ) {
            //         return $this->index++;
            //     })
            //     ->sortable(),
            Column::make('ID', 'id')
                ->sortable()
                ->searchable(),
            Column::make('id_entrada_productos')
                ->hideIf(true)
                ->sortable()
                ->searchable(),
            Column::make("id_producto")
                ->hideIf(true)
                ->sortable(),
            Column::make('Producto')
                ->label(fn ($row) => Producto::find($row->id_producto)->denominacion)
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
                ->hideIf(true)
                ->sortable(),
            Column::make('id_um')
                ->hideIf(true)
                ->sortable(),
            Column::make("Unidad de medida")
                ->label(fn ($row) => TablaMaestra::find($row->id_um)->denominacion)
                ->sortable(),
            Column::make('id_estado_bien')
                ->hideIf(true)
                ->sortable(),
            Column::make("Estado del bien")
                ->label(fn ($row) => TablaMaestra::find($row->id_estado_bien)->denominacion)
                ->sortable(),
            Column::make('id_marca')
                ->hideIf(true)
                ->sortable(),
            Column::make("Marca")
                ->label(fn ($row) => TablaMaestra::find($row->id_marca)->abreviatura)
                ->sortable(),
            Column::make('costo')
                ->hideIf(true)
                ->sortable(),
            Column::make('Estado'),
            Column::make('Acciones')
                ->unclickable()
                ->label(
                    function ($row, Column $column) {
                        // $edit = '<button class="btn btn-xs btn-success text-white" onclick="window.location.href=\'' . route('frontend.entrada_producto_detalles.show', ['entrada_producto' => $row->id_entrada_productos, 'entrada_producto_detalles' => $row->id]) . '\'">Mostrarme</button>';
                        $delete = app(EntradaProductoDetallesForm::class)->delete($row)->modalTitle("Eliminar producto: ")->confirmAsModal("Eliminar?", "Eliminar", "btn btn-danger");

                        $edit = app(EntradaProductoDetallesForm::class)->edit($row)->asModal($triggerContent = 'Editar', $triggerClass = 'btn btn-success btn-entrada', $message = null, $modalTitle = 'Editar el producto');
                        return $edit . " " . $delete;
                    }
                )->html(),
        ];
    }
}
