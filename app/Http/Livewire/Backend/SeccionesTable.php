<?php

namespace App\Http\Livewire\Backend;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Seccione;
use App\Models\Anaquele;
use App\Models\Almacene;
use Illuminate\Database\Eloquent\Builder;
use App\View\Forms\SeccioneForm;

class SeccionesTable extends DataTableComponent
{
    protected $model = Seccione::class;
    public $id_almacenes;

    public function mount($id_almacenes)
    {
        $this->id_almacenes = $id_almacenes;
    }

    /**
     * @return Builder
     */
    public function builder(): Builder
    {
        $id_almacenes = $this->id_almacenes;
        return Seccione::whereHas('almacenes', function ($query) use ($id_almacenes) { $query->where('id_almacenes', $id_almacenes); });
    }

    public function configure(): void
    {
        $this->setPerPageAccepted([50, 100, 150]);

        $this->setPerPage(50);

        $this->setDefaultSort('id', 'desc');

        $this->setPrimaryKey('id')
        ->setTableRowUrl(function($row) {
            return "javascript:'); rowclick(this); ('";
        });
    }

    public function delete($id) {

        if(intval($id) == 0){
            return;
        }
        $types = Seccione::findOrFail(intval($id));
        $types->delete();

    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Almacen")
                ->label(fn ($row) => $row->almacenes->pluck('codigo')->implode(', ')),
            Column::make("Codigo", "codigo")
                ->sortable(),
            Column::make("Denominacion", "denominacion")
                ->sortable(),
            Column::make("Anaqueles")
                ->label(fn ($row) => $row->anaqueles->pluck('codigo')->implode(', ')),
            Column::make("Estado")
                ->label(fn($row) => array("CANCELADO","ACTIVO")[Seccione::find($row->id)["estado"]])
                ->sortable(),
            Column::make('Acciones')
                ->unclickable()
                ->label(
                    function ($row, Column $column) {
                        $delete = app(SeccioneForm::class)->delete($row)->modalTitle("Eliminar sección ".$row->codigo.": ".$row->denominacion."?")->confirmAsModal("Eliminar?", "Eliminar", "btn btn-danger");

                        $edit = app(SeccioneForm::class)->edit($row)->asModal($triggerContent = 'Editar', $triggerClass = 'btn btn-success btn-seccion', $message = null, $modalTitle = 'Editar la Sección');
                        return $edit . " " . $delete;
                    }
                )->html(),
        ];
    }
}
