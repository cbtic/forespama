@extends('frontend.layouts.app')

@section('title', __('Register'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <x-frontend.card>
                    <x-slot name="header">
                        @lang('Register')
                    </x-slot>

                    <x-slot name="body">
                        <x-forms.post :action="route('frontend.auth.register')">
                            <!--<div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">@lang('Name')</label>

                                <div class="col-md-6">
                                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="{{ __('Name') }}" maxlength="100" required autofocus autocomplete="name" />
                                </div>
                            </div>--><!--form-group-->

                            <div class="form-group row">
                                <label for="tipo_documento" class="col-md-4 col-form-label text-md-right">@lang('Tipo Documento')</label>

                                <div class="col-md-6">
                                    <select name="tipo_documento" id="tipo_documento" class="form-control form-control-sm">
                                        <option value="1" selected="selected">DNI</option>
                                        <option value="2">CARNÉ DE EXTRANJERÍA</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="numero_documento" class="col-md-4 col-form-label text-md-right">@lang('N&uacute;mero Documento')</label>

                                <div class="col-md-6">
                                    <input type="text" name="numero_documento" id="numero_documento" class="form-control" value="{{ old('numero_documento') }}" placeholder="{{ __('Numero Documento') }}" maxlength="100" required autofocus autocomplete="numero_documento" onchange="obtenerPersona()" />
                                </div>
                            </div><!--form-group-->

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">@lang('Name')</label>

                                <div class="col-md-6">
                                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="{{ __('Name') }}" maxlength="100" required autofocus autocomplete="name" readonly /> 
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="apellido_paterno" class="col-md-4 col-form-label text-md-right">@lang('Apellido Paterno')</label>

                                <div class="col-md-6">
                                    <input type="text" name="apellido_paterno" id="apellido_paterno" class="form-control" value="{{ old('apellido_paterno') }}" placeholder="{{ __('Apellido Paterno') }}" maxlength="100" required autofocus autocomplete="apellido_paterno" readonly />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="apellido_materno" class="col-md-4 col-form-label text-md-right">@lang('Apellido Materno')</label>

                                <div class="col-md-6">
                                    <input type="text" name="apellido_materno" id="apellido_materno" class="form-control" value="{{ old('apellido_materno') }}" placeholder="{{ __('Apellido Materno') }}" maxlength="100" required autofocus autocomplete="apellido_materno" readonly />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="numero_celular" class="col-md-4 col-form-label text-md-right">@lang('N&uacute;mero Celular')</label>

                                <div class="col-md-6">
                                    <input type="text" name="numero_celular" id="numero_celular" class="form-control" placeholder="{{ __('Numero Celular') }}" value="{{ old('numero_celular') }}" maxlength="255" required autocomplete="numero_celular" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">@lang('E-mail Address')</label>

                                <div class="col-md-6">
                                    <input type="text" name="email" id="email" class="form-control" placeholder="{{ __('E-mail Address') }}" value="{{ old('email') }}" maxlength="255" required autocomplete="email" />
                                </div>
                            </div><!--form-group-->

                            <div class="form-group row">
                                <label for="departamento" class="col-md-4 col-form-label text-md-right">@lang('Departamento')</label>
                                
                                <div class="col-md-6">
                                    <select name="departamento" id="departamento" class="form-control" onChange="obtenerProvincia()">
                                        <option value="">--Selecionar--</option>
                                        <?php
                                        foreach ($departamento as $row) {?>
                                        <option value="<?php echo $row->id_departamento?>" ><?php echo $row->desc_ubigeo ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="provincia" class="col-md-4 col-form-label text-md-right">@lang('Provincia')</label>

                                <div class="col-md-6">
                                    <select name="provincia" id="provincia" class="form-control" onChange="obtenerDistrito()">
                                        <option value="">--Selecionar--</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="distrito" class="col-md-4 col-form-label text-md-right">Distrito</label>

                                <div class="col-md-6">
                                    <select name="distrito" id="distrito" class="form-control">
                                        <option value="">--Selecionar--</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="direccion" class="col-md-4 col-form-label text-md-right">@lang('Direcci&oacute;n')</label>

                                <div class="col-md-6">
                                    <input type="text" name="direccion" id="direccion" class="form-control" placeholder="{{ __('Direccion') }}" value="{{ old('direccion') }}" maxlength="255" autocomplete="direccion" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="fecha_nacimiento" class="col-md-4 col-form-label text-md-right">@lang('Fecha Nacimiento')</label>

                                <div class="col-md-6">
                                    <input type="text" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" placeholder="{{ __('dd-mm-yyyy') }}" value="{{ old('fecha_nacimiento') }}" autocomplete="off" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">@lang('Password')</label>

                                <div class="col-md-6">
                                    <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Password') }}" maxlength="100" autocomplete="new-password" />
                                </div>
                            </div><!--form-group-->

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">@lang('Password Confirmation')</label>

                                <div class="col-md-6">
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="{{ __('Password Confirmation') }}" maxlength="100" autocomplete="new-password" />
                                </div>
                            </div><!--form-group-->

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" name="terms" id="terms" value="1" class="form-check-input" required>
                                        <label class="form-check-label" for="terms">
                                            Acepto los <a href="#" data-toggle="modal" data-target="#modalTerminos"> Términos y Condiciones de Aliados PAMA </a>
                                        </label>
                                    </div>
                                </div>
                            </div><!--form-group-->

                            @if(config('boilerplate.access.captcha.registration'))
                                <div class="row">
                                    <div class="col">
                                        @captcha
                                        <input type="hidden" name="captcha_status" value="true" />
                                    </div><!--col-->
                                </div><!--row-->
                            @endif

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button class="btn btn-primary" type="submit">@lang('Register')</button>
                                </div>
                            </div><!--form-group-->
                        </x-forms.post>
                        <div class="modal fade" id="modalTerminos" tabindex="-1" role="dialog" aria-labelledby="modalTerminosLabel" aria-hidden="true">

                            <div class="modal-dialog modal-lg" role="document">

                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalTerminosLabel">
                                            Términos y Condiciones – Aliados PAMA
                                        </h5>

                                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body" style="max-height: 65vh; overflow-y: auto;">

                                        <h6><strong>1. Programa Aliados PAMA</strong></h6>

                                        <p> Bienvenido al programa <strong>Aliados PAMA</strong> de <strong>Forestal PAMA S.A.C.</strong> </p>

                                        <p> El programa Aliados PAMA permite a personas registradas como aliados generar ventas a compradores potenciales a Forestal PAMA S.A.C., pudiendo generar comisiones de acuerdo con las condiciones comerciales establecidas por la empresa. </p>

                                        <p> La participación como aliado no implica una relación laboral, societaria ni de representación legal con Forestal PAMA S.A.C. </p>

                                        <h6><strong>2. Registro del aliado</strong></h6>

                                        <p> El aliado deberá proporcionar información verdadera, completa y actualizada durante su registro. </p>

                                        <p> El aliado es responsable de mantener la confidencialidad de sus credenciales de acceso y de todas las actividades realizadas desde su cuenta. </p>

                                        <p> Forestal PAMA S.A.C. podrá verificar la información proporcionada y, cuando corresponda, suspender o cancelar una cuenta que contenga información falsa, inconsistente o que incumpla estos términos. </p>

                                        <h6><strong>3. Registro y seguimiento de ventas</strong></h6>

                                        <p> Las ventas mostradas en la plataforma corresponden a las ventas que hayan sido correctamente identificadas y asociadas al aliado por Forestal PAMA S.A.C. </p>

                                        <p> El aliado podrá consultar desde la plataforma información relacionada con: </p>

                                        <ul>
                                            <li>Ventas generadas con su codigo de Aliado Pama.</li>
                                            <li>Estado de las ventas.</li>
                                            <li>Monto de las ventas.</li>
                                            <li>Comisión generada.</li>
                                            <li>Comisiones disponibles para retiro.</li>
                                            <li>Historial de retiros realizados.</li>
                                        </ul>

                                        <p> La información mostrada en la plataforma podrá estar sujeta a validación y actualización por parte de Forestal PAMA S.A.C. </p>

                                        <h6><strong>4. Comisiones</strong></h6>

                                        <p> El aliado tendrá derecho a recibir una comisión de acuerdo con el porcentaje, monto o esquema de comisión establecido por Forestal PAMA S.A.C. para cada venta o campaña. </p>

                                        <p> La comisión será considerada generada cuando la venta cumpla con las condiciones establecidas por la empresa. </p>

                                        <p> Una venta anulada, cancelada, devuelta, no concretada o que no cumpla las condiciones comerciales establecidas podrá no generar comisión o dar lugar al ajuste de una comisión previamente registrada. </p>

                                        <p> Forestal PAMA S.A.C. podrá modificar las condiciones o porcentajes de comisión para futuras ventas, comunicándolo a los aliados por los medios disponibles. </p>

                                        <h6><strong>5. Retiro de comisiones</strong></h6>

                                        <p> El aliado podrá solicitar el retiro de las comisiones que se encuentren disponibles y habilitadas para retiro. </p>

                                        <p> La solicitud de retiro deberá realizarse a través de la plataforma, proporcionando la información necesaria para efectuar el pago. </p>

                                        <p> Forestal PAMA S.A.C. realizará la validación correspondiente antes de procesar cada solicitud. </p>

                                        <p> La solicitud de retiro podrá pasar por diferentes estados, tales como: </p>

                                        <ul>
                                            <li><strong>Pendiente:</strong> solicitud registrada.</li>
                                            <li><strong>En revisión:</strong> solicitud en proceso de validación.</li>
                                            <li><strong>Aprobada:</strong> solicitud autorizada para pago.</li>
                                            <li><strong>Pagada:</strong> comisión entregada al aliado.</li>
                                            <li><strong>Rechazada:</strong> solicitud que no cumple con las condiciones requeridas.</li>
                                        </ul>

                                        <p> En caso de existir observaciones, inconsistencias o información incorrecta, la solicitud podrá ser rechazada o devuelta para su corrección. </p>

                                        <h6><strong>6. Validación de las operaciones</strong></h6>

                                        <p> Forestal PAMA S.A.C. podrá revisar y validar las ventas, clientes referidos y comisiones registradas antes de aprobar cualquier retiro. </p>

                                        <p> En caso de detectarse registros duplicados, operaciones fraudulentas, información falsa, manipulación del sistema o cualquier otra conducta irregular, la empresa podrá suspender temporalmente el pago de las comisiones involucradas y revisar la cuenta del aliado. </p>

                                        <h6><strong>7. Uso de la plataforma</strong></h6>

                                        <p> El aliado se compromete a utilizar la plataforma exclusivamente para consultar sus ventas, comisiones y gestionar sus solicitudes de retiro. </p>

                                        <p>Queda prohibido:</p>

                                        <ul>
                                            <li>Compartir las credenciales de acceso con terceros.</li>
                                            <li>Intentar acceder a información de otros aliados.</li>
                                            <li>Manipular o alterar la información mostrada por la plataforma.</li>
                                            <li>Realizar acciones que afecten el funcionamiento o seguridad del sistema.</li>
                                            <li>Utilizar información de otros usuarios sin autorización.</li>
                                        </ul>

                                        <h6><strong>8. Suspensión o cancelación</strong></h6>

                                        <p> Forestal PAMA S.A.C. podrá suspender o cancelar una cuenta cuando exista incumplimiento de estos términos, uso indebido de la plataforma, fraude o cualquier otra conducta que pueda perjudicar a la empresa, sus clientes u otros aliados. </p>

                                        <p> La cancelación de una cuenta no elimina las obligaciones o responsabilidades que correspondan por operaciones realizadas anteriormente. </p>

                                        <h6><strong>9. Protección de datos personales</strong></h6>

                                        <p> Los datos proporcionados por el aliado serán utilizados para gestionar su participación en el programa Aliados PAMA, administrar sus ventas y comisiones, validar sus solicitudes de retiro y mantener la comunicación relacionada con el programa. </p>

                                        <p> Forestal PAMA S.A.C. se compromete a realizar el tratamiento de los datos personales de acuerdo con la normativa vigente aplicable. </p>

                                        <h6><strong>10. Aceptación de los términos</strong></h6>

                                        <p> Al registrarse en la plataforma y marcar la opción <strong>“Acepto los Términos y Condiciones de Aliados PAMA”</strong>, el aliado declara haber leído, comprendido y aceptado las presentes condiciones para participar en el programa Aliados PAMA. </p>

                                        <p> Forestal PAMA S.A.C. podrá actualizar estos términos y condiciones cuando sea necesario. Las modificaciones serán comunicadas a través de los medios disponibles en la plataforma. </p>

                                        <hr>

                                        <p class="text-muted small mb-0">
                                            <strong>Forestal PAMA S.A.C.</strong>
                                        </p>

                                    </div>

                                    <div class="modal-footer">

                                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> Cerrar </button>
                                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="$('#terms').prop('checked', true);"> Aceptar términos </button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </x-slot>
                </x-frontend.card>
            </div><!--col-md-8-->
        </div><!--row-->
    </div><!--container-->
@endsection

@push('after-scripts')
<script type="text/javascript">

    $(document).ready(function() {
        $('#fecha_nacimiento').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            language: 'es',
            endDate: new Date()
        });
	});
    
	function obtenerProvincia(){

		var id = $('#departamento').val();
		if(id=="")return false;
		$('#provincia').attr("disabled",true);
		$('#distrito').attr("disabled",true);

		var msgLoader = "";
		msgLoader = "Procesando, espere un momento por favor";
		var heightBrowser = $(window).width()/2;
		$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
		$('.loader').show();

		$.ajax({
			url: '/persona/obtener_provincia/'+id,
			dataType: "json",
			success: function(result){
				var option = "<option value='' selected='selected'>Seleccionar</option>";
				$('#provincia').html("");
				$(result).each(function (ii, oo) {
					option += "<option value='"+oo.id_provincia+"'>"+oo.desc_ubigeo+"</option>";
				});
				$('#provincia').html(option);

				var option2 = "<option value=''>Seleccionar</option>";
				$('#distrito').html(option2);

				$('#provincia').attr("disabled",false);
				$('#distrito').attr("disabled",false);

				$('.loader').hide();

			}
		});
	}

	function obtenerDistrito(){

		var id_departamento = $('#departamento').val();
		var id = $('#provincia').val();
		if(id=="")return false;
		$('#distrito').attr("disabled",true);

		var msgLoader = "";
		msgLoader = "Procesando, espere un momento por favor";
		var heightBrowser = $(window).width()/2;
		$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
		$('.loader').show();

		$.ajax({
			url: '/persona/obtener_distrito/'+id_departamento+'/'+id,
			dataType: "json",
			success: function(result){
				var option = "<option value=''>Seleccionar</option>";
				$('#distrito').html("");
				$(result).each(function (ii, oo) {
					option += "<option value='"+oo.id_ubigeo+"'>"+oo.desc_ubigeo+"</option>";
				});
				$('#distrito').html(option);

				$('#distrito').attr("disabled",false);
				$('.loader').hide();

			}
		});
	}

    function obtenerPersona(){

        var tipo_documento = $("#tipo_documento").val();
        var numero_documento = $("#numero_documento").val();

        if(tipo_documento == 1){
            validaDni();
        }else{
            $("#name").attr("readonly",false);
            $("#apellido_paterno").attr("readonly",false);
            $("#apellido_materno").attr("readonly",false);
        }
    }

    function validaDni() {

		var numero_documento = $("#numero_documento").val();

		if (numero_documento == "") {
			bootbox.alert("Debe ingresar el número de documento.");
			return false;
		}

		var settings = {
			"url": "https://apiperu.dev/api/dni/" + numero_documento,
			"method": "GET",
			"timeout": 0,
			"headers": {
				"Authorization": "Bearer 61864887dd1f3918ec09fc9a10bc2e7fa46ba777f867d23d355a800bb5d68396"
			},
		};

		$.ajax(settings).done(function(response) {
			console.log(response);

			if(response.success == true) {

				var data = response.data;

				$('#apellido_paterno').val('')
				$('#apellido_materno').val('')
				$('#name').val('')

				$('#apellido_paterno').val(data.apellido_paterno);
				$('#apellido_materno').val(data.apellido_materno);
				$('#name').val(data.nombres);

			}else{
				bootbox.alert("DNI Inv&aacute;lido. Revise el DNI digitado!");
				return false;
			}
		});
	}

</script>

@endpush
