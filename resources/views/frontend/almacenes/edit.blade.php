@extends('backend.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Editar Almacen #{{ $almacenes->id }}</div>

                <div class="card-body">
                    <x-forms.almacene :almacenes="$almacenes"></x-forms.almacene>
                </div>
            </div>
        </div>

        <x-backend.card>
            <x-slot name="header">
                @lang("Detalle de Secciones")
            </x-slot>
            <x-slot name="headerActions" :id_almacenes="$almacenes->id">
                <x-forms.Seccione :id_almacenes="$almacenes->id" />
            </x-slot>
            <x-slot name="body">
                <livewire:backend.secciones-table :id_almacenes="$almacenes->id">
            </x-slot>
        </x-backend.card>
    </div>
</div>
@endsection

@push('after-scripts')
<!-- Modal Anaquel -->
<div class="modal fade" id="ModalAnaquel" role="dialog">
     <div class="modal-dialog">
     <!-- Modal contenido-->
     <div class="modal-content" style="padding: 0 !important">
        <div class="modal-body-anaquel">
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ asset('js/almacenes.js') }}"></script>
<script>

/* Llamando al formulario Modal para nuevo producto */
$('.btnNuevoAnaquel').on('click',function(){
    $('.modal-body-anaquel').load('/anaqueles/modal_create',function(){
        $('#ModalAnaquel').modal({show:true});
    });
});

function rowclick(td){
        let rowId = td.parentElement.rowIndex;
        document.getElementsByClassName("btn btn-success btn-seccion")[rowId-1].click();
        setTimeout(function(){
            redimensionaSelect2();
        }, 500);
    }

function redimensionaSelect2(){
        $('.form-select').select2({dropdownAutoWidth : true});
    }

$('.btn.btn-default').on('click', function() {
            setTimeout(function(){
                // alert(500);
                $('.form-select').select2();
            }, 500)
        });


function manejar_popup(parent_modal) {
    $("#ModalAnaquel > div > div > div > div > div > div > div > div.modal-header > button").on("click", function (event) {
        $('#ModalAnaquel').modal('hide');
        $('#'+parent_modal).modal('show');
    });

    $('.form-select').select2();

    $('#ModalAnaquel').on('hidden.bs.modal', function (e) {
        $('#'+parent_modal).modal('show');
    });

    $("form").eq($("form").length-1).on( "submit", function( event ) {
        $('.form-select').select2();
        let _form = $("form").eq($("form").length-1);

        $.ajax({
            url: "{{ route('frontend.anaqueles.store') }}",
            method: 'POST',
            dataType: 'json',
            data : _form.serialize(),
            success: function(data) {
                    // log response into console
                    console.log(data);
                    let insertar_item = data.codigo;
                    let insertar_value = data.id;
                    var AnaquelProducto = new Option(insertar_item, insertar_value, true, true);
                    // Append it to the select
                    $("#Id_anaqueles").append(AnaquelProducto).trigger('change');
                    // alert( "Enviar datos a: " + $("form").eq($("form").length-2).prop('action'));
                    $('#ModalAnaquel').modal('hide');
                    $('#'+parent_modal).modal('show');
                },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.log("some error");
            }
            });
        event.preventDefault();
    });
}

</script>
@endpush
