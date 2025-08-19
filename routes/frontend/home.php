<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\TermsController;
use Tabuna\Breadcrumbs\Trail;

use App\Http\Controllers\Frontend\IngresoVehiculoTroncoController;
use App\Http\Controllers\TablaMaestraController;
use App\Http\Controllers\Frontend\PersonaController;
use App\Http\Controllers\Frontend\EmpresaController;
use App\Http\Controllers\VehiculoController;

use App\Http\Controllers\Frontend\IngresoController;
use App\Http\Controllers\Frontend\TipoCambioController;
use App\Http\Controllers\Frontend\AlmacenesController;
use App\Http\Controllers\Frontend\SeccionesController;
use App\Http\Controllers\Frontend\AnaquelesController;
use App\Http\Controllers\Frontend\ProductosController;
use App\Http\Controllers\Frontend\LoteController;
use App\Http\Controllers\Frontend\EntradaProductosController;
use App\Http\Controllers\Frontend\OrdenCompraController;
use App\Http\Controllers\Frontend\KardexController;

use App\Http\Controllers\Frontend\ComprobanteController;
use App\Http\Controllers\Frontend\EntradaProductoDetallesController;
use App\Http\Controllers\Frontend\DispensacionController;
use App\Http\Controllers\Frontend\MarcaController;
use App\Http\Controllers\Frontend\TiendaController;
use App\Http\Controllers\Frontend\IngresoProduccionController;
use App\Http\Controllers\Frontend\RequerimientoController;
use App\Http\Controllers\Frontend\GuiaInternaController;

use App\Http\Controllers\Frontend\ProformaController;

use App\Http\Controllers\ConductoresController;

use App\Http\Controllers\Frontend\EquivalenciaProductosController;

use App\Http\Controllers\Frontend\ParametroController;
use App\Http\Controllers\Frontend\EmpaquetadoController;
use App\Http\Controllers\Frontend\DevolucionController;
use App\Http\Controllers\Frontend\PromotorController;
use App\Http\Controllers\Frontend\EmpresaCubicajeController;
use App\Http\Controllers\Frontend\AcerradoMaderaController;
use App\Http\Controllers\Frontend\HornoController;
use App\Http\Controllers\Frontend\ActivoController;
use App\Http\Controllers\Frontend\OrdenProduccionController;
use App\Http\Controllers\Frontend\FamiliaController;
use App\Http\Controllers\Frontend\SubFamiliaController;

//use App\Http\Controllers\VehiculoController;


//use App\Models\Ubigeo;

/*
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */

 Route::get('/phpinfo', function () {
     phpinfo();
 })->name('phpinfo');

Route::get('/', [HomeController::class, 'index'])
    ->name('index')
    ->breadcrumbs(function (Trail $trail) {
        $trail->push(__('Home'), route('frontend.index'));
    });

Route::get('terms', [TermsController::class, 'index'])
    ->name('pages.terms')
    ->breadcrumbs(function (Trail $trail) {
        $trail->parent('frontend.index')
            ->push(__('Terms & Conditions'), route('frontend.pages.terms'));
    });

Route::get('ingreso_vehiculo_tronco', [IngresoVehiculoTroncoController::class, 'index'])->name('ingreso_vehiculo_tronco');
Route::get('ingreso_vehiculo_tronco/obtener_datos_vehiculo/{placa}', [IngresoVehiculoTroncoController::class, 'obtener_datos_vehiculo'])->name('ingreso_vehiculo_tronco.obtener_datos_vehiculo');
Route::post('ingreso_vehiculo_tronco/send_ingreso', [IngresoVehiculoTroncoController::class, 'send_ingreso'])->name('ingreso_vehiculo_tronco.send_ingreso');
Route::post('ingreso_vehiculo_tronco/send_cubicaje', [IngresoVehiculoTroncoController::class, 'send_cubicaje'])->name('ingreso_vehiculo_tronco.send_cubicaje');
Route::post('ingreso_vehiculo_tronco/listar_ingreso_vehiculo_tronco_ajax', [IngresoVehiculoTroncoController::class, 'listar_ingreso_vehiculo_tronco_ajax'])->name('ingreso_vehiculo_tronco.listar_ingreso_vehiculo_tronco_ajax');
Route::post('ingreso_vehiculo_tronco/listar_ingreso_vehiculo_tronco_pagos_ajax', [IngresoVehiculoTroncoController::class, 'listar_ingreso_vehiculo_tronco_pagos_ajax'])->name('listar_ingreso_vehiculo_tronco_pagos_ajax.listar_ingreso_vehiculo_tronco_ajax');
Route::get('ingreso_vehiculo_tronco/modal_pago/{id}/{id_ingreso_vehiculo_tronco}', [IngresoVehiculoTroncoController::class, 'modal_pago'])->name('ingreso_vehiculo_tronco.modal_pago');
Route::post('ingreso_vehiculo_tronco/send_pago', [IngresoVehiculoTroncoController::class, 'send_pago'])->name('ingreso_vehiculo_tronco.send_pago');
Route::get('comprobante/create_consulta_sodimac', [ComprobanteController::class, 'create_consulta_sodimac'])->name('comprobante.create_consulta_sodimac');
Route::get('comprobante/create_facturacion', [ComprobanteController::class, 'create_facturacion'])->name('comprobante.create_facturacion');
Route::get('comprobante/create_pagos', [ComprobanteController::class, 'create_pagos'])->name('comprobante.create_pagos');
Route::get('comprobante/create_ventas', [ComprobanteController::class, 'create_ventas'])->name('comprobante.create_ventas');
Route::get('comprobante/create_facturacion_orden_compra', [ComprobanteController::class, 'create_facturacion_orden_compra'])->name('comprobante.create_facturacion_orden_compra');
Route::post('comprobante/listar_facturacion_orden_compra_ajax', [ComprobanteController::class, 'listar_facturacion_orden_compra_ajax'])->name('comprobante.listar_facturacion_orden_compra_ajax');
Route::get('comprobante/exportar_listar_facturacion_orden_compra/{empresa_compra}/{fecha_inicio}/{fecha_fin}/{numero_orden_compra}/{numero_orden_compra_cliente}/{situacion}/{estado}/{vendedor}/{estado_pedido}/{facturado}', [ComprobanteController::class, 'exportar_listar_facturacion_orden_compra'])->name('comprobante.exportar_listar_facturacion_orden_compra');
Route::get('comprobante/lista_ventas_anio/{anio}/{empresa}', [ComprobanteController::class, 'lista_ventas_anio'])->name('comprobante.lista_ventas_anio');
Route::get('comprobante/lista_pagos_anio/{anio}/{empresa}', [ComprobanteController::class, 'lista_pagos_anio'])->name('comprobante.lista_pagos_anio');
Route::get('comprobante/lista_retencion_anio/{anio}/{empresa}', [ComprobanteController::class, 'lista_retencion_anio'])->name('comprobante.lista_retencion_anio');
Route::get('comprobante/lista_cobros_anio/{anio}/{empresa}', [ComprobanteController::class, 'lista_cobros_anio'])->name('comprobante.lista_cobros_anio');
Route::post('comprobante/send_detalle_factura', [ComprobanteController::class, 'send_detalle_factura'])->name('comprobante.send_detalle_factura');

Route::get('ingreso_vehiculo_tronco/modal_placa/{id}', [IngresoVehiculoTroncoController::class, 'modal_placa'])->name('ingreso_vehiculo_tronco.modal_placa');
Route::get('ingreso_vehiculo_tronco/modal_empresa/{id}', [IngresoVehiculoTroncoController::class, 'modal_empresa'])->name('ingreso_vehiculo_tronco.modal_empresa');
Route::get('ingreso_vehiculo_tronco/modal_conductor/{id}', [IngresoVehiculoTroncoController::class, 'modal_conductor'])->name('ingreso_vehiculo_tronco.modal_conductor');

Route::post('ingreso_vehiculo_tronco/upload_imagen_ingreso', [IngresoVehiculoTroncoController::class, 'upload_imagen_ingreso'])->name('ingreso_vehiculo_tronco.upload_imagen_ingreso');
Route::get('ingreso_vehiculo_tronco/modal_ingreso_imagen/{id}', [IngresoVehiculoTroncoController::class, 'modal_ingreso_imagen'])->name('ingreso_vehiculo_tronco.modal_ingreso_imagen');

Route::post('ingreso_vehiculo_tronco/upload_pago', [IngresoVehiculoTroncoController::class, 'upload_pago'])->name('ingreso_vehiculo_tronco.upload_pago');

// Route::get('tabla_maestras', [TablaMaestraController::class, 'index'])->name('tabla_maestras.all');
// Route::get('tabla_maestras/{id}', [TablaMaestraController::class, 'show'])->name('tabla_maestras.show');
// Route::post('tabla_maestras/create', [TablaMaestraController::class, 'create'])->name('tabla_maestras.create');
// Route::post('tabla_maestras/send', [TablaMaestraController::class, 'send'])->name('tabla_maestras.send');
// Route::post('tabla_maestras/listar_tabla_maestras_ajax', [TablaMaestraController::class, 'listar_tabla_maestras_ajax'])->name('tabla_maestras.listar_tabla_maestras_ajax');
// Route::get('tabla_maestras/modal_tablamaestras/{id}', [TablaMaestraController::class, 'modal_tablamaestras'])->name('tabla_maestras.modal_tablamaestras');
// Route::get('tabla_maestras/eliminar_tabla_maestra/{id}/{estado}', [TablaMaestraController::class, 'eliminar_tabla_maestra'])->name('tabla_maestras.eliminar_tabla_maestra');
Route::get('ingreso_vehiculo_tronco/cubicaje', [IngresoVehiculoTroncoController::class, 'cubicaje'])->name('ingreso_vehiculo_tronco.cubicaje');
Route::get('ingreso_vehiculo_tronco/cargar_cubicaje/{id}', [IngresoVehiculoTroncoController::class, 'cargar_cubicaje'])->name('ingreso_vehiculo_tronco.cargar_cubicaje');

Route::get('ingreso_vehiculo_tronco/pagos', [IngresoVehiculoTroncoController::class, 'pagos'])->name('ingreso_vehiculo_tronco.pagos');

Route::get('ingreso_vehiculo_tronco/cargar_reporte_cubicaje/{id}', [IngresoVehiculoTroncoController::class, 'cargar_reporte_cubicaje'])->name('ingreso_vehiculo_tronco.cargar_reporte_cubicaje');
Route::get('ingreso_vehiculo_tronco/cargar_pago_cubicaje/{id}', [IngresoVehiculoTroncoController::class, 'cargar_pago_cubicaje'])->name('ingreso_vehiculo_tronco.cargar_pago_cubicaje');

Route::get('tabla_maestras', [TablaMaestraController::class, 'index'])->name('tabla_maestras.all');
Route::get('tabla_maestras/{id}', [TablaMaestraController::class, 'show'])->name('tabla_maestras.show');
Route::post('tabla_maestras/create', [TablaMaestraController::class, 'create'])->name('tabla_maestras.create');
Route::post('tabla_maestras/send', [TablaMaestraController::class, 'send'])->name('tabla_maestras.send');
Route::post('tabla_maestras/listar_tabla_maestras_ajax', [TablaMaestraController::class, 'listar_tabla_maestras_ajax'])->name('tabla_maestras.listar_tabla_maestras_ajax');
Route::get('tabla_maestras/modal_tablamaestras/{id}', [TablaMaestraController::class, 'modal_tablamaestras'])->name('tabla_maestras.modal_tablamaestras');
Route::get('tabla_maestras/eliminar_tabla_maestra/{id}/{estado}', [TablaMaestraController::class, 'eliminar_tabla_maestra'])->name('tabla_maestras.eliminar_tabla_maestra');

Route::get('personas', [personaController::class, 'index'])->name('personas');
Route::post('persona/send', [personaController::class, 'send'])->name('persona.send');
Route::get('persona/consulta_persona', [PersonaController::class, 'consulta_persona'])->name('persona.consulta_persona');
Route::post('persona/listar_persona_ajax', [PersonaController::class, 'listar_persona_ajax'])->name('persona.listar_persona_ajax');
Route::get('persona/modal_persona/{id}', [PersonaController::class, 'modal_persona'])->name('persona.modal_persona');
Route::get('persona/eliminar_persona/{id}/{estado}', [PersonaController::class, 'eliminar_persona'])->name('persona.eliminar_persona');
Route::post('persona/buscar_persona_ajax', [PersonaController::class, 'buscar_persona_ajax'])->name('persona.buscar_persona_ajax');
Route::get('persona/obtener_provincia/{idDepartamento}', [PersonaController::class, 'obtener_provincia'])->name('persona.obtener_provincia');
Route::get('persona/obtener_distrito/{idDepartamento}/{idProvincia}', [PersonaController::class, 'obtener_distrito'])->name('persona.obtener_distrito');
Route::get('persona/obtener_persona/{tipo_documento}/{numero_documento}', [PersonaController::class, 'obtener_persona'])->name('persona.obtener_persona');
Route::get('persona/obtener_persona_conductor/{tipo_documento}/{numero_documento}', [PersonaController::class, 'obtener_persona_conductor'])->name('persona.obtener_persona_conductor');

