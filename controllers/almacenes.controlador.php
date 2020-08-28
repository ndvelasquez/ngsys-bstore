<?php
    class ControladorAlmacenes {
        
        /*
        =====================================
        MOSTRAR ALMACENES
        =====================================
        */

        static public function ctrlMostrarAlmacen($item, $valor) {
            $tabla = "almacen";
            $respuesta = ModeloAlmacenes::mdlMostrarAlmacen($tabla, $item, $valor);

            return $respuesta;
        }

        /*
        =====================================
        GUARDAR ALMACEN
        =====================================
        */

        static public function ctrlCrearAlmacen() {

            if (isset($_POST["nombre"])) {
                    
                    $tabla = "almacen";
                    $datos = $_POST["nombre"];
                    $respuesta = ModeloAlmacenes::mdlCrearAlmacen($tabla,$datos);
                    /*======================================================
                    INSERTA EL LOG DE AUDITORIA
                    ========================================================*/
                    $datosAuditoria = array(
                        "usuario" => $_SESSION["usuario"],
                        "accion" => "INSERTAR",
                        "tabla" => $tabla
                    );
                    $respuestoaAuditoria = ModeloAuditoria::mdlInsertaLog($datosAuditoria);
                    if ($respuesta == "ok") {
                        echo "<script>
                        Swal.fire({
                            type: 'success',
                            title: 'almacen creado',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            closeOnConfirm: false
                          }).then((result) =>{
                            if(result.value){
                                window.location = 'almacenes';
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
                                window.location = 'almacenes';
                            }
                          });
                              </script>";
                    }
            }
        }

        /*
        ================================
        EDITAR ALMACEN
        ================================
        */
        static public function ctrlEditarAlmacen() {
            if (isset($_POST["idAlmacen"])) {

                if (preg_match('/[a-zA-ZñÑ]\w+/', $_POST["editarNombre"])) {
                    
                    $tabla = "almacen";
                    $datos = array('id' => $_POST["idAlmacen"], 'nombre' => $_POST["editarNombre"]);
                    $respuesta = ModeloAlmacenes::mdlEditarAlmacen($tabla,$datos);
                    /*======================================================
                    INSERTA EL LOG DE AUDITORIA
                    ========================================================*/
                    $datosAuditoria = array(
                        "usuario" => $_SESSION["usuario"],
                        "accion" => "MODIFICAR",
                        "tabla" => $tabla
                    );
                    $respuestoaAuditoria = ModeloAuditoria::mdlInsertaLog($datosAuditoria);
                    if ($respuesta == "ok") {
                        echo "<script>
                        Swal.fire({
                            type: 'success',
                            title: 'almacen editado',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            closeOnConfirm: false
                          }).then((result) =>{
                            if(result.value){
                                window.location = 'almacenes';
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
                                window.location = 'almacenes';
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
                                window.location = 'almacenes';
                            }
                          });
                              </script>";
                }
            }
        }
        /*
        =====================================
        ELIMINAR ALMACENES
        =====================================
        */

        static public function ctrlEliminarAlmacen() {
           if (isset($_GET["idAlmacen"])) {
                $tabla = "almacen";
                $datos = $_GET["idAlmacen"];

                $respuesta = ModeloAlmacenes::mdlEliminarAlmacen($tabla, $datos);
                /*======================================================
                INSERTA EL LOG DE AUDITORIA
                ========================================================*/
                $datosAuditoria = array(
                    "usuario" => $_SESSION["usuario"],
                    "accion" => "ELIMINAR",
                    "tabla" => $tabla
                );
                $respuestoaAuditoria = ModeloAuditoria::mdlInsertaLog($datosAuditoria);
                if ($respuesta == "ok") {
                    echo "<script>
                        Swal.fire({
                            type: 'success',
                            title: 'almacen eliminado',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            closeOnConfirm: false
                          }).then((result) =>{
                            if(result.value){
                                window.location = 'almacenes';
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
                                window.location = 'almacenes';
                            }
                          });
                              </script>";
                }
           }
        }
    }
?>