@extends('backend.layouts.app')

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('Almacenes')
        </x-slot>

        <x-slot name="headerActions">
            <x-utils.link
                icon="c-icon cil-plus"
                class="card-header-action"
                :href="route('frontend.almacenes.create')"
                :text="__('Nuevo')"
            />
        </x-slot>

        <x-slot name="body">
            <livewire:backend.almacenes-table />
        </x-slot>
    </x-backend.card>
@endsection

@push('after-scripts')
<script type="text/javascript">

    $('.btn.btn-danger').click(function(event) {
        var form =  $(this).closest("form");
        event.preventDefault();

        Swal.fire({
                title: 'Eliminar Almacen',
                text: "Está seguro de eliminar a este almacen?",
                showCancelButton: true,
                confirmButtonText: 'Continue',
                cancelButtonText: 'Cancel',
                icon: 'warning'
            }).then((result) => {
                if (result.value) {
                    form.submit();
                } else {
                    Swal.fire("Cancelado", "El almacen no ha sido eliminado.", "error");
                }
            });
        });

</script>
@endpush