Route::get('persona/obtener_personas/{tipo_documento}/{numero_documento}', [PersonaController::class, 'obtener_personas'])->name('persona.obtener_personas');


Route::get('empresas', [EmpresaController::class, 'index'])->name('empresas');
Route::post('empresa/send', [EmpresaController::class, 'send'])->name('empresa.send');
Route::get('empresa/consulta_empresa', [EmpresaController::class, 'consulta_empresa'])->name('empresa.consulta_empresa');
Route::post('empresa/listar_empresa_ajax', [EmpresaController::class, 'listar_empresa_ajax'])->name('empresa.listar_empresa_ajax');
Route::get('empresa/modal_empresa/{id}', [EmpresaController::class, 'modal_empresa'])->name('empresa.modal_empresa');
Route::get('empresa/eliminar_empresa/{id}/{estado}', [EmpresaController::class, 'eliminar_empresa'])->name('empresa.eliminar_empresa');
Route::post('empresa/send_empresa_ingreso', [EmpresaController::class, 'send_empresa_ingreso'])->name('empresa.send_empresa_ingreso');

Route::get('empresa/obtener_empresa/{ruc}', [EmpresaController::class, 'obtener_empresa'])->name('empresa.obtener_empresa');

// Route::get('vehiculos', [VehiculoController::class, 'index'])->name('vehiculos');
Route::post('vehiculo/send_vehiculo_ingreso', 'App\Http\Controllers\VehiculoController@send_vehiculo_ingreso')->name('vehiculo.send_vehiculo_ingreso');
// Route::get('vehiculo/consulta_vehiculo', [VehiculoController::class, 'consulta_vehiculo'])->name('vehiculo.consulta_vehiculo');
// Route::post('vehiculo/listar_vehiculo_ajax', [VehiculoController::class, 'listar_vehiculo_ajax'])->name('vehiculo.listar_vehiculo_ajax');
// Route::get('vehiculo/modal_vehiculo/{id}', [VehiculoController::class, 'modal_vehiculo'])->name('vehiculo.modal_vehiculo');
// Route::get('vehiculo/eliminar_vehiculo/{id}/{estado}', [VehiculoController::class, 'eliminar_vehiculo'])->name('vehiculo.eliminar_vehiculo');

Route::get('vehiculos', 'App\Http\Controllers\VehiculoController@index')->name('vehiculos.index');
Route::post('vehiculos', 'App\Http\Controllers\VehiculoController@store')->name('vehiculos.store');
Route::get('vehiculos/create', 'App\Http\Controllers\VehiculoController@create')->name('vehiculos.create');
Route::get('vehiculos/{vehiculos}', 'App\Http\Controllers\VehiculoController@show')->name('vehiculos.show');
Route::put('vehiculos/{vehiculos}', 'App\Http\Controllers\VehiculoController@update')->name('vehiculos.update');
Route::patch('vehiculos/{vehiculos}', 'App\Http\Controllers\VehiculoController@update');
Route::delete('vehiculos/{vehiculos}', 'App\Http\Controllers\VehiculoController@destroy')->name('vehiculos.destroy');
Route::get('vehiculos/{vehiculos}/edit', 'App\Http\Controllers\VehiculoController@edit')->name('vehiculos.edit');

Route::get('conductores', 'App\Http\Controllers\ConductoresController@index')->name('conductores.index');
Route::post('conductores', 'App\Http\Controllers\ConductoresController@store')->name('conductores.store');
Route::get('conductores/create', 'App\Http\Controllers\ConductoresController@create')->name('conductores.create');
//Route::get('conductores/{conductores}', 'App\Http\Controllers\ConductoresController@show')->name('conductores.show');
Route::put('conductores/{conductores}', 'App\Http\Controllers\ConductoresController@update')->name('conductores.update');
Route::patch('conductores/{conductores}', 'App\Http\Controllers\ConductoresController@update');
Route::delete('conductores/{conductores}', 'App\Http\Controllers\ConductoresController@destroy')->name('conductores.destroy');
Route::get('conductores/{conductores}/edit', 'App\Http\Controllers\ConductoresController@edit')->name('conductores.edit');

Route::post('conductores/send_conductor_ingreso', 'App\Http\Controllers\ConductoresController@send_conductor_ingreso')->name('conductores.send_conductor_ingreso');

// Route::resource('tablamaestras', 'App\Http\Controllers\TablaMaestraController');

Route::get('tablamaestras', 'App\Http\Controllers\TablaMaestraController@index')->name('tablamaestras.index');
Route::post('tablamaestras', 'App\Http\Controllers\TablaMaestraController@store')->name('tablamaestras.store');
Route::get('tablamaestras/create', 'App\Http\Controllers\TablaMaestraController@create')->name('tablamaestras.create');
Route::get('tablamaestras/{tablamaestras}', 'App\Http\Controllers\TablaMaestraController@show')->name('tablamaestras.show');
Route::put('tablamaestras/{tablamaestras}', 'App\Http\Controllers\TablaMaestraController@update')->name('tablamaestras.update');
Route::patch('tablamaestras/{tablamaestras}', 'App\Http\Controllers\TablaMaestraController@update');
Route::delete('tablamaestras/{tablamaestras}', 'App\Http\Controllers\TablaMaestraController@destroy')->name('tablamaestras.destroy');
Route::get('tablamaestras/{tablamaestras}/edit', 'App\Http\Controllers\TablaMaestraController@edit')->name('tablamaestras.edit');

Route::get('anaqueles', 'App\Http\Controllers\AnaquelesController@index')->name('anaqueles.index');
Route::post('anaqueles', 'App\Http\Controllers\AnaquelesController@store')->name('anaqueles.store');
Route::get('anaqueles/create', 'App\Http\Controllers\AnaquelesController@create')->name('anaqueles.create');
Route::get('anaqueles/{anaqueles}', 'App\Http\Controllers\AnaquelesController@show')->name('anaqueles.show');
Route::put('anaqueles/{anaqueles}', 'App\Http\Controllers\AnaquelesController@update')->name('anaqueles.update');
Route::delete('anaqueles/{anaqueles}', 'App\Http\Controllers\AnaquelesController@destroy')->name('anaqueles.destroy');
Route::get('anaqueles/{anaqueles}/edit', 'App\Http\Controllers\AnaquelesController@edit')->name('anaqueles.edit');

/*Route::get('almacenes', 'App\Http\Controllers\AlmacenesController@index')->name('almacenes.index');
Route::post('almacenes', 'App\Http\Controllers\AlmacenesController@store')->name('almacenes.store');
Route::get('almacenes/create', 'App\Http\Controllers\AlmacenesController@create')->name('almacenes.create');
Route::get('almacenes/{almacenes}', 'App\Http\Controllers\AlmacenesController@show')->name('almacenes.show');
Route::put('almacenes/{almacenes}', 'App\Http\Controllers\AlmacenesController@update')->name('almacenes.update');
Route::delete('almacenes/{almacenes}', 'App\Http\Controllers\AlmacenesController@destroy')->name('almacenes.destroy');
Route::get('almacenes/{almacenes}/edit', 'App\Http\Controllers\AlmacenesController@edit')->name('almacenes.edit');
*/
Route::get('secciones', 'App\Http\Controllers\SeccionesController@index')->name('secciones.index');
Route::post('secciones', 'App\Http\Controllers\SeccionesController@store')->name('secciones.store');
Route::get('secciones/create', 'App\Http\Controllers\SeccionesController@create')->name('secciones.create');
Route::get('secciones/{secciones}', 'App\Http\Controllers\SeccionesController@show')->name('secciones.show');
Route::put('secciones/{secciones}', 'App\Http\Controllers\SeccionesController@update')->name('secciones.update');
Route::delete('secciones/{secciones}', 'App\Http\Controllers\SeccionesController@destroy')->name('secciones.destroy');
Route::get('secciones/{secciones}/edit', 'App\Http\Controllers\SeccionesController@edit')->name('secciones.edit');

Route::get('productos', 'App\Http\Controllers\ProductosController@index')->name('productos.index');
Route::post('productos', 'App\Http\Controllers\ProductosController@store')->name('productos.store');
Route::get('productos/create', 'App\Http\Controllers\ProductosController@create')->name('productos.create');
Route::get('productos/modal_create', 'App\Http\Controllers\ProductosController@modal_create')->name('productos.modal_create');
Route::get('productos/{productos}', 'App\Http\Controllers\ProductosController@show')->name('productos.show');
Route::put('productos/{productos}', 'App\Http\Controllers\ProductosController@update')->name('productos.update');
Route::delete('productos/{productos}', 'App\Http\Controllers\ProductosController@destroy')->name('productos.destroy');
Route::get('productos/{productos}/edit', 'App\Http\Controllers\ProductosController@edit')->name('productos.edit');


Route::get('ingreso/create', [IngresoController::class, 'create'])->name('ingreso.create');
Route::get('ingreso/obtener_valorizacion/{tipo_documento}/{id_persona}', [IngresoController::class, 'obtener_valorizacion'])->name('ingreso.obtener_valorizacion')->where('tipo_documento', '(.*)');
Route::post('ingreso/listar_valorizacion', [IngresoController::class, 'listar_valorizacion'])->name('ingreso.listar_valorizacion');
Route::post('ingreso/listar_valorizacion_concepto', [IngresoController::class, 'listar_valorizacion_concepto'])->name('ingreso.listar_valorizacion_concepto');
Route::post('ingreso/listar_valorizacion_periodo', [IngresoController::class, 'listar_valorizacion_periodo'])->name('ingreso.listar_valorizacion_periodo');
Route::post('ingreso/listar_valorizacion_mes', [IngresoController::class, 'listar_valorizacion_mes'])->name('ingreso.listar_valorizacion_mes');
Route::get('ingreso/listar_proforma_det/{id}', [IngresoController::class, 'listar_proforma_det'])->name('ingreso.listar_proforma_det');
Route::get('ingreso/listar_orden_compra_det/{id}/{emp}', [IngresoController::class, 'listar_orden_compra_det'])->name('ingreso.listar_orden_compra_det');
Route::get('ingreso/obtener_proforma_id/{id}', [IngresoController::class, 'obtener_proforma_id'])->name('ingreso.obtener_proforma_id');

Route::get('ingreso/obtener_pago/{tipo_documento}/{persona_id}', [IngresoController::class, 'obtener_pago'])->name('ingreso.obtener_pago')->where('tipo_documento', '(.*)');
Route::get('ingreso/obtener_proforma/{tipo_documento}/{persona_id}', [IngresoController::class, 'obtener_proforma'])->name('ingreso.obtener_proforma')->where('tipo_documento', '(.*)');
Route::post('ingreso/sendCaja', [IngresoController::class, 'sendCaja'])->name('ingreso.sendCaja');
Route::get('ingreso/modal_otro_pago/{periodo}/{idpersona}/{idagremiado}/{tipo_documento}', [IngresoController::class, 'modal_otro_pago'])->name('ingreso.modal_otro_pago');
Route::get('ingreso/modal_fraccionar/{idConcepto}/{idpersona}/{idagremiado}/{TotalFraccionar}', [IngresoController::class, 'modal_fraccionar'])->name('ingreso.modal_fraccionar');
Route::post('ingreso/modal_fraccionamiento', [IngresoController::class, 'modal_fraccionamiento'])->name('ingreso.modal_fraccionamiento');
Route::post('ingreso/modal_persona', [IngresoController::class, 'modal_persona'])->name('ingreso.modal_persona');
Route::get('ingreso/modal_exonerar', [IngresoController::class, 'modal_exonerar'])->name('ingreso.modal_exonerar');

