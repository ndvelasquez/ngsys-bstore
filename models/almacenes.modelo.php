<?php

    require_once "conexion.php";

    class ModeloAlmacenes {

        // MOSTRAR ALMACENES
        static public function mdlMostrarAlmacen($tabla, $item, $valor) {
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
        // INSERTA NUEVO ALMACEN
        static public function mdlCrearAlmacen($tabla,$datos) {
            $sentencia = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre) VALUES (:nombre)");
            $sentencia -> bindParam(":nombre", $datos, PDO::PARAM_STR);

            if($sentencia -> execute()) {
                return "ok";
            }
            else {
                return "error";
            }

            $sentencia = null;
        }
        // EDITAR ALMACEN
        static public function mdlEditarAlmacen($tabla,$datos) {
            $sentencia = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre WHERE id = :id");
            $sentencia -> bindParam(":id", $datos["id"], PDO::PARAM_INT);
            $sentencia -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);

            if($sentencia -> execute()) {
                return "ok";
            }
            else {
                return "error";
            }

            $sentencia = null;
        }
        
        // ELIMINAR ALMACENES
        static public function mdlEliminarAlmacen($tabla, $datos) {
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