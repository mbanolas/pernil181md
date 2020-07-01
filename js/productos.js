    // Material Select Initialization
    $(document).ready(function() {
        
        // modelo ajax
        // $.ajax({
        //         type: "POST",
        //         url: "<?= base_url() ?>index.php/<controller>/<fuction>",
        //         data: {},
        //         success: function(datos) {
        //             //    alert (datos)
        //             var datos = $.parseJSON(datos)
        //             // alert(datos['id_proveedor'])
        //         },
        //         error: function() {
        //             alert("Información importante. Error en el proceso <controller>/<fuction>. Informar");
        //         }
        //     })

        // No se muestra la tabla hasta que está cargada
        $('.loading').addClass('d-none')
        $('#productos').show()

        // variable busquedas utilizada en EXPORT 
        var jsonBusquedas = "";

        // acciones botones en barra menu productos    
        // NUEVO 
        // Abre modal para poner NUEVO producto
        $('#nuevo').click(function() {
            $('#actividad').val('nuevo')
            // En datosSuccess se guardan los datos generados por ajax para emplearlos fuera de ajax
            var datosSuccess = ""
            // ajax syncrono: no se ejecuta lo que sigue a ajax hasta que este finalic
            $.ajax({
                async: false,
                type: 'POST',
                url: "<?php echo base_url() ?>" + "index.php/productos/getDatosProductoNuevo",
                data: {

                },
                success: function(datos) {
                    // alert(datos)
                    datosSuccess = $.parseJSON(datos);
                },
                error: function() {
                    alert("Error en el proceso. getVerProducto");
                }
            })
            $('input.form-control').removeAttr('disabled')

            // botones
            $('.cerrar').addClass('d-none')
            $('.grabar_editar').addClass('d-none')
            $('.grabar_nuevo').removeClass('d-none')
            $('.descatalogar_producto').addClass('d-none')
            $('.catalogar_producto').addClass('d-none')
            $('.cancelar_editar').removeClass('d-none')

            $('#id').prop('disabled', true)
            $('#iva').prop('disabled', true)
            $('#precio_transformacion_unidad').prop('disabled', true)
            $('#precio_transformacion_peso').prop('disabled', true)
            
            $('#myModalProducto').css('color', 'black')
            $('.modal-title').html('Introducir datos nuevo producto')

            $.each(datosSuccess, function(index, value) {
                
                    $('#' + index).val(value)
                    $('#' + index).parent().children('label').addClass('active')
                    if ($('input[data-activates="select-options-' + index + '"]').length)
                        $('input[data-activates="select-options-' + index + '"]').val(datosSuccess['valor_' + index])
            })

            $('#codigo_producto').removeAttr('disabled')

            $('#fecha_modificacion').val("<?php echo date('d/m/Y') ?>")
            $('#modificado_por').val("<?php echo $this->session->id ?>")

            $('#id_grupo').prop('disabled', false)
            $('#id_grupo').materialSelect('refresh')

            $('#id_familia').prop('disabled', false)
            $('#id_familia').materialSelect('refresh')

            $('#id_proveedor_web').prop('disabled', false)
            $('#id_proveedor_web').materialSelect('refresh')

            $('#control_stock').prop('disabled', false)
            $('#control_stock').materialSelect('refresh')

            $('#tipo_unidad').prop('disabled', false)
            $('#tipo_unidad').materialSelect('refresh')

            $("#myModalProducto").modal({
                backdrop: 'static',
                keyboard: false
            })
        })

        // CATALOGAR DESCATALOGAR
        // Abre modal para VER producto y descatalogar
        $('table#productos').delegate('.descatalogar', 'click', function() {
            $('#actividad').val('descatalogar')
            id = $(this).parent().parent().parent().parent().attr('producto')

            // En datosSuccess se guardan los datos generados por ajax para emplearlos fuera de ajax
            var datosSuccess = ""
            // ajax syncrono: no se ejecuta lo que sigue a ajax hasta que este finalic
            $.ajax({
                async: false,
                type: 'POST',
                url: "<?php echo base_url() ?>" + "index.php/productos/getDatosProducto",
                data: {
                    'id_pe_producto': id
                },
                success: function(datos) {
                    // alert(datos)
                    datosSuccess = $.parseJSON(datos);
                },
                error: function() {
                    alert("Error en el proceso. getDatosProducto - descatalogar");
                }
            })
            // disable inputs y selects
            $('input.form-control').attr('disabled', 'disabled')
            $('input[type="search"]').removeAttr('disabled')



            $('#id_grupo').prop('disabled', true)
            $('#id_grupo').materialSelect('refresh')

            $('#id_familia').prop('disabled', true)
            $('#id_familia').materialSelect('refresh')

            $('#id_proveedor_web').prop('disabled', true)
            $('#id_proveedor_web').materialSelect('refresh')

            $('#control_stock').prop('disabled', true)
            $('#control_stock').materialSelect('refresh')

            $('#tipo_unidad').prop('disabled', true)
            $('#tipo_unidad').materialSelect('refresh')

            // botones
            $('.cerrar').addClass('d-none')
            $('.grabar_editar').addClass('d-none')
            $('.grabar_nuevo').addClass('d-none')
            $('.descatalogar_producto').removeClass('d-none')
            $('.catalogar_producto').addClass('d-none')
            $('.cancelar_editar').removeClass('d-none')

            $('.modal-title').html('Datos producto - clasificado')
            $('#myModalProducto').css('color', 'black')
            $.each(datosSuccess, function(index, value) {
                $('#' + index).val(value)
                $('#' + index).parent().children('label').addClass('active')
                if ($('input[data-activates="select-options-' + index + '"]').length)
                    $('input[data-activates="select-options-' + index + '"]').val(datosSuccess['valor_' + index])
            })
            $("#myModalProducto").modal({
                backdrop: 'static',
                keyboard: false
            })
        })

        // Abre modal para VER producto y catalogar
        $('table#productos').delegate('.catalogar', 'click', function() {
            $('#actividad').val('catalogar')
            id = $(this).parent().parent().parent().parent().attr('producto')

            // En datosSuccess se guardan los datos generados por ajax para emplearlos fuera de ajax
            var datosSuccess = ""
            // ajax syncrono: no se ejecuta lo que sigue a ajax hasta que este finalic
            $.ajax({
                async: false,
                type: 'POST',
                url: "<?php echo base_url() ?>" + "index.php/productos/getDatosProducto",
                data: {
                    'id_pe_producto': id
                },
                success: function(datos) {
                    // alert(datos)
                    datosSuccess = $.parseJSON(datos);
                },
                error: function() {
                    alert("Error en el proceso. getDatosProducto-catalogar");
                }
            })
            // disable inputs y selects
            $('input.form-control').attr('disabled', 'disabled')
            $('input[type="search"]').removeAttr('disabled')



            $('#id_grupo').prop('disabled', true)
            $('#id_grupo').materialSelect('refresh')

            $('#id_familia').prop('disabled', true)
            $('#id_familia').materialSelect('refresh')

            $('#id_proveedor_web').prop('disabled', true)
            $('#id_proveedor_web').materialSelect('refresh')

            $('#control_stock').prop('disabled', true)
            $('#control_stock').materialSelect('refresh')

            $('#tipo_unidad').prop('disabled', true)
            $('#tipo_unidad').materialSelect('refresh')

            // botones
            $('.cerrar').addClass('d-none')
            $('.grabar_editar').addClass('d-none')
            $('.grabar_nuevo').addClass('d-none')
            $('.descatalogar_producto').addClass('d-none')
            $('.catalogar_producto').removeClass('d-none')
            $('.cancelar_editar').removeClass('d-none')

            $('.modal-title').html('Datos producto - clasificado')
            $('#myModalProducto').css('color', 'black')
            $.each(datosSuccess, function(index, value) {
                $('#' + index).val(value)
                $('#' + index).parent().children('label').addClass('active')
                if ($('input[data-activates="select-options-' + index + '"]').length)
                    $('input[data-activates="select-options-' + index + '"]').val(datosSuccess['valor_' + index])
            })
            $("#myModalProducto").modal({
                backdrop: 'static',
                keyboard: false
            })
        })

        //set button id on click to hide first modal
        $("#signin").on("click", function() {
            $('#myModal1').modal('hide');
        });

        //trigger next modal
        $("#signin").on("click", function() {
            if ($('#productos_compra').prop('checked')) {
                $('#myModal2').modal('show');
            } else {
                $('#myModal3').modal('show');
            }
        });

        // NI FILTROS
        $('#no_filtros').click(function() {
            // Reset Column filtering
            $('#productos thead input').val('').change();
            // Redraw table (and reset main search filter)
            // $("#productos").DataTable().search("").draw();
        })

        // EXPORTAR
        $('#exportar').click(function(e) {
            $('#exportar > div.spinner-border').removeClass('d-none')
            //recoje los datos de buscar 
            jsonBusquedas = "/"
            var v = "_"
            if ($('#productos_filter > input').val() != "") v = encodeURIComponent($('#productos_filter > input').val())
            jsonBusquedas += v
            var i;
            for (i = 2; i < 13; i++) {
                jsonBusquedas += "/"
                var v = "_"

                if ($('#productos > thead > tr:nth-child(2) > th:nth-child(' + i + ') > input').val() != "") {
                    v = encodeURIComponent($('#productos > thead > tr:nth-child(1) > th:nth-child(' + i + ') > input').val())
                }
                jsonBusquedas += v
            }
            console.log(this.href + jsonBusquedas);
            setTimeout(function() {
                $('#exportar > div.spinner-border').addClass('d-none')
            }, 2000);
            window.location.href = this.href + jsonBusquedas
            return false;
        })

        // acciones en cada producto
        // Abre modal para EDITAR producto
        // Editar
        $('table#productos').delegate('.editar', 'click', function() {
            $('#actividad').val('editar')
            id = $(this).parent().parent().parent().parent().attr('producto')
            $('#cerrar').addClass('hide')
            $('#grabar').removeClass('hide')
            $('#cancelar').removeClass('hide')

            // En datosSuccess se guardan los datos generados por ajax para emplearlos fuera de ajax
            var datosSuccess = ""
            // ajax syncrono: no se ejecuta lo que sigue a ajax hasta que este finalic
            $.ajax({
                async: false,
                type: 'POST',
                url: "<?php echo base_url() ?>" + "index.php/productos/getDatosProducto",
                data: {
                    'id_pe_producto': id
                },
                success: function(datos) {
                    // alert(datos)
                    datosSuccess = $.parseJSON(datos);
                },
                error: function() {
                    alert("Error en el proceso. getVerProducto");
                }
            })
            $('input.form-control').removeAttr('disabled')
            $('#iva').prop('disabled', true)
            $('#precio_transformacion_unidad').prop('disabled', true)
            $('#precio_transformacion_peso').prop('disabled', true)

            $('#fecha_modificacion').val("<?php echo date('d/m/Y') ?>")
            $('#modificado_por').val("<?php echo $this->session->id ?>")

            $('#id_grupo').prop('disabled', false)
            $('#id_grupo').materialSelect('refresh')

            $('#id_familia').prop('disabled', false)
            $('#id_familia').materialSelect('refresh')

            $('#id_proveedor_web').prop('disabled', false)
            $('#id_proveedor_web').materialSelect('refresh')

            $('#control_stock').prop('disabled', false)
            $('#control_stock').materialSelect('refresh')

            $('#tipo_unidad').prop('disabled', true)
            $('#tipo_unidad').materialSelect('refresh')

            $('input#id').attr('disabled', 'disabled')
            $('input#codigo_producto').attr('disabled', 'disabled')

            $('#myModalProducto').css('color', 'black')
            $('.modal-title').html('Modificar datos producto')

            // botones
            $('.cerrar').addClass('d-none')
            $('.grabar_editar').removeClass('d-none')
            $('.grabar_nuevo').addClass('d-none')
            $('.descatalogar_producto').addClass('d-none')
            $('.catalogar_producto').addClass('d-none')
            $('.cancelar_editar').removeClass('d-none')
            $.each(datosSuccess, function(index, value) {
                $('#' + index).val(value)
                $('#' + index).parent().children('label').addClass('active')
                if ($('input[data-activates="select-options-' + index + '"]').length)
                    $('input[data-activates="select-options-' + index + '"]').val(datosSuccess['valor_' + index])
            })

            $("#myModalProducto").modal({
                backdrop: 'static',
                keyboard: false
            })

        })

        // Abre modal para VER producto
        // Ver
        $('table#productos').delegate('.ver', 'click', function() {
            $('#actividad').val('ver')
            id = $(this).parent().parent().parent().parent().attr('producto')

            // En datosSuccess se guardan los datos generados por ajax para emplearlos fuera de ajax
            var datosSuccess = ""
            // ajax syncrono: no se ejecuta lo que sigue a ajax hasta que este finalic
            $.ajax({
                async: false,
                type: 'POST',
                url: "<?php echo base_url() ?>" + "index.php/productos/getDatosProducto",
                data: {
                    'id_pe_producto': id
                },
                success: function(datos) {
                    // alert(datos)
                    datosSuccess = $.parseJSON(datos);
                },
                error: function() {
                    alert("Error en el proceso. getVerProducto");
                }
            })
            // disable inputs y selects
            $('input.form-control').attr('disabled', 'disabled')
            $('input[type="search"]').removeAttr('disabled')


            // $('.md-form input:not([type]), .md-form input[type="text"]:not(.browser-default), .md-form input[type="password"]:not(.browser-default), .md-form input[type="email"]:not(.browser-default), .md-form input[type="url"]:not(.browser-default), .md-form input[type="time"]:not(.browser-default), .md-form input[type="date"]:not(.browser-default), .md-form input[type="datetime"]:not(.browser-default), .md-form input[type="datetime-local"]:not(.browser-default), .md-form input[type="tel"]:not(.browser-default), .md-form input[type="number"]:not(.browser-default), .md-form input[type="search"]:not(.browser-default), .md-form input[type="phone"]:not(.browser-default), .md-form input[type="search-md"], .md-form textarea.md-textarea').css('border-bottom','0px solid red !important')
            // $('.md-form .form-control:disabled, .md-form .form-control[readonly]').css('border','4px solid red !important')

            $('#id_grupo').prop('disabled', true)
            $('#id_grupo').materialSelect('refresh')

            $('#id_familia').prop('disabled', true)
            $('#id_familia').materialSelect('refresh')

            $('#id_proveedor_web').prop('disabled', true)
            $('#id_proveedor_web').materialSelect('refresh')

            $('#control_stock').prop('disabled', true)
            $('#control_stock').materialSelect('refresh')

            $('#tipo_unidad').prop('disabled', true)
            $('#tipo_unidad').materialSelect('refresh')

            // botones
            $('.cerrar').removeClass('d-none')
            $('.grabar_editar').addClass('d-none')
            $('.grabar_nuevo').addClass('d-none')
            $('.descatalogar_producto').addClass('d-none')
            $('.catalogar_producto').addClass('d-none')
            $('.cancelar_editar').addClass('d-none')

            $('.modal-title').html('Datos producto')
            $('#myModalProducto').css('color', 'black')

            $.each(datosSuccess, function(index, value) {
                $('#' + index).val(value)
                $('#' + index).parent().children('label').addClass('active')
                if ($('input[data-activates="select-options-' + index + '"]').length)
                    $('input[data-activates="select-options-' + index + '"]').val(datosSuccess['valor_' + index])
            })
            $("#myModalProducto").modal({
                backdrop: 'static',
                keyboard: false
            })
        })

        // motral modal imagen del producto
        // imagen producto
        $('table#productos').delegate('.img', 'click', function() {
            $('#actividad').val('imagen')
            id = $(this).parent().parent().attr('producto')
            var img = $(this).attr('src');
            // En datosSuccess se guardan los datos generados por ajax para emplearlos fuera de ajax
            var datosSuccess = ""
            // ajax syncrono: no se ejecuta lo que sigue a ajax hasta que este finalic
            $.ajax({
                async: false,
                type: 'POST',
                url: "<?php echo base_url() ?>" + "index.php/productos/getDatosProducto",
                data: {
                    'id_pe_producto': id
                },
                success: function(datos) {
                    // alert(datos)
                    datosSuccess = $.parseJSON(datos);
                },
                error: function() {
                    alert("Error en el proceso. getVerProducto");
                }
            })

            // disable inputs y selects
            $('input.form-control').attr('disabled', 'disabled')

            $('#id_grupo').prop('disabled', true)
            $('#id_grupo').materialSelect('refresh')

            $('#id_familia').prop('disabled', true)
            $('#id_familia').materialSelect('refresh')

            $('#id_proveedor_web').prop('disabled', true)
            $('#id_proveedor_web').materialSelect('refresh')

            $('#control_stock').prop('disabled', true)
            $('#control_stock').materialSelect('refresh')

            $('#tipo_unidad').prop('disabled', true)
            $('#tipo_unidad').materialSelect('refresh')

            // botones
            $('.cerrar').removeClass('d-none')
            $('.grabar_editar').addClass('d-none')
            $('.grabar_nuevo').addClass('d-none')
            $('.descatalogar_producto').addClass('d-none')
            $('.catalogar_producto').addClass('d-none')
            $('.cancelar_editar').addClass('d-none')

            $('.modal-title').html('Datos producto')
            $('#myModalProducto').css('color', 'black')

            $.each(datosSuccess, function(index, value) {
                $('#' + index).val(value)
                $('#' + index).parent().children('label').addClass('active')
                if ($('input[data-activates="select-options-' + index + '"]').length)
                    $('input[data-activates="select-options-' + index + '"]').val(datosSuccess['valor_' + index])
            })
            // $("#myModalProducto").modal({
            //     backdrop: 'static',
            //     keyboard: false
            // })
            console.log(img)
            var producto = $(this).parent().parent().children('td:eq(3)').html()
            console.log(producto)
            var codigo13 = $(this).parent().parent().children('td:eq(1)').html()
            console.log(codigo13)
            var codigoBoka = $(this).parent().parent().children('td:eq(2)').html()
            console.log(codigoBoka)
            // $('#myModalProducto').css('color', 'black')
            $('.modal-title-imagen').html('<h5>Imagen del producto</h5><h5><b>' + producto + '</b></h5><h5>Código: ' + codigo13 + '</h5><h5>Boka: ' + codigoBoka + '</h5>')
            if (img == "") $('#imagen').html("Este producto NO tiene imagen")
            else $('#imagen').html('<img src="' + img + '" alt="NO se ha encontrado la imagen<br>"' + img + ' >')
            $("#mostrarImagenModal").modal(
            )
        })

        $('.dataTables_length').addClass('bs-select');

        
        // ver https://datatables.net/examples/api/multi_filter.html Comments
        // coloca la barra columns search en la parte superior
        $('#productos tfoot tr').appendTo('#productos thead');

    });
