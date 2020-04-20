<?php

    require_once "conexion.php";

    class ModeloClientes {

        // MOSTRAR CLIENTES
        static public function mdlMostrarCliente($tabla, $item, $valor) {
            if ($item != null) {
                $sentencia = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
                $sentencia -> bindParam(":".$item, $valor, PDO::PARAM_STR);
                $sentencia -> execute();
            }
            else {
                $sentencia = Conexion::conectar()->prepare("SELECT * FROM $tabla");
                $sentencia -> execute();

                return $sentencia -> fetchAll();
                $sentencia = null;
            }

            return $sentencia -> fetch();
            $sentencia = null;
        }
        // VERIFICAR DOCUMENTO DEL CLIENTE
        static public function mdlVerificaDocumento($tabla, $item1, $valor1, $item2, $valor2) {
            $sentencia = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item1 = :$item1 AND $item2 = :$item2");
                $sentencia -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
                $sentencia -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);
                $sentencia -> execute();
                return $sentencia -> fetch();
        }
        // INSERTA NUEVO CLIENTE
        static public function mdlCrearCliente($tabla,$datos) {
            $sentencia = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, tipo_documento, documento, email, telefono, fecha_nacimiento, direccion) VALUES (:nombre, :tipo_documento, :documento, :email, :telefono, :fecha_nacimiento, :direccion)");
            $sentencia -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
            $sentencia -> bindParam(":tipo_documento", $datos["tipo_documento"], PDO::PARAM_STR);
            $sentencia -> bindParam(":documento", $datos["documento"], PDO::PARAM_STR);
            $sentencia -> bindParam(":email", $datos["email"], PDO::PARAM_STR);
            $sentencia -> bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
            $sentencia -> bindParam(":fecha_nacimiento", $datos["fecha_nacimiento"], PDO::PARAM_STR);
            $sentencia -> bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);

            if($sentencia -> execute()) {
                return "ok";
            }
            else {
                return "error";
            }

            $sentencia = null;
        }
        // EDITAR CLIENTE
        static public function mdlEditarCliente($tabla,$datos) {
            $sentencia = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, tipo_documento = :tipo_documento, documento = :documento, email = :email, telefono = :telefono, fecha_nacimiento = :fecha_nacimiento, direccion = :direccion WHERE id = :id");
            $sentencia -> bindParam(":id", $datos["id"], PDO::PARAM_INT);
            $sentencia -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
            $sentencia -> bindParam(":tipo_documento", $datos["tipo_documento"], PDO::PARAM_STR);
            $sentencia -> bindParam(":documento", $datos["documento"], PDO::PARAM_STR);
            $sentencia -> bindParam(":email", $datos["email"], PDO::PARAM_STR);
            $sentencia -> bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
            $sentencia -> bindParam(":fecha_nacimiento", $datos["fecha_nacimiento"], PDO::PARAM_STR);
            $sentencia -> bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);

            if($sentencia -> execute()) {
                return "ok";
            }
            else {
                return "error";
            }

            $sentencia = null;
        }
        // ACTUALIZAR CLIENTE
        static public function mdlActualizarCliente($tabla, $item1, $valor1, $criterio) {
            $sentencia = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE id = :id");
            $sentencia -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
            $sentencia -> bindParam(":id", $criterio, PDO::PARAM_STR);

            if($sentencia -> execute()) {
                return "ok";
            }
            else {
                return "error";
            }
            $sentencia = null;
        }
        
        // ELIMINAR CLIENTES
        static public function mdlEliminarCliente($tabla, $datos) {
            $sentencia = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
            $sentencia -> bindParam(":id", $datos, PDO::PARAM_STR);
            $sentencia -> execute();

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