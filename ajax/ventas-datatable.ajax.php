<?php
    require_once "../controllers/productos.controlador.php";
    require_once "../models/productos.modelo.php";

    class TablaProductosVentas {
        public function mostrarTablaProductosVentas () {
            if(isset($_POST["id_almacen"]) && $_POST["id_almacen"] != "") {
                $item = "id_almacen";
                $valor = $_POST["id_almacen"];
                $productos = Controladorproductos::ctrlMostrarproductos($item, $valor);
            }
            else {
                $item = null;
                $valor = null;
                $productos = Controladorproductos::ctrlMostrarproductos($item, $valor);
            }
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

                    $botones = "<div class='btn-group'><button class='btn btn-primary agregarProducto recuperarBoton' idProducto='".$productos[$i]["id"]."'>Agregar</button></div>";

                    $datosJson .='[
                        "'.($i + 1).'",
                        "'.$imagen.'",
                        "'.$productos[$i]["codigo"].'",
                        "'.$productos[$i]["descripcion"].'",
                        "'.$stock.'",
                        "'.$botones.'"
                    ],';
                }
            $datosJson = substr($datosJson, 0, -1);
            $datosJson .='] }';      
            echo $datosJson;
        }
    }
    $mostrarProductosVentas = new TablaProductosVentas();
    $mostrarProductosVentas -> mostrarTablaProductosVentas();
?>