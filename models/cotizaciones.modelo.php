<?php

    require_once "conexion.php";

    class ModeloCotizaciones {

        // MOSTRAR COTIZACIONES
        static public function mdlMostrarCotizacion($tabla, $item, $valor) {
            if ($item != null) {
                $sentencia = Conexion::conectar()->prepare("SELECT cotizaciones.*, clientes.nombre as cliente, usuarios.nombre as vendedor FROM $tabla INNER JOIN clientes ON clientes.id = cotizaciones.id_cliente INNER JOIN usuarios ON usuarios.id = cotizaciones.id_usuario WHERE cotizaciones.$item = :$item");
                $sentencia -> bindParam(":".$item, $valor, PDO::PARAM_STR);
                $sentencia -> execute();
            }
            else {
                $sentencia = Conexion::conectar()->prepare("SELECT cotizaciones.*, clientes.nombre as cliente, usuarios.nombre as vendedor FROM $tabla INNER JOIN clientes ON clientes.id = cotizaciones.id_cliente INNER JOIN usuarios ON usuarios.id = cotizaciones.id_usuario");
                $sentencia -> execute();

                return $sentencia -> fetchAll();
                $sentencia = null;
            }

            return $sentencia -> fetch();
            $sentencia = null;
        }

        // INSERTA NUEVA COTIZACION
        static public function mdlCrearCotizacion($tabla,$datos) {
            $sentencia = Conexion::conectar()->prepare("INSERT INTO $tabla(codigo, id_usuario, id_cliente, productos, neto, impuestos, total, estado) VALUES (:codigo, :id_usuario, :id_cliente, :productos, :neto, :impuestos, :total, 1)");
            $sentencia -> bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
            $sentencia -> bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_INT);
            $sentencia -> bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);
            $sentencia -> bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
            $sentencia -> bindParam(":neto", $datos["neto"], PDO::PARAM_STR);
            $sentencia -> bindParam(":impuestos", $datos["impuestos"], PDO::PARAM_STR);
            $sentencia -> bindParam(":total", $datos["total"], PDO::PARAM_STR);

            if($sentencia -> execute()) {
                return "ok";
            }
            else {
                return "error";
            }

            $sentencia = null;
        }
        // EDITAR COTIZACION
        static public function mdlEditarCotizacion($tabla,$datos) {
            $sentencia = Conexion::conectar()->prepare("UPDATE $tabla SET codigo = :codigo, id_usuario = :id_usuario, id_cliente = :id_cliente, productos = :productos, neto = :neto, impuestos = :impuestos, total = :total WHERE id = :id");
            $sentencia -> bindParam(":id", $datos["id"], PDO::PARAM_INT);
            $sentencia -> bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
            $sentencia -> bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_INT);
            $sentencia -> bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);
            $sentencia -> bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
            $sentencia -> bindParam(":neto", $datos["neto"], PDO::PARAM_STR);
            $sentencia -> bindParam(":impuestos", $datos["impuestos"], PDO::PARAM_STR);
            $sentencia -> bindParam(":total", $datos["total"], PDO::PARAM_STR);

            if($sentencia -> execute()) {
                return "ok";
            }
            else {
                return "error";
            }

            $sentencia = null;
        }
        // ANULAR COTIZACION
        static public function mdlAnularCotizacion($tabla, $datos) {
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

        // ACTUALIZAR ESTADO COOTIZACION
        static public function mdlActualizaCotizacion($item, $valor) {
            $sentencia = Conexion::conectar()->prepare("UPDATE cotizaciones SET estado = 3 WHERE $item = :$item");
            $sentencia -> bindParam(":".$item, $valor, PDO::PARAM_STR);
            $sentencia -> execute();

            if($sentencia -> execute()) {
                return "ok";
            }
            else {
                return "error";
            }
            $sentencia = null;
        }

        // MOSTRAR COTIZACIONES POR RANGO DE FECHAS Y VENDEDOR
        static public function mdlMostrarCotizacionVendedor($tabla, $fechaInicio, $fechaFin, $vendedor) {
            if ($fechaInicio == null) {
                $sentencia = Conexion::conectar()->prepare("SELECT cotizaciones.*, clientes.nombre as cliente, usuarios.nombre as vendedor FROM $tabla INNER JOIN clientes ON clientes.id = cotizaciones.id_cliente INNER JOIN usuarios ON usuarios.id = cotizaciones.id_usuario WHERE cotizaciones.id_usuario = :id_usuario");
                $sentencia -> bindParam(":id_usuario", $vendedor, PDO::PARAM_STR);
                $sentencia -> execute();

                return $sentencia -> fetchAll();
            }
            else if ($fechaInicio == $fechaFin) {
                $sentencia = Conexion::conectar()->prepare("SELECT cotizaciones.*, clientes.nombre as cliente, usuarios.nombre as vendedor FROM $tabla INNER JOIN clientes ON clientes.id = cotizaciones.id_cliente INNER JOIN usuarios ON usuarios.id = cotizaciones.id_usuario WHERE cotizaciones.fecha_creacion LIKE '%$fechaInicio%' AND cotizaciones.id_usuario = :id_usuario");
                $sentencia -> bindParam(":cotizaciones.fecha_creacion", $fechaInicio, PDO::PARAM_STR);
                $sentencia -> bindParam(":id_usuario", $vendedor, PDO::PARAM_STR);
                $sentencia -> execute();

                return $sentencia -> fetchAll();
            }
            else {
                $sentencia = Conexion::conectar()->prepare("SELECT cotizaciones.*, clientes.nombre as cliente, usuarios.nombre as vendedor FROM $tabla INNER JOIN clientes ON clientes.id = cotizaciones.id_cliente INNER JOIN usuarios ON usuarios.id = cotizaciones.id_usuario WHERE cotizaciones.fecha_creacion BETWEEN '$fechaInicio' AND '$fechaFin' AND cotizaciones.id_usuario = :id_usuario");
                $sentencia -> bindParam(":id_usuario", $vendedor, PDO::PARAM_STR);
                $sentencia -> execute();

                return $sentencia -> fetchAll();
            }
            $sentencia = null;
        }

        // MOSTRAR COTIZACIONES POR RANGO DE FECHA
        static public function mdlMostrarRangoFechasCotizacion($tabla, $fechaInicio, $fechaFin) {
            if ($fechaInicio == null) {
                $sentencia = Conexion::conectar()->prepare("SELECT cotizaciones.*, clientes.nombre as cliente, usuarios.nombre as vendedor FROM $tabla INNER JOIN clientes ON clientes.id = cotizaciones.id_cliente INNER JOIN usuarios ON usuarios.id = cotizaciones.id_usuario");
                $sentencia -> execute();

                return $sentencia -> fetchAll();
            }
            else if ($fechaInicio == $fechaFin) {
                $sentencia = Conexion::conectar()->prepare("SELECT cotizaciones.*, clientes.nombre as cliente, usuarios.nombre as vendedor FROM $tabla INNER JOIN clientes ON clientes.id = cotizaciones.id_cliente INNER JOIN usuarios ON usuarios.id = cotizaciones.id_usuario WHERE cotizaciones.fecha_creacion LIKE '%$fechaInicio%'");
                $sentencia -> bindParam(":cotizaciones.fecha_creacion", $fechaInicio, PDO::PARAM_STR);
                $sentencia -> execute();

                return $sentencia -> fetchAll();
            }
            else {
                $sentencia = Conexion::conectar()->prepare("SELECT cotizaciones.*, clientes.nombre as cliente, usuarios.nombre as vendedor FROM $tabla INNER JOIN clientes ON clientes.id = cotizaciones.id_cliente INNER JOIN usuarios ON usuarios.id = cotizaciones.id_usuario WHERE cotizaciones.fecha_creacion BETWEEN '$fechaInicio' AND '$fechaFin'");
                $sentencia -> execute();

                return $sentencia -> fetchAll();
            }
            $sentencia = null;
        }

    }

?>