@extends('backend.layouts.app')

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('Conductores')
        </x-slot>

        <x-slot name="headerActions">
            <x-utils.link
                icon="c-icon cil-plus"
                class="card-header-action"
                :href="route('frontend.conductores.create')"
                :text="__('Nuevo')"
            />
        </x-slot>

        <x-slot name="body">
            <livewire:backend.conductores-table />
            </x-slot>
        </x-backend.card>
@endsection

@push('after-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<script type="text/javascript">

    $('.btn.btn-danger').click(function(event) {
        var form =  $(this).closest("form");
        event.preventDefault();
        swal({
            title: `Eliminar Conductor`,
            text: "Está seguro de eliminar a este conductor?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
    });

</script>
@endpush
