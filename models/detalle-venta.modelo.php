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
        // EDITAR VENTA
        static public function mdlEditarVenta($tabla,$datos) {
            $sentencia = Conexion::conectar()->prepare("UPDATE $tabla SET codigo = :codigo, descripcion = :descripcion, id_categoria = :id_categoria, precio_compra = :precio_compra, precio_venta = :precio_venta, imagen = :imagen WHERE id = :id");
            $sentencia -> bindParam(":id", $datos["id"], PDO::PARAM_INT);
            $sentencia -> bindParam(":id_categoria", $datos["categoria"], PDO::PARAM_INT);
            $sentencia -> bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
            $sentencia -> bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
            $sentencia -> bindParam(":precio_compra", $datos["precioCompra"], PDO::PARAM_STR);
            $sentencia -> bindParam(":precio_venta", $datos["precioVenta"], PDO::PARAM_STR);
            $sentencia -> bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);

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