Route::get('ingreso/obtener_conceptos/{periodo}', [IngresoController::class, 'obtener_conceptos'])->name('ingreso.obtener_conceptos')->where('periodo', '(.*)');
Route::post('ingreso/send_concepto', [IngresoController::class, 'send_concepto'])->name('ingreso.send_concepto');
Route::post('ingreso/send_fracciona_deuda', [IngresoController::class, 'send_fracciona_deuda'])->name('ingreso.send_fracciona_deuda');
Route::get('ingreso/modal_valorizacion_factura/{id}', [IngresoController::class, 'modal_valorizacion_factura'])->name('ingreso.modal_valorizacion_factura');
Route::get('ingreso/liquidacion_caja', [IngresoController::class, 'liquidacion_caja'])->name('ingreso.liquidacion_caja');
Route::get('ingreso/modal_liquidacion/{id}', [IngresoController::class, 'modal_liquidacion'])->name('ingreso.modal_liquidacion');
Route::get('ingreso/modal_detalle_factura/{id}', [IngresoController::class, 'modal_detalle_factura'])->name('ingreso.modal_detalle_factura');
Route::post('ingreso/updateCajaLiquidacion', [IngresoController::class, 'updateCajaLiquidacion'])->name('ingreso.updateCajaLiquidacion');
Route::post('ingreso/listar_estado_cuenta_ajax', [IngresoController::class, 'listar_estado_cuenta_ajax'])->name('ingreso.listar_estado_cuenta_ajax');
Route::post('ingreso/listar_liquidacion_caja_ajax', [IngresoController::class, 'listar_liquidacion_caja_ajax'])->name('ingreso.listar_liquidacion_caja_ajax');
Route::get('ingreso/exportar_liquidacion_caja/{fecha_inicio_desde}/{fecha_inicio_hasta}/{fecha_ini}/{fecha_fin}/{id_caja}/{estado}', [IngresoController::class, 'exportar_liquidacion_caja'])->name('ingreso.exportar_liquidacion_caja');
Route::get('ingreso/exportar_estado_cuenta/{tipo}/{afiliado}/{numero_documento}/{periodo}/{fecha_inicio}/{fecha_fin}/{pago}/{order}/{sort}', [IngresoController::class, 'exportar_estado_cuenta'])->name('ingreso.exportar_estado_cuenta');
Route::post('ingreso/listar_empresa_beneficiario_ajax', [IngresoController::class, 'listar_empresa_beneficiario_ajax'])->name('ingreso.listar_empresa_beneficiario_ajax');
Route::post('ingreso/anula_fraccionamiento', [IngresoController::class, 'anula_fraccionamiento'])->name('ingreso.anula_fraccionamiento');
Route::post('ingreso/exonerar_valorizacion/{motivo}', [IngresoController::class, 'exonerar_valorizacion'])->name('ingreso.exonerar_valorizacion');
Route::post('ingreso/anular_valorizacion', [IngresoController::class, 'anular_valorizacion'])->name('ingreso.anular_valorizacion');
Route::get('ingreso/modal_consulta_persona', [IngresoController::class, 'modal_consulta_persona'])->name('ingreso.modal_consulta_persona');
Route::post('ingreso/valida_deuda_vencida', [IngresoController::class, 'valida_deuda_vencida'])->name('ingreso.valida_deuda_vencida');

Route::get('ingreso/modal_productos/{id}', [IngresoController::class, 'modal_productos'])->name('ingreso.modal_productos');

Route::get('ingreso/caja_total', [IngresoController::class, 'caja_total'])->name('ingreso.caja_total');
Route::post('ingreso/obtener_caja_condicion_pago', [IngresoController::class, 'obtener_caja_condicion_pago'])->name('ingreso.obtener_caja_condicion_pago');
Route::post('ingreso/obtener_caja_venta', [IngresoController::class, 'obtener_caja_venta'])->name('ingreso.obtener_caja_venta');

Route::get('ingreso/obtener_producto_tipo_denominacion/{tipo}/{den}/{emp}/{ori}', [IngresoController::class, 'obtener_producto_tipo_denominacion'])->name('ingreso.obtener_producto_tipo_denominacion');
Route::get('ingreso/obtener_producto_eqiv_id/{id}/{emp}/{ori}', [IngresoController::class, 'obtener_producto_eqiv_id'])->name('ingreso.obtener_producto_eqiv_id');
Route::post('ingreso/sendCajaMoneda', [IngresoController::class, 'sendCajaMoneda'])->name('ingreso.sendCajaMoneda');

Route::post('proforma/send', [ProformaController::class, 'send'])->name('proforma.send');
Route::get('proforma/proforma_pdf/{id}', [ProformaController::class, 'proforma_pdf'])->name('proforma.proforma_pdf');
Route::get('proforma/obtener_proforma_id/{id}', [ProformaController::class, 'obtener_proforma_id'])->name('proforma.obtener_proforma_id');



Route::post('comprobante/edit', [ComprobanteController::class, 'edit'])->name('comprobante.edit');
Route::get('comprobante', [ComprobanteController::class, 'index'])->name('comprobante.all');
Route::post('comprobante/create', [ComprobanteController::class, 'create'])->name('comprobante.create');
Route::post('comprobante/send', [ComprobanteController::class, 'send'])->name('comprobante.send');
Route::get('comprobante/{id}', [ComprobanteController::class, 'show'])->name('comprobante.show');
Route::post('comprobante/send_nc', [ComprobanteController::class, 'send_nc'])->name('comprobante.send_nc');
Route::post('comprobante/send_nd', [ComprobanteController::class, 'send_nd'])->name('comprobante.send_nd');
//Route::get('comprobante/nc_edit/{id}/{id_caja}', [ComprobanteController::class, 'nc_edit'])->name('comprobante.nc_edit');
Route::post('comprobante/nc_edita', [ComprobanteController::class, 'nc_edita'])->name('comprobante.nc_edita');
Route::post('comprobante/nd_edita', [ComprobanteController::class, 'nd_edita'])->name('comprobante.nd_edita');

Route::get('comprobante/firmar/{id}', [ComprobanteController::class, 'firmar'])->name('comprobante.firmar');
Route::get('comprobante/firmar_nc/{id}', [ComprobanteController::class, 'firmar_nc'])->name('comprobante.firmar_nc');
Route::get('comprobante/firmar_nd/{id}', [ComprobanteController::class, 'firmar_nd'])->name('comprobante.firmar_nd');
Route::get('comprobante/guia_json/{id}', [ComprobanteController::class, 'guia_json'])->name('comprobante.guia_json');
Route::get('comprobante/envio_comprobante_sunat_automatico/{fecha}', [ComprobanteController::class, 'envio_comprobante_sunat_automatico'])->name('comprobante.envio_comprobante_sunat_automatico');

Route::get('comprobante/credito_pago/{id}', [ComprobanteController::class, 'credito_pago'])->name('comprobante.credito_pago');
Route::post('comprobante/listar_credito_pago', [ComprobanteController::class, 'listar_credito_pago'])->name('comprobante.listar_credito_pago');
Route::post('comprobante/send_credito_pago', [ComprobanteController::class, 'send_credito_pago'])->name('comprobante.send_credito_pago');
Route::get('comprobante/obtener_credito_pago/{id}', [ComprobanteController::class, 'obtener_credito_pago'])->name('comprobante.obtener_credito_pago');
Route::get('comprobante/eliminar_credito_pago/{id}', [ComprobanteController::class, 'eliminar_credito_pago'])->name('comprobante.eliminar_credito_pago');

Route::get('comprobante/envio_factura_sunat_automatico/{fecha}', [ComprobanteController::class, 'envio_factura_sunat_automatico'])->name('comprobante.envio_factura_sunat_automatico');
Route::get('comprobante/envio_guia_sunat_automatico/{fecha}', [ComprobanteController::class, 'envio_guia_sunat_automatico'])->name('comprobante.envio_guia_sunat_automatico');
Route::post('comprobante/listar_comprobante', [ComprobanteController::class, 'listar_comprobante'])->name('comprobante.listar_comprobante');

Route::get('comprobante/obtener_representante/{tipo_documento}/{numero_documento}', [ComprobanteController::class, 'obtener_representante'])->name('comprobante.obtener_representante');

Route::get('comprobante/obtiene_orden_compra/{id}', [ComprobanteController::class, 'obtiene_orden_compra'])->name('comprobante.obtiene_orden_compra');


Route::get('lotes', 'App\Http\Controllers\LoteController@index')->name('lotes.index');
Route::post('lotes', 'App\Http\Controllers\LoteController@store')->name('lotes.store');
Route::get('lotes/create', 'App\Http\Controllers\LoteController@create')->name('lotes.create');
Route::get('lotes/modal_create', 'App\Http\Controllers\LoteController@modal_create')->name('lotes.modal_create');
Route::get('lotes/{lotes}', 'App\Http\Controllers\LoteController@show')->name('lotes.show');
Route::put('lotes/{lotes}', 'App\Http\Controllers\LoteController@update')->name('lotes.update');
Route::delete('lotes/{lotes}', 'App\Http\Controllers\LoteController@destroy')->name('lotes.destroy');
Route::get('lotes/{lotes}/edit', 'App\Http\Controllers\LoteController@edit')->name('lotes.edit');

/*Route::get('entrada_productos', 'App\Http\Controllers\EntradaProductosController@index')->name('entrada_productos.index');
Route::post('entrada_productos', 'App\Http\Controllers\EntradaProductosController@store')->name('entrada_productos.store');
Route::get('entrada_productos/create', 'App\Http\Controllers\EntradaProductosController@create')->name('entrada_productos.create');
Route::get('entrada_productos/{entrada_productos}', 'App\Http\Controllers\EntradaProductosController@show')->name('entrada_productos.show');
Route::put('entrada_productos/{entrada_productos}', 'App\Http\Controllers\EntradaProductosController@update')->name('entrada_productos.update');
Route::delete('entrada_productos/{entrada_productos}', 'App\Http\Controllers\EntradaProductosController@destroy')->name('entrada_productos.destroy');
Route::get('entrada_productos/edit/{entrada_productos}', 'App\Http\Controllers\EntradaProductosController@edit')->name('entrada_productos.edit');
*/
Route::post('entrada_producto_detalles', 'App\Http\Controllers\EntradaProductoDetallesController@store')->name('entrada_producto_detalles.store');
Route::put('entrada_producto_detalles/{entrada_producto_detalles}', 'App\Http\Controllers\EntradaProductoDetallesController@update')->name('entrada_producto_detalles.update');
Route::delete('entrada_producto_detalles/{entrada_producto_detalles}', 'App\Http\Controllers\EntradaProductoDetallesController@destroy')->name('entrada_producto_detalles.destroy');

Route::get('salida_productos', 'App\Http\Controllers\SalidaProductoController@index')->name('salida_productos.index');
Route::post('salida_productos', 'App\Http\Controllers\SalidaProductoController@store')->name('salida_productos.store');
Route::get('salida_productos/create', 'App\Http\Controllers\SalidaProductoController@create')->name('salida_productos.create');
Route::get('salida_productos/{salida_productos}', 'App\Http\Controllers\SalidaProductoController@show')->name('salida_productos.show');
Route::put('salida_productos/{salida_productos}', 'App\Http\Controllers\SalidaProductoController@update')->name('salida_productos.update');
Route::delete('salida_productos/{salida_productos}', 'App\Http\Controllers\SalidaProductoController@destroy')->name('salida_productos.destroy');
Route::get('salida_productos/edit/{salida_productos}', 'App\Http\Controllers\SalidaProductoController@edit')->name('salida_productos.edit');

Route::post('salida_producto_detalles', 'App\Http\Controllers\SalidaProductoDetalleController@store')->name('salida_producto_detalles.store');
Route::put('salida_producto_detalles/{salida_producto_detalles}', 'App\Http\Controllers\SalidaProductoDetalleController@update')->name('salida_producto_detalles.update');
Route::delete('salida_producto_detalles/{salida_producto_detalles}', 'App\Http\Controllers\SalidaProductoDetalleController@destroy')->name('salida_producto_detalles.destroy');
/*
Route::get('ubigeo/listar_departamentos_ajax', function() {
    return response()->json([ 'status' => 'OK', 'departamentos' => Ubigeo::departamentos() ]);
});

Route::get('ubigeo/listar_provincias_ajax/{id_departamento}', function(Request $request) {
    return response()->json([ 'status' => 'OK', 'provincias' => Ubigeo::provincias(request()->route('id_departamento')) ]);
});

Route::get('ubigeo/listar_distritos_ajax/{id_departamento}/{id_provincia}', function(Request $request) {
    return response()->json([ 'status' => 'OK', 'distritos' => Ubigeo::distritos_ajax(request()->route('id_departamento'), request()->route('id_provincia')) ]);
});
*/

Route::get('kardex', 'App\Http\Controllers\KardexController@index')->name('kardex.index');
// Route::post('kardex', 'App\Http\Controllers\KardexController@store')->name('kardex.store');
// Route::get('kardex/create', 'App\Http\Controllers\KardexController@create')->name('kardex.create');
// Route::get('kardex/{kardex}', 'App\Http\Controllers\KardexController@show')->name('kardex.show');
// Route::put('kardex/{kardex}', 'App\Http\Controllers\KardexController@update')->name('kardex.update');
// Route::delete('kardex/{kardex}', 'App\Http\Controllers\KardexController@destroy')->name('kardex.destroy');
// Route::get('kardex/edit/{kardex}', 'App\Http\Controllers\KardexController@edit')->name('kardex.edit');

Route::get('movimientos', 'App\Http\Controllers\MovimientoController@index')->name('movimientos.index');

