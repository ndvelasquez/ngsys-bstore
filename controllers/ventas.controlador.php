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
                    $listaProductos = json_decode($_POST["listaProductos"]);
                    
                    $datos = array(
                        "codigo" => $_POST["codVenta"],
                        "id_usuario" => $_POST["idVendedor"],
                        "id_cliente" => $_POST["agregarCliente"],
                        "productos" => $_POST["listaProductos"],
                        "neto" => $_POST["precioNeto"],
                        "impuestos" => $_POST["valorImpuesto"],
                        "total" => $_POST["totalVenta"],
                        "metodo_pago" => $_POST["listaMetodoPago"],
                        "estado" => 1
                    );
                    $respuesta = ModeloVentas::mdlCrearVenta($tabla,$datos);

                    if ($respuesta == "ok") {
                        /*=============================================
                        GUARDO EL DETALLE DE LA VENTA
                        ===============================================*/
                        $item =  "codigo";
                        $valor = $datos["codVenta"];
                        // Traigo la venta insertada recientemente
                        $traerVenta = ModeloVentas::mdlMostrarVenta($tabla, $item, $valor);
                        foreach ($listaProductos as $key => $producto) {
                            $tablaDetalleVenta = "detalle_venta";

                            $datosDetalleVenta = array(
                                "id_venta" => $traerVenta["id"],
                                "id_producto" => $producto["id"],
                                "cantidad" => $producto["cantidad"],
                                "precio" => $producto["precio"],
                                "estado" => 1
                            );
                            $respuestaDetalleVenta = ModeloDetalleVentas::mdlCrearDetalleVenta($tablaDetalleVenta, $datosDetalleVenta);
                        }
                        if ($respuestaDetalleVenta == "ok") {
                            echo "<script>
                            Swal.fire({
                                type: 'success',
                                title: 'Venta creada',
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
                    $datos = array(
                            "id" => $_POST["idVenta"],
                            "codigo" => $_POST["codVenta"],
                            "id_usuario" => $_POST["idVendedor"],
                            "id_cliente" => $_POST["agregarCliente"],
                            "productos" => $_POST["listaProductos"],
                            "neto" => $_POST["precioNeto"],
                            "impuestos" => $_POST["valorImpuesto"],
                            "total" => $_POST["totalVenta"],
                            "metodo_pago" => $_POST["listaMetodoPago"]
                    );
                    $respuesta = ModeloVentas::mdlEditarVenta($tabla,$datos);

                    if ($respuesta == "ok") {
                        echo "<script>
                        Swal.fire({
                            type: 'success',
                            title: 'Venta editada',
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

        static public function ctrlEliminarProducto() {
           if (isset($_GET["idVenta"])) {
                $tabla = "ventas";
                $datos = $_GET["idVenta"];

                $respuesta = ModeloVentas::mdlAnularVenta($tabla, $datos);

                if ($respuesta == "ok") {
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
                else {
                    echo "<script>
                        Swal.fire({
                            type: 'error',
                            title: 'Error al eliminar',
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