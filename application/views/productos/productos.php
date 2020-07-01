<link rel="stylesheet" href="<?php echo base_url() ?>/css/productos.min.css">

<!-- Card -->
<div class="card card-cascade">
    <!-- Card image -->
    <div class="view view-cascade gradient-card-header blue-gradient">
        <!-- Title -->
        <h2 class="card-header-title ">Productos <?php echo strtolower($tipoProducto) ?>
            <div class="spinner-grow text-danger loading " role="status">
                <span class="sr-only ">Cargando...</span>
            </div>
            <button class="btn btn-primary float-right" id="no_filtros">No filtros</button>
            <?php if($this->session->categoria!=2) { ?>
            <a class="btn btn-primary float-right" id="exportar" href="<?= base_url() ?>index.php/productos/exportExcel">
                Exportar
                <!--Small yellow-->
                <div class="ml-1 d-none spinner-border spinner-border-sm" role="status">
                    <span class="sr-only">Cargando...</span>
                </div>
            </a>
           
            <!-- <a class="btn btn-secondary float-right" id="exportar">Exportar</a> -->

            <button class="btn btn-primary float-right" id="nuevos_rangos" data-toggle="modal" data-target="#myModal1">Nuevos rangos/añadas</button>

            <?php } ?>
            <a class="btn btn-primary float-right" id="cambioTipoProducto" href="<?php echo base_url() ?>index.php/productos/productos/<?php echo (1 - intval($status_producto)) ?>">Prod. <?php echo $otroTipoProducto ?></a>
            <?php if($this->session->categoria!=2) { ?>
            <button class="btn btn-primary float-right" id="nuevo">Nuevo</button>
            <?php } ?>
        </h2>
        <!-- Subtitle -->
        <!-- <p class="card-header-subtitle mb-0">Deserve for her own card</p> -->
    </div>

    <!-- Card content -->
    <div class="card-body card-body-cascade text-center">
        <!-- cargango sniiper -->
        <h1 class="loading">Cargando...</h1>
        <div class="preloader-wrapper big active loading">
            <div class="spinner-layer spinner-blue-only">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
        <!-- final snnipers -->
        <!-- tabla productos -->
        <?php if($this->session->categoria==2) { ?>
        <table id="productos" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%" style="display:none">
            <thead>
                <tr>
                    <th></th>
                    <th>Código Producto</th>
                    <th>Cód. Bascula</th>
                    <th class="izquierda" style="min-width:40% !important">Nombre</th>
                    <th>Peso Real (Kg)</th>
                    <th>Tipo Unidad</th>
                    <!-- <th>Precio Compra Final en Tienda</th> -->
                    <!-- <th class="izquierda" style="min-width:20% !important">Proveedor</th> -->
                    <th>Tarifa PVP</th>
                    <!-- <th>Margen (%)</th> -->
                    <th>Undidades Stock</th>
                    <!-- <th>Valor Stock precio compra actual</th> -->
                    <th>Imagen Producto</th>
                </tr>
            </thead>
            <tbody>
               
                <?php foreach ($productos as $k => $v) { ?>
                    <tr producto='<?php echo $v->id ?>'>
                        <td >
                            <!--Dropdown -->
                            <div class="dropdown">
                                <!--Trigger-->
                                <a class="btn btn-sm btn-blue-grey dropdown-toggle acciones" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones </a>
                                <!--Menu-->
                                <div class="dropdown-menu dropdown-light">
                                    <!-- <a class="dropdown-item btn-sm editar" href="#">Editar</a> -->
                                    <a class="dropdown-item ver" href="#">Ver producto</a>
                                    <?php $desCat = $status_producto ? " Descatalogar" : " Catalogar" ?>
                                    <!-- <a class="dropdown-item <?php echo strtolower($desCat) ?>" href="#"><?php echo $desCat ?></a> -->
                                    <!-- <a class="dropdown-item eliminar" href="#">Eliminar</a> -->
                                </div>
                            </div>
                            <!--/Dropdown -->
                        </td>
                        <td class="text-center"><?php echo $v->codigo_producto ?></td>
                        <td class="text-right"><?php echo $v->id_producto ?></td>
                        <td class="text-left"><?php echo $v->nombre ?> </td>
                        <!-- <td class="text-right"><?php echo number_format($v->peso_real / 1000, 3, ",", ".") ?></td> -->
                        <td class="text-right"><?php echo number_format($v->peso_real / 1000, 3, ",", ".") ?></td>
                        <td class="text-right"><?php echo $v->tipo_unidad ?> </td>
                        <!-- <td class="text-right"><?php echo number_format($v->precio_compra / 1000, 3, ",", ".") ?></td> -->
                        <!-- <td class="text-left"><?php echo $v->proveedor ?> </td> -->
                        <td class="text-right"><?php echo number_format($v->tarifa_venta / 1000, 3, ",", ".") ?></td>
                        <!-- <td class="text-right"><?php echo number_format($v->margen_real_producto / 1000, 3, ",", ".") ?></td> -->
                        <td class="text-right"><?php echo $v->stock_total ?></td>
                        <!-- <td class="text-right"><?php echo number_format($v->valoracion, 3, ",", ".") ?></td> -->
                        <td><img class=" img rounded-circle " src="<?php echo $v->url_imagen_portada ?>"  ></img></td>
                        

                     </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th>Código Producto</th>
                    <th>Cód. Bascula</th>
                    <th class="izquierda">Nombre</th>
                    <th>Peso Real (Kg)</th>
                    <th>Tipo Unidad</th>
                    <!-- <th>Precio Compra Final en Tienda</th> -->
                    <th class="izquierda">Proveedor</th>
                    <th>Tarifa PVP</th>
                    <!-- <th>Margen (%)</th> -->
                    <th>Undidades Stock</th>
                    <!-- <th>Valor Stock precio compra actual</th> -->
                    <th>Imagen Producto</th>
                </tr>
            </tfoot>

            <!-- <?php //echo $tabla; 
                    ?> -->
        </table>
        <?php } else {?>
            <table id="productos" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%" style="display:none">
            <thead>
                <tr>
                    <th></th>
                    <th>Código Producto</th>
                    <th>Cód. Bascula</th>
                    <th class="izquierda" style="min-width:40% !important">Nombre</th>
                    <th>Peso Real (Kg)</th>
                    <th>Tipo Unidad</th>
                    <th>Precio Compra Final en Tienda</th>
                    <th class="izquierda" style="min-width:20% !important">Proveedor</th>
                    <th>Tarifa PVP</th>
                    <th>Margen (%)</th>
                    <th>Undidades Stock</th>
                    <th>Valor Stock precio compra actual</th>
                    <th>Imagen Producto</th>
                </tr>
            </thead>
            <tbody>
               
                <?php foreach ($productos as $k => $v) { ?>
                    <tr producto='<?php echo $v->id ?>'>
                        <td >
                            <!--Dropdown -->
                            <div class="dropdown">
                                <!--Trigger-->
                                <a class="btn btn-sm btn-blue-grey dropdown-toggle acciones" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones </a>
                                <!--Menu-->
                                <div class="dropdown-menu dropdown-light">
                                    <a class="dropdown-item btn-sm editar" href="#">Editar</a>
                                    <a class="dropdown-item ver" href="#">Ver producto</a>
                                    <?php $desCat = $status_producto ? " Descatalogar" : " Catalogar" ?>
                                    <a class="dropdown-item <?php echo strtolower($desCat) ?>" href="#"><?php echo $desCat ?></a>
                                    <a class="dropdown-item eliminar" href="#">Eliminar</a>
                                </div>
                            </div>
                            <!--/Dropdown -->
                        </td>
                        <td class="text-center"><?php echo $v->codigo_producto ?></td>
                        <td class="text-right"><?php echo $v->id_producto ?></td>
                        <td class="text-left"><?php echo $v->nombre ?> </td>
                        <td class="text-right"><?php echo number_format($v->peso_real / 1000, 3, ",", ".") ?></td>
                        <td class="text-right"><?php echo $v->tipo_unidad ?> </td>
                        <td class="text-right"><?php echo number_format($v->precio_compra / 1000, 3, ",", ".") ?></td>
                        <td class="text-left"><?php echo $v->proveedor ?> </td>
                        <td class="text-right"><?php echo number_format($v->tarifa_venta / 1000, 3, ",", ".") ?></td>
                        <td class="text-right"><?php echo number_format($v->margen_real_producto / 1000, 3, ",", ".") ?></td>
                        <td class="text-right"><?php echo $v->stock_total ?></td>
                        <td class="text-right"><?php echo number_format($v->valoracion, 3, ",", ".") ?></td>
                        <td><img class=" img rounded-circle " src="<?php echo $v->url_imagen_portada ?>"  ></img></td>
                        

                     </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th>Código Producto</th>
                    <th>Cód. Bascula</th>
                    <th class="izquierda">Nombre</th>
                    <th>Peso Real (Kg)</th>
                    <th>Tipo Unidad</th>
                    <th>Precio Compra Final en Tienda</th>
                    <th class="izquierda">Proveedor</th>
                    <th>Tarifa PVP</th>
                    <th>Margen (%)</th>
                    <th>Undidades Stock</th>
                    <th>Valor Stock precio compra actual</th>
                    <th>Imagen Producto</th>
                </tr>
            </tfoot>

            <!-- <?php //echo $tabla; 
                    ?> -->
        </table>
        <?php } ?>

        <!-- fin tabla productos -->
    </div>
    <!-- EndCard content -->
</div>
<!-- End Card -->
<!-- End project -->


<!-- <script data-require="bootstrap@*" data-semver="3.3.6" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> -->
<script type="text/javascript" src="<?php echo base_url() ?>js/productos.min.js"></script>
<script>

//configuración tabla productos
$('#productos').DataTable({
     
     "dom": "<'row'<'col-sm-12 col-md-6'><'col-sm-12 col-md-6'f>>" +
         "<'row'<'col-sm-12'tr>>" +
         "<'row'<'col-sm-12 col-md-4' l><'col-sm-12 col-md-4' i><'col-sm-12 col-md-4'p>>",
     orderCellsTop: true,
     fixedHeader: true,
     "pagingType": "first_last_numbers",
     "order": [
         [1, "asc"]
     ],
     
     colReorder: true,
     initComplete: function() {
         // añade search al pie
         this.api().columns().every(function(e) {
             if (e != 0) {
                 var column = this;
                 $(`<input class="form-control form-control-sm" type="search" placeholder="Buscar">`)
                     .appendTo($(column.footer()).empty())
                     // .appendTo($('#productos > thead > tr:nth-child(2) > th').empty())
                     .on('change input', function() {
                         var val = $(this).val()
                         column
                             .search(val ? val : '', true, false)
                             .draw();
                     });
             }
         });
     },
     "language": {
         "sProcessing": "Procesando...",
         "sLengthMenu": "Mostrar _MENU_ registros",
         "sZeroRecords": "No se encontraron resultados",
         "sEmptyTable": "Ningún dato disponible en esta tabla =(",
         "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
         "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
         "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
         "sInfoPostFix": "",
         "sSearch": "Buscar:",
         "sUrl": "",
         "sInfoThousands": ",",
         "sLoadingRecords": "Cargando...",
         "oPaginate": {
             "sFirst": "Primero",
             "sLast": "Último",
             "sNext": "Siguiente",
             "sPrevious": "Anterior"
         },
         "oAria": {
             "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
             "sSortDescending": ": Activar para ordenar la columna de manera descendente"
         },
         "buttons": {
             "copy": "Copiar",
             "colvis": "Visibilidad"
         }
     },
 })


</script>