Route::get('tipo_cambio', [TipoCambioController::class, 'index'])->name('tipocambio.index');
Route::post('tipo_cambio/listar_tipo_cambio_ajax', [TipoCambioController::class, 'listar_tipo_cambio_ajax'])->name('tipo_cambio.listar_tipo_cambio_ajax');
Route::get('tipo_cambio/modal_tipo_cambio/{id}', [TipoCambioController::class, 'modal_tipo_cambio'])->name('tipo_cambio.modal_tipo_cambio');
Route::post('tipo_cambio/send', [TipoCambioController::class, 'send'])->name('tipo_cambio.send');
Route::get('tipo_cambio/eliminar_tipo_cambio/{id}/{estado}', [TipoCambioController::class, 'eliminar_tipo_cambio'])->name('tipo_cambio.eliminar_tipo_cambio');

Route::get('almacenes/create', [AlmacenesController::class, 'create'])->name('almacenes.create');
Route::post('almacenes/listar_almacenes_ajax', [AlmacenesController::class, 'listar_almacenes_ajax'])->name('almacenes.listar_almacenes_ajax');
Route::post('almacenes/send_almacen', [AlmacenesController::class, 'send_almacen'])->name('almacenes.send_almacen');
Route::get('almacenes/modal_almacen/{id}', [AlmacenesController::class, 'modal_almacen'])->name('almacenes.modal_almacen');
Route::get('almacenes/obtener_provincia/{idDepartamento}', [AlmacenesController::class, 'obtener_provincia'])->name('almacenes.obtener_provincia');
Route::get('almacenes/obtener_distrito/{idDepartamento}/{idProvincia}', [AlmacenesController::class, 'obtener_distrito'])->name('almacenes.obtener_distrito');
Route::get('almacenes/eliminar_almacen/{id}/{estado}', [AlmacenesController::class, 'eliminar_almacen'])->name('almacenes.eliminar_almacen');
Route::get('almacenes/modal_usuario/{id}', [AlmacenesController::class, 'modal_usuario'])->name('almacenes.modal_usuario');
Route::get('almacenes/obtener_provincia_distrito/{id}', [AlmacenesController::class, 'obtener_provincia_distrito'])->name('almacenes.obtener_provincia_distrito');

Route::get('secciones/create', [SeccionesController::class, 'create'])->name('secciones.create');
Route::post('secciones/listar_seccion_ajax', [SeccionesController::class, 'listar_seccion_ajax'])->name('secciones.listar_seccion_ajax');
Route::post('secciones/send_seccion', [SeccionesController::class, 'send_seccion'])->name('secciones.send_seccion');
Route::get('secciones/modal_seccion/{id}', [SeccionesController::class, 'modal_seccion'])->name('secciones.modal_seccion');
Route::get('secciones/eliminar_seccion/{id}/{estado}', [SeccionesController::class, 'eliminar_seccion'])->name('secciones.eliminar_seccion');
Route::get('secciones/modal_ver_anaqueles/{id}', [SeccionesController::class, 'modal_ver_anaqueles'])->name('secciones.modal_ver_anaqueles');

Route::get('anaqueles/create', [AnaquelesController::class, 'create'])->name('anaqueles.create');
Route::post('anaqueles/listar_anaqueles_ajax', [AnaquelesController::class, 'listar_anaqueles_ajax'])->name('anaqueles.listar_anaqueles_ajax');
Route::post('anaqueles/send_anaquel', [AnaquelesController::class, 'send_anaquel'])->name('anaqueles.send_anaquel');
Route::get('anaqueles/modal_anaquel/{id}', [AnaquelesController::class, 'modal_anaquel'])->name('anaqueles.modal_anaquel');
Route::get('anaqueles/eliminar_anaquel/{id}/{estado}', [AnaquelesController::class, 'eliminar_anaquel'])->name('anaqueles.eliminar_anaquel');
Route::get('anaqueles/obtener_anaquel/{id_almacen}', [AnaquelesController::class, 'obtener_anaquel'])->name('anaqueles.obtener_anaquel');
Route::post('secciones/send_editar_anaquel_activo', [SeccionesController::class, 'send_editar_anaquel_activo'])->name('secciones.send_editar_anaquel_activo');

Route::get('productos/create', [ProductosController::class, 'create'])->name('productos.create');
Route::post('productos/listar_producto_ajax', [ProductosController::class, 'listar_producto_ajax'])->name('productos.listar_producto_ajax');
Route::post('productos/send_producto', [ProductosController::class, 'send_producto'])->name('productos.send_producto');
Route::get('productos/modal_producto/{id}', [ProductosController::class, 'modal_producto'])->name('productos.modal_producto');
Route::get('productos/eliminar_producto/{id}/{estado}', [ProductosController::class, 'eliminar_producto'])->name('productos.eliminar_producto');
Route::get('productos/obtener_producto/{id_producto}', [ProductosController::class, 'obtener_producto'])->name('productos.obtener_producto');

Route::get('lotes/create', [LoteController::class, 'create'])->name('lotes.create');
Route::post('lotes/listar_lote_ajax', [LoteController::class, 'listar_lote_ajax'])->name('lotes.listar_lote_ajax');
Route::post('lotes/send_lote', [LoteController::class, 'send_lote'])->name('lotes.send_lote');
Route::get('lotes/modal_lote/{id}', [LoteController::class, 'modal_lote'])->name('lotes.modal_lote');
Route::get('lotes/eliminar_lote/{id}/{estado}', [LoteController::class, 'eliminar_lote'])->name('lotes.eliminar_lote');
Route::get('lotes/obtener_seccion_almacen/{id}', [LoteController::class, 'obtener_seccion_almacen'])->name('lotes.obtener_seccion_almacen');
Route::get('lotes/obtener_anaquel_seccion/{id}', [LoteController::class, 'obtener_anaquel_seccion'])->name('lotes.obtener_anaquel_seccion');

Route::get('entrada_productos/create', [EntradaProductosController::class, 'create'])->name('entrada_productos.create');
Route::post('entrada_productos/listar_entrada_productos_ajax', [EntradaProductosController::class, 'listar_entrada_productos_ajax'])->name('entrada_productos.listar_entrada_productos_ajax');
Route::post('entrada_productos/send_entrada_producto', [EntradaProductosController::class, 'send_entrada_producto'])->name('entrada_productos.send_entrada_producto');
Route::get('entrada_productos/modal_entrada_producto/{id}', [EntradaProductosController::class, 'modal_entrada_producto'])->name('entrada_productos.modal_entrada_producto');
Route::get('entrada_productos/eliminar_entrada_producto/{id}/{estado}', [EntradaProductosController::class, 'eliminar_entrada_producto'])->name('entrada_productos.eliminar_entrada_producto');
Route::get('entrada_productos/modal_detalle_producto/{id}/{tipo}', [EntradaProductosController::class, 'modal_detalle_producto'])->name('entrada_productos.modal_detalle_producto');

Route::get('entrada_productos_detalle/send_entrada_producto_detalle', [EntradaProductoDetallesController::class, 'send_entrada_producto_detalle'])->name('entrada_productos_detalle.send_entrada_producto_detalle');

Route::get('entrada_productos/obtener_documento_entrada', [EntradaProductosController::class, 'obtener_documento_entrada'])->name('entrada_productos.obtener_documento_entrada');

Route::get('entrada_productos/obtener_documento_salida', [EntradaProductosController::class, 'obtener_documento_salida'])->name('entrada_productos.obtener_documento_salida');

Route::get('entrada_productos/movimiento_pdf/{id}/{tipo_movimiento}', [EntradaProductosController::class, 'movimiento_pdf'])->name('entrada_productos.movimiento_pdf');

Route::get('entrada_productos/cargar_detalle/{id}/{tipo_movimiento}', [EntradaProductosController::class, 'cargar_detalle'])->name('entrada_productos.cargar_detalle');
Route::get('almacenes/cargar_usuario/{id}', [AlmacenesController::class, 'cargar_usuario'])->name('almacenes.cargar_usuario');
Route::get('secciones/cargar_anaqueles/{id}', [SeccionesController::class, 'cargar_anaqueles'])->name('secciones.cargar_anaqueles');

Route::get('orden_compra/create', [OrdenCompraController::class, 'create'])->name('orden_compra.create');
Route::post('orden_compra/listar_orden_compra_ajax', [OrdenCompraController::class, 'listar_orden_compra_ajax'])->name('orden_compra.listar_orden_compra_ajax');
Route::post('orden_compra/send_orden_compra', [OrdenCompraController::class, 'send_orden_compra'])->name('orden_compra.send_orden_compra');
Route::get('orden_compra/modal_orden_compra/{id}', [OrdenCompraController::class, 'modal_orden_compra'])->name('orden_compra.modal_orden_compra');
Route::get('orden_compra/eliminar_orden_compra/{id}/{estado}', [OrdenCompraController::class, 'eliminar_orden_compra'])->name('orden_compra.eliminar_orden_compra');
Route::get('orden_compra/cargar_detalle/{id}', [OrdenCompraController::class, 'cargar_detalle'])->name('orden_compra.cargar_detalle');
Route::get('orden_compra/cargar_detalle_abierto/{id}/{tipo_movimiento}', [OrdenCompraController::class, 'cargar_detalle_abierto'])->name('orden_compra.cargar_detalle_abierto');
Route::get('orden_compra/consulta_stock_pedido', [OrdenCompraController::class, 'consulta_stock_pedido'])->name('orden_compra.consulta_stock_pedido');
Route::get('orden_compra/modal_consulta_orden_compra/{id}', [OrdenCompraController::class, 'modal_consulta_orden_compra'])->name('orden_compra.modal_consulta_orden_compra');
Route::post('orden_compra/upload_orden_compra', [OrdenCompraController::class, 'upload_orden_compra'])->name('orden_compra.upload_orden_compra');
Route::get('orden_compra/obtener_orden_compra_id/{id}', [OrdenCompraController::class, 'obtener_orden_compra_id'])->name('orden_compra.obtener_orden_compra_id');
Route::get('orden_compra/obtener_orden_compra_persona_id/{id}', [OrdenCompraController::class, 'obtener_orden_compra_persona_id'])->name('orden_compra.obtener_orden_compra_persona_id');

Route::get('orden_compra/obtener_salida_prod_id/{id}', [OrdenCompraController::class, 'obtener_salida_prod_id'])->name('orden_compra.obtener_salida_prod_id');
Route::get('orden_compra/listar_salida_prod_det/{id}/{emp}', [OrdenCompraController::class, 'listar_salida_prod_det'])->name('orden_compra.listar_salida_prod_det');


Route::get('kardex/create', [KardexController::class, 'create'])->name('kardex.create');
Route::post('kardex/listar_kardex_ajax', [KardexController::class, 'listar_kardex_ajax'])->name('kardex.listar_kardex_ajax');

Route::get('entrada_productos/modal_detalle_producto_orden_compra/{id}/{tipo}', [EntradaProductosController::class, 'modal_detalle_producto_orden_compra'])->name('entrada_productos.modal_detalle_producto_orden_compra');
Route::get('orden_compra/movimiento_pdf/{id}', [OrdenCompraController::class, 'movimiento_pdf'])->name('orden_compra.movimiento_pdf');
Route::get('entrada_productos/modal_historial_entrada_producto/{id}/{id_tipo_documento}', [EntradaProductosController::class, 'modal_historial_entrada_producto'])->name('entrada_productos.modal_historial_entrada_producto');
Route::get('orden_compra/obtener_codigo_orden_compra/{tipo_documento}', [OrdenCompraController::class, 'obtener_codigo_orden_compra'])->name('orden_compra.obtener_codigo_orden_compra');
Route::get('entrada_productos/obtener_codigo_entrada_producto/{tipo_movimiento}/{tipo_documento}', [EntradaProductosController::class, 'obtener_codigo_entrada_producto'])->name('entrada_productos.obtener_codigo_entrada_producto');
Route::post('entrada_productos/send_entrada_producto_directo', [EntradaProductosController::class, 'send_entrada_producto_directo'])->name('entrada_productos.send_entrada_producto_directo');
Route::get('productos/obtener_producto_stock/{id_producto}/{tipo_movimiento}', [ProductosController::class, 'obtener_producto_stock'])->name('productos.obtener_producto_stock');
Route::get('entrada_productos/modal_detalle_producto_historial/{id}/{tipo}', [EntradaProductosController::class, 'modal_detalle_producto_historial'])->name('entrada_productos.modal_detalle_producto_historial');

Route::get('productos/obtener_producto_tipo_denominacion/{tipo}/{den}', [ProductosController::class, 'obtener_producto_tipo_denominacion'])->name('productos.obtener_producto_tipo_denominacion');

