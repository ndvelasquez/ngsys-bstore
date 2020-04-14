<?php

    require_once "conexion.php";

    class ModeloUsuarios {

        // VERIFICA DATOS DE USUARIOS
        static public function mdlVerificaUsuario($tabla, $item, $valor) {
            $sentencia = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
            $sentencia -> bindParam(":".$item, $valor, PDO::PARAM_STR);
            $sentencia -> execute();

            return $sentencia -> fetch();
            $sentencia = null;
        }
        // MOSTRAR USUARIOS
        static public function mdlMostrarUsuario($tabla, $item, $valor) {
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
        // INSERTA NUEVO USUARIO
        static public function mdlCrearUsuario($tabla,$datos) {
            $sentencia = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, usuario, clave, perfil, foto) VALUES (:nombre, :usuario, :clave, :perfil, :foto)");
            $sentencia -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
            $sentencia -> bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
            $sentencia -> bindParam(":clave", $datos["clave"], PDO::PARAM_STR);
            $sentencia -> bindParam(":perfil", $datos["perfil"], PDO::PARAM_STR);
            $sentencia -> bindParam(":foto", $datos["foto"], PDO::PARAM_STR);

            if($sentencia -> execute()) {
                return "ok";
            }
            else {
                return "error";
            }

            $sentencia = null;
        }
        // EDITAR USUARIO
        static public function mdlEditarUsuario($tabla,$datos) {
            $sentencia = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, usuario = :usuario, clave = :clave, perfil = :perfil, foto = :foto WHERE id = :id");
            $sentencia -> bindParam(":id", $datos["id"], PDO::PARAM_INT);
            $sentencia -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
            $sentencia -> bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
            $sentencia -> bindParam(":clave", $datos["clave"], PDO::PARAM_STR);
            $sentencia -> bindParam(":perfil", $datos["perfil"], PDO::PARAM_STR);
            $sentencia -> bindParam(":foto", $datos["foto"], PDO::PARAM_STR);

            if($sentencia -> execute()) {
                return "ok";
            }
            else {
                return "error";
            }

            $sentencia = null;
        }
        // ACTUALIZAR ESTADO DEL USUARIO
        static public function mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2) {
            $sentencia = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");
            $sentencia -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
            $sentencia -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);

            if($sentencia -> execute()) {
                return "ok";
            }
            else {
                return "error";
            }

            $sentencia = null;
        }
        // ELIMINAR USUARIOS
        static public function mdlEliminarUsuario($tabla, $datos) {
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