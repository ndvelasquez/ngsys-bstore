<?php

    require_once "conexion.php";

    class ModeloProductoAlmacen {

        // INSERTA NUEVO PRODUCTO ASOCIADO AL ALMACEN
        static public function mdlCrearProductoAlmacen($tabla,$datos) {
            $sentencia = Conexion::conectar()->prepare("INSERT INTO $tabla(id_producto,id_almacen) VALUES (:id_producto,:id_almacen)");
            $sentencia -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);
            $sentencia -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);

            if($sentencia -> execute()) {
                return "ok";
            }
            else {
                return "error";
            }

            $sentencia = null;
        }
        // EDITAR PRODUCTO ASOCIADO A ALMACEN
        static public function mdlEditarAlmacen($tabla,$datos) {
            $sentencia = Conexion::conectar()->prepare("UPDATE $tabla SET id_almacen = :id_almacen WHERE id_producto = :id_producto");
            $sentencia -> bindParam(":id_producto", $datos["id"], PDO::PARAM_INT);
            $sentencia -> bindParam(":id_almacen", $datos["almacen"], PDO::PARAM_STR);

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