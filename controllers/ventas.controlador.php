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
               && isset($_POST["listaMetodoPago"])
               && isset($_POST["observacion"])) {

                /*===================================================
                VERIFICO QUE NO HAYAN CODIGOS DUPLICADOS
                =====================================================*/
                $arrayVentas = ModeloVentas::mdlMostrarVenta('ventas', null, null);

                foreach ($arrayVentas as $key => $venta) {
                    if($_POST["codVenta"] == $venta["codigo"]) {
                        echo "<script>window.location = 'crear-pedido'</script>";
                    }
                }

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
                    
                    // si la venta es a partir de una cotización, actualiza estado
                    if (isset($_POST["idCotizacion"])) {
                        $itemCotizacion = "id";
                        $valorCotizacion = $_POST["idCotizacion"];
                        ModeloCotizaciones::mdlActualizaCotizacion($itemCotizacion, $valorCotizacion);
                    }
                    
                    $datos = array(
                        "codigo" => $_POST["codVenta"],
                        "id_usuario" => $_POST["idVendedor"],
                        "id_cliente" => $_POST["agregarCliente"],
                        "productos" => $_POST["listaProductos"],
                        "neto" => $_POST["precioNeto"],
                        "impuestos" => $_POST["valorImpuesto"],
                        "total" => $precioFormateado,
                        "metodo_pago" => $_POST["listaMetodoPago"],
                        "observacion" => $_POST["observacion"],
                        "estado" => 3
                    );
                    $respuesta = ModeloVentas::mdlCrearVenta($tabla,$datos);
                    /*======================================================
                    INSERTA EL LOG DE AUDITORIA
                    ========================================================*/
                    $datosAuditoria = array(
                        "usuario" => $_SESSION["usuario"],
                        "accion" => "INSERTAR",
                        "tabla" => $tabla
                    );
                    $respuestoaAuditoria = ModeloAuditoria::mdlInsertaLog($datosAuditoria);
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
                                "tipo_movimiento" => "SALIDA",
                                "precio" => $producto["precio"]
                            );
                            $respuestaDetalleVenta = ModeloDetalleVentas::mdlCrearDetalleVenta($tablaDetalleVenta, $datosDetalleVenta);
                            array_push($totalProductosComprados, $producto["cantidad"]);
                            // INSERTO EL MOVIMIENTO
                            $respuestaInventario = ModeloInventario::mdlInsertaMovimiento($datosDetalleVenta);
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
                                title: 'Venta creada con éxito',
                                icon: 'success',
                                confirmButtonText: 'Cerrar',
                                closeOnConfirm: false
                              }).then((result) =>{
                                if(result.value){
                                    window.location = 'pedidos';
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
                                    window.location = 'pedidos';
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
                                window.location = 'pedidos';
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
                            "id_usuario" => $_POST["idVendedor"],
                            "id_cliente" => $_POST["idCliente"],
                            "productos" => $_POST["listaProductos"],
                            "neto" => $_POST["precioNeto"],
                            "impuestos" => $_POST["valorImpuesto"],
                            "total" => $_POST["totalVenta"],
                            "metodo_pago" => $_POST["listaMetodoPago"],
                            "estado" => $_POST["estado"],
                            "observacion" => $_POST["observacion"]
                        );
                    $respuesta = ModeloVentas::mdlEditarVenta($tabla,$datos);
                    /*======================================================
                    INSERTA EL LOG DE AUDITORIA
                    ========================================================*/
                    $datosAuditoria = array(
                        "usuario" => $_SESSION["usuario"],
                        "accion" => "MODIFICAR",
                        "tabla" => $tabla
                    );
                    $respuestoaAuditoria = ModeloAuditoria::mdlInsertaLog($datosAuditoria);
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
                                "tipo_movimiento" => "SALIDA",
                                "precio" => $producto["precio"],
                                "estado" => 1
                            );
                            $respuestaDetalleVenta = ModeloDetalleVentas::mdlCrearDetalleVenta($tablaDetalleVenta, $datosDetalleVenta);
                            // LLENO EL ARRAY CON LA CANTIDAD DE PRODUCTOS QUE SE HAN VENDIDO
                            array_push($totalProductosComprados, $producto["cantidad"]);
                            // INSERTO EL MOVIMIENTO
                            $respuestaInventario = ModeloInventario::mdlInsertaMovimiento($datosDetalleVenta);
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
                                    window.location = 'pedidos';
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
                                window.location = 'pedidos';
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
                                window.location = 'pedidos';
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
                /*======================================================
                INSERTA EL LOG DE AUDITORIA
                ========================================================*/
                $datosAuditoria = array(
                    "usuario" => $_SESSION["usuario"],
                    "accion" => "ANULACION",
                    "tabla" => $tabla
                );
                $respuestoaAuditoria = ModeloAuditoria::mdlInsertaLog($datosAuditoria);
                if ($respuesta == "ok") {
                    // TRAIGO LA VENTA ANULADA RECIENTEMENTE
                    $traerVenta = ModeloVentas::mdlMostrarVenta($tabla, $item, $datos);
                    // CONVIERTO LA LISTA DE PRODUCTOS EN JSON A UN ARRAY
                    $listarProductos = json_decode($traerVenta["productos"], true);
                    /*=============================================================
                    ACTUALIZAR EL STOCK Y LAS VENTAS DE LOS PRODUCTOS
                    ===============================================================*/
                    foreach ($listarProductos as $key => $value) {
                        $tablaProducto = "productos";
                        $itemProducto = "id";
                        $valorProducto = $value["id"];
                        $cantidadProducto = $value["cantidad"];
                        $traerProducto = ModeloProductos::mdlMostrarProducto($tablaProducto, $itemProducto, $valorProducto);
                        $stockActualizado = $traerProducto["stock"] + $value["cantidad"];
                        $ventasActualizadas = $traerProducto["ventas"] - $value["cantidad"];
                        $item1 = "stock";
                        $item2 = "ventas";
                        $actualizarProducto = ModeloProductos::mdlActualizarProducto($tablaProducto, $item1, $stockActualizado, $valorProducto);
                        $actualizarProducto = ModeloProductos::mdlActualizarProducto($tablaProducto, $item2, $ventasActualizadas, $valorProducto);
                        array_push($totalProductosComprados, $value["cantidad"]);

                        // INSERTO EL MOVIMIENTO
                        $datosInventario = array (
                            "id_producto" => $valorProducto,
                            "tipo_movimiento" => "ENTRADA",
                            "cantidad" => $cantidadProducto
                        );
                        $respuestaInventario = ModeloInventario::mdlInsertaMovimiento($datosInventario);
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
                                    window.location = 'pedidos';
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
                                window.location = 'pedidos';
                            }
                          });
                              </script>";
                }
           }
        }

        /*
        =====================================
        MOSTRAR VENTAS POR RANGO DE FECHA
        =====================================
        */
        static public function ctrlRangoFechasVenta($fechaInicial, $fechaFinal) {
            $tabla = "ventas";
            $respuesta = ModeloVentas::mdlMostrarRangoFechasVenta($tabla,$fechaInicial,$fechaFinal);
            return $respuesta;
        }

        /*
        =====================================
        MOSTRAR PRODUCTOS MAS VENDIDOS
        =====================================
        */
        static public function ctrlVentasPorVendedor($tabla) {
            $respuesta = ModeloVentas::mdlVentasPorVendedor($tabla);
            return $respuesta;
        }
        /*
        =====================================
        MOSTRAR CLIENTES CON MAS COMPRAS
        =====================================
        */
        static public function ctrlComprasCliente($tabla) {
            $respuesta = ModeloVentas::mdlComprasPorCliente($tabla);
            return $respuesta;
        }

        /*======================================================
        SUMAR EL TOTAL DE VENTAS
        ========================================================*/
        static public function ctrlSumaTotalVentas() {
            $tabla = "ventas";
            $item = null;
            $valor = null;
            $traerVentas = ModeloVentas::mdlMostrarVenta($tabla, $item, $valor);
            $sumarTotalVentas = 0;
            foreach ($traerVentas as $key => $itemVenta) {
                if ($itemVenta["estado"] != 2) {
                    $sumarTotalVentas += $itemVenta["total"];
                }
            }
            return $sumarTotalVentas;
        }

        /*=============================================
	    DESCARGAR EXCEL
	    =============================================*/

        public function ctrlDescargarReporte(){

            if(isset($_GET["reporte"])){

                $tabla = "ventas";

                if(isset($_GET["fechaInicial"]) && isset($_GET["fechaFinal"])){

                    $ventas = ModeloVentas::mdlMostrarRangoFechasVenta($tabla, $_GET["fechaInicial"], $_GET["fechaFinal"]);

                }else{

                    $item = null;
                    $valor = null;

                    $ventas = ModeloVentas::mdlMostrarVenta($tabla, $item, $valor);

                }


			/*=============================================
			CREAR EL ARCHIVO DE EXCEL
			=============================================*/

			$Name = $_GET["reporte"].'.xls';

			header('Expires: 0');
			header('Cache-control: private');
			header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
			header("Cache-Control: cache, must-revalidate"); 
			header('Content-Description: File Transfer');
			header('Last-Modified: '.date('D, d M Y H:i:s'));
			header("Pragma: public"); 
			header('Content-Disposition:; filename="'.$Name.'"');
			header("Content-Transfer-Encoding: binary");

			echo utf8_decode("<table border='0'> 

					<tr> 
					<td style='font-weight:bold; border:1px solid #eee;'>CÓDIGO</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>CLIENTE</td>
					<td style='font-weight:bold; border:1px solid #eee;'>VENDEDOR</td>
					<td style='font-weight:bold; border:1px solid #eee;'>CANTIDAD</td>
					<td style='font-weight:bold; border:1px solid #eee;'>PRODUCTOS</td>
					<td style='font-weight:bold; border:1px solid #eee;'>IMPUESTO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>NETO</td>		
					<td style='font-weight:bold; border:1px solid #eee;'>TOTAL</td>		
					<td style='font-weight:bold; border:1px solid #eee;'>METODO DE PAGO</td	
                    <td style='font-weight:bold; border:1px solid #eee;'>FECHA</td>
                    <td style='font-weight:bold; border:1px solid #eee;'>ESTADO</td>		
					</tr>");

			foreach ($ventas as $row => $item){

			 echo utf8_decode("<tr>
			 			<td style='border:1px solid #eee;'>".$item["codigo"]."</td> 
			 			<td style='border:1px solid #eee;'>".$item["cliente"]."</td>
			 			<td style='border:1px solid #eee;'>".$item["vendedor"]."</td>
			 			<td style='border:1px solid #eee;'>");

			 	$productos =  json_decode($item["productos"], true);

			 	foreach ($productos as $key => $valueProductos) {
			 			
			 			echo utf8_decode($valueProductos["cantidad"]."<br>");
			 		}

			 	echo utf8_decode("</td><td style='border:1px solid #eee;'>");	

		 		foreach ($productos as $key => $valueProductos) {
			 			
		 			echo utf8_decode($valueProductos["descripcion"]."<br>");
		 		
		 		}

		 		echo utf8_decode("</td>
					<td style='border:1px solid #eee;'>$ ".number_format($item["impuestos"],2)."</td>
					<td style='border:1px solid #eee;'>$ ".number_format($item["neto"],2)."</td>	
					<td style='border:1px solid #eee;'>$ ".number_format($item["total"],2)."</td>
					<td style='border:1px solid #eee;'>".$item["metodo_pago"]."</td>
                    <td style='border:1px solid #eee;'>".substr($item["fecha_creacion"],0,10)."</td>");
                if ($item["estado"] != 2) {
                    echo utf8_decode("<td style='border:1px solid #eee;'>Activa</td>
                    </tr>");
                }
                else {
                    echo utf8_decode("<td style='border:1px solid #eee;'>Anulada</td>
                    </tr>");
                }


			}


			echo "</table>";

		}

	}
    }
?>