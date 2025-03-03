
<?php  $routeName = \Request::route()->getName();
	$grupo = explode(".",$routeName);
	if(isset($grupo[0]) && $grupo[0]!="admin"){
?>
    
<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    
    <div class="c-sidebar-brand d-lg-down-none">

        <!--
        <svg class="c-sidebar-brand-full" width="118" height="46" alt="CoreUI Logo">
            <use xlink:href="{{ asset('img/brand/coreui.svg#full') }}"></use>
        </svg>
        <svg class="c-sidebar-brand-minimized" width="46" height="46" alt="CoreUI Logo">
            <use xlink:href="{{ asset('img/brand/coreui.svg#signet') }}"></use>
        </svg>
		-->

        <a href="{{ route('frontend.index') }}" class="navbar-brand">
            <img src="<?php echo URL::to('/') ?>/img/logo_forestalpama.jpg" alt="" width="190" style="padding:0px;margin:0px">
        </a>

    </div><!--c-sidebar-brand-->

    @auth

    <ul class="c-sidebar-nav">
        <!--
		<li class="c-sidebar-nav-item">
            <x-utils.link
                class="c-sidebar-nav-link"
                :href="route('admin.dashboard')"
                :active="activeClass(Route::is('admin.dashboard'), 'c-active')"
                icon="c-sidebar-nav-icon cil-speedometer"
                :text="__('Dashboard')" />
        </li>
		-->

	@if(Gate::check('Ingreso de Camiones') || Gate::check('Cubicaje de Troncos') || Gate::check('Pagos'))

        <li class="c-sidebar-nav-title">@lang('System')</li>

        <li class="c-sidebar-nav-dropdown {{ activeClass(Route::is('admin.auth.user.*') || Route::is('admin.auth.role.*'), 'c-open c-show') }}">
            <x-utils.link href="#" icon="c-sidebar-nav-icon cil-user" class="c-sidebar-nav-dropdown-toggle" :text="__('Materia Prima')" />

            <ul class="c-sidebar-nav-dropdown-items">
			
                @can('Ingreso de Camiones')
                <li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('frontend.ingreso_vehiculo_tronco')" class="c-sidebar-nav-link" :text="__('Ingreso Camion')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
                </li>
                @endif

                @can('Cubicaje de Troncos')
                <li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('frontend.ingreso_vehiculo_tronco.cubicaje')" class="c-sidebar-nav-link" :text="__('Cubicaje Tronco')" :active="activeClass(Route::is('admin.auth.role.*'), 'c-active')" />
                </li>
                @endif

                @can('Pagos')
                <li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('frontend.ingreso_vehiculo_tronco.pagos')" class="c-sidebar-nav-link" :text="__('Pagos')" :active="activeClass(Route::is('admin.auth.role.*'), 'c-active')" />
                </li>
                @endif
            </ul>
        </li>
        

	@endif

        @if(Gate::check('Acerrado'))
        <li class="c-sidebar-nav-dropdown">
            <x-utils.link href="#" icon="c-sidebar-nav-icon cil-list" class="c-sidebar-nav-dropdown-toggle" :text="__('Acerrado')" />

            <!--
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <x-utils.link
                            :href="route('log-viewer::dashboard')"
                            class="c-sidebar-nav-link"
                            :text="__('Dashboard')" />
                    </li>
                    <li class="c-sidebar-nav-item">
                        <x-utils.link
                            :href="route('log-viewer::logs.list')"
                            class="c-sidebar-nav-link"
                            :text="__('Logs')" />
                    </li>
                </ul>
				-->

        </li>
    @endif
	
    @if(Gate::check('Almacenes') || Gate::check('Secciones') || Gate::check('Anaqueles') || Gate::check('Productos') || Gate::check('Lotes'))

        <li class="c-sidebar-nav-dropdown">
            <x-utils.link href="#" icon="c-sidebar-nav-icon cil-list" class="c-sidebar-nav-dropdown-toggle" :text="__('Control Mantenimiento')" />

        </li>


        <li class="c-sidebar-nav-dropdown">
            <x-utils.link href="#" icon="c-sidebar-nav-icon cil-list" class="c-sidebar-nav-dropdown-toggle" :text="__('Almacenes')" />
            <ul class="c-sidebar-nav-dropdown-items">
				
				@can('Almacenes')
                <li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('frontend.almacenes.create')" class="c-sidebar-nav-link" :text="__('Almacenes')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
                </li>
				@endif
				
				@can('Secciones')
                <li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('frontend.secciones.create')" class="c-sidebar-nav-link" :text="__('Secciones')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
                </li>
				@endif
				
				@can('Anaqueles')
                <li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('frontend.anaqueles.create')" class="c-sidebar-nav-link" :text="__('Anaqueles')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
                </li>
				@endif
				
				@can('Productos')
                <li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('frontend.productos.create')" class="c-sidebar-nav-link" :text="__('Productos')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
                </li>
				@endif
				
				@can('Lotes')
                <li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('frontend.lotes.create')" class="c-sidebar-nav-link" :text="__('Lotes')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
                </li>
				@endif
				
            </ul>

        </li>
		
	@endif
	
	@if(Gate::check('Requerimientos') || Gate::check('Entradas') || Gate::check('Orden Compra') || Gate::check('Consulta Stock') || Gate::check('Dispensacion') || Gate::check('Ingreso Produccion') || Gate::check('Kardex') || Gate::check('Movimientos') || Gate::check('Verificacion Aplicacion Comisiones') || Gate::check('Empaquetado') || Gate::check('Devolucion'))

        <li class="c-sidebar-nav-dropdown">
            <x-utils.link href="#" icon="c-sidebar-nav-icon cil-list" class="c-sidebar-nav-dropdown-toggle" :text="__('Operaciones')" />
            <ul class="c-sidebar-nav-dropdown-items">
				
                @can('Requerimientos')
                <li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('frontend.requerimiento.create')" class="c-sidebar-nav-link" :text="__('Requerimientos')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
                </li>
				@endif

				@can('Entradas')
                <li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('frontend.entrada_productos.create')" class="c-sidebar-nav-link" :text="__('Entradas y Salidas')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
                </li>
				@endif

                @can('Orden Compra')
                <li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('frontend.orden_compra.create')" class="c-sidebar-nav-link" :text="__('Orden Compra y Venta')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
                </li>

                @endif

                @can('Consulta Stock')

                <li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('frontend.orden_compra.consulta_stock_pedido')" class="c-sidebar-nav-link" :text="__('Consulta de Stock de Pedidos')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
                </li>

				@endif
				
				@can('Dispensacion')
                <li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('frontend.dispensacion.create')" class="c-sidebar-nav-link" :text="__('Dispensacion')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
                </li>
				@endif

                @can('Ingreso Produccion')
                <li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('frontend.ingreso_produccion.create')" class="c-sidebar-nav-link" :text="__('Ingreso Produccion')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
                </li>
				@endif
				
				@can('Kardex')
                <li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('frontend.kardex.create')" class="c-sidebar-nav-link" :text="__('Kardex')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
                </li>
				@endif
				
				@can('Movimientos')
                <li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('frontend.movimientos.index')" class="c-sidebar-nav-link" :text="__('Movimientos')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
                </li>
				@endif

                @can('Verificacion Aplicacion Comisiones')
				<li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('frontend.parametro.create_valida_parametro')" class="c-sidebar-nav-link" :text="__('Verificacion de Aplicacion de Comisiones')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
                </li>
				@endif

                @can('Empaquetado')
				<li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('frontend.empaquetado.create_empaquetado')" class="c-sidebar-nav-link" :text="__('Transformacion')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
                </li>
				@endif

                @can('Devolucion')
				<li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('frontend.devolucion.create')" class="c-sidebar-nav-link" :text="__('Devolucion')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
                </li>
				@endif
				
            </ul>

        </li>

        @endif

        @if(Gate::check('Ingreso Caja') || Gate::check('Comprobante') || Gate::check('Guia') || Gate::check('Consulta Sodimac'))

        <li class="c-sidebar-nav-dropdown">
            <x-utils.link href="#" icon="c-sidebar-nav-icon cil-list" class="c-sidebar-nav-dropdown-toggle" :text="__('Caja')" />
            <ul class="c-sidebar-nav-dropdown-items">
                @can('Ingreso Caja')
                <li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('frontend.ingreso.create')" class="c-sidebar-nav-link" :text="__('Estado de Cuentas')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />                  
                </li>
                @endif
                @can('Comprobante')
                <li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('frontend.comprobante.all')" class="c-sidebar-nav-link" :text="__('Consulta de Facturas')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />                  
                </li>
                @endif
                @can('Consulta Sodimac')
                <li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('frontend.comprobante.create_consulta_sodimac')" class="c-sidebar-nav-link" :text="__('Consulta de Facturas Sodimac')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />                  
                </li>
                @endif
                @can('Guia')
                <li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('frontend.guia_interna.create')" class="c-sidebar-nav-link" :text="__('Consulta de Guias')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />                  
                </li>
                @endif
            </ul>
        </li> 
		
	@endif
	
	@if(Gate::check('Inventario') || Gate::check('Consulta Productos Venta'))
        <li class="c-sidebar-nav-dropdown">
            <x-utils.link href="#" icon="c-sidebar-nav-icon cil-list" class="c-sidebar-nav-dropdown-toggle" :text="__('Consultas')" />
            <ul class="c-sidebar-nav-dropdown-items">
            @can('Inventario')
                <li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('frontend.kardex.create_consulta')" class="c-sidebar-nav-link" :text="__('Consultas de Existencias')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
                </li>
            @endif
            @can('Consulta Productos Venta')
                <li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('frontend.kardex.create_consulta_productos')" class="c-sidebar-nav-link" :text="__('Consultas de Productos')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
                </li>
            @endif
            </ul>
        </li>
        
	@endif
	
	@if(Gate::check('Mantenimiento Personas') || Gate::check('Mantenimiento Empresas') || Gate::check('Mantenimiento Vehiculos') || Gate::check('Mantenimiento Tablas Maestras') || Gate::check('Mantenimiento Conductores') || Gate::check('Mantenimiento Tipo Cambio') || Gate::check('Mantenimiento Marcas') || Gate::check('Mantenimiento Tiendas') || Gate::check('Mantenimiento Equivalencia Producto') || Gate::check('Mantenimiento Parametro') || Gate::check('Mantenimiento Empaquetado'))
	
        <li class="c-sidebar-nav-dropdown">
            <x-utils.link href="#" icon="c-sidebar-nav-icon cil-list" class="c-sidebar-nav-dropdown-toggle" :text="__('Mantenimiento')" />
            <ul class="c-sidebar-nav-dropdown-items">
                
				@can('Mantenimiento Personas')
				<li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('frontend.personas')" class="c-sidebar-nav-link" :text="__('Personas')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
                </li>
				@endif
				
				@can('Mantenimiento Empresas')
                <li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('frontend.empresas')" class="c-sidebar-nav-link" :text="__('Empresas')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
                </li>
				@endif
				
				@can('Mantenimiento Vehiculos')
                <li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('frontend.vehiculos.create')" class="c-sidebar-nav-link" :text="__('Vehiculos')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
                </li>
				@endif
				
				@can('Mantenimiento Tablas Maestras')
                <li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('frontend.tablamaestras.index')" class="c-sidebar-nav-link" :text="__('Tablas Maestras')" />
                </li>
				@endif
				
				@can('Mantenimiento Conductores')
                <li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('frontend.conductores.create')" class="c-sidebar-nav-link" :text="__('Conductores')" />
                </li>
				@endif
				
				@can('Mantenimiento Tipo Cambio')
                <li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('frontend.tipocambio.index')" class="c-sidebar-nav-link" :text="__('Tipo Cambio')" />
                </li>
				@endif

                @can('Mantenimiento Marcas')
				<li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('frontend.marcas.create')" class="c-sidebar-nav-link" :text="__('Marcas')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
                </li>
				@endif

                @can('Mantenimiento Tiendas')
				<li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('frontend.tiendas.create')" class="c-sidebar-nav-link" :text="__('Tiendas')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
                </li>
				@endif

                @can('Mantenimiento Equivalencia Producto')
				<li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('frontend.equivalencia_producto.create')" class="c-sidebar-nav-link" :text="__('Equivalencia Producto')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
                </li>
				@endif

                @can('Mantenimiento Parametro')
				<li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('frontend.parametro.create')" class="c-sidebar-nav-link" :text="__('Parametros')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
                </li>
				@endif

                @can('Mantenimiento Empaquetado')
				<li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('frontend.empaquetado.create')" class="c-sidebar-nav-link" :text="__('Empaquetado')" :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
                </li>
				@endif

            </ul>

        </li>
	
	@endif
	
	@if(Gate::check('Consultas'))
	
        <li class="c-sidebar-nav-dropdown">
            <x-utils.link href="#" icon="c-sidebar-nav-icon cil-list" class="c-sidebar-nav-dropdown-toggle" :text="__('Reportes')" />

        </li>

    @endif    

	@endauth

    </ul>

    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
</div><!--sidebar-->
<?php } ?>