Route::get('kardex/create_consulta', [KardexController::class, 'create_consulta'])->name('kardex.create_consulta');
Route::post('kardex/listar_kardex_existencia_ajax', [KardexController::class, 'listar_kardex_existencia_ajax'])->name('kardex.listar_kardex_existencia_ajax');
Route::post('kardex/listar_kardex_existencia_producto_ajax', [KardexController::class, 'listar_kardex_existencia_producto_ajax'])->name('kardex.listar_kardex_existencia_producto_ajax');
Route::get('kardex/exportar_listar_existencia/{consulta_almacen}', [KardexController::class, 'exportar_listar_existencia'])->name('kardex.exportar_listar_existencia');
Route::get('kardex/exportar_listar_existencia_consulta_producto/{consulta_existencia_producto}/{consulta_almacen_producto}/{consulta_tipo_producto}/{cantidad_existencia_producto}', [KardexController::class, 'exportar_listar_existencia_consulta_producto'])->name('kardex.exportar_listar_existencia_consulta_producto');

Route::get('dispensacion/create', [DispensacionController::class, 'create'])->name('dispensacion.create');
Route::post('dispensacion/listar_dispensacion_ajax', [DispensacionController::class, 'listar_dispensacion_ajax'])->name('dispensacion.listar_dispensacion_ajax');
Route::post('dispensacion/send_dispensacion', [DispensacionController::class, 'send_dispensacion'])->name('dispensacion.send_dispensacion');
Route::get('dispensacion/modal_dispensacion/{id}', [DispensacionController::class, 'modal_dispensacion'])->name('dispensacion.modal_dispensacion');
Route::get('dispensacion/eliminar_dispensacion/{id}/{estado}', [DispensacionController::class, 'eliminar_dispensacion'])->name('dispensacion.eliminar_dispensacion');
Route::get('dispensacion/obtener_unidad_trabajo/{area_trabajo}', [DispensacionController::class, 'obtener_unidad_trabajo'])->name('dispensacion.obtener_unidad_trabajo');
Route::get('dispensacion/obtener_codigo_dispensacion/{tipo_documento}', [DispensacionController::class, 'obtener_codigo_dispensacion'])->name('dispensacion.obtener_codigo_dispensacion');
Route::get('dispensacion/cargar_detalle/{id}', [DispensacionController::class, 'cargar_detalle'])->name('dispensacion.cargar_detalle');
Route::get('productos/obtener_producto_almacen/{id_almacen}', [ProductosController::class, 'obtener_producto_almacen'])->name('productos.obtener_producto_almacen');
Route::get('entrada_productos/guia_electronica_pdf/{id}/{tipo_movimiento}', [EntradaProductosController::class, 'guia_electronica_pdf'])->name('entrada_productos.guia_electronica_pdf');
Route::get('dispensacion/movimiento_pdf_dispensacion/{id}', [DispensacionController::class, 'movimiento_pdf_dispensacion'])->name('dispensacion.movimiento_pdf_dispensacion');
Route::get('kardex/create_consulta_productos', [KardexController::class, 'create_consulta_productos'])->name('kardex.create_consulta_productos');
Route::post('kardex/listar_kardex_consulta_producto_ajax', [KardexController::class, 'listar_kardex_consulta_producto_ajax'])->name('kardex.listar_kardex_consulta_producto_ajax');
Route::get('productos/obtener_stock_producto/{almacen}/{id_producto}', [ProductosController::class, 'obtener_stock_producto'])->name('productos.obtener_stock_producto');

Route::get('orden_compra/modal_orden_compra_tienda/{id}', [OrdenCompraController::class, 'modal_orden_compra_tienda'])->name('orden_compra.modal_orden_compra_tienda');

Route::get('marcas/create', [MarcaController::class, 'create'])->name('marcas.create');
Route::post('marcas/listar_marca_ajax', [MarcaController::class, 'listar_marca_ajax'])->name('marcas.listar_marca_ajax');
Route::post('marcas/send_marca', [MarcaController::class, 'send_marca'])->name('marcas.send_marca');
Route::get('marcas/modal_marca/{id}', [MarcaController::class, 'modal_marca'])->name('marcas.modal_marca');
Route::get('marcas/eliminar_marca/{id}/{estado}', [MarcaController::class, 'eliminar_marca'])->name('marcas.eliminar_marca');

Route::get('tiendas/create', [TiendaController::class, 'create'])->name('tiendas.create');
Route::post('tiendas/listar_tienda_ajax', [TiendaController::class, 'listar_tienda_ajax'])->name('tiendas.listar_tienda_ajax');
Route::post('tiendas/send_tienda', [TiendaController::class, 'send_tienda'])->name('tiendas.send_tienda');
Route::get('tiendas/modal_tienda/{id}', [TiendaController::class, 'modal_tienda'])->name('tiendas.modal_tienda');
Route::get('tiendas/eliminar_tienda/{id}/{estado}', [TiendaController::class, 'eliminar_tienda'])->name('tiendas.eliminar_tienda');
Route::get('tiendas/obtener_datos_tienda/{empresa}', [TiendaController::class, 'obtener_datos_tienda'])->name('tiendas.obtener_datos_tienda');

Route::get('ingreso_produccion/create', [IngresoProduccionController::class, 'create'])->name('ingreso_produccion.create');
Route::post('ingreso_produccion/listar_ingreso_produccion_ajax', [IngresoProduccionController::class, 'listar_ingreso_produccion_ajax'])->name('ingreso_produccion.listar_ingreso_produccion_ajax');
Route::post('ingreso_produccion/send_ingreso_produccion', [IngresoProduccionController::class, 'send_ingreso_produccion'])->name('ingreso_produccion.send_ingreso_produccion');
Route::get('ingreso_produccion/modal_ingreso_produccion/{id}', [IngresoProduccionController::class, 'modal_ingreso_produccion'])->name('ingreso_produccion.modal_ingreso_produccion');
Route::get('ingreso_produccion/eliminar_ingreso_produccion/{id}/{estado}', [IngresoProduccionController::class, 'eliminar_ingreso_produccion'])->name('ingreso_produccion.eliminar_ingreso_produccion');
Route::get('ingreso_produccion/obtener_codigo_ingreso_produccion/{tipo_documento}', [IngresoProduccionController::class, 'obtener_codigo_ingreso_produccion'])->name('ingreso_produccion.obtener_codigo_ingreso_produccion');
Route::get('ingreso_produccion/cargar_detalle/{id}', [IngresoProduccionController::class, 'cargar_detalle'])->name('ingreso_produccion.cargar_detalle');
Route::get('orden_compra/modal_tiendas_orden_compra/{id}', [OrdenCompraController::class, 'modal_tiendas_orden_compra'])->name('orden_compra.modal_tiendas_orden_compra');
Route::post('orden_compra/send_tiendas_orden_compra', [OrdenCompraController::class, 'send_tiendas_orden_compra'])->name('orden_compra.send_tiendas_orden_compra');
Route::get('ingreso_produccion/movimiento_pdf_ingreso_produccion/{id}', [IngresoProduccionController::class, 'movimiento_pdf_ingreso_produccion'])->name('ingreso_produccion.movimiento_pdf_ingreso_produccion');
Route::get('orden_compra/cargar_detalle_tienda/{id}', [OrdenCompraController::class, 'cargar_detalle_tienda'])->name('orden_compra.cargar_detalle_tienda');

Route::get('requerimiento/create', [RequerimientoController::class, 'create'])->name('requerimiento.create');
Route::post('requerimiento/listar_requerimiento_ajax', [RequerimientoController::class, 'listar_requerimiento_ajax'])->name('requerimiento.listar_requerimiento_ajax');
Route::post('requerimiento/send_requerimiento', [RequerimientoController::class, 'send_requerimiento'])->name('requerimiento.send_requerimiento');
Route::get('requerimiento/modal_requerimiento/{id}', [RequerimientoController::class, 'modal_requerimiento'])->name('requerimiento.modal_requerimiento');
Route::get('requerimiento/eliminar_requerimiento/{id}/{estado}', [RequerimientoController::class, 'eliminar_requerimiento'])->name('requerimiento.eliminar_requerimiento');
Route::get('requerimiento/cargar_detalle/{id}', [RequerimientoController::class, 'cargar_detalle'])->name('requerimiento.cargar_detalle');
Route::get('requerimiento/obtener_codigo_requerimiento/{tipo_documento}', [RequerimientoController::class, 'obtener_codigo_requerimiento'])->name('requerimiento.obtener_codigo_requerimiento');
Route::get('requerimiento/movimiento_pdf_requerimiento/{id}', [RequerimientoController::class, 'movimiento_pdf_requerimiento'])->name('requerimiento.movimiento_pdf_requerimiento');

Route::post('productos/upload_producto', [ProductosController::class, 'upload_producto'])->name('productos.upload_producto');
Route::get('productos/modal_ver_productos/{id}', [ProductosController::class, 'modal_ver_productos'])->name('productos.modal_ver_productos');

Route::post('requerimiento/send_requerimiento_orden_compra', [RequerimientoController::class, 'send_requerimiento_orden_compra'])->name('requerimiento.send_requerimiento_orden_compra');
Route::get('entrada_productos/modal_datos_guia/{id}', [EntradaProductosController::class, 'modal_datos_guia'])->name('entrada_productos.modal_datos_guia');
Route::get('empresa/obtener_empresa_id/{id}', [EmpresaController::class, 'obtener_empresa_id'])->name('empresa.obtener_empresa_id');
Route::get('requerimiento/modal_atender_requerimiento/{id}', [RequerimientoController::class, 'modal_atender_requerimiento'])->name('requerimiento.modal_atender_requerimiento');

Route::get('guia_interna/create', [GuiaInternaController::class, 'create'])->name('guia_interna.create');
Route::post('guia_interna/listar_guia_interna_ajax', [GuiaInternaController::class, 'listar_guia_interna_ajax'])->name('guia_interna.listar_guia_interna_ajax');
Route::post('guia_interna/send_guia_interna', [GuiaInternaController::class, 'send_guia_interna'])->name('guia_interna.send_guia_interna');
Route::get('guia_interna/modal_guia_interna/{id}', [GuiaInternaController::class, 'modal_guia_interna'])->name('guia_interna.modal_guia_interna');
Route::get('guia_interna/eliminar_guia_interna/{id}/{estado}', [GuiaInternaController::class, 'eliminar_guia_interna'])->name('guia_interna.eliminar_guia_interna');
Route::get('entrada_productos/obtener_documentos/{tipo_documento}', [EntradaProductosController::class, 'obtener_documentos'])->name('entrada_productos.obtener_documentos');
Route::get('entrada_productos/cargar_detalle_documento/{tipo_documento}/{id_documento}', [EntradaProductosController::class, 'cargar_detalle_documento'])->name('entrada_productos.cargar_detalle_documento');

Route::get('vehiculo/create', [VehiculoController::class, 'create'])->name('vehiculo.create');
Route::get('vehiculo/consulta_vehiculo', [VehiculoController::class, 'consulta_vehiculo'])->name('vehiculo.consulta_vehiculo');
Route::post('vehiculo/listar_vehiculo_ajax', [VehiculoController::class, 'listar_vehiculo_ajax'])->name('vehiculo.listar_vehiculo_ajax');
Route::get('vehiculo/modal_vehiculo/{id}', [VehiculoController::class, 'modal_vehiculo'])->name('vehiculo.modal_vehiculo');
Route::get('vehiculo/eliminar_vehiculo/{id}/{estado}', [VehiculoController::class, 'eliminar_vehiculo'])->name('vehiculo.eliminar_vehiculo');
Route::post('vehiculo/send', [VehiculoController::class, 'send'])->name('vehiculo.send');
Route::post('vehiculo/send_mantenimiento', [VehiculoController::class, 'send_mantenimiento'])->name('vehiculo.send_mantenimiento');
Route::get('vehiculo/modal_vehiculo_guia/{id}', [VehiculoController::class, 'modal_vehiculo_guia'])->name('vehiculo.modal_vehiculo_guia');

Route::get('conductores/create', [ConductoresController::class, 'create'])->name('conductores.create');
Route::post('conductores/listar_conductor_ajax', [ConductoresController::class, 'listar_conductor_ajax'])->name('conductores.listar_conductor_ajax');
Route::get('conductores/modal_conductor_ingreso/{id}', [ConductoresController::class, 'modal_conductor_ingreso'])->name('conductores.modal_conductor_ingreso');
Route::get('conductores/eliminar_conductor/{id}/{estado}', [ConductoresController::class, 'eliminar_conductor'])->name('conductores.eliminar_conductor');
Route::post('conductores/send_conductor_ingreso', [ConductoresController::class, 'send_conductor_ingreso'])->name('conductores.send_conductor_ingreso');
Route::get('conductores/modal_conductor_guia/{id}/{id_empresa_conductor_vehiculo}', [ConductoresController::class, 'modal_conductor_guia'])->name('conductores.modal_conductor_guia');

