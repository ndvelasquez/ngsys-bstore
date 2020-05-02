<?php
    class ControladorInventario {
        /*=============================================
        MOSTRAR MOVIMIENTOS DE PRODUCTOS
        ===============================================*/
        static public function ctrlMostrarMovimientos($item, $valor) {
            $respuesta = ModeloInventario::mdlMostrarMovimientos($item,$valor);
            return $respuesta;
        }
    }
?>