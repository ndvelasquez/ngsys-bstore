<?php

    require_once "conexion.php";

    class ModeloDetalleVentas {
        // MOSTRAR DETALLE VENTA
        static public function mdlMostrarDetalleVenta($tabla,$item,$valor) {
            if ($item != null) {
                $sentencia = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
                $sentencia -> bindParam(":".$item, $valor, PDO::PARAM_STR);
                $sentencia -> execute();
            }
            else {
                $sentencia = Conexion::conectar()->prepare("SELECT * FROM $tabla ");
                $sentencia -> execute();
            }
            return $sentencia -> fetchAll();
            $sentencia = null;
        }

        // INSERTA DETALLE VENTA
        static public function mdlCrearDetalleVenta($tabla,$datos) {
            $sentencia = Conexion::conectar()->prepare("INSERT INTO $tabla(id_venta, id_producto, cantidad, precio) VALUES (:id_venta, :id_producto, :cantidad, :precio)");
            $sentencia -> bindParam(":id_venta", $datos["id_venta"], PDO::PARAM_STR);
            $sentencia -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_INT);
            $sentencia -> bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_INT);
            $sentencia -> bindParam(":precio", $datos["precio"], PDO::PARAM_STR);

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