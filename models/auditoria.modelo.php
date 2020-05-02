<?php

    require_once "conexion.php";

    class ModeloAuditoria {

        // INSERTA NUEVO LOG
        static public function mdlInsertaLog($datos) {
            $sentencia = Conexion::conectar()->prepare("INSERT INTO auditoria(usuario, accion, tabla) VALUES (:usuario, :accion, :tabla)");
            $sentencia -> bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
            $sentencia -> bindParam(":accion", $datos["accion"], PDO::PARAM_STR);
            $sentencia -> bindParam(":tabla", $datos["tabla"], PDO::PARAM_STR);

            if($sentencia -> execute()) {
                return "ok";
            }
            else {
                return "error";
            }

            $sentencia = null;
        }
        
    }

?>