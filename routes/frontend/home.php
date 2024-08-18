<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\TermsController;
use Tabuna\Breadcrumbs\Trail;

use App\Http\Controllers\Frontend\IngresoVehiculoTroncoController;
use App\Http\Controllers\TablaMaestraController;
use App\Http\Controllers\Frontend\PersonaController;
use App\Http\Controllers\Frontend\EmpresaController;
use App\Http\Controllers\Frontend\VehiculoController;

use App\Http\Controllers\Frontend\IngresoController;
use App\Http\Controllers\Frontend\TipoCambioController;
use App\Http\Controllers\Frontend\AlmacenesController;
use App\Http\Controllers\Frontend\SeccionesController;
use App\Http\Controllers\Frontend\AnaquelesController;
use App\Http\Controllers\Frontend\ProductosController;
use App\Http\Controllers\Frontend\LoteController;
use App\Http\Controllers\Frontend\EntradaProductosController;

use App\Models\Ubigeo;

/*
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */

// Route::get('/phpinfo', function () {
//     phpinfo();
// })->name('phpinfo');

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

Route::get('ingreso_vehiculo_tronco/modal_placa/{id}', [IngresoVehiculoTroncoController::class, 'modal_placa'])->name('ingreso_vehiculo_tronco.modal_placa');
Route::get('ingreso_vehiculo_tronco/modal_empresa/{id}', [IngresoVehiculoTroncoController::class, 'modal_empresa'])->name('ingreso_vehiculo_tronco.modal_empresa');
Route::get('ingreso_vehiculo_tronco/modal_conductor/{id}', [IngresoVehiculoTroncoController::class, 'modal_conductor'])->name('ingreso_vehiculo_tronco.modal_conductor');

Route::post('ingreso_vehiculo_tronco/upload_imagen_ingreso', [IngresoVehiculoTroncoController::class, 'upload_imagen_ingreso'])->name('ingreso_vehiculo_tronco.upload_imagen_ingreso');
Route::get('ingreso_vehiculo_tronco/modal_ingreso_imagen/{id}', [IngresoVehiculoTroncoController::class, 'modal_ingreso_imagen'])->name('ingreso_vehiculo_tronco.modal_ingreso_imagen');

// Route::get('tabla_maestras', [TablaMaestraController::class, 'index'])->name('tabla_maestras.all');
// Route::get('tabla_maestras/{id}', [TablaMaestraController::class, 'show'])->name('tabla_maestras.show');
// Route::post('tabla_maestras/create', [TablaMaestraController::class, 'create'])->name('tabla_maestras.create');
// Route::post('tabla_maestras/send', [TablaMaestraController::class, 'send'])->name('tabla_maestras.send');
// Route::post('tabla_maestras/listar_tabla_maestras_ajax', [TablaMaestraController::class, 'listar_tabla_maestras_ajax'])->name('tabla_maestras.listar_tabla_maestras_ajax');
// Route::get('tabla_maestras/modal_tablamaestras/{id}', [TablaMaestraController::class, 'modal_tablamaestras'])->name('tabla_maestras.modal_tablamaestras');
// Route::get('tabla_maestras/eliminar_tabla_maestra/{id}/{estado}', [TablaMaestraController::class, 'eliminar_tabla_maestra'])->name('tabla_maestras.eliminar_tabla_maestra');
Route::get('ingreso_vehiculo_tronco/cubicaje', [IngresoVehiculoTroncoController::class, 'cubicaje'])->name('ingreso_vehiculo_tronco.cubicaje');
Route::get('ingreso_vehiculo_tronco/cargar_cubicaje/{id}', [IngresoVehiculoTroncoController::class, 'cargar_cubicaje'])->name('ingreso_vehiculo_tronco.cargar_cubicaje');

Route::get('ingreso_vehiculo_tronco/cargar_reporte_cubicaje/{id}', [IngresoVehiculoTroncoController::class, 'cargar_reporte_cubicaje'])->name('ingreso_vehiculo_tronco.cargar_reporte_cubicaje');

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
Route::get('conductores/{conductores}', 'App\Http\Controllers\ConductoresController@show')->name('conductores.show');
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


//Route::get('ingreso/create', [IngresoController::class, 'create'])->name('ingreso.create');
Route::get('ingresos/create', [IngresoController::class, 'create'])->name('ingresos.create');
Route::get('ingresos/obtener_valorizacion/{tipo_documento}/{id_persona}', [IngresoController::class, 'obtener_valorizacion'])->name('ingreso.obtener_valorizacion')->where('tipo_documento', '(.*)');
Route::post('ingresos/listar_valorizacion', [IngresoController::class, 'listar_valorizacion'])->name('ingreso.listar_valorizacion');
Route::post('ingresos/listar_valorizacion_concepto', [IngresoController::class, 'listar_valorizacion_concepto'])->name('ingreso.listar_valorizacion_concepto');
Route::post('ingresos/listar_valorizacion_periodo', [IngresoController::class, 'listar_valorizacion_periodo'])->name('ingreso.listar_valorizacion_periodo');
Route::get('ingresos/obtener_pago/{tipo_documento}/{persona_id}', [IngresoController::class, 'obtener_pago'])->name('ingreso.obtener_pago')->where('tipo_documento', '(.*)');
Route::post('ingresos/sendCaja', [IngresoController::class, 'sendCaja'])->name('ingreso.sendCaja');
Route::get('ingresos/modal_valorizacion_factura/{id}', [IngresoController::class, 'modal_valorizacion_factura'])->name('ingreso.modal_valorizacion_factura');

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

Route::get('ubigeo/listar_departamentos_ajax', function() {
    return response()->json([ 'status' => 'OK', 'departamentos' => Ubigeo::departamentos() ]);
});

Route::get('ubigeo/listar_provincias_ajax/{id_departamento}', function(Request $request) {
    return response()->json([ 'status' => 'OK', 'provincias' => Ubigeo::provincias(request()->route('id_departamento')) ]);
});

Route::get('ubigeo/listar_distritos_ajax/{id_departamento}/{id_provincia}', function(Request $request) {
    return response()->json([ 'status' => 'OK', 'distritos' => Ubigeo::distritos_ajax(request()->route('id_departamento'), request()->route('id_provincia')) ]);
});

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
Route::get('entrada_productos/modal_detalle_producto/{id}', [EntradaProductosController::class, 'modal_detalle_producto'])->name('entrada_productos.modal_detalle_producto');

Route::get('entrada_productos_detalle/send_entrada_producto_detalle', [EntradaProductoDetallesController::class, 'send_entrada_producto_detalle'])->name('entrada_productos_detalle.send_entrada_producto_detalle');

Route::get('entrada_productos/obtener_documento_entrada', [EntradaProductosController::class, 'obtener_documento_entrada'])->name('entrada_productos.obtener_documento_entrada');

Route::get('entrada_productos/obtener_documento_salida', [EntradaProductosController::class, 'obtener_documento_salida'])->name('entrada_productos.obtener_documento_salida');
