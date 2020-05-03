<?php
    require_once "../controllers/productos.controlador.php";
    require_once "../models/productos.modelo.php";

    class TablaProductos {
        public function mostrarTablaProductos () {
            $item = null;
            $valor = null;
            $productos = Controladorproductos::ctrlMostrarproductos($item, $valor);
            
            $datosJson = '{
                "data": [';
                for ($i=0; $i < count($productos); $i++) {

                    if($productos[$i]["imagen"] != "") {
                        $imagen = "<img src='".$productos[$i]["imagen"]."' width='50px' alt='imagen-producto'>";
                    }
                    else {
                        $imagen = "<img src='views/img/productos/default/anonymous.png' width='50px' alt='imagen-producto'>";
                    }

                    if ($productos[$i]["stock"] <= 10) {
                        $stock = "<button class='btn btn-danger btn-xs'>".$productos[$i]["stock"]."</button>";
                    }
                    else if ($productos[$i]["stock"] > 11 && $productos[$i]["stock"] <= 20) {
                        $stock = "<button class='btn btn-warning btn-xs'>".$productos[$i]["stock"]."</button>";
                    }
                    else {
                        $stock = "<button class='btn btn-success btn-xs'>".$productos[$i]["stock"]."</button>";
                    }

                    $botones = "<div class='btn-group'><button class='btn btn-warning btn-editarProducto' idProducto='".$productos[$i]["id"]."' data-toggle='modal' data-target='#modalEditarProducto'><i class='far fa-edit'></i></button><button class='btn btn-danger btn-eliminarProducto' idProducto='".$productos[$i]["id"]."' imagenProducto='".$productos[$i]["imagen"]."' codProducto='".$productos[$i]["codigo"]."'><i class='fa fa-times'></i></button><button class='btn btn-primary btn-verMovimientos' idProducto='".$productos[$i]["id"]."'><i class='far fa-eye'></i></button></div>";

                    $datosJson .='[
                        "'.($i + 1).'",
                        "'.$imagen.'",
                        "'.$productos[$i]["codigo"].'",
                        "'.$productos[$i]["descripcion"].'",
                        "'.$productos[$i]["categoria"].'",
                        "'.$stock.'",
                        "'.$productos[$i]["precio_compra"].'",
                        "'.$productos[$i]["precio_venta"].'",
                        "'.$productos[$i]["fecha_creacion"].'",
                        "'.$botones.'"
                    ],';
                }
            $datosJson = substr($datosJson, 0, -1);
            $datosJson .='] }';      
            echo $datosJson;
        }
    }
    $mostrarProductos = new TablaProductos();
    $mostrarProductos -> mostrarTablaProductos();
?>