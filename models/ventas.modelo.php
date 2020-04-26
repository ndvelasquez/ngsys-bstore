<?php

    require_once "conexion.php";

    class ModeloVentas {

        // MOSTRAR VENTAS
        static public function mdlMostrarVenta($tabla, $item, $valor) {
            if ($item != null) {
                $sentencia = Conexion::conectar()->prepare("SELECT ventas.*, clientes.nombre as cliente, usuarios.nombre as vendedor FROM $tabla INNER JOIN clientes ON clientes.id = ventas.id_cliente INNER JOIN usuarios ON usuarios.id = ventas.id_usuario WHERE ventas.$item = :$item");
                $sentencia -> bindParam(":".$item, $valor, PDO::PARAM_STR);
                $sentencia -> execute();
            }
            else {
                $sentencia = Conexion::conectar()->prepare("SELECT ventas.*, clientes.nombre as cliente, usuarios.nombre as vendedor FROM $tabla INNER JOIN clientes ON clientes.id = ventas.id_cliente INNER JOIN usuarios ON usuarios.id = ventas.id_usuario");
                $sentencia -> execute();

                return $sentencia -> fetchAll();
                $sentencia = null;
            }

            return $sentencia -> fetch();
            $sentencia = null;
        }
        // INSERTA NUEVA VENTA
        static public function mdlCrearVenta($tabla,$datos) {
            $sentencia = Conexion::conectar()->prepare("INSERT INTO $tabla(codigo, id_usuario, id_cliente, productos, neto, impuestos, total, metodo_pago, estado) VALUES (:codigo, :id_usuario, :id_cliente, :productos, :neto, :impuestos, :total, :metodo_pago, 1)");
            $sentencia -> bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
            $sentencia -> bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_INT);
            $sentencia -> bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);
            $sentencia -> bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
            $sentencia -> bindParam(":neto", $datos["neto"], PDO::PARAM_STR);
            $sentencia -> bindParam(":impuestos", $datos["impuestos"], PDO::PARAM_STR);
            $sentencia -> bindParam(":total", $datos["total"], PDO::PARAM_STR);
            $sentencia -> bindParam(":metodo_pago", $datos["metodo_pago"], PDO::PARAM_STR);

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
            $sentencia = Conexion::conectar()->prepare("UPDATE $tabla SET codigo = :codigo, id_usuario = :id_usuario, id_cliente = :id_cliente, productos = :productos, neto = :neto, impuestos = :impuestos, total = :total, metodo_pago = :metodo_pago WHERE id = :id");
            $sentencia -> bindParam(":id", $datos["id"], PDO::PARAM_INT);
            $sentencia -> bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
            $sentencia -> bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_INT);
            $sentencia -> bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);
            $sentencia -> bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
            $sentencia -> bindParam(":neto", $datos["neto"], PDO::PARAM_STR);
            $sentencia -> bindParam(":impuestos", $datos["impuestos"], PDO::PARAM_STR);
            $sentencia -> bindParam(":total", $datos["total"], PDO::PARAM_STR);
            $sentencia -> bindParam(":metodo_pago", $datos["metodo_pago"], PDO::PARAM_STR);

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
            $sentencia = Conexion::conectar()->prepare("UPDATE $tabla SET estado = 2 WHERE id = :id");
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

        // MOSTRAR VENTAS POR RANGO DE FECHAS
        static public function mdlMostrarRangoFechasVenta($tabla, $fechaInicio, $fechaFin) {
            if ($fechaInicio == null) {
                $sentencia = Conexion::conectar()->prepare("SELECT ventas.*, clientes.nombre as cliente, usuarios.nombre as vendedor FROM $tabla INNER JOIN clientes ON clientes.id = ventas.id_cliente INNER JOIN usuarios ON usuarios.id = ventas.id_usuario");
                $sentencia -> execute();

                return $sentencia -> fetchAll();
            }
            else if ($fechaInicio == $fechaFin) {
                $sentencia = Conexion::conectar()->prepare("SELECT ventas.*, clientes.nombre as cliente, usuarios.nombre as vendedor FROM $tabla INNER JOIN clientes ON clientes.id = ventas.id_cliente INNER JOIN usuarios ON usuarios.id = ventas.id_usuario WHERE ventas.fecha_creacion LIKE '%$fechaInicio%'");
                $sentencia -> bindParam(":ventas.fecha_creacion", $fechaInicio, PDO::PARAM_STR);
                $sentencia -> execute();

                return $sentencia -> fetchAll();
            }
            else {
                $sentencia = Conexion::conectar()->prepare("SELECT ventas.*, clientes.nombre as cliente, usuarios.nombre as vendedor FROM $tabla INNER JOIN clientes ON clientes.id = ventas.id_cliente INNER JOIN usuarios ON usuarios.id = ventas.id_usuario WHERE ventas.fecha_creacion BETWEEN '$fechaInicio' AND '$fechaFin'");
                $sentencia -> execute();

                return $sentencia -> fetchAll();
            }
            $sentencia = null;
        }

        // MOSTRAR EL TOTAL DE VENTAS POR VENDEDOR
        static public function mdlVentasPorVendedor($tabla) {
            $sentencia = Conexion::conectar()->prepare("SELECT usuarios.nombre as vendedor, (SELECT SUM(total)) AS total_ventas FROM $tabla
            INNER JOIN usuarios ON usuarios.id = ventas.id_usuario
            WHERE ventas.estado = 1
            GROUP BY id_usuario;");
            $sentencia -> execute();
            return $sentencia -> fetchAll();
        }
        // MOSTRAR EL TOTAL COMPRADO POR CLIENTE
        static public function mdlComprasPorCliente($tabla) {
            $sentencia = Conexion::conectar()->prepare("SELECT clientes.nombre as cliente, clientes.compras as cantidad_compras, (SELECT SUM(total)) AS total_compras FROM $tabla
            INNER JOIN clientes ON clientes.id = ventas.id_cliente
            WHERE ventas.estado = 1
            GROUP BY id_cliente;");
            $sentencia -> execute();
            return $sentencia -> fetchAll();
        }
    }

?>