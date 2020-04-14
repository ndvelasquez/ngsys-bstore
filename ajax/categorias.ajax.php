<?php

    require_once "../controllers/categorias.controlador.php";
    require_once "../models/categorias.modelo.php";

    class AjaxCategorias {

        public $idCategoria;
        
    /* 
    =================================
    EDITAR CATEGORIAS
    =================================
    */
    public function ajaxEditarCategoria() {

            $item = "id";
            $valor = $this -> idCategoria;
            $respuesta = ControladorCategorias::ctrlMostrarCategorias($item, $valor);

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
            $respuesta = ControladorCategorias::ctrlMostrarCategorias($item, $valor);

            echo json_encode($respuesta);
        }
    }
    // CREO OBJETO PARA MOSTRAR DATOS A EDITAR
    if(isset($_POST["idCategoria"])) {
        $editar = new AjaxCategorias();
        $editar -> idCategoria = $_POST["idCategoria"];
        $editar -> ajaxEditarCategoria();
    }
    // CREO OBJETO PARA VERIFICAR SI EL NOMBRE YA SE ENCUENTRA REGISTRADO
    if(isset($_POST["validaNombre"])) {
        $validaUsuario = new AjaxCategorias();
        $validaUsuario -> verificarNombre = $_POST["validaNombre"];
        $validaUsuario -> ajaxVerificaNombre();
    }
?>