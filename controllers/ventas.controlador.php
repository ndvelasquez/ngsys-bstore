<?php
    class ControladorVentas {
        /*
        =====================================
        MOSTRAR VENTAS
        =====================================
        */

        static public function ctrlMostrarVentas($item, $valor) {
            $tabla = "ventas";
            $respuesta = ModeloVentas::mdlMostrarVenta($tabla, $item, $valor);

            return $respuesta;
        }

        /*
        =====================================
        GUARDAR VENTA
        =====================================
        */

        static public function ctrlCrearVenta() {
            if (isset($_POST["codVenta"])
               && isset($_POST["idVendedor"])
               && isset($_POST["agregarCliente"])
               && isset($_POST["listaProductos"])
               && isset($_POST["precioNeto"])
               && isset($_POST["valorImpuesto"])
               && isset($_POST["totalVenta"])
               && isset($_POST["listaMetodoPago"])) {

                if (preg_match('/[0-9]+/', $_POST["codVenta"])
                  && preg_match('/[0-9.]+/', $_POST["precioNeto"])
                  && preg_match('/[0-9.]+/', $_POST["valorImpuesto"])
                  && preg_match('/[0-9.]+/', $_POST["totalVenta"])) {

                    
                    $tabla = "ventas";
                    $listaProductos = json_decode($_POST["listaProductos"], true);
                    $totalProductosComprados = array();
                    // Formateo el precio a un formato adecuado para la BD
                    $precioTotal = $_POST["totalVenta"];
                    $precioFormateado = (0+str_replace(",","",$precioTotal));
                    $precioFormateado = number_format($precioFormateado,2,".","");
                    
                    $datos = array(
                        "codigo" => $_POST["codVenta"],
                        "id_usuario" => $_POST["idVendedor"],
                        "id_cliente" => $_POST["agregarCliente"],
                        "productos" => $_POST["listaProductos"],
                        "neto" => $_POST["precioNeto"],
                        "impuestos" => $_POST["valorImpuesto"],
                        "total" => $precioFormateado,
                        "metodo_pago" => $_POST["listaMetodoPago"],
                        "estado" => 1
                    );
                    $respuesta = ModeloVentas::mdlCrearVenta($tabla,$datos);

                    if ($respuesta == "ok") {
                        /*=============================================
                        GUARDO EL DETALLE DE LA VENTA
                        ===============================================*/
                        $item =  "codigo";
                        $valor = $_POST["codVenta"];
                        // Traigo la venta insertada recientemente
                        $traerVenta = ModeloVentas::mdlMostrarVenta($tabla, $item, $valor);
                        foreach ($listaProductos as $key => $producto) {
                            $tablaDetalleVenta = "detalle_venta";

                            $datosDetalleVenta = array(
                                "id_venta" => $traerVenta["id"],
                                "id_producto" => $producto["id"],
                                "cantidad" => $producto["cantidad"],
                                "precio" => $producto["precio"]
                            );
                            $respuestaDetalleVenta = ModeloDetalleVentas::mdlCrearDetalleVenta($tablaDetalleVenta, $datosDetalleVenta);
                            array_push($totalProductosComprados, $producto["cantidad"]);
                        }
                        /*==============================================
                        ACTUALIZAR LAS COMPRAS DEL CLIENTE
                        ================================================*/
                        $tablaClientes = "clientes";
                        $item = "id";
                        $valorCliente = $_POST["agregarCliente"];
                        $traerCliente = ModeloClientes::mdlMostrarCliente($tablaClientes,$item,$valorCliente);

                        $item1 = "compras";
                        $valor1 = array_sum($totalProductosComprados) + $traerCliente["compras"];
                        $comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1, $valor1, $valorCliente);
                        /*==============================================
                        ACTUALIZAR LA ULTIMA FECHA DE COMPRA DEL CLIENTE
                        ================================================*/
                        $item1a = "ultima_compra";
                        $valor1a = date('Y-m-d H:i:s');
                        $ultimaCompra = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1a, $valor1a, $valorCliente);
                        if ($respuestaDetalleVenta == "ok" && $comprasCliente == "ok" && $ultimaCompra == "ok") {
                            echo "<script>
                            Swal.fire({
                                type: 'success',
                                title: 'Venta creada con éxito',
                                icon: 'success',
                                confirmButtonText: 'Cerrar',
                                closeOnConfirm: false
                              }).then((result) =>{
                                if(result.value){
                                    window.location = 'ventas';
                                }
                              });
                                  </script>";
                        }
                        else {
                            echo "<script>
                            Swal.fire({
                                title: 'Error!',
                                text: 'Los datos no se guardaron correctamente',
                                icon: 'error',
                                confirmButtonText: 'Cerrar',
                                closeOnConfirm: false
                            }).then((result) =>{
                                if(result.value){
                                    window.location = 'ventas';
                                }
                            });
                              </script>";
                        }
                    }
                    else {
                        echo "<script>
                        Swal.fire({
                            title: 'Error!',
                            text: 'Los datos no se guardaron correctamente',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            closeOnConfirm: false
                          }).then((result) =>{
                            if(result.value){
                                window.location = 'ventas';
                            }
                          });
                              </script>";
                    }
                }
            }
        }

        /*
        ================================
        EDITAR VENTA
        ================================
        */
        static public function ctrleditarVenta() {
            if (isset($_POST["idVenta"])) {

                if (preg_match('/[0-9]+/', $_POST["codVenta"])
                && preg_match('/[0-9.]+/', $_POST["precioNeto"])
                && preg_match('/[0-9.]+/', $_POST["valorImpuesto"])
                && preg_match('/[0-9.]+/', $_POST["totalVenta"])) {
                    
                    
                    $tabla = "ventas";
                    // CONVIERTO LA LISTA DE PRODUCTOS EN JSON A UN ARRAY
                    $listadoProductos = json_decode($_POST["listaProductos"], true);
                    // DECLARO UN ARRAY CON TODOS LOS PRODUCTOS VENDIDOS NUEVOS
                    $totalProductosComprados = array();
                    // DECLARO UN ARRAY CON LOS PRODUCTOS VENDIDOS EN LA VENTA SELECCIONADA
                    $totalProductosAntiguos = array();
                        /*==============================================
                        FORMATEAR LAS COMPRAS DEL CLIENTE ANTES DEL UPDATE
                        ================================================*/
                        $tablaClientes = "clientes";
                        $item = "id";
                        $valorCliente = $_POST["idCliente"];
                        $traerCliente = ModeloClientes::mdlMostrarCliente($tablaClientes,$item,$valorCliente);
                        // TRAIGO LOS PRODUCTOS DE LA VENTA ANTIGUA PARA PODER RESETEAR LA COMPRA ACTUAL
                        $tablaDetalleVenta = "detalle_venta";
                        $itemVenta =  "id_venta";
                        $valorVenta = $_POST["idVenta"];
                        $traerVenta = ModeloDetalleVentas::mdlMostrarDetalleVenta($tablaDetalleVenta, $itemVenta, $valorVenta);
                        // LLENO EL ARRAY CON LA CANTIDAD DE PRODUCTOS QUE SE HAN VENDIDO
                        foreach ($traerVenta as $key => $value) {
                            array_push($totalProductosAntiguos, $value["cantidad"]);
                        }
                        $item1 = "compras";
                        $valor1 = $traerCliente["compras"] - array_sum($totalProductosAntiguos);
                        $comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1, $valor1, $valorCliente);
                        $datos = array(
                            "id" => $_POST["idVenta"],
                            "codigo" => $_POST["codVenta"],
                            "id_usuario" => $_POST["idVendedor"],
                            "id_cliente" => $_POST["idCliente"],
                            "productos" => $_POST["listaProductos"],
                            "neto" => $_POST["precioNeto"],
                            "impuestos" => $_POST["valorImpuesto"],
                            "total" => $_POST["totalVenta"],
                            "metodo_pago" => $_POST["listaMetodoPago"]
                        );
                    $respuesta = ModeloVentas::mdlEditarVenta($tabla,$datos);
                    /*=======================================================
                    NOTA: a este punto, el detalle de las ventas y los productos
                    se actualizan mediante triggers
                    =========================================================*/
                    if ($respuesta == "ok") {
                        /*=============================================
                        GUARDO EL DETALLE DE LA VENTA
                        ===============================================*/
                        // Traigo la venta insertada recientemente
                        $traerVenta = ModeloVentas::mdlMostrarVenta($tabla, $item, $valorVenta);
                        foreach ($listadoProductos as $key => $producto) {
                            $datosDetalleVenta = array(
                                "id_venta" => $traerVenta["id"],
                                "id_producto" => $producto["id"],
                                "cantidad" => $producto["cantidad"],
                                "precio" => $producto["precio"],
                                "estado" => 1
                            );
                            $respuestaDetalleVenta = ModeloDetalleVentas::mdlCrearDetalleVenta($tablaDetalleVenta, $datosDetalleVenta);
                            // LLENO EL ARRAY CON LA CANTIDAD DE PRODUCTOS QUE SE HAN VENDIDO
                            array_push($totalProductosComprados, $producto["cantidad"]);
                        }
                        /*==============================================
                        ACTUALIZAR LAS COMPRAS DEL CLIENTE
                        ================================================*/
                        $traerCliente2 = ModeloClientes::mdlMostrarCliente($tablaClientes, $item, $valorCliente);
                        $valor1 = array_sum($totalProductosComprados) + $traerCliente2["compras"];
                        $comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1, $valor1, $valorCliente);
                        if ($respuestaDetalleVenta == "ok" && $comprasCliente == "ok") {
                            echo "<script>
                            Swal.fire({
                                type: 'success',
                                title: 'Venta editada con éxito',
                                icon: 'success',
                                confirmButtonText: 'Cerrar',
                                closeOnConfirm: false
                              }).then((result) =>{
                                if(result.value){
                                    window.location = 'ventas';
                                }
                              });
                                  </script>";
                        }
                    }
                    else {
                        echo "<script>
                        Swal.fire({
                            title: 'Error!',
                            text: 'Los datos no se guardaron correctamente',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            closeOnConfirm: false
                          }).then((result) =>{
                            if(result.value){
                                window.location = 'ventas';
                            }
                          });
                              </script>";
                    }
                }
                else {
                    echo "<script>
                        Swal.fire({
                            title: 'Error!',
                            text: 'Revisar campos obligatorios',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            closeOnConfirm: false
                          }).then((result) =>{
                            if(result.value){
                                window.location = 'ventas';
                            }
                          });
                              </script>";
                }
            }
        }

        /*
        =====================================
        ANULAR VENTA
        =====================================
        */
        static public function ctrlAnularVenta() {
           if (isset($_GET["idVenta"])) {
                $tabla = "ventas";
                $item ="id";
                $datos = $_GET["idVenta"];
                // DECLARO UN ARRAY CON TODOS LOS PRODUCTOS VENDIDOS
                $totalProductosComprados = array();

                $respuesta = ModeloVentas::mdlAnularVenta($tabla, $datos);

                if ($respuesta == "ok") {
                    // TRAIGO LA VENTA ANULADA RECIENTEMENTE
                    $traerVenta = ModeloVentas::mdlMostrarVenta($tabla, $item, $datos);
                    // CONVIERTO LA LISTA DE PRODUCTOS EN JSON A UN ARRAY
                    $listarProductos = json_decode($traerVenta["productos"], true);
                    /*=============================================================
                    ACTUALIZAR EL STOCK DE LOS PRODUCTOS
                    ===============================================================*/
                    foreach ($listarProductos as $key => $value) {
                        $tablaProducto = "productos";
                        $itemProducto = "id";
                        $valorProducto = $value["id"];
                        $traerProducto = ModeloProductos::mdlMostrarProducto($tablaProducto, $itemProducto, $valorProducto);
                        $stockActualizado = $traerProducto["stock"] + $value["cantidad"];
                        $item1 = "stock";
                        $actualizarProducto = ModeloProductos::mdlActualizarProducto($tablaProducto, $item1, $stockActualizado, $valorProducto);
                        array_push($totalProductosComprados, $value["cantidad"]);
                    }
                    /*=============================================================
                    ACTUALIZAR LAS COMPRAS DEL CLIENTE
                    ===============================================================*/
                        $tablaClientes = "clientes";
                        $valorCliente = $traerVenta["id_cliente"];
                        $traerCliente = ModeloClientes::mdlMostrarCliente($tablaClientes,$item,$valorCliente);
                        $itemCliente = "compras";
                        $valor1 = $traerCliente["compras"] - array_sum($totalProductosComprados);
                        $actualizaComprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $itemCliente, $valor1, $valorCliente);
                    if ($actualizarProducto == "ok" && $actualizaComprasCliente == "ok") {
                        echo "<script>
                            Swal.fire({
                                type: 'success',
                                title: 'Venta anulada',
                                icon: 'success',
                                confirmButtonText: 'Cerrar',
                                closeOnConfirm: false
                              }).then((result) =>{
                                if(result.value){
                                    window.location = 'ventas';
                                }
                              });
                                  </script>";
                    }
                }
                else {
                    echo "<script>
                        Swal.fire({
                            type: 'error',
                            title: 'Error al anular',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            closeOnConfirm: false
                          }).then((result) =>{
                            if(result.value){
                                window.location = 'ventas';
                            }
                          });
                              </script>";
                }
           }
        }
    }
?>