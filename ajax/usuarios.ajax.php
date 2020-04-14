<?php

    require_once "../controllers/usuarios.controlador.php";
    require_once "../models/usuarios.modelo.php";

    class AjaxUsuarios {

        public $idUsuario;
        
    /* 
    =================================
    EDITAR USUARIOS
    =================================
    */
    public function ajaxEditarUsuario() {

            $item = "id";
            $valor = $this -> idUsuario;
            $respuesta = ControladorUsuarios::ctrlMostrarUsuarios($item, $valor);

            echo json_encode($respuesta);
        }
        
    /* 
    =================================
    CAMBIAR ESTADO DE USUARIOS
    =================================
    */
        public $activarUsuario;
        public $activarId;
        public function ajaxCambiarEstado() {
            
            $tabla = "usuarios";
            $item1 = "estado";
            $item2 = "id";
            $valor1 = $this -> activarUsuario;
            $valor2 = $this -> activarId;

            $respuesta = ModeloUsuarios::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);

        }
    /* 
    =================================
    VERIFICAR SI USUARIO YA EXISTE
    =================================
    */
        public $verificarUsuario;
        public function ajaxVerificaUsuario() {
            $item = "usuario";
            $valor = $this -> verificarUsuario;
            $respuesta = ControladorUsuarios::ctrlMostrarUsuarios($item, $valor);

            echo json_encode($respuesta);
        }
    }
    // CREO OBJETO PARA MOSTRAR DATOS A EDITAR
    if(isset($_POST["idUsuario"])) {
        $editar = new AjaxUsuarios();
        $editar -> idUsuario = $_POST["idUsuario"];
        $editar -> ajaxEditarUsuario();
    }
    // CREO OBJETO PARA CAMBIAR ESTADO
    if(isset($_POST["estadoUsuario"])) {
        $activarUsuario = new AjaxUsuarios();
        $activarUsuario -> activarId = $_POST["idUsuario"];
        $activarUsuario -> activarUsuario = $_POST["estadoUsuario"];
        $activarUsuario -> ajaxCambiarEstado();
    }
    // CREO OBJETO PARA VERIFICAR SI EL USUARIO YA SE ENCUENTRA REGISTRADO
    if(isset($_POST["validarUsuario"])) {
        $validaUsuario = new AjaxUsuarios();
        $validaUsuario -> verificarUsuario = $_POST["validarUsuario"];
        $validaUsuario -> ajaxVerificaUsuario();
    }
?>