@extends('frontend.layouts.app')

@section('title', __('Terms & Conditions'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <x-frontend.card>
                    <x-slot name="header">
                        @lang('Terms & Conditions')
                    </x-slot>

                    <x-slot name="body">
                        <p>Al registrarse en nuestra plataforma, el usuario declara que la información proporcionada es verdadera, completa y actualizada.</p>

                        <p>El usuario acepta que los datos proporcionados durante el registro sean utilizados para:</p>

                        <p>Crear y administrar su cuenta de usuario.</p>

                        <p>Identificar y validar su identidad cuando corresponda.</p>

                        <p>Gestionar las solicitudes, compras, servicios y demás operaciones realizadas a través de la plataforma.</p>

                        <p>Enviar comunicaciones relacionadas con sus operaciones, cuenta o servicios.</p>

                        <p>Mejorar la atención y los servicios ofrecidos por la empresa.</p>

                        <p>El usuario es responsable de mantener actualizados sus datos y de la confidencialidad de sus credenciales de acceso.</p>

                        <p>Asimismo, el usuario declara que cuenta con autorización para proporcionar los datos registrados y acepta el tratamiento de sus datos personales de acuerdo con la normativa vigente sobre protección de datos personales.</p>
                        
                        <p>La empresa se compromete a utilizar los datos personales únicamente para las finalidades relacionadas con la prestación y gestión de sus servicios, adoptando las medidas necesarias para su protección.</p>
                        
                        <p>El usuario podrá ejercer los derechos que le correspondan respecto al tratamiento de sus datos personales, de acuerdo con la legislación vigente.</p>

                        <p>Al marcar la opción “Acepto los términos y condiciones”, el usuario declara haber leído, comprendido y aceptado las presentes condiciones.</p>
                    </x-slot>
                </x-frontend.card>
            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->
@endsection
