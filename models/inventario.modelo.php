<?php

    require_once "conexion.php";

    class ModeloInventario {

        // MOSTRAR MOVIMIENTOS
        static public function mdlMostrarMovimientos($item, $valor) {
            if ($item != null) {
                $sentencia = Conexion::conectar()->prepare("SELECT inventario.*, productos.descripcion as producto FROM inventario INNER JOIN productos ON productos.id = inventario.id_producto WHERE inventario.$item = :$item ORDER BY inventario.id DESC");
                $sentencia -> bindParam(":".$item, $valor, PDO::PARAM_STR);
                $sentencia -> execute();
            }
            else {
                $sentencia = Conexion::conectar()->prepare("SELECT inventario.*, productos.descripcion as producto FROM inventario INNER JOIN productos ON productos.id = inventario.id_producto ORDER BY inventario.id DESC");
                $sentencia -> execute();

                return $sentencia -> fetchAll();
                $sentencia = null;
            }

            return $sentencia -> fetchAll();
            $sentencia = null;
        }
        // INSERTA NUEVO MOVIMIENTO
        static public function mdlInsertaMovimiento($datos) {
            $sentencia = Conexion::conectar()->prepare("INSERT INTO inventario(id_producto, tipo_movimiento, cantidad) VALUES (:id_producto, :tipo_movimiento, :cantidad)");
            $sentencia -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);
            $sentencia -> bindParam(":tipo_movimiento", $datos["tipo_movimiento"], PDO::PARAM_STR);
            $sentencia -> bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_STR);

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