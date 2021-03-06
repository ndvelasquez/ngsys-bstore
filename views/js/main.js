$(document).ready(function () {
    // MENU SIDEBAR
    $('.sidebar-menu').tree();

    /* 
    ===========================
    CONFIG. DATATABLE
    ===========================
    */
    $('.tablas').DataTable({
      'language': {
        "sProcessing":     "Procesando...",
                    "sLengthMenu":     "Mostrar _MENU_ registros",
                    "sZeroRecords":    "No se encontraron resultados",
                    "sEmptyTable":     "Ningún dato disponible en esta tabla =(",
                    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix":    "",
                    "sSearch":         "Buscar:",
                    "sUrl":            "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst":    "Primero",
                        "sLast":     "Último",
                        "sNext":     "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    },
                    "buttons": {
                        "copy": "Copiar",
                        "colvis": "Visibilidad"
                    }
    }
    });

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass   : 'iradio_minimal-blue'
      })

     /* 
    =========================================
    SUBIR Y PRE VISUALIZAR FOTO DEL USUARIO
    =========================================
    */
    $('.fotoUsuario').change(function() {
        let imagen = this.files[0];
        
        if (imagen.type != 'image/png' && imagen.type != 'image/jpeg') {

            $('.fotoUsuario').val("");
            Swal.fire({
                type: 'error',
                title: 'Error al subir la imagen',
                text: 'La imagen no coincide con el formato solicitado',
                icon: 'error',
                confirmButtonText: 'Cerrar'
            });
        } 
        else if (imagen.size > 10000000) {
            $('.fotoUsuario').val("");
            Swal.fire({
                type: 'error',
                title: 'Error al subir la imagen',
                text: 'La imagen no supera el tamaño indicado',
                icon: 'error',
                confirmButtonText: 'Cerrar'
            });
        }
        else {
            let datosImagen = new FileReader;
            datosImagen.readAsDataURL(imagen);

            $(datosImagen).on('load', function(event) {
                let rutaImagen = event.target.result;
                $('.preview').attr('src', rutaImagen);
            });
        }
        
    });

    /* 
    =====================================================
    MOSTRAR DATOS DE USUARIO EN FORMULARIO PARA EDITAR
    ====================================================
    */
   $(document).on("click", ".btn-editarUsuario", function () {
       let idUsuario = $(this).attr("idUsuario");
       let datos = new FormData();
       datos.append('idUsuario', idUsuario);

       $.ajax({
            url: 'ajax/usuarios.ajax.php',
            method: 'POST',
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(respuesta) {
                $("#editarNombreUsuario").val(respuesta["nombre"]);
                $("#editarUsuario").val(respuesta["usuario"]);
                $("#idUsuario").val(respuesta["id"]);
                $("#editarPerfil").html(respuesta["perfil"]);
                $("#editarPerfil").val(respuesta["perfil"]);
                $("#claveActual").val(respuesta["clave"]);
                $("#fotoActual").val(respuesta["foto"]);
                
                if(respuesta["foto"] != null && respuesta["foto"] != "") {
                    $('.preview').attr('src', respuesta["foto"]);
                }

            }
       })
   });

   /*
   =========================================
   ACTIVAR O DESACTIVAR USUARIO
   =========================================
   */
    $(document).on("click", ".btnActivar", function () {
        let idUsuario = $(this).attr("idUsuario");
        let estadoUsuario = $(this).attr("estadoUsuario");
        let datos = new FormData();
        datos.append('idUsuario', idUsuario);
        datos.append('estadoUsuario', estadoUsuario);
        $.ajax({
            url: 'ajax/usuarios.ajax.php',
            method: 'POST',
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(respuesta) {
               if(window.matchMedia("(max-width:767px)").matches) {
                Swal.fire({
                    type: 'success',
                    title: 'Usuario Actualizado',
                    icon: 'success',
                    confirmButtonText: 'Cerrar',
                    closeOnConfirm: false
                  }).then((result) =>{
                    if(result.value){
                        window.location = 'usuarios';
                    }
                  });
               }
            }
       });

       if (estadoUsuario == 0) {
           $(this).removeClass('btn-success');
           $(this).addClass('btn-danger');
           $(this).html('Desactivado');
           $(this).attr('estadoUsuario', 1);
       }
       else {
           $(this).removeClass('btn-danger');
           $(this).addClass('btn-success');
           $(this).html('Activado');
           $(this).attr('estadoUsuario', 0);
       }

    });

    /*
    =============================================
    VERIFICAR SI UN USUARIO YA ESTA REGISTRADO
    =============================================
    */
    $('#usuario').change(function () {
        $(".alert").remove();
        let usuario = $(this).val();
        let datos = new FormData();
        datos.append('validarUsuario', usuario);
        $.ajax({
            url: 'ajax/usuarios.ajax.php',
            method: 'POST',
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(respuesta) {
               if(respuesta) {
                   $("#usuario").parent().after('<div class="alert alert-danger">este usuario ya existe en la base de datos</div>');
                   $("#usuario").val("");
               }
            }
       })
    });
    /* 
    =====================================================
    ELIMINAR USUARIO
    ====================================================
    */
   $(document).on("click", ".btn-eliminarUsuario", function () {
    let idUsuario = $(this).attr("idUsuario");
    let fotoUsuario = $(this).attr("fotoUsuario");
    let usuario = $(this).attr("usuario");

    Swal.fire({
        title: '¿Desea eliminar el usuario?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Eliminar'
      }).then((result) => {
        if (result.value) {
          window.location = "index.php?ruta=usuarios&idUsuario="+idUsuario+"&usuario="+usuario+"&fotoUsuario="+fotoUsuario;
        }
      })
    });

    /* 
    ================================================
    SELECCIONAR CATEGORIA A EDITAR
    ================================================
    */
   $(document).on("click", ".btn-editarCategoria", function () {
    let idCategoria = $(this).attr("idCategoria");
    let datos = new FormData();
    datos.append("idCategoria", idCategoria);
    $.ajax({
        url: 'ajax/categorias.ajax.php',
        method: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(respuesta) {
            $("#editarNombre").val(respuesta["nombre"]);
            $("#idCategoria").val(respuesta["id"]);

        }
   })

   });

   /*
    =============================================
    VERIFICAR SI UN NOMBRE YA ESTA REGISTRADO
    =============================================
    */
   $('#nombre').change(function () {
    $(".alert").remove();
    let nombre = $(this).val();
    let datos = new FormData();
    datos.append('validaNombre', nombre);
    $.ajax({
        url: 'ajax/categorias.ajax.php',
        method: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(respuesta) {
           if(respuesta) {
               $("#nombre").parent().after('<div class="alert alert-danger">este nombre ya existe en la base de datos</div>');
               $("#nombre").val("");
           }
        }
   })
});

    /* 
    =====================================================
    ELIMINAR CATEGORIA
    ====================================================
    */
    $(document).on("click", ".btn-eliminarCategoria", function () {
    let idCategoria = $(this).attr("idCategoria");
    
    Swal.fire({
        title: '¿Desea eliminar la categoria?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Eliminar'
    }).then((result) => {
            if (result.value) {
            window.location = "index.php?ruta=categorias&idCategoria="+idCategoria;
            }
        })
    });

    /* 
    ================================================
    SELECCIONAR ALMACEN A EDITAR
    ================================================
    */
   $(document).on("click", ".btn-editarAlmacen", function () {
    let idAlmacen = $(this).attr("idAlmacen");
    let datos = new FormData();
    datos.append("idAlmacen", idAlmacen);
    $.ajax({
        url: 'ajax/almacenes.ajax.php',
        method: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(respuesta) {
            $("#editarNombre").val(respuesta["nombre"]);
            $("#idAlmacen").val(respuesta["id"]);

        }
   })

   });

   /*
    =============================================
    VERIFICAR SI UN NOMBRE YA ESTA REGISTRADO
    =============================================
    */
   $('#nombre').change(function () {
    $(".alert").remove();
    let nombre = $(this).val();
    let datos = new FormData();
    datos.append('validaNombre', nombre);
    $.ajax({
        url: 'ajax/almacenes.ajax.php',
        method: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(respuesta) {
           if(respuesta) {
               $("#nombre").parent().after('<div class="alert alert-danger">este nombre ya existe en la base de datos</div>');
               $("#nombre").val("");
           }
        }
   })
});

    /* 
    =====================================================
    ELIMINAR ALMACEN
    ====================================================
    */
    $(document).on("click", ".btn-eliminarAlmacen", function () {
    let idAlmacen = $(this).attr("idAlmacen");
    
    Swal.fire({
        title: '¿Desea eliminar el almacén?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Eliminar'
    }).then((result) => {
            if (result.value) {
            window.location = "index.php?ruta=almacenes&idAlmacen="+idAlmacen;
            }
        })
    });

    /* 
    =====================================================
    CARGAR DATOS DINAMICOS DE LOS PRODUCTOS CON AJAX
    ====================================================
    */
   cargarDataTable();
    /* 
    =====================================================
    CREAR NUEVO CODIGO DEL PRODUCTO
    ====================================================
    */
    // $("#categoria").change(function () {
    //     let idCategoria = $(this).val();
    //     let datos = new FormData();
    //     datos.append('idCategoria', idCategoria);
    //     $.ajax({
    //         url: 'ajax/productos.ajax.php',
    //         method: 'POST',
    //         data: datos,
    //         cache: false,
    //         contentType: false,
    //         processData: false,
    //         dataType: 'json',
    //         success: function(respuesta) {
    //            if (!respuesta) {
    //                let nuevoCodigo = idCategoria + "001";
    //                $("#codProducto").val(nuevoCodigo);
    //            }
    //            else {
    //                let nuevoCodigo = Number(respuesta["codigo"]) + 1;
    //                $("#codProducto").val(nuevoCodigo);
    //            }
               
    //         }
    //    })

    // });
    /* 
    =========================================
    SUBIR Y PRE VISUALIZAR IMAGEN DEL PRODUCTO
    =========================================
    */
   $('.imagenProducto').change(function() {
        let imagen = this.files[0];
        
        if (imagen.type != 'image/png' && imagen.type != 'image/jpeg') {

            $('.imagenProducto').val("");
            Swal.fire({
                type: 'error',
                title: 'Error al subir la imagen',
                text: 'La imagen no coincide con el formato solicitado',
                icon: 'error',
                confirmButtonText: 'Cerrar'
            });
        } 
        else if (imagen.size > 10000000) {
            $('.imagenProducto').val("");
            Swal.fire({
                type: 'error',
                title: 'Error al subir la imagen',
                text: 'La imagen no supera el tamaño indicado',
                icon: 'error',
                confirmButtonText: 'Cerrar'
            });
        }
        else {
            let datosImagen = new FileReader;
            datosImagen.readAsDataURL(imagen);

            $(datosImagen).on('load', function(event) {
                let rutaImagen = event.target.result;
                $('.preview').attr('src', rutaImagen);
            });
        }
        
    });

    /* 
    =====================================================
    MOSTRAR DATOS DE PRODUCTO EN FORMULARIO PARA EDITAR
    ====================================================
    */
    $(document).on("click", ".btn-editarProducto", function () {
    let idProducto = $(this).attr("idproducto");
    let datos = new FormData();
    datos.append('idProducto', idProducto);

        $.ajax({
            url: 'ajax/productos.ajax.php',
            method: 'POST',
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(respuesta) {
                console.log(respuesta);
                $("#idProducto").val(respuesta["id"]);
                $("#editarDescripcion").val(respuesta["descripcion"]);
                $("#editarCodProducto").val(respuesta["codigo"]);
                $("#editarCategoria").val(respuesta["id_categoria"]);
                $("#editarCategoria").html(respuesta["categoria"]);
                $("#editarAlmacen").val(respuesta["id_almacen"]);
                $("#editarAlmacen").html(respuesta["almacen"]);
                $("#editarCantidad").val(respuesta["stock"]);
                $("#editarPrecioCompra").val(respuesta["precio_compra"]);
                $("#editarPrecioVenta").val(respuesta["precio_venta"]);
                $("#imagenActual").val(respuesta["imagen"]);
                
                if(respuesta["imagen"] != null && respuesta["imagen"] != "") {
                    $('.preview').attr('src', respuesta["imagen"]);
                }

            }
        });
    });
    /*
    ================================================
    CALCULO DEL PORCENTAJE
    ================================================
    */
   $("#precioCompra").change(function () {
    if ($("#chkPorcentaje").prop("checked")) {
        let valorPorcentaje = $("#porcentaje").val();
        let porcentaje = ((Number($("#precioCompra").val()) * Number(valorPorcentaje)) / 100) + (Number($("#precioCompra").val()));
        $("#precioVenta").val(porcentaje);
    }
   });
   $("#editarPrecioCompra").change(function () {
    if ($("#chkPorcentaje").prop("checked")) {
        let valorPorcentaje = $("#porcentaje").val();
        let porcentaje = ((Number($("#precioCompra").val()) * Number(valorPorcentaje)) / 100) + (Number($("#precioCompra").val()));
        $("#precioVenta").val(porcentaje);
    }
   });
   $("#porcentaje").change(function () {
        let valorPorcentaje = $("#porcentaje").val();
        let porcentaje = ((Number($("#precioCompra").val()) * Number(valorPorcentaje)) / 100) + (Number($("#precioCompra").val()));
        $("#precioVenta").val(porcentaje);
   });
   $("#editarPorcentaje").change(function () {
    let valorPorcentaje = $("#porcentaje").val();
    let porcentaje = ((Number($("#precioCompra").val()) * Number(valorPorcentaje)) / 100) + (Number($("#precioCompra").val()));
    $("#precioVenta").val(porcentaje);
    });
    // introducción manual del precio de venta
    $("#chkPorcentaje").on("ifChecked", function () {
        $("#precioVenta").prop("readonly", true);
    });
    $("#chkPorcentaje").on("ifUnchecked", function () {
        $("#precioVenta").prop("readonly", false);
    });
    $("#editarChkPorcentaje").on("ifChecked", function () {
        $("#editarPrecioVenta").prop("readonly", true);
    });
    $("#editarChkPorcentaje").on("ifUnchecked", function () {
        $("#editarPrecioVenta").prop("readonly", false);
    });
    // verifico que mi precio de venta no sea menor al de compra
    $("#precioVenta").change(function () {
        $(".alert").remove();
        let valorPrecioCompra = Number($("#precioCompra").val());
        let valorPrecioVenta = Number ($("#precioVenta").val());
        if (valorPrecioVenta < valorPrecioCompra) {
            $("#precioVenta").parent().after('<div class="alert alert-warning">el precio de venta no puede ser mayor al precio de compra</div>');
            $("#precioVenta").val("");
        }
    });
    /* 
    =====================================================
    ELIMINAR PRODUCTO
    ====================================================
    */
   $(document).on("click", ".btn-eliminarProducto", function () {
    let idProducto = $(this).attr("idproducto");
    let imagenProducto = $(this).attr("imagenproducto");
    let codProducto = $(this).attr("codProducto");

    Swal.fire({
        title: '¿Desea eliminar el producto?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Eliminar'
      }).then((result) => {
        if (result.value) {
          window.location = "index.php?ruta=productos&idProducto="+idProducto+"&codProducto="+codProducto+"&imagenProducto="+imagenProducto;
        }
      })
    });

    // formato de fecha
    // $('#fechaNacimiento').datepicker({
    //     format: 'yyyy-mm-dd',
    //     autoclose: true
    //   });
    // formato de telefono
    $('[data-mask]').inputmask();

    /* 
    ================================================
    SELECCIONAR CLIENTE A EDITAR
    ================================================
    */
   $(document).on("click", ".btn-editarCliente", function () {
    let idCliente = $(this).attr("idCliente");
    let datos = new FormData();
    datos.append("idCliente", idCliente);
    $.ajax({
        url: 'ajax/clientes.ajax.php',
        method: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(respuesta) {
            $("#idCliente").val(respuesta["id"]);
            // $("#editarTipoDocumento").val(respuesta["tipo_documento"]);
            // $("#editarTipoDocumento").html(respuesta["tipo_documento"]);
            $("#editarDocumento").val(respuesta["documento"]);
            $("#editarNombre").val(respuesta["nombre"]);
            $("#editarEmail").val(respuesta["email"]);
            $("#editarTelefono").val(respuesta["telefono"]);
            // $("#editarFechaNacimiento").val(respuesta["fecha_nacimiento"]);
            $("#editarDireccion").val(respuesta["direccion"]);
        }
   })

   });

   /*
    =============================================
    VERIFICAR SI UN DOCUMENTO YA ESTA REGISTRADO
    =============================================
    */
   $('#documento').change(function () {
    $(".alert").remove();
    let documento = $(this).val();
    let tipoDocumento = $("#tipoDocumento").val();
    let datos = new FormData();
    datos.append('validaTipoDocumento', tipoDocumento);
    datos.append('validaDocumento', documento);
    $.ajax({
        url: 'ajax/clientes.ajax.php',
        method: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(respuesta) {
            console.log(respuesta);
            
           if(respuesta) {
               $("#documento").parent().after('<div class="alert alert-warning">el documento ya existe en la base de datos</div>');
               $("#documento").val("");
           }
        }
   })
});

    /* 
    =====================================================
    ELIMINAR CLIENTE
    ====================================================
    */
    $(document).on("click", ".btn-eliminarCliente", function () {
    let idCliente = $(this).attr("idCliente");
    
    Swal.fire({
        title: '¿Desea eliminar el cliente?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Eliminar'
    }).then((result) => {
            if (result.value) {
            window.location = "index.php?ruta=clientes&idCliente="+idCliente;
            }
        })
    });

    
    /* 
    =====================================================
    CARGAR DATOS DINAMICOS DE LOS PRODUCTOS(VENTAS) CON AJAX
    ====================================================
    */
   cargarDataTableVenta();
   function cargarDataTableVenta() {
    let almacen = $('#selectAlmacenVenta').selectpicker();
    let idAlmacen = $(almacen).selectpicker('val');
        $('.tablaProductoVenta').DataTable( {
            "destroy" : true,
            "ajax": {
                "url" : "ajax/ventas-datatable.ajax.php",
                "data" : {"id_almacen" : idAlmacen},
                "type" : "post"
            },
            "order" : [],
            "language": {
                "sProcessing":     "Procesando...",
                            "sLengthMenu":     "Mostrar _MENU_ registros",
                            "sZeroRecords":    "No se encontraron resultados",
                            "sEmptyTable":     "Ningún dato disponible en esta tabla =(",
                            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix":    "",
                            "sSearch":         "Buscar:",
                            "sUrl":            "",
                            "sInfoThousands":  ",",
                            "sLoadingRecords": "Cargando...",
                            "oPaginate": {
                                "sFirst":    "Primero",
                                "sLast":     "Último",
                                "sNext":     "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "oAria": {
                                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                            },
                            "buttons": {
                                "copy": "Copiar",
                                "colvis": "Visibilidad"
                            }
                }
        });
    }

    /* 
    =====================================================
    CARGAR DATOS DINAMICOS DE LOS PRODUCTOS(COTIZACION) CON AJAX
    ====================================================
    */
   cargarDataTableCotizacion();
   function cargarDataTableCotizacion() {
    let almacen = $('#selectAlmacenCotizacion').selectpicker();
    let idAlmacen = $(almacen).selectpicker('val');
        $('.tablaProductoCotizacion').DataTable( {
            "destroy" : true,
            "ajax": {
                "url" : "ajax/ventas-datatable.ajax.php",
                "data" : {"id_almacen" : idAlmacen},
                "type" : "post"
            },
            "order" : [],
            "language": {
                "sProcessing":     "Procesando...",
                            "sLengthMenu":     "Mostrar _MENU_ registros",
                            "sZeroRecords":    "No se encontraron resultados",
                            "sEmptyTable":     "Ningún dato disponible en esta tabla =(",
                            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix":    "",
                            "sSearch":         "Buscar:",
                            "sUrl":            "",
                            "sInfoThousands":  ",",
                            "sLoadingRecords": "Cargando...",
                            "oPaginate": {
                                "sFirst":    "Primero",
                                "sLast":     "Último",
                                "sNext":     "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "oAria": {
                                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                            },
                            "buttons": {
                                "copy": "Copiar",
                                "colvis": "Visibilidad"
                            }
                }
        });
    }

    /* 
    =====================================================
    AGREGAR PRODUCTOS
    ====================================================
    */
   $(".tablaProductoVenta tbody").on("click", "button.agregarProducto", function () {
    let idProducto = $(this).attr("idproducto");
    
    $(this).removeClass("btn-primary agregarProducto");
    $(this).addClass("btn-default");

    let datos = new FormData();
    datos.append("idProducto", idProducto);

    $.ajax({
        url: 'ajax/productos.ajax.php',
        method: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(respuesta) {
            let descripcion = respuesta["descripcion"];
            let stock = respuesta["stock"];
            let precio = respuesta["precio_venta"];
            let idProducto = respuesta["id"];

            if (stock == 0) {
                Swal.fire({
                    title: 'No hay stock disponible',
                    icon: 'error',
                    confirmButtonText: 'Cerrar'
                });
                $("button[idProducto='"+idProducto+"']").addClass("btn-primary agregarProducto");
                $("button[idProducto='"+idProducto+"']").removeClass("btn-default");

                return;
            }
            
            $(".productos").append(

                '<div class="row" style="padding:5px 15px">' +

                    '<!-- Descripción del producto -->' +
                    '<div class="col-xs-6" style="padding-right: 0px">' +
                    '<div class="input-group">' +
                        '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="'+idProducto+'"><i class="fa fa-times" aria-hidden="true"></i></button></span>' +
                        '<input type="text" class="form-control descripcionProducto" name="agregarProducto" id="agregarProducto" idProducto="'+idProducto+'" value="'+descripcion+'" required>' +
                    '</div>' +
                    '</div>' +

                    '<!-- Cantidad del producto -->' +
                    '<div class="col-xs-3 ingresoCantidad">' +
                    '<input type="number" class="form-control cantidadProducto" name="cantidadProducto" min="1" value="1" stock="'+stock+'" nuevoStock="'+Number(stock-1)+'" required>' +
                    '</div>' +

                    '<!-- Precio del producto -->' +
                    '<div class="col-xs-3 ingresoPrecio" style="padding-left: 0px">' +
                    '<div class="input-group">' +
                        
                        '<input type="text" class="form-control precioProducto" name="precioProducto" precioReal="'+precio+'" value="'+precio+'" readonly required>' +
                        '<span class="input-group-addon"><b>S/</b></span>' +
                    '</div>' +
                    '</div>' +
                '</div>'
            );

            // SUMAR TOTAL DE PRECIOS
            sumarTotalPrecios();
            // SUMAR LOS IMPUESTOS AL TOTAL
            agregarImpuesto();
            // FORMATEAR EL PRECIO
            $(".precioProducto").number(true, 2);
            // LISTAR PRODUCTOS EN JSON
            listarProductos();
            // MODIFICAR EL PRECIO DE DELIVERY
            modificaPrecioDelivery();

        }
    });
   });

   /* 
    =====================================================
    AGREGAR PRODUCTOS EN COTIZACION
    ====================================================
    */
   var contador = 1;
   $(".tablaProductoCotizacion tbody").on("click", "button.agregarProducto", function () {
    let idProducto = $(this).attr("idproducto");
    $(this).removeClass("btn-primary agregarProducto");
    $(this).addClass("btn-default");

    let datos = new FormData();
    datos.append("idProducto", idProducto);

    $.ajax({
        url: 'ajax/productos.ajax.php',
        method: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(respuesta) {
            let descripcion = respuesta["descripcion"];
            let stock = respuesta["stock"];
            let precio = respuesta["precio_venta"];
            let idProducto = respuesta["id"];

            
            $(".productos").append(

                '<div class="row" style="padding:5px 15px">' +

                    '<!-- Descripción del producto -->' +
                    '<div class="col-xs-4" style="padding-right: 0px">' +
                    '<div class="input-group">' +
                        '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="'+idProducto+'"><i class="fa fa-times" aria-hidden="true"></i></button></span>' +
                        '<input type="text" class="form-control descripcionProducto" name="agregarProducto" id="agregarProducto" idProducto="'+idProducto+'" value="'+descripcion+'" required>' +
                    '</div>' +
                    '</div>' +

                    '<!-- Cantidad del producto -->' +
                    '<div class="col-xs-2 ingresoCantidad">' +
                    '<input type="number" id="producto'+contador+'" class="form-control cantidadProducto" name="cantidadProducto" min="1" value="1" stock="'+stock+'" nuevoStock="'+Number(stock-1)+'" required>' +
                    '</div>' +

                    '<!-- Precio unitario del producto -->' +
                    '<div class="col-xs-3 ingresoPrecioUnitario" style="padding-left: 0px">' +
                        '<div class="input-group">' +
                            '<input type="text" class="form-control precioUnitario" name="precioUnitario" value="'+precio+'" required>' +
                            '<span class="input-group-addon"><b>S/</b></span>' +
                        '</div>' +
                    '</div>' +

                    '<!-- Precio del producto -->' +
                    '<div class="col-xs-3 ingresoPrecio" style="padding-left: 0px">' +
                        '<div class="input-group">' +
                            '<input type="text" class="form-control precioProducto" name="precioProducto" precioReal="'+precio+'" value="'+precio+'" required>' +
                            '<span class="input-group-addon"><b>S/</b></span>' +
                        '</div>' +
                    '</div>' +
                '</div>'
            );

            // SUMAR TOTAL DE PRECIOS
            sumarTotalPrecios();
            // SUMAR LOS IMPUESTOS AL TOTAL
            agregarImpuesto();
            // FORMATEAR EL PRECIO
            $(".precioProducto").number(true, 2);
            $(".precioUnitario").number(true, 2);
            // LISTAR PRODUCTOS EN JSON
            listarProductos();
            // MODIFICAR EL PRECIO DE DELIVERY
            modificaPrecioDelivery();
            
            contador++;
        }
    });
   });

   /*=====================================================
   FUNCION PARA MODIFICAR EL PRECIO DEL DELIVERY
   =======================================================*/
   function modificaPrecioDelivery() {
       let arrayDescripciones = $(".descripcionProducto");
       let arrayPrecios = $(".precioProducto");
       let arrayCantidades = $(".cantidadProducto");
       for (let i = 0; i < arrayDescripciones.length; i++) {
            
            if($(arrayDescripciones[i]).val().toLowerCase() == "delivery" || $(arrayDescripciones[i]).val() == "10") {
                $(arrayPrecios[i]).removeAttr("readonly");
                $(arrayPrecios[i]).attr("precioReal", "1");
                $(arrayCantidades[i]).attr("readonly", true);
            }
            else {
                $(arrayCantidades[i]).removeAttr("readonly");
            }
           
       }
       
   }
   $(".formularioVenta").on("change", ".precioProducto", function (e) {
        let precioDelivery = $(this).val();
        $(this).attr("precioReal", precioDelivery);
        console.log($(this).attr("precioReal"));
        // SUMAR TOTAL DE PRECIOS
        sumarTotalPrecios();
        // SUMAR LOS IMPUESTOS AL TOTAL
        agregarImpuesto();
        // FORMATEAR EL PRECIO
        $(".precioProducto").number(true, 2);
        // LISTAR PRODUCTOS EN JSON
        listarProductos();
        
    });

   /*=============================================
    RECUPERAR EL ID DEL PRODUCTO AL NAVEGAR POR LA TABLA DINAMICA
    ==============================================*/
   $(".tablaProductoVenta").on("draw.dt", function () {
    if (localStorage.getItem("quitarProducto") != null) {
        let listarIdProductos = JSON.parse(localStorage.getItem("quitarProducto"));
        for (let i = 0; i < listarIdProductos.length; i++) {
            
            $("button.recuperarBoton[idProducto='"+listarIdProductos[i]["idProducto"]+"']").removeClass("btn-default");
            $("button.recuperarBoton[idProducto='"+listarIdProductos[i]["idProducto"]+"']").addClass("btn-primary agregarProducto");
            
        }
    }
   });

   /*=============================================
    VERIFICAR VARIABLES DEL LOCAL STORAGE
    ==============================================*/
   if (localStorage.getItem("capturarRango") != null) {
    $('#daterange-btn span').html(localStorage.getItem('capturarRango'));
   }
   else {
    $('#daterange-btn span').html('<i class="far fa-calendar-alt"></i> Rango de fecha');
   }

    if (localStorage.getItem("capturarRango2") != null) {
        $('#daterange-btn2 span').html(localStorage.getItem('capturarRango2'));
       }
       else {
        $('#daterange-btn2 span').html('<i class="far fa-calendar-alt"></i> Rango de fecha');
       }

   /* 
    =====================================================
    QUITAR PRODUCTO
    =====================================================
    */
   var idQuitarProducto;
   localStorage.removeItem("quitarProducto");
   $(".formularioVenta").on("click", "button.quitarProducto", function() {
    $(this).parent().parent().parent().parent().remove();
    let idProducto = $(this).attr("idProducto");

    /*=========================================================
      ALMACENAR EN EL LOCALSTORAGE EL ID DEL PRODUCTO A QUITAR
      =========================================================
    */
    if (localStorage.getItem("quitarProducto") == null) {
        idQuitarProducto = [];
    }
    else {
        idQuitarProducto.concat(localStorage.getItem("quitarProducto"));
    }
    idQuitarProducto.push({"idProducto": idProducto});
    localStorage.setItem("quitarProducto", JSON.stringify(idQuitarProducto));

    $("button.recuperarBoton[idProducto='"+idProducto+"']").removeClass("btn-default");
    $("button.recuperarBoton[idProducto='"+idProducto+"']").addClass("btn-primary agregarProducto");

    if($(".productos").children().length != 0) {
        // SUMAR TOTAL DE PRECIOS
        sumarTotalPrecios();
        // SUMAR LOS IMPUESTOS AL TOTAL
        agregarImpuesto();
        // LISTAR PRODUCTOS EN JSON
        listarProductos();
        
    }
    else {
        $("#totalVenta").val(0);
        $("#totalVenta").attr("total",0);
    }

   });

   /*=====================================================
   AL MOMENTO DE SELECCIONAR EL PRODUCTO
   =======================================================*/
   $(".formularioVenta").on("change", "select.descripcionProducto", function() {
       let idProducto = $(this).val();
       let descripcionProducto = $(this).parent().parent().parent().children().children().children(".descripcionProducto");
       let precioProducto = $(this).parent().parent().parent().children(".ingresoPrecio").children().children(".precioProducto");
       let cantidadProducto = $(this).parent().parent().parent().children(".ingresoCantidad").children(".cantidadProducto");
       console.log(idProducto);
       

       let datos = new FormData();
       datos.append("idProducto", idProducto);
       $.ajax({
        url: 'ajax/productos.ajax.php',
        method: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(respuesta) {
            $(descripcionProducto).attr("idProducto", respuesta["id"]);
            $(cantidadProducto).attr("stock", respuesta["stock"]);
            $(cantidadProducto).attr("nuevoStock", Number(respuesta["stock"]) - 1)
            $(precioProducto).val(respuesta["precio_venta"]);
            $(precioProducto).attr("precioReal", respuesta["precio_venta"]);
            
            // SUMAR TOTAL DE PRECIOS
            sumarTotalPrecios();
            // SUMAR LOS IMPUESTOS AL TOTAL
            agregarImpuesto();
            // LISTAR PRODUCTOS EN JSON
            listarProductos();
            // MODIFICAR EL PRECIO DE DELIVERY
            modificaPrecioDelivery();
        }
    });

   });

   /*================================================
   MODIFICAR PRECIO DEL PRODUCTO SEGUN LA CANTIDAD
   ==================================================*/
   $(".formularioVenta").on("change", ".cantidadProducto", function () {
    let precio = $(this).parent().parent().children(".ingresoPrecio").children().children(".precioProducto");
    let precioSumado = $(this).val() * precio.attr("precioReal");
    $(precio).val(precioSumado);

    let nuevoStock = Number($(this).attr("stock")) - $(this).val();

	$(this).attr("nuevoStock", nuevoStock);

    if (Number($(this).attr("stock")) < Number($(this).val())) {
        Swal.fire({
            title: 'La cantidad supera el stock',
            text: 'Sólo hay '+$(this).attr("stock")+' unidades disponibles',
            icon: 'error',
            confirmButtonText: 'Cerrar'
        });
        $(this).val(1);
        precioSumado = $(this).val() * precio.attr("precioReal");
    }
    // SUMAR TOTAL DE PRECIOS
    sumarTotalPrecios();

    // SUMAR LOS IMPUESTOS AL TOTAL
    agregarImpuesto();

    // APLICAR DESCUENTOS
    aplicaDescuento();

    // LISTAR PRODUCTOS EN JSON
    listarProductos();
    
   });

   /*================================================
   SUMAR TODOS LOS PRECIOS
   ==================================================*/
   function sumarTotalPrecios() {
       let precioItem = $(".precioProducto");
       let arraySumaPrecios = [];
       
       for (let i = 0; i < precioItem.length; i++) {
           arraySumaPrecios.push(Number($(precioItem[i]).val()));
       }
       
       function sumaPrecios(total, numero) {
           return total + numero;
       }

       let sumaTotalPrecio = arraySumaPrecios.reduce(sumaPrecios);
       $("#totalVenta").val(sumaTotalPrecio);
       $("#totalVenta").attr("total",sumaTotalPrecio);
       
   }

   /*==========================================
   FUNCION PARA AGREGAR EL IMPUESTO
   ============================================*/
   function agregarImpuesto() {
       let impuesto = $("#impuestoVenta").val();
       let precioTotal = $("#totalVenta").attr("total");

       let precioImpuesto = Number(precioTotal * impuesto/100);

       let totalConImpuesto = Number(precioImpuesto) + Number(precioTotal);
       $("#totalVenta").val(totalConImpuesto);
       $("#valorImpuesto").val(precioImpuesto);
       $("#precioNeto").val(precioTotal);
   }

    //EJECUTO LA FUNCION AL CAMBIAR EL VALOR DEL IMPUESTO    
   $("#impuestoVenta").change(function() {
    agregarImpuesto();
   });
   // FORMATEAR EL PRECIO
   $("#totalVenta").number(true, 2);
   // LISTAR PRODUCTOS EN JSON
   listarProductos();

   /*=============================================
    SELECCIONAR MÉTODO DE PAGO
    =============================================*/
   $("#metodoDePago").change(function () {

    let metodo = $(this).val();
    
    if(metodo == "efectivo") {
        $(this).parent().parent().removeClass("col-xs-6");
        $(this).parent().parent().addClass("col-xs-4");
        $(this).parent().parent().parent().children(".cajasMetodoPago").html(
            '<div class="col-xs-4">'+ 

			 	'<div class="input-group">'+ 

			 		'<span class="input-group-addon"><b>S/</b></span>'+ 

			 		'<input type="text" class="form-control" id="valorEfectivo" placeholder="Cliente entregó" required>'+

			 	'</div>'+

			 '</div>'+

			 '<div class="col-xs-4" id="capturarCambioEfectivo" style="padding-left:0px">'+

			 	'<div class="input-group">'+

			 		'<span class="input-group-addon"><b>S/</b></span>'+

			 		'<input type="text" class="form-control" id="cambioEfectivo" placeholder="A devolver" readonly required>'+

			 	'</div>'+

			 '</div>'
        );

        // FORMATEAR LOS DIGITOS DE EFECTIVO
        $("#valorEfectivo").number(true, 2);
        $("#cambioEfectivo").number(true, 2);

        // LISTAR METODO EN EL INPUT
        listarMetodos();
    }
    else if (metodo == "contraentrega") {
        $(this).parent().parent().removeClass('col-xs-4');

        $(this).parent().parent().addClass('col-xs-6');

        $(this).parent().parent().parent().children('.cajasMetodoPago').html(

            '<div class="col-xs-6" style="padding-left:0px">'+
                       
             '</div>'
        );
        
        
        // LISTAR METODO EN EL INPUT
        listarMetodos();
    }
    else if (metodo == "transferencia") {
        console.log(metodo);
        
        $(this).parent().parent().removeClass('col-xs-4');

		$(this).parent().parent().addClass('col-xs-6');

		 $(this).parent().parent().parent().children('.cajasMetodoPago').html(

		 	'<div class="col-xs-6" style="padding-left:0px">'+
                        
                '<div class="input-group">'+
                     
                  '<input type="number" min="0" class="form-control" id="codigoTransaccion" placeholder="Código transacción"  required>'+
                       
                  '<span class="input-group-addon"><i class="fa fa-lock"></i></span>'+
                  
                '</div>'+

              '</div>'
              );
            // LISTAR METODO EN EL INPUT
            listarMetodos();
    }
    else {
        $(this).parent().parent().removeClass('col-xs-4');

		$(this).parent().parent().addClass('col-xs-6');

		 $(this).parent().parent().parent().children('.cajasMetodoPago').html(

		 	'<div class="col-xs-6" style="padding-left:0px">'+
                        
                '<div class="input-group">'+
                     
                  '<input type="number" min="0" class="form-control" id="codigoTransaccion" placeholder="Código transacción"  required>'+
                       
                  '<span class="input-group-addon"><i class="fa fa-lock"></i></span>'+
                  
                '</div>'+

              '</div>'
              );
            // LISTAR METODO EN EL INPUT
            listarMetodos();
    }

   });

   /*=================================================
   CALCULAR EL CAMBIO
   ===================================================*/
   $(".formularioVenta").on("change", "input#valorEfectivo", function () {
       let efectivo = $(this).val();
       let cambio = Number(efectivo) - Number($("#totalVenta").val());
       let inputCambio = $(this).parent().parent().parent().children("#capturarCambioEfectivo").children().children("#cambioEfectivo");
       $(inputCambio).val(cambio);
       
   });

   /*=============================================
    LISTAR MÉTODO DE PAGO
    =============================================*/

    function listarMetodos(){

        var listaMetodos = "";

        if($("#metodoDePago").val() == "efectivo"){

            $("#listaMetodoPago").val("efectivo");

        }
        else if($("#metodoDePago").val() == "contraentrega") {
            $("#listaMetodoPago").val("contraentrega");
        }
        else if($("#metodoDePago").val() == "transferencia") {
            $("#listaMetodoPago").val($("#metodoDePago").val()+"-"+$("#codigoTransaccion").val());
        }
        else{

            $("#listaMetodoPago").val($("#metodoDePago").val()+"-"+$("#codigoTransaccion").val());

        }

    }

    /*=============================================
    INVOCO FUNCION MÉTODO DE PAGO AL COLOCAR EL COD DE TRANSACCION CON TC O TD
    =============================================*/

    $(".formularioVenta").on("change", "input#codigoTransaccion", function () {
        // LISTAR METODO EN EL INPUT
        listarMetodos();
    });

    /*=============================================
    LISTAR TODOS LOS PRODUCTOS EN FORMATO JSON
    ===============================================*/
    function listarProductos () {
        let listarProducto = [];
        let descripcion = $(".descripcionProducto");
        let precio = $(".precioProducto");
        let cantidad = $(".cantidadProducto");
        let valorPorcentaje = $("#editarPorcentaje").val();

        for (let i = 0; i < descripcion.length; i++) {
            let precioProducto = $(precio[i]).attr("precioReal");
            let precioConPorcentaje = Number(precioProducto) - Number((precioProducto * Number(valorPorcentaje)) / 100);
            
            listarProducto.push({
                "id" : $(descripcion[i]).attr("idProducto"),
                "descripcion" : $(descripcion[i]).val(),
                "precio" : precioConPorcentaje,
                "cantidad" : $(cantidad[i]).val(),
                "stock" : $(cantidad[i]).attr("nuevoStock"),
                "total" : $(precio[i]).val()
            });
            
        }
        $("#listaProductos").val(JSON.stringify(listarProducto));
        
    }
    /*======================================================
    BOTON PARA EDITAR VENTA
    ========================================================*/
    $(document).on("click", ".btn-editarVenta", function () {
        let idVenta = $(this).attr("idVenta");
        
        window.location = "index.php?ruta=editar-venta&idVenta="+idVenta;
    });
    /*=============================================
    FUNCIÓN PARA DESACTIVAR LOS BOTONES AGREGAR CUANDO EL PRODUCTO YA HABÍA SIDO SELECCIONADO EN LA CARPETA
    =============================================*/

    function quitarAgregarProducto(){

        //Capturamos todos los id de productos que fueron elegidos en la venta
        var idProductos = $(".quitarProducto");

        //Capturamos todos los botones de agregar que aparecen en la tabla
        var botonesTabla = $(".tablaProductoVenta tbody button.agregarProducto");

        //Recorremos en un ciclo para obtener los diferentes idProductos que fueron agregados a la venta
        for(var i = 0; i < idProductos.length; i++){

            //Capturamos los Id de los productos agregados a la venta
            var boton = $(idProductos[i]).attr("idProducto");
            
            //Hacemos un recorrido por la tabla que aparece para desactivar los botones de agregar
            for(var j = 0; j < botonesTabla.length; j ++){

                if($(botonesTabla[j]).attr("idProducto") == boton){

                    $(botonesTabla[j]).removeClass("btn-primary agregarProducto");
                    $(botonesTabla[j]).addClass("btn-default");

                }
            }

        }
        
    }

    /*================================================
    APLICAR DESCUENTO A LOS PRODUCTOS
    ==================================================*/
    function aplicaDescuento () {
        let valorPorcentaje = $("#editarPorcentaje").val();
        let productos = $(".precioProducto");
        let cantidad = $(".cantidadProducto");
        
        if (productos.length > 0) {
            for (let i = 0; i < productos.length; i++) {
                let precioProducto = Number($(productos[i]).attr("precioReal")) * Number($(cantidad[i]).val());
                // let precioProducto = $(productos[i]).val();
                let porcentaje = Number(precioProducto) - Number((precioProducto * Number(valorPorcentaje)) / 100);
                
                $(productos[i]).val(porcentaje);
                sumarTotalPrecios();
                listarProductos();
            }
        }
    }

    // INVOCO LA FUNCION DE APLICAR DESCUENTO 
    $("#editarPorcentaje").change(function () { 
       aplicaDescuento();
    });

    /*=============================================
    CADA VEZ QUE CARGUE LA TABLA CUANDO NAVEGAMOS EN ELLA EJECUTAR LA FUNCIÓN:
    =============================================*/
    $('.tablaProductoVenta').on( 'draw.dt', function(){
        quitarAgregarProducto();
    });

    /* 
    =====================================================
    ANULAR VENTA
    ====================================================
    */
   $(document).on("click", ".btn-anularVenta", function () {
    let idVenta = $(this).attr("idVenta");
    
    Swal.fire({
        title: '¿Desea anular la venta?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Anular'
    }).then((result) => {
            if (result.value) {
            window.location = "index.php?ruta=pedidos&idVenta="+idVenta;
            }
        })
    });

    /* 
    =====================================================
    IMPRIMIR LA BOLETA DE LA VENTA (Administrador)
    ====================================================
    */
   $(document).on("click", ".btn-imprimirDetalle", function () {
    let codigoVenta = $(this).attr("codVenta");

    // formato CARTA
    window.open("extensions/tcpdf/pdf/pedido.php?codigo="+codigoVenta, "_blank");

    // formato TICKETERA
    // window.open("extensions/tcpdf/pdf/pedido-ticket.php?codigo="+codigoVenta, "_blank");
    // window.open("extensions/tcpdf/pdf/pdf.php");
   });

   /* 
    =====================================================
    IMPRIMIR LA BOLETA DE LA VENTA (Vendedor)
    ====================================================
    */
   $(document).on("click", ".btn-imprimirDetalleVendedor", function () {
    let codigoVenta = $(this).attr("codVenta");

    window.open("extensions/tcpdf/pdf/pedido-vendedor.php?codigo="+codigoVenta, "_blank");
    // window.open("extensions/tcpdf/pdf/pdf.php");
   });

   /* 
    =====================================================
    RANGO DE FECHAS
    ====================================================
    */
   $('#daterange-btn').daterangepicker(
    {
      ranges   : {
        'Hoy'       : [moment(), moment()],
        'Ayer'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Últimos 7 días' : [moment().subtract(6, 'days'), moment()],
        'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
        'Este mes'  : [moment().startOf('month'), moment().endOf('month')],
        'Último mes'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      },
      startDate: moment(),
      endDate  : moment()
    },
    function (start, end) {
      $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      let fechaInicial = start.format('YYYY-MM-DD');
      let fechaFinal = end.format('YYYY-MM-DD');
      let capturarRango = $('#daterange-btn span').html();

      localStorage.setItem('capturarRango', capturarRango);

      window.location = 'index.php?ruta=pedidos&fechaInicial='+fechaInicial+'&fechaFinal='+fechaFinal;
    }
  );
    /* 
    =====================================================
    LO MISMO PARA EL RANGO DE LOS REPORTES
    ====================================================
    */
   $('#daterange-btn2').daterangepicker(
    {
      ranges   : {
        'Hoy'       : [moment(), moment()],
        'Ayer'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Últimos 7 días' : [moment().subtract(6, 'days'), moment()],
        'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
        'Este mes'  : [moment().startOf('month'), moment().endOf('month')],
        'Último mes'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      },
      startDate: moment(),
      endDate  : moment()
    },
    function (start, end) {
      $('#daterange-btn2 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      let fechaInicial = start.format('YYYY-MM-DD');
      let fechaFinal = end.format('YYYY-MM-DD');
      let capturarRango = $('#daterange-btn2 span').html();

      localStorage.setItem('capturarRango2', capturarRango);

      window.location = 'index.php?ruta=reporte-ventas&fechaInicial='+fechaInicial+'&fechaFinal='+fechaFinal;
    }
  );

    /* 
    =====================================================
    CANCELAR SELECCION DEL RANGO
    ====================================================
    */
   $('.daterangepicker.opensleft .range_inputs .cancelBtn').on('click', function () {
       localStorage.removeItem('capturarRango');
       localStorage.clear();
       window.location = 'pedidos';
   });
   /* 
    =====================================================
    CANCELAR SELECCION DEL RANGO (REPORTES)
    ====================================================
    */
   $('.daterangepicker.opensright .range_inputs .cancelBtn').on('click', function () {
    localStorage.removeItem('capturarRango2');
    localStorage.clear();
    window.location = 'reporte-ventas';
        
    });

    /* 
    =====================================================
    CAPTURAR EL RANGO SELECCIONADO POR DEFECTO
    ====================================================
    */   
   $('.daterangepicker.opensleft .ranges li').on('click', function () {
    let textoHoy = $(this).attr('data-range-key');

    if (textoHoy == "Hoy") {
        let fecha = new Date();
        let dia = fecha.getDate();
        let mes = fecha.getMonth() + 1;
        let year = fecha.getFullYear();

        if (mes < 10) {
            var fechaInicial = year+'-0'+mes+'-'+dia;
            var fechaFinal = year+'-0'+mes+'-'+dia;
        }
        else if (dia < 10) {
            var fechaInicial = year+'-'+mes+'-0'+dia;
            var fechaFinal = year+'-'+mes+'-0'+dia;
        }
        else if (dia < 10 && mes < 10) {
            var fechaInicial = year+'-0'+mes+'-0'+dia;
            var fechaFinal = year+'-0'+mes+'-0'+dia;
        }
        else {
            var fechaInicial = year+'-'+mes+'-'+dia;
            var fechaFinal = year+'-'+mes+'-'+dia;
        }

        localStorage.setItem("capturarRango", "Hoy");

        window.location = 'index.php?ruta=pedidos&fechaInicial='+fechaInicial+'&fechaFinal='+fechaFinal;
    }
   });
   /* 
    =====================================================
    CAPTURAR EL RANGO SELECCIONADO POR DEFECTO (REPORTES)
    ====================================================
    */   
   $('.daterangepicker.opensright .ranges li').on('click', function () {
    let textoHoy = $(this).attr('data-range-key');

    if (textoHoy == "Hoy") {
        // console.log('ola k ase');
        
        let fecha = new Date();
        let dia = fecha.getDate();
        let mes = fecha.getMonth() + 1;
        let year = fecha.getFullYear();

        if (mes < 10) {
            var fechaInicial = year+'-0'+mes+'-'+dia;
            var fechaFinal = year+'-0'+mes+'-'+dia;
        }
        else if (dia < 10) {
            var fechaInicial = year+'-'+mes+'-0'+dia;
            var fechaFinal = year+'-'+mes+'-0'+dia;
        }
        else if (dia < 10 && mes < 10) {
            var fechaInicial = year+'-0'+mes+'-0'+dia;
            var fechaFinal = year+'-0'+mes+'-0'+dia;
        }
        else {
            var fechaInicial = year+'-'+mes+'-'+dia;
            var fechaFinal = year+'-'+mes+'-'+dia;
        }

        localStorage.setItem("capturarRango2", "Hoy");

        window.location = 'index.php?ruta=reporte-ventas&fechaInicial='+fechaInicial+'&fechaFinal='+fechaFinal;
    }
   });

   /*======================================================
    BOTON PARA EDITAR COTIZACION
    ========================================================*/
    $(document).on("click", ".btn-editarCotizacion", function () {
        let idCotizacion = $(this).attr("idCotizacion");
        
        window.location = "index.php?ruta=editar-cotizacion&idCotizacion="+idCotizacion;
    });

    /* 
    =====================================================
    ANULAR COTIZACION
    ====================================================
    */
   $(document).on("click", ".btn-anularCotizacion", function () {
    let idCotizacion = $(this).attr("idCotizacion");
    
    Swal.fire({
        title: '¿Desea anular la cotización?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Anular'
    }).then((result) => {
            if (result.value) {
            window.location = "index.php?ruta=cotizaciones&idCotizacion="+idCotizacion;
            }
        })
    });

    /* 
    =====================================================
    IMPRIMIR LA COTIZACION
    ====================================================
    */
   $(document).on("click", ".btn-imprimirCotizacion", function () {
    let codigoCotizacion = $(this).attr("codCotizacion");

    window.open("extensions/tcpdf/pdf/cotizacion.php?codigo="+codigoCotizacion, "_blank");
    // window.open("extensions/tcpdf/pdf/pdf.php");
   });

   /* 
    =====================================================
    IMPRIMIR LISTA DE PRECIOS
    ====================================================
    */
   $(document).on("click", ".imprimirProductos", function () {
    window.open("extensions/tcpdf/pdf/productos.php", "_blank");
   });

   /*======================================================
    BOTON PARA VER MOVIMIENTOS DEL PRODUCTO
    ========================================================*/
    $(document).on("click", ".btn-verMovimientos", function () {
        let idProducto = $(this).attr("idProducto");
        
        window.location = "index.php?ruta=movimientos&idProducto="+idProducto;
    });

    /*======================================================
    BOTON PARA GENERAR VENTA A PARTIR DE LA COTIZACION SELECCIONADA
    ========================================================*/
    $(document).on("click", ".btn-convierteVenta", function () {
        let idCotizacion = $(this).attr("idCotizacion");
        
        window.location = "index.php?ruta=crear-pedido2&idCotizacion="+idCotizacion;
    });

    /*===========================================================
    **************************************************
    *******************PARA LA COTIZACION*************
    **************************************************
    =============================================================*/
    $(".formularioCotizacion").on("change", ".precioProducto", function (e) {
        let precioDelivery = $(this).val();
        $(this).attr("precioReal", precioDelivery);
        // SUMAR TOTAL DE PRECIOS
        sumarTotalPrecios();
        // SUMAR LOS IMPUESTOS AL TOTAL
        agregarImpuesto();
        // FORMATEAR EL PRECIO
        $(".precioProducto").number(true, 2);
        // LISTAR PRODUCTOS EN JSON
        listarProductos();
        
    });
    $(".formularioCotizacion").on("change", ".precioUnitario", function (e) {
        
        let cantidad = $(this).parent().parent().parent().children(".ingresoCantidad").children(".cantidadProducto");
        let precioSumado = $(this).val() * cantidad.val();
        
        let precio = $(this).parent().parent().parent().children(".ingresoPrecio").children().children(".precioProducto");
        $(precio).attr("precioReal", precioSumado);
        $(precio).val(precioSumado);

        // SUMAR TOTAL DE PRECIOS
        sumarTotalPrecios();
    
        // SUMAR LOS IMPUESTOS AL TOTAL
        agregarImpuesto();
    
        // APLICAR DESCUENTOS
        // aplicaDescuento();
    
        // LISTAR PRODUCTOS EN JSON
        listarProductos();
        
    });
    
    /* 
        =====================================================
        QUITAR PRODUCTO COTIZACION
        =====================================================
        */
       var idQuitarProducto;
       localStorage.removeItem("quitarProducto");
       $(".formularioCotizacion").on("click", "button.quitarProducto", function() {
        $(this).parent().parent().parent().parent().remove();
        let idProducto = $(this).attr("idProducto");
    
        /*=========================================================
          ALMACENAR EN EL LOCALSTORAGE EL ID DEL PRODUCTO A QUITAR
          =========================================================
        */
        if (localStorage.getItem("quitarProducto") == null) {
            idQuitarProducto = [];
        }
        else {
            idQuitarProducto.concat(localStorage.getItem("quitarProducto"));
        }
        idQuitarProducto.push({"idProducto": idProducto});
        localStorage.setItem("quitarProducto", JSON.stringify(idQuitarProducto));
    
        $("button.recuperarBoton[idProducto='"+idProducto+"']").removeClass("btn-default");
        $("button.recuperarBoton[idProducto='"+idProducto+"']").addClass("btn-primary agregarProducto");
    
        if($(".productos").children().length != 0) {
            // SUMAR TOTAL DE PRECIOS
            sumarTotalPrecios();
            // SUMAR LOS IMPUESTOS AL TOTAL
            agregarImpuesto();
            // LISTAR PRODUCTOS EN JSON
            listarProductos();
            
        }
        else {
            $("#totalVenta").val(0);
            $("#totalVenta").attr("total",0);
        }
    
       });
    
       
    
    /*===================================================
    MODIFICAR PRECIO DEL PRODUCTO SEGUN LA CANTIDAD EN COTIZACION
    =====================================================*/
       
       $(".formularioCotizacion").on("change", ".cantidadProducto", function () {
        
        let precio = $(this).parent().parent().children(".ingresoPrecioUnitario").children().children(".precioUnitario");
        // console.log(precio.val());
        
        let precioSumado = $(this).val() * precio.val();
        // console.log(precioSumado);
        
        let precio2 = $(this).parent().parent().children(".ingresoPrecio").children().children(".precioProducto");
        
        $(precio2).val(precioSumado);
    
        let nuevoStock = Number($(this).attr("stock")) - $(this).val();
    
        $(this).attr("nuevoStock", nuevoStock);
    
        // if (Number($(this).attr("stock")) < Number($(this).val())) {
        //     Swal.fire({
        //         title: 'La cantidad supera el stock',
        //         text: 'Sólo hay '+$(this).attr("stock")+' unidades disponibles',
        //         icon: 'error',
        //         confirmButtonText: 'Cerrar'
        //     });
        // }
        // SUMAR TOTAL DE PRECIOS
        sumarTotalPrecios();
    
        // SUMAR LOS IMPUESTOS AL TOTAL
        agregarImpuesto();
    
        // APLICAR DESCUENTOS
        // aplicaDescuento();
    
        // LISTAR PRODUCTOS EN JSON
        listarProductos();
        
       });
    
        /*=================================================
       CALCULAR EL CAMBIO EN COTIZACION
       ===================================================*/
       $(".formularioCotizacion").on("change", "input#valorEfectivo", function () {
        let efectivo = $(this).val();
        let cambio = Number(efectivo) - Number($("#totalVenta").val());
        let inputCambio = $(this).parent().parent().parent().children("#capturarCambioEfectivo").children().children("#cambioEfectivo");
        $(inputCambio).val(cambio);
        
    });
    
    /*=============================================
    INVOCO FUNCION MÉTODO DE PAGO AL COLOCAR EL COD DE TRANSACCION CON TC O TD
    =============================================*/
    
        $(".formularioCotizacion").on("change", "input#codigoTransaccion", function () {
            // LISTAR METODO EN EL INPUT
            listarMetodos();
        });
    
    /*===================================================
    MOSTRAR ESTADOS DEL PEDIDO EN EL SELECT (EDITAR PEDIDO)
    =====================================================*/
    let estado = $("#estado").selectpicker();
    let valorEstado = $(estado).selectpicker('val');

    switch (valorEstado) {
        case '1':
            $(estado).find('[value=1]').prop("selected", true);
            $(estado).selectpicker('refresh');
            break;
        case '3':
            $(estado).find('[value=3]').prop("selected", true);
            $(estado).selectpicker('refresh');
            break;
        case '4':
            $(estado).find('[value=4]').prop("selected", true);
            $(estado).selectpicker('refresh');
            break;
    
        default:
            
            break;
    }

    /*===================================================
    MOSTRAR PRODUCTOS POR ALMACEN SELECCIONADO
    =====================================================*/    
    $('#selectAlmacen').change(function() {
        cargarDataTable();
    });

    /*===================================================
    MOSTRAR PRODUCTOS POR ALMACEN SELECCIONADO (VENTAS)
    =====================================================*/    
    $('#selectAlmacenVenta').change(function() {
        cargarDataTableVenta();
    });

    /*===================================================
    MOSTRAR PRODUCTOS POR ALMACEN SELECCIONADO (COTIZACIONES)
    =====================================================*/    
    $('#selectAlmacenCotizacion').change(function() {
        cargarDataTableCotizacion();
    });

    /*==================================================
    INVOCO A MI DATATABLE ENVIANDO COMO PARAMETRO EL DEL ID DEL ALMACEN
    ====================================================*/
    function cargarDataTable() {
        let almacen = $('#selectAlmacen').selectpicker();
        let idAlmacen = $(almacen).selectpicker('val');
        $('.tablaProducto').DataTable( {
            "destroy" : true,
            "ajax": {
                "url" : "ajax/productos-datatable.ajax.php",
                "data" : {"id_almacen" : idAlmacen},
                "type" : "post"
            },
            "order" : [],
            "language": {
                "sProcessing":     "Procesando...",
                            "sLengthMenu":     "Mostrar _MENU_ registros",
                            "sZeroRecords":    "No se encontraron resultados",
                            "sEmptyTable":     "Ningún dato disponible en esta tabla =(",
                            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix":    "",
                            "sSearch":         "Buscar:",
                            "sUrl":            "",
                            "sInfoThousands":  ",",
                            "sLoadingRecords": "Cargando...",
                            "oPaginate": {
                                "sFirst":    "Primero",
                                "sLast":     "Último",
                                "sNext":     "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "oAria": {
                                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                            },
                            "buttons": {
                                "copy": "Copiar",
                                "colvis": "Visibilidad"
                            }
            }
        });
    }
});