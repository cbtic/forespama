
# Models
app/Models/SalidaProducto.php`
`app/Models/SalidaProductoDetalle.php`

# Controllers
app/Http/Controllers/SalidaProducto(s)Controller.php`
`app/Http/Controllers/SalidaProductoDetalle(s)Controller.php`

> php artisan make:model SalidaProducto -c

# Livewire Tables
app/Http/Livewire/Backend/SalidaProductosTable.php`
`app/Http/Livewire/Backend/SalidaProductoDetallesTable.php`

> php artisan make:datatable SalidaProductosTable SalidaProducto

# Rules
app/Http/Requests/SalidaProductoRequest.php`
`app/Http/Requests/SalidaProductoDetalleRequest.php`

> php artisan make:request SalidaProductoRequest 

# Forms
app/View/Components/Forms/SalidaProducto.php`
`app/View/Components/Forms/SalidaProductoDetalle.php`
app/View/Forms/SalidaProductosForm.php`
`app/View/Forms/SalidaProductoDetallesForm.php`

> touch app/View/Components/Forms/SalidaProducto.php
> touch app/View/Forms/SalidaProductosForm.php

# Views
resources/views/frontend/salida_productos/create.blade.php`
resources/views/frontend/salida_productos/edit.blade.php`
resources/views/frontend/salida_productos/index.blade.php`
resources/views/frontend/salida_productos/show.blade.php`

> cp -r resources/views/frontend/salida_productos resources/views/frontend/salida_productos

`resources/views/frontend/salida_producto_detalles/create.blade.php`
`resources/views/frontend/salida_producto_detalles/edit.blade.php`
`resources/views/frontend/salida_producto_detalles/index.blade.php`
`resources/views/frontend/salida_producto_detalles/show.blade.php`
