<nav class="navbar navbar-expand-md navbar-dark bg-primary mb-0" style="background:#183e39!important">
    <!--<div class="container">
        <x-utils.link
            :href="route('frontend.index')"
            :text="appName()"
            class="navbar-brand" />
	-->
	
		<a href="{{ route('frontend.index') }}" class="navbar-brand">
            <img src="<?php echo URL::to('/') ?>/img/logo_forestalpama.jpg" alt="" width="190" style="padding:0px;margin:0px">
        </a>
		<br>
		
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="@lang('Toggle navigation')">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav col-lg-9 col-md-9 col-sm-12 col-xs-12">
                @if(config('boilerplate.locale.status') && count(config('boilerplate.locale.languages')) > 1)
					
                @endif

                @guest
                    <li class="nav-item">
                        <x-utils.link
                            :href="route('frontend.auth.login')"
                            :active="activeClass(Route::is('frontend.auth.login'))"
                            :text="__('Login')"
                            class="nav-link" />
                    </li>

                    @if (config('boilerplate.access.user.registration'))
                        <li class="nav-item">
                            <x-utils.link
                                :href="route('frontend.auth.register')"
                                :active="activeClass(Route::is('frontend.auth.register'))"
                                :text="__('Register')"
                                class="nav-link" />

                        </li>
                    @endif
                @else
					
					@if(Gate::check('Ingreso de Camiones') || Gate::check('Cubicaje de Troncos') || Gate::check('Pagos') || Gate::check('Reporte Pagos'))

						<!--<li class="c-sidebar-nav-title">@lang('System')</li>-->

						<li class="nav-item dropdown">
							<a href="#" class="nav-link dropdown-toggle" id="navbarDropdownPrueba" data-toggle="dropdown"
						   aria-haspopup="true" aria-expanded="false">Materia Prima</a>

						   <div class="dropdown-menu" aria-labelledby="navbarDropdownPrueba">
							
								@can('Ingreso de Camiones')
									<x-utils.link :href="route('frontend.ingreso_vehiculo_tronco')" class="dropdown-item" :text="__('Ingreso Camion')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif

								@can('Cubicaje de Troncos')
									<x-utils.link :href="route('frontend.ingreso_vehiculo_tronco.cubicaje')" class="dropdown-item" :text="__('Cubicaje Tronco')" :active="activeClass(Route::is('admin.auth.role.*'), 'c-active')" />
								@endif

								@can('Pagos')
									<x-utils.link :href="route('frontend.ingreso_vehiculo_tronco.pagos')" class="dropdown-item" :text="__('Pagos')" :active="activeClass(Route::is('admin.auth.role.*'), 'c-active')" />
								@endif

								@can('Reporte Pagos')
									<x-utils.link :href="route('frontend.ingreso_vehiculo_tronco.reporte_pagos')" class="dropdown-item" :text="__('Reporte Pagos')" :active="activeClass(Route::is('admin.auth.role.*'), 'c-active')" />
								@endif

							</div>
						</li>
						
					@endif
					
					@if(Gate::check('Acerrado') || Gate::check('Horno'))

						<li class="nav-item dropdown">
							<a href="#" class="nav-link dropdown-toggle" id="navbarDropdownPrueba" data-toggle="dropdown"
							aria-haspopup="true" aria-expanded="false">Acerrado</a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdownPrueba">
								
								@can('Acerrado')
									<x-utils.link :href="route('frontend.acerrado_madera.create')" class="dropdown-item" :text="__('Acerrado Madera')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif

								@can('Horno')
									<x-utils.link :href="route('frontend.horno.create')" class="dropdown-item" :text="__('Horno')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif
								
							</div>
						</li>
					@endif
					
					
					@if(Gate::check('Registro Activos'))
						<li class="nav-item dropdown">
							<a href="#" class="nav-link dropdown-toggle" id="navbarDropdownPrueba" data-toggle="dropdown"
							aria-haspopup="true" aria-expanded="false">Activos</a>
								
								<div class="dropdown-menu" aria-labelledby="navbarDropdownPrueba">

									@can('Registro Activos')
										<x-utils.link :href="route('frontend.activos.create')" class="dropdown-item" :text="__('Registro de Activos')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
									@endif

									@can('Registro Entrega Activos')
										<x-utils.link :href="route('frontend.activos.create_entrega_activo')" class="dropdown-item" :text="__('Registro de Entrega Activos')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
									@endif

								</div>
						</li>
					@endif

					@if(Gate::check('Almacenes') || Gate::check('Secciones') || Gate::check('Anaqueles') || Gate::check('Productos') || Gate::check('Lotes'))

						<li class="nav-item dropdown">
							<a href="#" class="nav-link dropdown-toggle" id="navbarDropdownPrueba" data-toggle="dropdown"
						   	aria-haspopup="true" aria-expanded="false">Almacenes</a>

						   	<div class="dropdown-menu" aria-labelledby="navbarDropdownPrueba">
								
								@can('Almacenes')
									<x-utils.link :href="route('frontend.almacenes.create')" class="dropdown-item" :text="__('Almacenes')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif
								
								@can('Secciones')
									<x-utils.link :href="route('frontend.secciones.create')" class="dropdown-item" :text="__('Secciones')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif
								
								@can('Anaqueles')
									<x-utils.link :href="route('frontend.anaqueles.create')" class="dropdown-item" :text="__('Anaqueles')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif
								
								@can('Productos')
									<x-utils.link :href="route('frontend.productos.create')" class="dropdown-item" :text="__('Productos')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif
								
								@can('Lotes')
									<x-utils.link :href="route('frontend.lotes.create')" class="dropdown-item" :text="__('Lotes')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif
								
							</div>

						</li>
						
					@endif

					@if(Gate::check('Chopeo Productos'))
						
						<li class="nav-item dropdown">
							<a href="#" class="nav-link dropdown-toggle" id="navbarDropdownPrueba" data-toggle="dropdown"
						   aria-haspopup="true" aria-expanded="false">Promotoria</a>

						   <div class="dropdown-menu" aria-labelledby="navbarDropdownPrueba">

								@can('Chopeo Productos')
									<x-utils.link :href="route('frontend.productos.create_chopeo_producto')" class="dropdown-item" :text="__('Chopeo de Productos')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif
								
							</div>

						</li>

					@endif
					
					
					@if(Gate::check('Requerimientos') || Gate::check('Entradas') || Gate::check('Orden Compra') || Gate::check('Consulta Stock') || Gate::check('Dispensacion') || Gate::check('Ingreso Produccion') || Gate::check('Kardex') || Gate::check('Movimientos') || Gate::check('Verificacion Aplicacion Comisiones') || Gate::check('Empaquetado') || Gate::check('Devolucion'))
						
						<li class="nav-item dropdown">
							<a href="#" class="nav-link dropdown-toggle" id="navbarDropdownPrueba" data-toggle="dropdown"
						   aria-haspopup="true" aria-expanded="false">Operaciones</a>

						   <div class="dropdown-menu" aria-labelledby="navbarDropdownPrueba">

								@can('Requerimientos')
									<x-utils.link :href="route('frontend.requerimiento.create')" class="dropdown-item" :text="__('Requerimientos')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif

								@can('Entradas')
									<x-utils.link :href="route('frontend.entrada_productos.create')" class="dropdown-item" :text="__('Entradas y Salidas')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif

								@can('Orden Compra')
									<x-utils.link :href="route('frontend.orden_compra.create')" class="dropdown-item" :text="__('Orden Compra y Venta')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif

								@can('Consulta Stock')
									<x-utils.link :href="route('frontend.orden_compra.consulta_stock_pedido')" class="dropdown-item" :text="__('Consulta de Stock de Pedidos')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif
								
								@can('Dispensacion')
									<x-utils.link :href="route('frontend.dispensacion.create')" class="dropdown-item" :text="__('Dispensacion')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif

								@can('Ingreso Produccion')
									<x-utils.link :href="route('frontend.ingreso_produccion.create')" class="dropdown-item" :text="__('Ingreso Produccion')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif
								
								@can('Kardex')
									<x-utils.link :href="route('frontend.kardex.create')" class="dropdown-item" :text="__('Kardex')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif
								
								@can('Movimientos')
									<x-utils.link :href="route('frontend.movimientos.index')" class="dropdown-item" :text="__('Movimientos')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif

								@can('Verificacion Aplicacion Comisiones')
									<x-utils.link :href="route('frontend.parametro.create_valida_parametro')" class="dropdown-item" :text="__('Verificacion de Aplicacion de Comisiones')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif

								@can('Empaquetado')
									<x-utils.link :href="route('frontend.empaquetado.create_empaquetado')" class="dropdown-item" :text="__('Transformacion')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif

								@can('Devolucion')
									<x-utils.link :href="route('frontend.devolucion.create')" class="dropdown-item" :text="__('Devolucion')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif

								@can('Gestion Autorizacion')
									<x-utils.link :href="route('frontend.orden_compra.create_autorizacion')" class="dropdown-item" :text="__('Gestion de Autorizacion')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif

								@can('Cargar Informe Venta b2b')
									<x-utils.link :href="route('frontend.orden_compra.create_informe_b2b')" class="dropdown-item" :text="__('Cargar Informe Venta B2B')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif

								@can('Reuso')
									<x-utils.link :href="route('frontend.reuso.create')" class="dropdown-item" :text="__('Reuso')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif

								@can('Ajuste Stock')
									<x-utils.link :href="route('frontend.entrada_productos.create_ajuste_stock')" class="dropdown-item" :text="__('Ajuste de Stock')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif
								
							</div>

						</li>

					@endif

					@if(Gate::check('Control Produccion Orden Compra') || Gate::check('Orden Fabricacion'))

						<li class="nav-item dropdown">
							<a href="#" class="nav-link dropdown-toggle" id="navbarDropdownPrueba" data-toggle="dropdown"
							aria-haspopup="true" aria-expanded="false">Produccion</a>

							<div class="dropdown-menu" aria-labelledby="navbarDropdownPrueba">
								
								@can('Control Produccion Orden Compra')
									<x-utils.link :href="route('frontend.orden_compra.create_control_produccion')" class="dropdown-item" :text="__('Control Produccion Orden Compra')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif

								@can('Orden Fabricacion')
									<x-utils.link :href="route('frontend.orden_produccion.create_orden_produccion')" class="dropdown-item" :text="__('Orden Fabricacion')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif
																
							</div>

						</li>
						
					@endif

						@if(Gate::check('Ingreso Caja') || Gate::check('Comprobante') || Gate::check('Guia') || Gate::check('Consulta Sodimac') || Gate::check('Consulta Promart') || Gate::check('Pagos Orden Compra') || Gate::check('Facturacion Orden Compra'))
 
						<li class="nav-item dropdown">
							<a href="#" class="nav-link dropdown-toggle" id="navbarDropdownPrueba" data-toggle="dropdown"
						   aria-haspopup="true" aria-expanded="false">Caja</a>

						   <div class="dropdown-menu" aria-labelledby="navbarDropdownPrueba">
							
								@can('Ingreso Caja')
									<x-utils.link :href="route('frontend.ingreso.create')" class="dropdown-item" :text="__('Estado de Cuentas')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />                  
								@endif

								@can('Comprobante')
									<x-utils.link :href="route('frontend.comprobante.all')" class="dropdown-item" :text="__('Consulta de Facturas')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />                  
								@endif

								@can('Consulta Sodimac')
									<x-utils.link :href="route('frontend.comprobante.create_consulta_sodimac')" class="dropdown-item" :text="__('Consulta de Facturas Sodimac')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />                  
								@endif

								@can('Consulta Promart')
									<x-utils.link :href="route('frontend.comprobante.create_consulta_promart')" class="dropdown-item" :text="__('Consulta de Facturas Promart')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />                  
								@endif

								@can('Guia')
									<x-utils.link :href="route('frontend.guia_interna.create')" class="dropdown-item" :text="__('Consulta de Guias')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />                  
								@endif

								@can('Pagos Orden Compra')
									<x-utils.link :href="route('frontend.orden_compra.create_pago_orden_compra')" class="dropdown-item" :text="__('Pagos Orden Compra')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />                  
								@endif

								@can('Facturacion Orden Compra')
									<x-utils.link :href="route('frontend.comprobante.create_facturacion_orden_compra')" class="dropdown-item" :text="__('Facturacion Orden Compra')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />                  
								@endif

							</div>
						</li> 
						
					@endif
					
					@if(Gate::check('Inventario') || Gate::check('Consulta Productos Venta'))

						<li class="nav-item dropdown">
							<a href="#" class="nav-link dropdown-toggle" id="navbarDropdownPrueba" data-toggle="dropdown"
						   aria-haspopup="true" aria-expanded="false">Consultas</a>

						   <div class="dropdown-menu" aria-labelledby="navbarDropdownPrueba">

								@can('Inventario')
									<x-utils.link :href="route('frontend.kardex.create_consulta')" class="dropdown-item" :text="__('Consultas de Existencias')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif

								@can('Consulta Productos Venta')
									<x-utils.link :href="route('frontend.kardex.create_consulta_productos')" class="dropdown-item" :text="__('Consultas de Productos')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif

								@can('Consulta Productos Orden Compra')
									<x-utils.link :href="route('frontend.kardex.create_consulta_productos_orden_compra')" class="dropdown-item" :text="__('Consulta Productos por Orden Compra')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif

							</div>
						</li>
						
					@endif
					
					@if(Gate::check('Mantenimiento Personas') || Gate::check('Mantenimiento Empresas') || Gate::check('Mantenimiento Vehiculos') || Gate::check('Mantenimiento Tablas Maestras') || Gate::check('Mantenimiento Conductores') || Gate::check('Mantenimiento Tipo Cambio') || Gate::check('Mantenimiento Marcas') || Gate::check('Mantenimiento Tiendas') || Gate::check('Mantenimiento Equivalencia Producto') || Gate::check('Mantenimiento Parametro') || Gate::check('Mantenimiento Empaquetado') || Gate::check('Mantenimiento Empresas Cubicaje') || Gate::check('Mantenimiento Familia') || Gate::check('Mantenimiento Sub Familia') || Gate::check('Mantenimiento Permisos Usuario Descuento') || Gate::check('Producto Competencia') || Gate::check('Mantenimiento Persona Proceso'))
						
						<li class="nav-item dropdown">
							<a href="#" class="nav-link dropdown-toggle" id="navbarDropdownPrueba" data-toggle="dropdown"
						   aria-haspopup="true" aria-expanded="false">Mantenimiento</a>

						   <div class="dropdown-menu" aria-labelledby="navbarDropdownPrueba">

								@can('Mantenimiento Personas')
									<x-utils.link :href="route('frontend.personas')" class="dropdown-item" :text="__('Personas')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif
								
								@can('Mantenimiento Empresas')
									<x-utils.link :href="route('frontend.empresas')" class="dropdown-item" :text="__('Empresas')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif
								
								@can('Mantenimiento Vehiculos')
									<x-utils.link :href="route('frontend.vehiculos.create')" class="dropdown-item" :text="__('Vehiculos')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif
								
								@can('Mantenimiento Tablas Maestras')
									<x-utils.link :href="route('frontend.tablamaestras.index')" class="dropdown-item" :text="__('Tablas Maestras')" />
								@endif
								
								@can('Mantenimiento Conductores')
									<x-utils.link :href="route('frontend.conductores.create')" class="dropdown-item" :text="__('Conductores')" />
								@endif
								
								@can('Mantenimiento Tipo Cambio')
									<x-utils.link :href="route('frontend.tipocambio.index')" class="dropdown-item" :text="__('Tipo Cambio')" />
								@endif

								@can('Mantenimiento Marcas')
									<x-utils.link :href="route('frontend.marcas.create')" class="dropdown-item" :text="__('Marcas')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif

								@can('Mantenimiento Tiendas')
									<x-utils.link :href="route('frontend.tiendas.create')" class="dropdown-item" :text="__('Tiendas')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif

								@can('Mantenimiento Equivalencia Producto')
									<x-utils.link :href="route('frontend.equivalencia_producto.create')" class="dropdown-item" :text="__('Equivalencia Producto')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif

								@can('Mantenimiento Parametro')
									<x-utils.link :href="route('frontend.parametro.create')" class="dropdown-item" :text="__('Parametros')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif

								@can('Mantenimiento Empaquetado')
									<x-utils.link :href="route('frontend.empaquetado.create')" class="dropdown-item" :text="__('Empaquetado')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif

								@can('Mantenimiento Empresas Cubicaje')
									<x-utils.link :href="route('frontend.empresa_cubicaje.create')" class="dropdown-item" :text="__('Empresas Cubicaje')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif

								@can('Mantenimiento Familia')
									<x-utils.link :href="route('frontend.familia.create')" class="dropdown-item" :text="__('Familia')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif

								@can('Mantenimiento Sub Familia')
									<x-utils.link :href="route('frontend.sub_familia.create')" class="dropdown-item" :text="__('Sub Familia')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif

								@can('Mantenimiento Permisos Usuario Descuento')
									<x-utils.link :href="route('frontend.usuario_descuento.create')" class="dropdown-item" :text="__('Permisos Usuario Descuento')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif

								@can('Producto Competencia')
									<x-utils.link :href="route('frontend.producto_competencia.create')" class="dropdown-item" :text="__('Producto Competencia')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif

								@can('Mantenimiento Persona Proceso')
									<x-utils.link :href="route('frontend.persona_proceso.create')" class="dropdown-item" :text="__('Persona Proceso')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif

							</div>
						</li>
					
					@endif
					
					@if(Gate::check('Reporte Comercializacion') || Gate::check('Reporte Comercializacion Tienda') || Gate::check('Reporte Pedidos Tienda'))
					
						<li class="nav-item dropdown">
							<a href="#" class="nav-link dropdown-toggle" id="navbarDropdownPrueba" data-toggle="dropdown"
						   aria-haspopup="true" aria-expanded="false">Reportes</a>

						   <div class="dropdown-menu" aria-labelledby="navbarDropdownPrueba">

								@can('Reporte Comercializacion')
									<x-utils.link :href="route('frontend.orden_compra.create_reporte_comercializacion')" class="dropdown-item" :text="__('Reporte de Comercializacion')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif

								@can('Reporte Comercializacion Tienda')
									<x-utils.link :href="route('frontend.orden_compra.create_reporte_comercializacion_tienda')" class="dropdown-item" :text="__('Reporte de Comercializacion por Tienda')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif

								@can('Reporte Pedidos Tienda')
									<x-utils.link :href="route('frontend.orden_compra.create_reporte_comercializacion_solicitado_tienda')" class="dropdown-item" :text="__('Reporte de Pedidos por Tienda')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif

								@can('Reporte Comercializacion General')
									<x-utils.link :href="route('frontend.orden_compra.create_reporte_comercializacion_general')" class="dropdown-item" :text="__('Reporte de Comercializacion General')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif

							</div>
						</li>

					@endif

					@if(Gate::check('Consulta de Facturacion') || Gate::check('Facturacion de Pagos') || Gate::check('Reporte Ventas'))
					
						<li class="nav-item dropdown">
							<a href="#" class="nav-link dropdown-toggle" id="navbarDropdownPrueba" data-toggle="dropdown"
						   aria-haspopup="true" aria-expanded="false">Contabilidad</a>

						   <div class="dropdown-menu" aria-labelledby="navbarDropdownPrueba">

								@can('Consulta de Facturacion')
									<x-utils.link :href="route('frontend.comprobante.create_facturacion')" class="dropdown-item" :text="__('Consulta de Facturacion')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif

								@can('Facturacion de Pagos')
									<x-utils.link :href="route('frontend.comprobante.create_pagos')" class="dropdown-item" :text="__('Facturacion de Pagos')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif

								@can('Reporte Ventas')
									<x-utils.link :href="route('frontend.comprobante.create_ventas')" class="dropdown-item" :text="__('Reporte Ventas')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif

								@can('Consulta de Facturacion Detalle')
									<x-utils.link :href="route('frontend.comprobante.create_facturacion_sodimac_detalle')" class="dropdown-item" :text="__('Consulta de Facturacion Detalle')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif

							</div>
						</li>

					@endif 

					@if(Gate::check('Consulta de Facturacion') || Gate::check('Marcacion Promotor'))
					
						<li class="nav-item dropdown">
							<a href="#" class="nav-link dropdown-toggle" id="navbarDropdownPrueba" data-toggle="dropdown"
						   aria-haspopup="true" aria-expanded="false">Promotores y Rutas</a>

						   <div class="dropdown-menu" aria-labelledby="navbarDropdownPrueba">

								@can('Asignacion Rutas')
									<x-utils.link :href="route('frontend.promotores.create_ruta')" class="dropdown-item" :text="__('Asignacion Rutas')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif

								@can('Marcacion Promotor')
									<x-utils.link :href="route('frontend.promotores.create_asistencia')" class="dropdown-item" :text="__('Marcar Asistencia Promotor')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
								@endif

							</div>
						</li>

					@endif 
					
                    <li class="nav-item dropdown">
                        <x-utils.link
                            href="#"
                            id="navbarDropdown"
                            class="nav-link dropdown-toggle"
                            role="button"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                            v-pre
                        >
                            <x-slot name="text">
                                <img class="rounded-circle" style="max-height: 20px" src="{{ $logged_in_user->avatar }}" />
                                {{ $logged_in_user->name }} <span class="caret"></span>
                            </x-slot>
                        </x-utils.link>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            @if ($logged_in_user->isAdmin())
                                <x-utils.link
                                    :href="route('admin.dashboard')"
                                    :text="__('Administration')"
                                    class="dropdown-item" />
                            @endif

                            @if ($logged_in_user->isUser())
                                <x-utils.link
                                    :href="route('frontend.user.dashboard')"
                                    :active="activeClass(Route::is('frontend.user.dashboard'))"
                                    :text="__('Dashboard')"
                                    class="dropdown-item"/>
                            @endif

                            <x-utils.link
                                :href="route('frontend.user.account')"
                                :active="activeClass(Route::is('frontend.user.account'))"
                                :text="__('My Account')"
                                class="dropdown-item" />

                            <x-utils.link
                                :text="__('Logout')"
                                class="dropdown-item"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <x-slot name="text">
                                    @lang('Logout')
                                    <x-forms.post :action="route('frontend.auth.logout')" id="logout-form" class="d-none" />
                                </x-slot>
                            </x-utils.link>
                        </div>
                    </li>
                @endguest
            </ul>
        </div><!--navbar-collapse-->
    </div><!--container-->
</nav>

@if (config('boilerplate.frontend_breadcrumbs'))
    @include('frontend.includes.partials.breadcrumbs')
@endif
