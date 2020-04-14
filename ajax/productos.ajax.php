<?php

    require_once "../controllers/productos.controlador.php";
    require_once "../models/productos.modelo.php";

    class AjaxProductos {

        public $idProducto;
        public $idCategoria;
        public $traerProductos;
        
        /* 
        =================================
        EDITAR PRODUCTOS
        =================================
        */
        public function ajaxEditarProducto() {

            if ($this -> traerProductos == "ok") {
                $item = null;
                $valor = null;
                $respuesta = ControladorProductos::ctrlMostrarProductos($item, $valor);

                echo json_encode($respuesta);
            }
            else {
                $item = "id";
                $valor = $this -> idProducto;
                $respuesta = ControladorProductos::ctrlMostrarProductos($item, $valor);

                echo json_encode($respuesta);
            }
                
            }
        /* 
        =================================
        CREAR NUEVO CODIGO DEL PRODUCTO
        =================================
        */
        public function ajaxNuevoCodigo() {
            $item = "id_categoria";
            $valor = $this -> idCategoria;
            $respuesta = ControladorProductos::ctrlMostrarProductos($item, $valor);

            echo json_encode($respuesta);
        }
    }
    
    // CREO OBJETO PARA CREAR NUEVO CODIGO
    if(isset($_POST["idCategoria"])) {
        $nuevoCodigo = new AjaxProductos();
        $nuevoCodigo -> idCategoria = $_POST["idCategoria"];
        $nuevoCodigo -> ajaxNuevoCodigo();
    }

    // CREO OBJETO PARA MOSTRAR DATOS A EDITAR
    if(isset($_POST["idProducto"])) {
        $editar = new AjaxProductos();
        $editar -> idProducto = $_POST["idProducto"];
        $editar -> ajaxEditarProducto();
    }

    // CREO OBJETO PARA TRAER PRODUCTOS
    if(isset($_POST["traerProductos"])) {
        $traerProductos = new AjaxProductos();
        $traerProductos -> traerProductos = $_POST["traerProductos"];
        $traerProductos -> ajaxEditarProducto();
    }
    
?>