<?php
    class ControladorCategorias {
        
        /*
        =====================================
        MOSTRAR CATEGORIAS
        =====================================
        */

        static public function ctrlMostrarCategorias($item, $valor) {
            $tabla = "categorias";
            $respuesta = ModeloCategorias::mdlMostrarCategoria($tabla, $item, $valor);

            return $respuesta;
        }

        /*
        =====================================
        GUARDAR CATEGORIA
        =====================================
        */

        static public function ctrlCrearCategoria() {

            if (isset($_POST["nombre"])) {
                    
                    $tabla = "categorias";
                    $datos = $_POST["nombre"];
                    $respuesta = ModeloCategorias::mdlCrearCategoria($tabla,$datos);

                    if ($respuesta == "ok") {
                        echo "<script>
                        Swal.fire({
                            type: 'success',
                            title: 'categoria creada',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            closeOnConfirm: false
                          }).then((result) =>{
                            if(result.value){
                                window.location = 'categorias';
                            }
                          });
                              </script>";
                    }
                    else {
                        echo "<script>
                        Swal.fire({
                            title: 'Error!',
                            text: 'Los datos no se guardaron correctamente',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            closeOnConfirm: false
                          }).then((result) =>{
                            if(result.value){
                                window.location = 'categorias';
                            }
                          });
                              </script>";
                    }
            }
        }

        /*
        ================================
        EDITAR CATEGORIA
        ================================
        */
        static public function ctrlEditarCategoria() {
            if (isset($_POST["idCategoria"])) {

                if (preg_match('/[a-zA-ZñÑ]\w+/', $_POST["editarNombre"])) {
                    
                    $tabla = "categorias";
                    $datos = array('id' => $_POST["idCategoria"], 'nombre' => $_POST["editarNombre"]);
                    $respuesta = ModeloCategorias::mdlEditarCategoria($tabla,$datos);

                    if ($respuesta == "ok") {
                        echo "<script>
                        Swal.fire({
                            type: 'success',
                            title: 'categoria editada',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            closeOnConfirm: false
                          }).then((result) =>{
                            if(result.value){
                                window.location = 'categorias';
                            }
                          });
                              </script>";
                    }
                    else {
                        echo "<script>
                        Swal.fire({
                            title: 'Error!',
                            text: 'Los datos no se guardaron correctamente',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            closeOnConfirm: false
                          }).then((result) =>{
                            if(result.value){
                                window.location = 'categorias';
                            }
                          });
                              </script>";
                    }
                }
                else {
                    echo "<script>
                        Swal.fire({
                            title: 'Error!',
                            text: 'El nombre no puede ir vacío',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            closeOnConfirm: false
                          }).then((result) =>{
                            if(result.value){
                                window.location = 'categorias';
                            }
                          });
                              </script>";
                }
            }
        }
        /*
        =====================================
        ELIMINAR CATEGORIAS
        =====================================
        */

        static public function ctrlEliminarCategoria() {
           if (isset($_GET["idCategoria"])) {
                $tabla = "categorias";
                $datos = $_GET["idCategoria"];

                $respuesta = ModeloCategorias::mdlEliminarCategoria($tabla, $datos);

                if ($respuesta == "ok") {
                    echo "<script>
                        Swal.fire({
                            type: 'success',
                            title: 'categoria eliminada',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            closeOnConfirm: false
                          }).then((result) =>{
                            if(result.value){
                                window.location = 'categorias';
                            }
                          });
                              </script>";
                }
                else {
                    echo "<script>
                        Swal.fire({
                            type: 'error',
                            title: 'Error al eliminar',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            closeOnConfirm: false
                          }).then((result) =>{
                            if(result.value){
                                window.location = 'categorias';
                            }
                          });
                              </script>";
                }
           }
        }
    }
?>