Route::get('vehiculo/obtener_vehiculo/{placa}', [VehiculoController::class, 'obtener_vehiculo'])->name('vehiculo.obtener_vehiculo');
Route::get('empresa/modal_empresa_guia/{id}/{placa}/{id_empresa_conductor_vehiculo}', [EmpresaController::class, 'modal_empresa_guia'])->name('empresa.modal_empresa_guia');
Route::post('vehiculo/send_guia_mantenimiento', [VehiculoController::class, 'send_guia_mantenimiento'])->name('vehiculo.send_guia_mantenimiento');

Route::get('guia_interna/obtener_provincia_distrito/{idDepartamento}', [GuiaInternaController::class, 'obtener_provincia_distrito'])->name('guia_interna.obtener_provincia_distrito');
Route::post('empresa/send_guia', [EmpresaController::class, 'send_guia'])->name('empresa.send_guia');
Route::get('guia_interna/obtener_numero_guia/{serie_guia}', [GuiaInternaController::class, 'obtener_numero_guia'])->name('guia_interna.obtener_numero_guia');
Route::get('guia_interna/guia_interna_pdf/{id}', [GuiaInternaController::class, 'guia_interna_pdf'])->name('guia_interna.guia_interna_pdf');

Route::get('equivalencia_producto/create', [EquivalenciaProductosController::class, 'create'])->name('equivalencia_producto.create');
Route::post('equivalencia_producto/listar_equivalencia_producto_ajax', [EquivalenciaProductosController::class, 'listar_equivalencia_producto_ajax'])->name('equivalencia_producto.listar_equivalencia_producto_ajax');
Route::post('equivalencia_producto/send_equivalencia_producto', [EquivalenciaProductosController::class, 'send_equivalencia_producto'])->name('equivalencia_producto.send_equivalencia_producto');
Route::get('equivalencia_producto/modal_equivalencia_producto/{id}', [EquivalenciaProductosController::class, 'modal_equivalencia_producto'])->name('equivalencia_producto.modal_equivalencia_producto');
Route::get('equivalencia_producto/eliminar_equivalencia_producto/{id}/{estado}', [EquivalenciaProductosController::class, 'eliminar_equivalencia_producto'])->name('equivalencia_producto.eliminar_equivalencia_producto');

Route::get('ingreso_vehiculo_tronco/cubicaje_pdf/{id}', [IngresoVehiculoTroncoController::class, 'cubicaje_pdf'])->name('ingreso_vehiculo_tronco.cubicaje_pdf');

Route::get('ingreso_vehiculo_tronco/exportar_listar_pagos/{ruc}/{empresa}/{placa}/{tipo_madera}/{fecha_inicio}/{fecha_fin}/{estado_pago}', [IngresoVehiculoTroncoController::class, 'exportar_listar_pagos'])->name('ingreso_vehiculo_tronco.exportar_listar_pagos');

Route::get('requerimiento/exportar_listar_requerimiento/{tipo_documento}/{fecha}/{numero_requerimiento}/{almacen}/{situacion}/{responsable_atencion}/{estado_atencion}/{tipo_requerimiento}/{estado}/{producto}/{denominacion_producto}', [RequerimientoController::class, 'exportar_listar_requerimiento'])->name('requerimiento.exportar_listar_requerimiento');
Route::get('ingreso_vehiculo_tronco/obtener_datos_vehiculo_guia/{placa}', [IngresoVehiculoTroncoController::class, 'obtener_datos_vehiculo_guia'])->name('ingreso_vehiculo_tronco.obtener_datos_vehiculo_guia');
Route::get('conductores/obtener_licencia/{conductor}', [ConductoresController::class, 'obtener_licencia'])->name('conductores.obtener_licencia');
Route::post('conductores/send_conductor_guia', [ConductoresController::class, 'send_conductor_guia'])->name('conductores.send_conductor_guia');
Route::get('empresa/modal_nueva_empresa/{id}', [EmpresaController::class, 'modal_nueva_empresa'])->name('empresa.modal_nueva_empresa');
Route::get('empresa/obtener_empresas_all', [EmpresaController::class, 'obtener_empresas_all'])->name('empresa.obtener_empresas_all');
Route::get('conductores/modal_nuevo_conductor/{id}', [ConductoresController::class, 'modal_nuevo_conductor'])->name('conductores.modal_nuevo_conductor');
Route::post('conductores/send_conductor_nuevo', [ConductoresController::class, 'send_conductor_nuevo'])->name('conductores.send_conductor_nuevo');
Route::get('conductores/obtener_conductores_nuevos', [ConductoresController::class, 'obtener_conductores_nuevos'])->name('conductores.obtener_conductores_nuevos');

Route::get('orden_compra/importar_archivo/{archivo}', [OrdenCompraController::class, 'importar_archivo'])->name('orden_compra.importar_archivo');

Route::get('parametro/create', [ParametroController::class, 'create'])->name('parametro.create');
Route::post('parametro/listar_parametros_ajax', [ParametroController::class, 'listar_parametros_ajax'])->name('parametro.listar_parametros_ajax');
Route::post('parametro/send_parametro', [ParametroController::class, 'send_parametro'])->name('parametro.send_parametro');
Route::get('parametro/modal_parametro/{id}', [ParametroController::class, 'modal_parametro'])->name('parametro.modal_parametro');
Route::get('parametro/eliminar_parametro/{id}/{estado}', [ParametroController::class, 'eliminar_parametro'])->name('parametro.eliminar_parametro');
Route::get('parametro/create_valida_parametro', [ParametroController::class, 'create_valida_parametro'])->name('parametro.create_valida_parametro');
Route::post('parametro/listar_total_orden_compra_tienda_ajax', [ParametroController::class, 'listar_total_orden_compra_tienda_ajax'])->name('parametro.listar_total_orden_compra_tienda_ajax');
Route::get('parametro/cargar_parametro_orden_compra/{id}', [ParametroController::class, 'cargar_parametro_orden_compra'])->name('parametro.cargar_parametro_orden_compra');
Route::get('orden_compra/obtener_entrada_salida/{id_orden_compra}/{tipo_documento}', [OrdenCompraController::class, 'obtener_entrada_salida'])->name('orden_compra.obtener_entrada_salida');
Route::get('vehiculo/obtener_vehiculo_guia/{placa}', [VehiculoController::class, 'obtener_vehiculo_guia'])->name('vehiculo.obtener_vehiculo_guia');
Route::get('orden_compra/exportar_listar_orden_compra/{tipo_documento}/{empresa_compra}/{empresa_vende}/{fecha_inicio}/{fecha_fin}/{numero_orden_compra}/{numero_orden_compra_cliente}/{almacen_origen}/{almacen_destino}/{situacion}/{estado}/{vendedor}/{estado_pedido}/{prioridad}', [OrdenCompraController::class, 'exportar_listar_orden_compra'])->name('orden_compra.exportar_listar_orden_compra');

Route::get('empaquetado/create', [EmpaquetadoController::class, 'create'])->name('empaquetado.create');
Route::post('empaquetado/listar_empaquetados_ajax', [EmpaquetadoController::class, 'listar_empaquetados_ajax'])->name('empaquetado.listar_empaquetados_ajax');
Route::post('empaquetado/send_empaquetado', [EmpaquetadoController::class, 'send_empaquetado'])->name('empaquetado.send_empaquetado');
Route::get('empaquetado/modal_empaquetado/{id}', [EmpaquetadoController::class, 'modal_empaquetado'])->name('empaquetado.modal_empaquetado');
Route::get('empaquetado/eliminar_empaquetado/{id}/{estado}', [EmpaquetadoController::class, 'eliminar_empaquetado'])->name('empaquetado.eliminar_empaquetado');
Route::get('empaquetado/obtener_codigo_empaquetado', [EmpaquetadoController::class, 'obtener_codigo_empaquetado'])->name('empaquetado.obtener_codigo_empaquetado');
Route::get('empaquetado/cargar_detalle/{id}', [EmpaquetadoController::class, 'cargar_detalle'])->name('empaquetado.cargar_detalle');
Route::get('empaquetado/create_empaquetado', [EmpaquetadoController::class, 'create_empaquetado'])->name('empaquetado.create_empaquetado');
Route::get('empaquetado/modal_empaquetado_operacion/{id}', [EmpaquetadoController::class, 'modal_empaquetado_operacion'])->name('empaquetado.modal_empaquetado_operacion');
Route::get('empaquetado/obtenerDetalle/{id_producto}', [EmpaquetadoController::class, 'obtenerDetalle'])->name('empaquetado.obtenerDetalle');
Route::post('empaquetado/send_operacion_empaquetado', [EmpaquetadoController::class, 'send_operacion_empaquetado'])->name('empaquetado.send_operacion_empaquetado');
Route::post('empaquetado/listar_operacion_empaquetados_ajax', [EmpaquetadoController::class, 'listar_operacion_empaquetados_ajax'])->name('empaquetado.listar_operacion_empaquetados_ajax');
Route::get('empaquetado/obtener_codigo_operacion_empaquetado', [EmpaquetadoController::class, 'obtener_codigo_operacion_empaquetado'])->name('empaquetado.obtener_codigo_operacion_empaquetado');
Route::get('empaquetado/modal_consulta_empaquetado_operacion/{id}', [EmpaquetadoController::class, 'modal_consulta_empaquetado_operacion'])->name('empaquetado.modal_consulta_empaquetado_operacion');
Route::get('empaquetado/cargar_operacion_detalle/{id}', [EmpaquetadoController::class, 'cargar_operacion_detalle'])->name('empaquetado.cargar_operacion_detalle');
Route::post('comprobante/listar_comprobante_sodimac_ajax', [ComprobanteController::class, 'listar_comprobante_sodimac_ajax'])->name('comprobante.listar_comprobante_sodimac_ajax');
Route::get('comprobante/exportar_factura_sodimac/{fecha_ini}/{fecha_fin}/{tipo_documento}/{serie}/{numero}', [ComprobanteController::class, 'exportar_factura_sodimac'])->name('comprobante.exportar_factura_sodimac');

Route::get('devolucion/create', [DevolucionController::class, 'create'])->name('devolucion.create');
Route::post('devolucion/listar_devolucion_ajax', [DevolucionController::class, 'listar_devolucion_ajax'])->name('devolucion.listar_devolucion_ajax');
Route::post('devolucion/send_devolucion', [DevolucionController::class, 'send_devolucion'])->name('devolucion.send_devolucion');
Route::get('devolucion/modal_devolucion/{id}/{id_tipo_documento}', [DevolucionController::class, 'modal_devolucion'])->name('devolucion.modal_devolucion');
Route::get('devolucion/cargar_salida/{numero_salida}', [DevolucionController::class, 'cargar_salida'])->name('devolucion.cargar_salida');
Route::get('devolucion/cargar_detalle/{id}/{id_tipo_documento}', [DevolucionController::class, 'cargar_detalle'])->name('devolucion.cargar_detalle');

