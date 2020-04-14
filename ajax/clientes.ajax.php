<?php

    require_once "../controllers/clientes.controlador.php";
    require_once "../models/clientes.modelo.php";

    class AjaxClientes {

        public $idCliente;
        
    /* 
    =================================
    EDITAR CLIENTES
    =================================
    */
    public function ajaxEditarCliente() {

            $item = "id";
            $valor = $this -> idCliente;
            $respuesta = ControladorClientes::ctrlMostrarClientes($item, $valor);

            echo json_encode($respuesta);
        }
        
    /* 
    =================================
    VERIFICAR SI EL DOCUMENTO EXISTE
    =================================
    */
        public $verificarDocumento;
        public $verificarTipoDocumento;
        public function ajaxVerificaDocumento() {
            $item1 = "tipo_documento";
            $item2 = "documento";
            $valor1 = $this -> verificarTipoDocumento;
            $valor2 = $this -> verificarDocumento;
            $respuesta = ControladorClientes::ctrlVerificaDocumento($item1, $valor1, $item2, $valor2);

            echo json_encode($respuesta);
        }
    }
    // CREO OBJETO PARA MOSTRAR DATOS A EDITAR
    if(isset($_POST["idCliente"])) {
        $editar = new AjaxClientes();
        $editar -> idCliente = $_POST["idCliente"];
        $editar -> ajaxEditarCliente();
    }
    // CREO OBJETO PARA VERIFICAR SI EL DOCUMENTO YA SE ENCUENTRA REGISTRADO
    if(isset($_POST["validaDocumento"])) {
        $verificaDocumento = new AjaxClientes();
        $verificaDocumento -> verificarTipoDocumento = $_POST["validaTipoDocumento"];
        $verificaDocumento -> verificarDocumento = $_POST["validaDocumento"];
        $verificaDocumento -> ajaxVerificaDocumento();
    }
?>