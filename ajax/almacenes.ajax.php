<?php

    require_once "../controllers/almacenes.controlador.php";
    require_once "../models/almacenes.modelo.php";

    class AjaxAlmacenes {

        public $idAlmacen;
        
    /* 
    =================================
    EDITAR ALMACENES
    =================================
    */
    public function ajaxEditarAlmacen() {

            $item = "id";
            $valor = $this -> idAlmacen;
            $respuesta = ControladorAlmacenes::ctrlMostrarAlmacen($item, $valor);

            echo json_encode($respuesta);
        }
        
    /* 
    =================================
    VERIFICAR SI NOMBRE YA EXISTE
    =================================
    */
        public $verificarNombre;
        public function ajaxVerificaNombre() {
            $item = "nombre";
            $valor = $this -> verificarNombre;
            $respuesta = ControladorAlmacenes::ctrlMostrarAlmacen($item, $valor);

            echo json_encode($respuesta);
        }
    }
    // CREO OBJETO PARA MOSTRAR DATOS A EDITAR
    if(isset($_POST["idAlmacen"])) {
        $editar = new AjaxAlmacenes();
        $editar -> idAlmacen = $_POST["idAlmacen"];
        $editar -> ajaxEditarAlmacen();
    }
    // CREO OBJETO PARA VERIFICAR SI EL NOMBRE YA SE ENCUENTRA REGISTRADO
    if(isset($_POST["validaNombre"])) {
        $validaAlmacenes = new AjaxAlmacenes();
        $validaAlmacenes -> verificarNombre = $_POST["validaNombre"];
        $validaAlmacenes -> ajaxVerificaNombre();
    }
?>