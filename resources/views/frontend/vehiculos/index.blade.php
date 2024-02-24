@extends('backend.layouts.app')

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('Vehiculos')
        </x-slot>

        <x-slot name="headerActions">
            <x-utils.link
                icon="c-icon cil-plus"
                class="card-header-action"
                :href="route('frontend.vehiculos.create')"
                :text="__('Nuevo')"
            />
        </x-slot>

        <x-slot name="body">
            <livewire:backend.vehiculo-table />
        </x-slot>
    </x-backend.card>
@endsection

@push('after-scripts')
<script type="text/javascript">

    $('.btn.btn-danger').click(function(event) {
        var form =  $(this).closest("form");
        event.preventDefault();

        Swal.fire({
                title: 'Eliminar Vehículo',
                text: "Está seguro de eliminar a este vehículo?",
                showCancelButton: true,
                confirmButtonText: 'Continue',
                cancelButtonText: 'Cancel',
                icon: 'warning'
            }).then((result) => {
                if (result.value) {
                    form.submit();
                } else {
                    Swal.fire("Cancelado", "El vehículo no ha sido eliminado.", "error");
                }
            });
        });

</script>
@endpush