Route::get('productos/exportar_listar_productos/{tipo_origen_producto}/{serie}/{codigo}/{denominacion}/{estado_bien}/{tipo_producto}/{tiene_imagen}/{estado}', [ProductosController::class, 'exportar_listar_productos'])->name('orden_compra.exportar_listar_productos');
Route::get('orden_compra/modal_datos_pedido_orden_compra/{id}', [OrdenCompraController::class, 'modal_datos_pedido_orden_compra'])->name('orden_compra.modal_datos_pedido_orden_compra');
Route::post('orden_compra/send_datos_contacto', [OrdenCompraController::class, 'send_datos_contacto'])->name('orden_compra.send_datos_contacto');
Route::get('orden_compra/obtener_provincia_distrito/{idDepartamento}', [OrdenCompraController::class, 'obtener_provincia_distrito'])->name('orden_compra.obtener_provincia_distrito');
Route::get('tienda/obtener_provincia_distrito/{idDepartamento}', [TiendaController::class, 'obtener_provincia_distrito'])->name('tienda.obtener_provincia_distrito');
Route::get('ingreso_vehiculo_tronco/reporte_pagos', [IngresoVehiculoTroncoController::class, 'reporte_pagos'])->name('ingreso_vehiculo_tronco.reporte_pagos');
Route::post('ingreso_vehiculo_tronco/listar_ingreso_vehiculo_tronco_reporte_ajax', [IngresoVehiculoTroncoController::class, 'listar_ingreso_vehiculo_tronco_reporte_ajax'])->name('ingreso_vehiculo_tronco.listar_ingreso_vehiculo_tronco_reporte_ajax');
Route::post('ingreso_vehiculo_tronco/listar_ingreso_vehiculo_tronco_reporte_pago_ajax', [IngresoVehiculoTroncoController::class, 'listar_ingreso_vehiculo_tronco_reporte_pago_ajax'])->name('ingreso_vehiculo_tronco.listar_ingreso_vehiculo_tronco_reporte_pago_ajax');
Route::get('ingreso_vehiculo_tronco/exportar_reporte_cubicaje/{fecha_inicio}/{fecha_fin}/{tipo_empresa}', [IngresoVehiculoTroncoController::class, 'exportar_reporte_cubicaje'])->name('ingreso_vehiculo_tronco.exportar_reporte_cubicaje');
Route::get('ingreso_vehiculo_tronco/exportar_reporte_pago/{fecha_inicio}/{fecha_fin}/{tipo_empresa}', [IngresoVehiculoTroncoController::class, 'exportar_reporte_pago'])->name('ingreso_vehiculo_tronco.exportar_reporte_pago');
Route::get('orden_compra/generar_lpn/{id_orden_compra}', [OrdenCompraController::class, 'generar_lpn'])->name('orden_compra.generar_lpn');
Route::get('orden_compra/create_reporte_comercializacion', [OrdenCompraController::class, 'create_reporte_comercializacion'])->name('orden_compra.create_reporte_comercializacion');
Route::post('orden_compra/listar_reporte_comercializacion_ajax', [OrdenCompraController::class, 'listar_reporte_comercializacion_ajax'])->name('orden_compra.listar_reporte_comercializacion_ajax');
Route::get('orden_compra/exportar_reporte_comercializacion/{empresa_compra}/{fecha_inicio}/{fecha_fin}/{numero_orden_compra_cliente}/{situacion}/{codigo_producto}/{producto}/{vendedor}/{estado_pedido}', [OrdenCompraController::class, 'exportar_reporte_comercializacion'])->name('orden_compra.exportar_reporte_comercializacion');
Route::get('requerimiento/exportar_listar_requerimiento_reporte/{tipo_documento}/{fecha}/{numero_requerimiento}/{almacen}/{situacion}/{responsable_atencion}/{estado_atencion}/{tipo_requerimiento}/{estado}/{producto}/{denominacion_producto}', [RequerimientoController::class, 'exportar_listar_requerimiento_reporte'])->name('requerimiento.exportar_listar_requerimiento_reporte');
Route::post('orden_compra/upload_orden_distribucion', [OrdenCompraController::class, 'upload_orden_distribucion'])->name('orden_compra.upload_orden_distribucion');
Route::post('comprobante/listar_factura_sodimac_ajax', [ComprobanteController::class, 'listar_factura_sodimac_ajax'])->name('comprobante.listar_factura_sodimac_ajax');
Route::get('comprobante/modal_factura_sodimac_detalle/{id}', [ComprobanteController::class, 'modal_factura_sodimac_detalle'])->name('comprobante.modal_factura_sodimac_detalle');
Route::post('comprobante/upload_factura_sodimac', [ComprobanteController::class, 'upload_factura_sodimac'])->name('comprobante.upload_factura_sodimac');
Route::get('comprobante/importar_archivo/{archivo}', [ComprobanteController::class, 'importar_archivo'])->name('comprobante.importar_archivo');
Route::post('comprobante/listar_factura_sodimac_pagos_ajax', [ComprobanteController::class, 'listar_factura_sodimac_pagos_ajax'])->name('comprobante.listar_factura_sodimac_pagos_ajax');
Route::get('comprobante/modal_factura_historico/{id}', [ComprobanteController::class, 'modal_factura_historico'])->name('comprobante.modal_factura_historico');
Route::post('comprobante/send_factura_historico', [ComprobanteController::class, 'send_factura_historico'])->name('comprobante.send_factura_historico');
Route::get('orden_compra/create_reporte_comercializacion_tienda', [OrdenCompraController::class, 'create_reporte_comercializacion_tienda'])->name('orden_compra.create_reporte_comercializacion_tienda');
Route::post('orden_compra/listar_reporte_comercializacion_tienda_ajax', [OrdenCompraController::class, 'listar_reporte_comercializacion_tienda_ajax'])->name('orden_compra.listar_reporte_comercializacion_tienda_ajax');
Route::get('orden_compra/exportar_reporte_comercializacion_tienda/{empresa_compra}/{fecha_inicio}/{fecha_fin}/{numero_orden_compra_cliente}/{producto}/{tienda}', [OrdenCompraController::class, 'exportar_reporte_comercializacion_tienda'])->name('orden_compra.exportar_reporte_comercializacion_tienda');
Route::get('entrada_productos/create_ajuste_stock', [EntradaProductosController::class, 'create_ajuste_stock'])->name('entrada_productos.create_ajuste_stock');
Route::post('entrada_productos/listar_ajuste_stock_ajax', [EntradaProductosController::class, 'listar_ajuste_stock_ajax'])->name('entrada_productos.listar_ajuste_stock_ajax');
Route::post('entrada_productos/send_ajuste_stock', [EntradaProductosController::class, 'send_ajuste_stock'])->name('entrada_productos.send_ajuste_stock');
Route::get('entrada_productos/modal_ajuste_stock/{id}', [EntradaProductosController::class, 'modal_ajuste_stock'])->name('entrada_productos.modal_ajuste_stock');
Route::get('orden_compra/modal_anular_orden_compra/{id}', [OrdenCompraController::class, 'modal_anular_orden_compra'])->name('orden_compra.modal_anular_orden_compra');
Route::post('orden_compra/anular_orden_compra', [OrdenCompraController::class, 'anular_orden_compra'])->name('orden_compra.anular_orden_compra');
Route::post('ingreso_vehiculo_tronco/upload_cubicaje', [IngresoVehiculoTroncoController::class, 'upload_cubicaje'])->name('ingreso_vehiculo_tronco.upload_cubicaje');
Route::get('comprobante/exportar_listar_pagos_sodimac/{fecha_ini}/{fecha_fin}/{tipo_documento}/{serie}/{numero}/{estado_pago}/{observacion_pago}/{dias_pagado}/{color}/{anulado}/{empresa}', [ComprobanteController::class, 'exportar_listar_pagos_sodimac'])->name('comprobante.exportar_listar_pagos_sodimac');
Route::get('promotores/create_ruta', [PromotorController::class, 'create_ruta'])->name('promotores.create_ruta');
Route::get('promotores/modal_promotor_ruta/{id}', [PromotorController::class, 'modal_promotor_ruta'])->name('promotores.modal_promotor_ruta');
Route::get('kardex/exportar_listar_consulta_kardex/{almacen}/{producto}/{fecha_inicio}/{fecha_fin}', [KardexController::class, 'exportar_listar_consulta_kardex'])->name('kardex.exportar_listar_consulta_kardex');
Route::get('orden_compra/create_pago_orden_compra', [OrdenCompraController::class, 'create_pago_orden_compra'])->name('orden_compra.create_pago_orden_compra');
Route::get('orden_compra/modal_pago/{id}/{id_orden_compra}', [OrdenCompraController::class, 'modal_pago'])->name('orden_compra.modal_pago');
Route::post('orden_compra/listar_orden_compra_pagos_ajax', [OrdenCompraController::class, 'listar_orden_compra_pagos_ajax'])->name('orden_compra.listar_orden_compra_pagos_ajax');
Route::get('orden_compra/cargar_pago_orden_compra/{id}', [OrdenCompraController::class, 'cargar_pago_orden_compra'])->name('orden_compra.cargar_pago_orden_compra');
Route::post('orden_compra/send_pago', [OrdenCompraController::class, 'send_pago'])->name('orden_compra.send_pago');
Route::post('orden_compra/upload_pago', [OrdenCompraController::class, 'upload_pago'])->name('orden_compra.upload_pago');
Route::get('orden_compra/create_reporte_comercializacion_solicitado_tienda', [OrdenCompraController::class, 'create_reporte_comercializacion_solicitado_tienda'])->name('orden_compra.create_reporte_comercializacion_solicitado_tienda');
Route::post('orden_compra/listar_reporte_comercializacion_solicitado_tienda_ajax', [OrdenCompraController::class, 'listar_reporte_comercializacion_solicitado_tienda_ajax'])->name('orden_compra.listar_reporte_comercializacion_solicitado_tienda_ajax');
Route::get('orden_compra/exportar_reporte_comercializacion_solicitado_tienda/{empresa_compra}/{fecha_inicio}/{fecha_fin}/{numero_orden_compra_cliente}/{producto}/{tienda}', [OrdenCompraController::class, 'exportar_reporte_comercializacion_solicitado_tienda'])->name('orden_compra.exportar_reporte_comercializacion_solicitado_tienda');
Route::get('requerimiento/modal_control_requerimiento/{id}', [RequerimientoController::class, 'modal_control_requerimiento'])->name('requerimiento.modal_control_requerimiento');
Route::get('requerimiento/cargar_detalle_control/{id}', [RequerimientoController::class, 'cargar_detalle_control'])->name('requerimiento.cargar_detalle_control');
Route::get('requerimiento/cargar_detalle_abierto/{id}', [RequerimientoController::class, 'cargar_detalle_abierto'])->name('requerimiento.cargar_detalle_abierto');
Route::post('requerimiento/send_genera_requerimiento', [RequerimientoController::class, 'send_genera_requerimiento'])->name('requerimiento.send_genera_requerimiento');
Route::get('orden_compra/cargar_guia_orden_compra/{id}', [OrdenCompraController::class, 'cargar_guia_orden_compra'])->name('orden_compra.cargar_guia_orden_compra');
Route::get('orden_compra/modal_guia/{id}/{id_orden_compra}', [OrdenCompraController::class, 'modal_guia'])->name('orden_compra.modal_guia');
Route::post('orden_compra/upload_guia', [OrdenCompraController::class, 'upload_guia'])->name('orden_compra.upload_guia');
Route::post('orden_compra/send_orden_compra_guia', [OrdenCompraController::class, 'send_orden_compra_guia'])->name('orden_compra.send_orden_compra_guia');
Route::get('orden_compra/eliminar_pago/{id}', [OrdenCompraController::class, 'eliminar_pago'])->name('orden_compra.eliminar_pago');
Route::get('dispensacion/exportar_listar_dispensacion_reporte/{tipo_documento}/{fecha_inicio}/{fecha_fin}/{numero_dispensacion}/{almacen}/{area_trabajo}/{unidad_trabajo}/{persona_recibe}/{estado}', [DispensacionController::class, 'exportar_listar_dispensacion_reporte'])->name('dispensacion.exportar_listar_dispensacion_reporte');
Route::get('requerimiento/movimiento_pdf_requerimiento_control/{id}', [RequerimientoController::class, 'movimiento_pdf_requerimiento_control'])->name('requerimiento.movimiento_pdf_requerimiento_control');
Route::get('empresa_cubicaje/create', [EmpresaCubicajeController::class, 'create'])->name('empresa_cubicaje.create');
Route::post('empresa_cubicaje/listar_empresa_cubicaje_ajax', [EmpresaCubicajeController::class, 'listar_empresa_cubicaje_ajax'])->name('empresa_cubicaje.listar_empresa_cubicaje_ajax');
Route::post('empresa_cubicaje/send_empresa_cubicaje', [EmpresaCubicajeController::class, 'send_empresa_cubicaje'])->name('empresa_cubicaje.send_empresa_cubicaje');
Route::get('empresa_cubicaje/modal_empresa_cubicaje/{id}', [EmpresaCubicajeController::class, 'modal_empresa_cubicaje'])->name('empresa_cubicaje.modal_empresa_cubicaje');
Route::get('empresa_cubicaje/eliminar_empresa_cubicaje/{id}/{estado}', [EmpresaCubicajeController::class, 'eliminar_empresa_cubicaje'])->name('empresa_cubicaje.eliminar_empresa_cubicaje');
Route::get('kardex/create_consulta_productos_orden_compra', [KardexController::class, 'create_consulta_productos_orden_compra'])->name('kardex.create_consulta_productos_orden_compra');
Route::post('kardex/listar_kardex_consulta_producto_orden_compra_ajax', [KardexController::class, 'listar_kardex_consulta_producto_orden_compra_ajax'])->name('kardex.listar_kardex_consulta_producto_orden_compra_ajax');
Route::get('kardex/exportar_listar_consulta_producto_oc/{consulta_oc_existencia_producto}/{consulta_oc_almacen_producto}/{consulta_oc_empresa}', [KardexController::class, 'exportar_listar_consulta_producto_oc'])->name('kardex.exportar_listar_consulta_producto_oc');
Route::get('orden_compra/exportar_listar_pagos_orden_compra/{empresa}/{persona}/{fecha_inicio}/{fecha_fin}/{estado_pago}', [OrdenCompraController::class, 'exportar_listar_pagos_orden_compra'])->name('orden_compra.exportar_listar_pagos_orden_compra');
Route::get('ingreso_produccion/exportar_listar_ingreso_produccion/{tipo_documento}/{fecha}/{numero_ingreso_produccion}/{almacen_destino}/{area}/{estado}', [IngresoProduccionController::class, 'exportar_listar_ingreso_produccion'])->name('ingreso_produccion.exportar_listar_ingreso_produccion');
Route::get('requerimiento/modal_observacion/{id}', [RequerimientoController::class, 'modal_observacion'])->name('requerimiento.modal_observacion');
Route::post('requerimiento/send_observacion_requerimiento', [RequerimientoController::class, 'send_observacion_requerimiento'])->name('requerimiento.send_observacion_requerimiento');
Route::get('requerimiento/modal_cerrar_antiguedad/{id}', [RequerimientoController::class, 'modal_cerrar_antiguedad'])->name('requerimiento.modal_cerrar_antiguedad');
Route::post('requerimiento/send_cerrar_antiguedad_requerimiento', [RequerimientoController::class, 'send_cerrar_antiguedad_requerimiento'])->name('requerimiento.send_cerrar_antiguedad_requerimiento');
Route::get('ingreso_vehiculo_tronco/exportar_listar_reporte_anual/{placa}/{ruc}/{anio}', [IngresoVehiculoTroncoController::class, 'exportar_listar_reporte_anual'])->name('ingreso_vehiculo_tronco.exportar_listar_reporte_anual');
Route::get('tipo_cambio/obtenerUltimoTipoCambio', [TipoCambioController::class, 'obtenerUltimoTipoCambio'])->name('tipo_cambio.obtenerUltimoTipoCambio');
Route::get('acerrado_madera/create', [AcerradoMaderaController::class, 'create'])->name('acerrado_madera.create');
Route::post('acerrado_madera/listar_ingreso_produccion_acerrado_madera_ajax', [AcerradoMaderaController::class, 'listar_ingreso_produccion_acerrado_madera_ajax'])->name('acerrado_madera.listar_ingreso_produccion_acerrado_madera_ajax');
Route::post('acerrado_madera/listar_produccion_acerrado_madera_ajax', [AcerradoMaderaController::class, 'listar_produccion_acerrado_madera_ajax'])->name('acerrado_madera.listar_produccion_acerrado_madera_ajax');
Route::get('acerrado_madera/modal_ingreso_acerrado_madera/{id}', [AcerradoMaderaController::class, 'modal_ingreso_acerrado_madera'])->name('acerrado_madera.modal_ingreso_acerrado_madera');
Route::post('acerrado_madera/send_ingreso_produccion_acerrado_madera', [AcerradoMaderaController::class, 'send_ingreso_produccion_acerrado_madera'])->name('acerrado_madera.send_ingreso_produccion_acerrado_madera');
Route::post('acerrado_madera/send_produccion_acerrado_madera', [AcerradoMaderaController::class, 'send_produccion_acerrado_madera'])->name('acerrado_madera.send_produccion_acerrado_madera');
Route::get('acerrado_madera/cargar_detalle_ingreso_vehiculo_acerrado', [AcerradoMaderaController::class, 'cargar_detalle_ingreso_vehiculo_acerrado'])->name('acerrado_madera.cargar_detalle_ingreso_vehiculo_acerrado');
Route::get('acerrado_madera/modal_salida_acerrado_madera/{id}', [AcerradoMaderaController::class, 'modal_salida_acerrado_madera'])->name('acerrado_madera.modal_salida_acerrado_madera');
Route::get('horno/create', [HornoController::class, 'create'])->name('horno.create');
Route::post('horno/listar_ingreso_horno_ajax', [HornoController::class, 'listar_ingreso_horno_ajax'])->name('horno.listar_ingreso_horno_ajax');
Route::get('horno/modal_ingreso_horno/{id}', [HornoController::class, 'modal_ingreso_horno'])->name('horno.modal_ingreso_horno');
Route::post('horno/send_ingreso_horno', [HornoController::class, 'send_ingreso_horno'])->name('horno.send_ingreso_horno');
Route::get('horno/cargar_detalle_acerrado', [HornoController::class, 'cargar_detalle_acerrado'])->name('horno.cargar_detalle_acerrado');
Route::get('horno/modal_salida_horno/{id}', [HornoController::class, 'modal_salida_horno'])->name('horno.modal_salida_horno');
Route::get('orden_compra/create_control_produccion', [OrdenCompraController::class, 'create_control_produccion'])->name('orden_compra.create_control_produccion');
Route::post('orden_compra/listar_orden_compra_control_produccion_ajax', [OrdenCompraController::class, 'listar_orden_compra_control_produccion_ajax'])->name('orden_compra.listar_orden_compra_control_produccion_ajax');
Route::get('orden_compra/modal_orden_compra_control_produccion/{id}', [OrdenCompraController::class, 'modal_orden_compra_control_produccion'])->name('orden_compra.modal_orden_compra_control_produccion');
Route::get('activos/create', [ActivoController::class, 'create'])->name('activos.create');
Route::get('activos/create_activo', [ActivoController::class, 'create_activo'])->name('activos.create_activo');
Route::post('activos/listar_activos_ajax', [ActivoController::class, 'listar_activos_ajax'])->name('activos.listar_activos_ajax');
Route::get('activos/modal_activos_horno/{id}', [ActivoController::class, 'modal_activos_horno'])->name('activos.modal_activos_horno');
Route::post('activos/send_activo', [ActivoController::class, 'send_activo'])->name('activos.send_activo');
Route::get('activos/obtener_provincia_distrito/{idDepartamento}', [ActivoController::class, 'obtener_provincia_distrito'])->name('activos.obtener_provincia_distrito');
Route::get('activos/eliminar_activo/{id}/{estado}', [ActivoController::class, 'eliminar_activo'])->name('activos.eliminar_activo');
Route::post('activos/upload_activo', [ActivoController::class, 'upload_activo'])->name('activos.upload_activo');
Route::get('ingreso_vehiculo_tronco/exportar_listar_cubicaje_excel/{id}', [IngresoVehiculoTroncoController::class, 'exportar_listar_cubicaje_excel'])->name('ingreso_vehiculo_tronco.exportar_listar_cubicaje_excel');
Route::get('orden_compra/cargar_detalle_control_produccion/{id}', [OrdenCompraController::class, 'cargar_detalle_control_produccion'])->name('orden_compra.cargar_detalle_control_produccion');
Route::get('orden_compra/send_comprometer_stock/{id_orden_compra_detalle}', [OrdenCompraController::class, 'send_comprometer_stock'])->name('orden_compra.send_comprometer_stock');
Route::get('orden_produccion/create_orden_produccion', [OrdenProduccionController::class, 'create_orden_produccion'])->name('orden_produccion.create_orden_produccion');
Route::post('orden_produccion/listar_orden_produccion_ajax', [OrdenProduccionController::class, 'listar_orden_produccion_ajax'])->name('orden_produccion.listar_orden_produccion_ajax');
Route::get('orden_produccion/modal_orden_produccion/{id}', [OrdenProduccionController::class, 'modal_orden_produccion'])->name('orden_produccion.modal_orden_produccion');
Route::post('orden_produccion/send_orden_produccion', [OrdenProduccionController::class, 'send_orden_produccion'])->name('orden_produccion.send_orden_produccion');
Route::get('orden_produccion/cargar_detalle', [OrdenProduccionController::class, 'cargar_detalle'])->name('orden_produccion.cargar_detalle');
Route::get('orden_produccion/cargar_detalle_guardado/{id}', [OrdenProduccionController::class, 'cargar_detalle_guardado'])->name('orden_produccion.cargar_detalle_guardado');

