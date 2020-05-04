<?php
    class ControladorClientes {
        
        /*
        =====================================
        MOSTRAR CLIENTES
        =====================================
        */

        static public function ctrlMostrarClientes($item, $valor) {
            $tabla = "clientes";
            $respuesta = ModeloClientes::mdlMostrarCliente($tabla, $item, $valor);

            return $respuesta;
        }
        /*
        =====================================
        VERIFICAR DOCUMENTO
        =====================================
        */

        static public function ctrlVerificaDocumento($item1, $valor1, $item2, $valor2) {
            $tabla = "clientes";
            $respuesta = ModeloClientes::mdlVerificaDocumento($tabla, $item1, $valor1, $item2, $valor2);

            return $respuesta;
        }

        /*
        =====================================
        GUARDAR CLIENTE
        =====================================
        */

        static public function ctrlCrearCliente() {

            if (isset($_POST["nombre"])
                && isset($_POST["telefono"])
                && isset($_POST["direccion"])) {

                    if (preg_match('/[a-zA-ZñÑ]\w+/', $_POST["nombre"])
                        
                        && preg_match('/^[()\-0-9 ]+$/', $_POST["telefono"])) {

                            $tabla = "clientes";
                            $datos = array(
                                "nombre" => $_POST["nombre"],
                                "tipo_documento" => $_POST["tipoDocumento"],
                                "documento" => $_POST["documento"],
                                "email" => $_POST["email"],
                                "telefono" => $_POST["telefono"],
                                "fecha_nacimiento" => $_POST["fechaNacimiento"],
                                "direccion" => $_POST["direccion"]
                            );
                            $respuesta = ModeloClientes::mdlCrearCliente($tabla,$datos);
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
                                    title: 'Cliente creado',
                                    icon: 'success',
                                    confirmButtonText: 'Cerrar',
                                    closeOnConfirm: false
                                  }).then((result) =>{
                                    if(result.value){
                                        window.location = 'clientes';
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
                                        window.location = 'clientes';
                                    }
                                  });
                                      </script>";
                            }
                    }
                    else {
                        echo "<script>
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'El formato de los campos deben coincidir con los solicitados',
                                    icon: 'error',
                                    confirmButtonText: 'Cerrar',
                                    closeOnConfirm: false
                              </script>";
                    }
            }
        }

        /*
        ================================
        EDITAR CLIENTE
        ================================
        */
        static public function ctrlEditarCliente() {
            if (isset($_POST["idCliente"])) {

                if (preg_match('/[a-zA-ZñÑ]\w+/', $_POST["editarNombre"])
                && preg_match('/[0-9]+/', $_POST["editarDocumento"])
                && preg_match('/\b[\w\.-]+@[\w\.-]+\.\w{2,4}\b/', $_POST["editarEmail"])
                && preg_match('/[0-9]+/', $_POST["editarTelefono"])) {
                    
                    $tabla = "clientes";
                    $datos = array(
                        "id" => $_POST["id"],
                        "nombre" => $_POST["editarNombre"],
                        "tipo_documento" => $_POST["editarTipoDocumento"],
                        "documento" => $_POST["editarDocumento"],
                        "email" => $_POST["editarEmail"],
                        "telefono" => $_POST["editarTelefono"],
                        "fecha_nacimiento" => $_POST["editarFechaNacimiento"],
                        "direccion" => $_POST["editarDireccion"]
                    );
                    $respuesta = ModeloClientes::mdlEditarCliente($tabla,$datos);
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
                            title: 'Cliente editado',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            closeOnConfirm: false
                          }).then((result) =>{
                            if(result.value){
                                window.location = 'clientes';
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
                                window.location = 'clientes';
                            }
                          });
                              </script>";
                    }
                }
                else {
                    echo "<script>
                        Swal.fire({
                            title: 'Error!',
                            text: 'Los campos solicitados no pueden ir vacíos',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                        </script>";
                }
            }
        }

        /*
        =====================================
        ELIMINAR CLIENTES
        =====================================
        */
        static public function ctrlEliminarCliente() {
           if (isset($_GET["idCliente"])) {
                $tabla = "clientes";
                $datos = $_GET["idCliente"];

                $respuesta = ModeloClientes::mdlEliminarCliente($tabla, $datos);
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
                            title: 'Cliente eliminado',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            closeOnConfirm: false
                          }).then((result) =>{
                            if(result.value){
                                window.location = 'clientes';
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
                                window.location = 'clientes';
                            }
                          });
                              </script>";
                }
           }
        }
    }
?>