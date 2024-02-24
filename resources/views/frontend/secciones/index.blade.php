@extends('backend.layouts.app')

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('Secciones')
        </x-slot>

        <x-slot name="headerActions">
            <x-utils.link
                icon="c-icon cil-plus"
                class="card-header-action"
                :href="route('frontend.secciones.create')"
                :text="__('Nuevo')"
            />
        </x-slot>

        <x-slot name="body">
            <livewire:backend.secciones-table />
        </x-slot>
    </x-backend.card>
@endsection

@push('after-scripts')
<script type="text/javascript">

    $('.btn.btn-danger').click(function(event) {
        var form =  $(this).closest("form");
        event.preventDefault();

        Swal.fire({
                title: 'Eliminar Sección',
                text: "Está seguro de eliminar a este sección?",
                showCancelButton: true,
                confirmButtonText: 'Continue',
                cancelButtonText: 'Cancel',
                icon: 'warning'
            }).then((result) => {
                if (result.value) {
                    form.submit();
                } else {
                    Swal.fire("Cancelado", "El sección no ha sido eliminado.", "error");
                }
            });
        });

</script>
@endpush
