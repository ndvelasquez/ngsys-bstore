<?php
    class ControladorCotizaciones {
        /*
        =====================================
        MOSTRAR COTIZACIONES
        =====================================
        */

        static public function ctrlMostrarCotizaciones($item, $valor) {
            $tabla = "cotizaciones";
            $respuesta = ModeloCotizaciones::mdlMostrarCotizacion($tabla, $item, $valor);

            return $respuesta;
        }

        /*
        =====================================
        GUARDAR COTIZACION
        =====================================
        */

        static public function ctrlCrearCotizacion() {
            if (isset($_POST["codCotizacion"])
               && isset($_POST["idVendedor"])
               && isset($_POST["agregarCliente"])
               && isset($_POST["listaProductos"])
               && isset($_POST["precioNeto"])
               && isset($_POST["valorImpuesto"])
               && isset($_POST["totalVenta"])) {

                if (preg_match('/[0-9]+/', $_POST["codCotizacion"])
                  && preg_match('/[0-9.]+/', $_POST["precioNeto"])
                  && preg_match('/[0-9.]+/', $_POST["valorImpuesto"])
                  && preg_match('/[0-9.]+/', $_POST["totalVenta"])) {

                    
                    $tabla = "cotizaciones";
                    // Formateo el precio a un formato adecuado para la BD
                    $precioTotal = $_POST["totalVenta"];
                    $precioFormateado = (0+str_replace(",","",$precioTotal));
                    $precioFormateado = number_format($precioFormateado,2,".","");
                    
                    $datos = array(
                        "codigo" => $_POST["codCotizacion"],
                        "id_usuario" => $_POST["idVendedor"],
                        "id_cliente" => $_POST["agregarCliente"],
                        "productos" => $_POST["listaProductos"],
                        "neto" => $_POST["precioNeto"],
                        "impuestos" => $_POST["valorImpuesto"],
                        "total" => $precioFormateado,
                        "estado" => 1
                    );
                    $respuesta = ModeloCotizaciones::mdlCrearCotizacion($tabla,$datos);

                    if ($respuesta == "ok") {
                        
                        echo "<script>
                        Swal.fire({
                            type: 'success',
                            title: 'Cotización creada con éxito',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            closeOnConfirm: false
                          }).then((result) =>{
                            if(result.value){
                                window.location = 'cotizaciones';
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
                                window.location = 'cotizaciones';
                            }
                          });
                              </script>";
                    }
                }
            }
        }

        /*
        ================================
        EDITAR COTIZACION
        ================================
        */
        static public function ctrleditarCotizacion() {
            if (isset($_POST["idCotizacion"])) {

                if (preg_match('/[0-9]+/', $_POST["codCotizacion"])
                && preg_match('/[0-9.]+/', $_POST["precioNeto"])
                && preg_match('/[0-9.]+/', $_POST["valorImpuesto"])
                && preg_match('/[0-9.]+/', $_POST["totalVenta"])) {
                    
                    
                    $tabla = "cotizaciones";
                    // CONVIERTO LA LISTA DE PRODUCTOS EN JSON A UN ARRAY
                
                        $datos = array(
                            "id" => $_POST["idCotizacion"],
                            "codigo" => $_POST["codCotizacion"],
                            "id_usuario" => $_POST["idVendedor"],
                            "id_cliente" => $_POST["idCliente"],
                            "productos" => $_POST["listaProductos"],
                            "neto" => $_POST["precioNeto"],
                            "impuestos" => $_POST["valorImpuesto"],
                            "total" => $_POST["totalVenta"]
                        );
                    $respuesta = ModeloCotizaciones::mdlEditarCotizacion($tabla,$datos);
                    
                    if ($respuesta == "ok") {
                        
                        echo "<script>
                        Swal.fire({
                            type: 'success',
                            title: 'Cotización editada con éxito',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            closeOnConfirm: false
                          }).then((result) =>{
                            if(result.value){
                                window.location = 'cotizaciones';
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
                                window.location = 'cotizaciones';
                            }
                          });
                              </script>";
                }
            }
        }

        /*
        =====================================
        ANULAR COTIZACION
        =====================================
        */
        static public function ctrlAnularCotizacion() {
           if (isset($_GET["idCotizacion"])) {
                $tabla = "cotizaciones";
                $datos = $_GET["idCotizacion"];
               
                $respuesta = ModeloCotizaciones::mdlAnularCotizacion($tabla, $datos);

                if ($respuesta == "ok") {
                    
                    echo "<script>
                        Swal.fire({
                            type: 'success',
                            title: 'Cotización anulada',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            closeOnConfirm: false
                          }).then((result) =>{
                            if(result.value){
                                window.location = 'cotizaciones';
                            }
                          });
                              </script>";
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
                                window.location = 'cotizaciones';
                            }
                          });
                              </script>";
                }
           }
        }

        /*
        =====================================
        MOSTRAR COTIZACIONES POR RANGO DE FECHA
        =====================================
        */
        static public function ctrlRangoFechasCotizacion($fechaInicial, $fechaFinal) {
            $tabla = "cotizaciones";
            $respuesta = ModeloCotizaciones::mdlMostrarRangoFechasCotizacion($tabla,$fechaInicial,$fechaFinal);
            return $respuesta;
        }

	}
?>