<?php

    require_once "conexion.php";

    class ModeloVentas {

        // MOSTRAR VENTAS
        static public function mdlMostrarVenta($tabla, $item, $valor) {
            if ($item != null) {
                $sentencia = Conexion::conectar()->prepare("SELECT ventas.*, clientes.nombre as cliente, usuarios.nombre as vendedor FROM $tabla INNER JOIN clientes ON clientes.id = ventas.id_cliente INNER JOIN usuarios ON usuarios.id = ventas.id_usuario WHERE $item = :$item ORDER BY fecha DESC");
                $sentencia -> bindParam(":".$item, $valor, PDO::PARAM_STR);
                $sentencia -> execute();
            }
            else {
                $sentencia = Conexion::conectar()->prepare("SELECT ventas.*, clientes.nombre as cliente, usuarios.nombre as vendedor FROM $tabla INNER JOIN clientes ON clientes.id = ventas.id_cliente INNER JOIN usuarios ON usuarios.id = ventas.id_usuario ");
                $sentencia -> execute();

                return $sentencia -> fetchAll();
                $sentencia = null;
            }

            return $sentencia -> fetch();
            $sentencia = null;
        }
        // INSERTA NUEVA VENTA
        static public function mdlCrearVenta($tabla,$datos) {
            $sentencia = Conexion::conectar()->prepare("INSERT INTO $tabla(id_categoria, codigo, descripcion, stock, precio_compra, precio_venta, imagen) VALUES (:id_categoria, :codigo, :descripcion, :stock, :precio_compra, :precio_venta, :imagen)");
            $sentencia -> bindParam(":id_categoria", $datos["categoria"], PDO::PARAM_INT);
            $sentencia -> bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
            $sentencia -> bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
            $sentencia -> bindParam(":stock", $datos["stock"], PDO::PARAM_STR);
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
        // ANULAR VENTA
        static public function mdlAnularVenta($tabla, $datos) {
            $sentencia = Conexion::conectar()->prepare("UPDATE $tabla SET estatus = 0 WHERE id = :id");
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