Route::get('familia/create', [FamiliaController::class, 'create'])->name('familia.create');
Route::post('familia/listar_familia_ajax', [FamiliaController::class, 'listar_familia_ajax'])->name('familia.listar_familia_ajax');
Route::get('familia/modal_familia/{id}', [FamiliaController::class, 'modal_familia'])->name('familia.modal_familia');
Route::post('familia/send_familia', [FamiliaController::class, 'send_familia'])->name('familia.send_familia');
Route::get('familia/eliminar_familia/{id}/{estado}', [FamiliaController::class, 'eliminar_familia'])->name('familia.eliminar_familia');
Route::get('sub_familia/create', [SubFamiliaController::class, 'create'])->name('sub_familia.create');
Route::post('sub_familia/listar_sub_familia_ajax', [SubFamiliaController::class, 'listar_sub_familia_ajax'])->name('sub_familia.listar_sub_familia_ajax');
Route::get('sub_familia/modal_sub_familia/{id}', [SubFamiliaController::class, 'modal_sub_familia'])->name('sub_familia.modal_sub_familia');
Route::post('sub_familia/send_sub_familia', [SubFamiliaController::class, 'send_sub_familia'])->name('sub_familia.send_sub_familia');
Route::get('sub_familia/eliminar_sub_familia/{id}/{estado}', [SubFamiliaController::class, 'eliminar_sub_familia'])->name('sub_familia.eliminar_sub_familia');
Route::get('sub_familia/valida_codigo_unico/{inicial}', [SubFamiliaController::class, 'valida_codigo_unico'])->name('sub_familia.valida_codigo_unico');
Route::get('sub_familia/obtener_sub_familia/{familia}', [SubFamiliaController::class, 'obtener_sub_familia'])->name('sub_familia.obtener_sub_familia');
Route::get('sub_familia/obtener_codigo/{sub_familia}', [SubFamiliaController::class, 'obtener_codigo'])->name('sub_familia.obtener_codigo');
Route::get('activos/modal_soat_activo/{id}', [ActivoController::class, 'modal_soat_activo'])->name('activos.modal_soat_activo');
Route::get('activos/modal_revision_tecnica_activo/{id}', [ActivoController::class, 'modal_revision_tecnica_activo'])->name('activos.modal_revision_tecnica_activo');
Route::get('activos/modal_control_mantenimiento_activo/{id}', [ActivoController::class, 'modal_control_mantenimiento_activo'])->name('activos.modal_control_mantenimiento_activo');
Route::get('activos/eliminar_soat_activo/{id}/{estado}', [ActivoController::class, 'eliminar_soat_activo'])->name('activos.eliminar_soat_activo');
Route::get('activos/eliminar_revision_tecnica_activo/{id}/{estado}', [ActivoController::class, 'eliminar_revision_tecnica_activo'])->name('activos.eliminar_revision_tecnica_activo');
Route::get('activos/eliminar_control_mantenimiento_activo/{id}/{estado}', [ActivoController::class, 'eliminar_control_mantenimiento_activo'])->name('activos.eliminar_control_mantenimiento_activo');
Route::post('activos/send', [ActivoController::class, 'send'])->name('activos.send');
Route::post('activos/send_soat_activo', [ActivoController::class, 'send_soat_activo'])->name('activos.send_soat_activo');
Route::post('activos/send_revision_tecnica_activo', [ActivoController::class, 'send_revision_tecnica_activo'])->name('activos.send_revision_tecnica_activo');
Route::post('activos/send_control_mantenimiento_activo', [ActivoController::class, 'send_control_mantenimiento_activo'])->name('activos.send_control_mantenimiento_activo');
Route::get('activos/editar_activo/{id}', [ActivoController::class, 'editar_activo'])->name('activos.editar_activo');
Route::get('orden_compra/obtener_orden_compra_matriz/{numero_orden_compra_matriz}', [OrdenCompraController::class, 'obtener_orden_compra_matriz'])->name('orden_compra.obtener_orden_compra_matriz');
Route::get('orden_produccion/movimiento_pdf/{id}', [OrdenProduccionController::class, 'movimiento_pdf'])->name('orden_produccion.movimiento_pdf');
Route::get('orden_produccion/modal_atender_orden_produccion/{id}', [OrdenProduccionController::class, 'modal_atender_orden_produccion'])->name('orden_produccion.modal_atender_orden_produccion');
Route::get('orden_produccion/cargar_detalle_orden_produccion/{id}', [OrdenProduccionController::class, 'cargar_detalle_orden_produccion'])->name('orden_produccion.cargar_detalle_orden_produccion');
Route::post('orden_produccion/send_orden_produccion_orden_compra', [OrdenProduccionController::class, 'send_orden_produccion_orden_compra'])->name('orden_produccion.send_orden_produccion_orden_compra');
Route::get('orden_compra/send_comprometer_stock_total/{id}', [OrdenCompraController::class, 'send_comprometer_stock_total'])->name('orden_compra.send_comprometer_stock_total');
Route::get('orden_produccion/modal_orden_produccion_planeamiento/{id}', [OrdenProduccionController::class, 'modal_orden_produccion_planeamiento'])->name('orden_produccion.modal_orden_produccion_planeamiento');
Route::get('orden_produccion/exportar_listar_orden_produccion/{id}', [OrdenProduccionController::class, 'exportar_listar_orden_produccion'])->name('orden_produccion.exportar_listar_orden_produccion');
Route::get('orden_produccion/movimiento_pdf_detallado/{id}', [OrdenProduccionController::class, 'movimiento_pdf_detallado'])->name('orden_produccion.movimiento_pdf_detallado');
Route::get('orden_produccion/cerrar_orden_produccion/{id}', [OrdenProduccionController::class, 'cerrar_orden_produccion'])->name('orden_produccion.cerrar_orden_produccion');
