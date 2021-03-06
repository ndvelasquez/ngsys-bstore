<?php

    require_once "conexion.php";

    class ModeloProductos {

        // MOSTRAR PRODUCTOS
        static public function mdlMostrarProducto($tabla, $item, $valor) {
            if ($item != null) {
                // VERIFICO SI SE ESTA SELECCIONANDO UN ALMACEN
                if ($item == "id_almacen") {
                    $tabla = "productos_almacen";
                    $sentencia = Conexion::conectar()->prepare("SELECT
                    categorias.nombre AS categoria,
                    productos.*,
                    productos_almacen.id_almacen,
                    almacen.nombre AS almacen
                    FROM
                        productos
                    INNER JOIN categorias ON categorias.id = productos.id_categoria
                    INNER JOIN productos_almacen ON productos_almacen.id_producto = productos.id
                    INNER JOIN almacen ON almacen.id = productos_almacen.id_almacen
                    WHERE $tabla.$item = :$item
                    ORDER BY
                    productos.id DESC");
                    $sentencia -> bindParam(":".$item, $valor, PDO::PARAM_STR);
                    $sentencia -> execute();

                    return $sentencia -> fetchAll();
                    $sentencia = null;
                }
                else {
                    $sentencia = Conexion::conectar()->prepare("SELECT
                    categorias.nombre AS categoria,
                    productos.*,
                    productos_almacen.id_almacen,
                    almacen.nombre AS almacen
                    FROM
                        productos
                    INNER JOIN categorias ON categorias.id = productos.id_categoria
                    INNER JOIN productos_almacen ON productos_almacen.id_producto = productos.id
                    INNER JOIN almacen ON almacen.id = productos_almacen.id_almacen
                    WHERE $tabla.$item = :$item
                    ORDER BY
                    productos.id DESC");
                    $sentencia -> bindParam(":".$item, $valor, PDO::PARAM_STR);
                    $sentencia -> execute();
                }

            }
            else {
                $sentencia = Conexion::conectar()->prepare("SELECT
                categorias.nombre AS categoria,
                productos.*,
                productos_almacen.id_almacen,
                almacen.nombre AS almacen
                FROM
                productos
                INNER JOIN categorias ON categorias.id = productos.id_categoria
                INNER JOIN productos_almacen ON productos_almacen.id_producto = productos.id
                INNER JOIN almacen ON almacen.id = productos_almacen.id_almacen");
                $sentencia -> execute();

                return $sentencia -> fetchAll();
                $sentencia = null;
            }   

            return $sentencia -> fetch();
            $sentencia = null;
        }
        // INSERTA NUEVO PRODUCTO
        static public function mdlCrearProducto($tabla,$datos) {
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
        // EDITAR PRODUCTO
        static public function mdlEditarProducto($tabla,$datos) {
            $sentencia = Conexion::conectar()->prepare("UPDATE $tabla SET codigo = :codigo, descripcion = :descripcion, id_categoria = :id_categoria, stock = stock + :cantidad, precio_compra = :precio_compra, precio_venta = :precio_venta, imagen = :imagen WHERE id = :id");
            $sentencia -> bindParam(":id", $datos["id"], PDO::PARAM_INT);
            $sentencia -> bindParam(":id_categoria", $datos["categoria"], PDO::PARAM_INT);
            $sentencia -> bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
            $sentencia -> bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
            $sentencia -> bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_STR);
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
        // ACTUALIZAR PRODUCTO
        static public function mdlActualizarProducto($tabla, $item1, $valor1, $criterio) {
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
        // ELIMINAR PRODUCTOS
        static public function mdlEliminarProducto($tabla, $datos) {
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
        // MOSTRAR PRODUCTOS MAS VENDIDOS
        static public function mdlMasVendidos($tabla) {
            $sentencia = Conexion::conectar()->prepare("SELECT descripcion, ventas, (SELECT SUM(ventas) FROM productos) as total FROM $tabla ORDER BY ventas DESC LIMIT 5");
            $sentencia -> execute();
            
            return $sentencia -> fetchAll();
            $sentencia = null;
        }
        // TRAER SOLO PRODUCTOS
        static public function mdlTraerSoloProducto($tabla, $item, $valor) {

            $sentencia = Conexion::conectar()->prepare("SELECT
                    categorias.nombre AS categoria,
                    productos.*
                    FROM
                        productos
                    INNER JOIN categorias ON categorias.id = productos.id_categoria
                    WHERE $tabla.$item = :$item
                    ORDER BY
                    productos.id DESC");
                    $sentencia -> bindParam(":".$item, $valor, PDO::PARAM_STR);
                    $sentencia -> execute();

                    return $sentencia -> fetch();
                    $sentencia = null;
        }
    }

?>