<?php
    class ControladorUsuarios {
        
        /* ==================================
            VALIDACION DE INGRESO DE USUARIO
           ==================================*/
        static public function ctrlValidaUsuario() {
            if(isset($_POST["Iusuario"])) {
                if (preg_match('/^[a-zA-Z0-9]+$/', $_POST["Iusuario"]) 
                 && preg_match('/(\W|^)[\w.\-]{0,25}/', $_POST["Ipassword"])) {
                    
                    $tabla = "usuarios";
                    $item = "usuario";
                    $valor = $_POST["Iusuario"];
                    
                    $respuesta = ModeloUsuarios::mdlVerificaUsuario($tabla,$item,$valor);
                    $hash = $respuesta["clave"];
                    if ($respuesta["usuario"] == $_POST["Iusuario"] && password_verify($_POST["Ipassword"], $hash)) {
                        if ($respuesta["estado"] == 0) {
                            echo '<br><div class="alert alert-danger">El usuario se encuentra deshabilitado</div>';  
                        }
                        else {
                            $_SESSION["validaLogin"] = "validado";
                            $_SESSION["id"] = $respuesta["id"];
                            $_SESSION["nombre"] = $respuesta["nombre"];
                            $_SESSION["usuario"] = $respuesta["usuario"];
                            $_SESSION["foto"] = $respuesta["foto"];
                            $_SESSION["perfil"] = $respuesta["perfil"];
                            date_default_timezone_set('America/Lima');
                            $fechaActual = date('Y-m-d H:i:s');
                            $item1 = "ultimo_login";
                            $item2 = "id";
                            $valor1 = $fechaActual;
                            $valor2 = $respuesta["id"];
                            $ultimoLogin = ModeloUsuarios::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);

                            if($ultimoLogin == "ok") {
                                echo '<script>
                                        window.location = "inicio"
                                      </script>';
                            }
                        }
                    }
                    else {
                        echo '<br><div class="alert alert-danger">Error: Usuario o contraseña no válidos</div>';
                    }
                }
            }
        }

        /*
        =====================================
        MOSTRAR USUARIOS
        =====================================
        */

        static public function ctrlMostrarUsuarios($item, $valor) {
            $tabla = "usuarios";
            $respuesta = ModeloUsuarios::mdlMostrarUsuario($tabla, $item, $valor);

            return $respuesta;
        }

        /*
        =====================================
        GUARDAR USUARIO
        =====================================
        */

        static public function ctrlCrearUsuario() {

            if (isset($_POST["nombreUsuario"])
               && isset($_POST["usuario"])
               && isset($_POST["clave"])
               && isset($_POST["perfilUsuario"])) {

                if (preg_match('/[a-zA-ZñÑ]\w+/', $_POST["nombreUsuario"])
                  && preg_match('/^[a-zA-Z0-9]+$/', $_POST["usuario"])
                  && preg_match('/(\W|^)[\w.\-]{0,25}/', $_POST["clave"])) {

                    $ruta = "";
                    /*
                    =======================================
                    VALIDAR FOTO DEL USUARIO
                    =======================================
                    */
                    if(isset($_FILES["fotoUsuario"]["tmp_name"])) {
                        
                        // creo un array para obtener las dimensiones de la foto de origen 
                        list($ancho, $alto) = getimagesize($_FILES["fotoUsuario"]["tmp_name"]);

                        // tamaño al que quiero redimensionar en pixeles
                        $nuevoAncho = 500;
                        $nuevoAlto = 500;

                        /*
                        =============================================
                        CREO DIRECTORIO DONDE SE GUARDARAN LAS FOTOS
                        =============================================
                        */
                        $directorio = "views/img/usuarios/".$_POST["usuario"];
                        mkdir($directorio, 0755); //0755 es el codigo de lectura y escritura

                        
                        /*
                        =============================================
                        SUBO LA FOTO DE ACUERDO AL TIPO DE IMAGEN
                        =============================================
                        */

                        if ($_FILES["fotoUsuario"]["type"] == "image/jpeg") {
                            /*
                            =============================================
                            PROCESO DE GUARDADO
                            =============================================
                            */
                            $aleatorio = mt_rand(100, 999);

                            $ruta = "views/img/usuarios/".$_POST["usuario"]."/".$aleatorio.".jpg";
                            $origen = imagecreatefromjpeg($_FILES["fotoUsuario"]["tmp_name"]);
                            $destino = imagecreatetruecolor($nuevoAncho,$nuevoAncho);
                            imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $alto, $ancho);
                            imagejpeg($destino, $ruta);
                        }

                        if ($_FILES["fotoUsuario"]["type"] == "image/png") {
                            /*
                            =============================================
                            PROCESO DE GUARDADO
                            =============================================
                            */
                            $aleatorio = mt_rand(100, 999);

                            $ruta = "views/img/usuarios/".$_POST["usuario"]."/".$aleatorio.".png";
                            $origen = imagecreatefrompng($_FILES["fotoUsuario"]["tmp_name"]);
                            $destino = imagecreatetruecolor($nuevoAncho,$nuevoAncho);
                            imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $alto, $ancho);
                            imagepng($destino, $ruta);
                        }
                    }
                    
                    $tabla = "usuarios";
                    $clave = password_hash($_POST["clave"], PASSWORD_DEFAULT);
                    $datos = array(
                            "nombre" => $_POST["nombreUsuario"],
                            "usuario" => $_POST["usuario"],
                            "clave" => $clave,
                            "perfil" => $_POST["perfilUsuario"],
                            "foto" => $ruta
                    );
                    $respuesta = ModeloUsuarios::mdlCrearUsuario($tabla,$datos);

                    if ($respuesta == "ok") {
                        echo "<script>
                        Swal.fire({
                            type: 'success',
                            title: 'Usuario creado',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            closeOnConfirm: false
                          }).then((result) =>{
                            if(result.value){
                                window.location = 'usuarios';
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
                                window.location = 'usuarios';
                            }
                          });
                              </script>";
                    }
                }
            }
        }

        /*
        ================================
        EDITAR USUARIO
        ================================
        */
        static public function ctrlEditarUsuario() {
            if (isset($_POST["editarUsuario"])) {

                if (preg_match('/[a-zA-ZñÑ]\w+/', $_POST["editarNombreUsuario"])) {
                    
                    $ruta = $_POST["fotoActual"];

                    /*
                    =======================================
                    VALIDAR FOTO DEL USUARIO
                    =======================================
                    */
                    if(isset($_FILES["editarFoto"]["tmp_name"]) && !empty($_FILES["editarFoto"]["tmp_name"])) {
                        
                        // creo un array para obtener las dimensiones de la foto de origen 
                        list($ancho, $alto) = getimagesize($_FILES["editarFoto"]["tmp_name"]);

                        // tamaño al que quiero redimensionar en pixeles
                        $nuevoAncho = 500;
                        $nuevoAlto = 500;

                        /*
                        =============================================
                        CREO DIRECTORIO DONDE SE GUARDARAN LAS FOTOS
                        =============================================
                        */
                        $directorio = "views/img/usuarios/".$_POST["editarUsuario"];

                        /* 
                        =============================================
                        VERIFICO QUE EXISTA EL DIRECTORIO DEL USUARIO
                        =============================================
                        */
                        if (!empty($_POST["fotoActual"])) {
                            unlink($_POST["fotoActual"]);
                        }
                        else {
                            mkdir($directorio, 0755); //0755 es el codigo de lectura y escritura
                        }

                        
                        /*
                        =============================================
                        SUBO LA FOTO DE ACUERDO AL TIPO DE IMAGEN
                        =============================================
                        */

                        if ($_FILES["editarFoto"]["type"] == "image/jpeg") {
                            /*
                            =============================================
                            PROCESO DE GUARDADO
                            =============================================
                            */
                            $aleatorio = mt_rand(100, 999);

                            $ruta = "views/img/usuarios/".$_POST["editarUsuario"]."/".$aleatorio.".jpg";
                            $origen = imagecreatefromjpeg($_FILES["editarFoto"]["tmp_name"]);
                            $destino = imagecreatetruecolor($nuevoAncho,$nuevoAncho);
                            imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $alto, $ancho);
                            imagejpeg($destino, $ruta);
                        }

                        if ($_FILES["editarFoto"]["type"] == "image/png") {
                            /*
                            =============================================
                            PROCESO DE GUARDADO
                            =============================================
                            */
                            $aleatorio = mt_rand(100, 999);

                            $ruta = "views/img/usuarios/".$_POST["editarUsuario"]."/".$aleatorio.".png";
                            $origen = imagecreatefrompng($_FILES["editarFoto"]["tmp_name"]);
                            $destino = imagecreatetruecolor($nuevoAncho,$nuevoAncho);
                            imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $alto, $ancho);
                            imagepng($destino, $ruta);
                        }
                    }
                    /* 
                    =======================================
                    VALIDAR CONTRASEÑA DEL USUARIO
                    =======================================
                    */
                    if ($_POST["editarClave"] != "") {
                        if(preg_match('/(\W|^)[\w.\-]{0,25}/', $_POST["editarClave"])) {
                            $clave = password_hash($_POST["editarClave"], PASSWORD_DEFAULT);
                        }
                        else {
                            echo "<script>
                            Swal.fire({
                                title: 'Error!',
                                text: 'El formato no coincide con lo solicitado',
                                icon: 'error',
                                confirmButtonText: 'Cerrar',
                                closeOnConfirm: false
                            }).then((result) =>{
                                if(result.value){
                                    window.location = 'usuarios';
                                }
                            });
                            </script>";
                        }
                    }
                    else {
                        $clave = $_POST["claveActual"];
                    }
                    
                    $tabla = "usuarios";
                    $datos = array(
                            "id" => $_POST["idUsuario"],
                            "nombre" => $_POST["editarNombreUsuario"],
                            "usuario" => $_POST["editarUsuario"],
                            "clave" => $clave,
                            "perfil" => $_POST["editarPerfil"],
                            "foto" => $ruta
                    );
                    $respuesta = ModeloUsuarios::mdlEditarUsuario($tabla,$datos);

                    if ($respuesta == "ok") {
                        echo "<script>
                        Swal.fire({
                            type: 'success',
                            title: 'Usuario editado',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            closeOnConfirm: false
                          }).then((result) =>{
                            if(result.value){
                                window.location = 'usuarios';
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
                                window.location = 'usuarios';
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
                                window.location = 'usuarios';
                            }
                          });
                              </script>";
                }
            }
        }
        /*
        =====================================
        ELIMINAR USUARIOS
        =====================================
        */

        static public function ctrlEliminarUsuario() {
           if (isset($_GET["idUsuario"])) {
                $tabla = "usuarios";
                $datos = $_GET["idUsuario"];

                if ($_GET["fotoUsuario"] != "") {
                    unlink($_GET["fotoUsuario"]);
                    rmdir("views/img/usuarios/".$_GET["usuario"]);
                }
                $respuesta = ModeloUsuarios::mdlEliminarUsuario($tabla, $datos);

                if ($respuesta == "ok") {
                    echo "<script>
                        Swal.fire({
                            type: 'success',
                            title: 'Usuario eliminado',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            closeOnConfirm: false
                          }).then((result) =>{
                            if(result.value){
                                window.location = 'usuarios';
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
                                window.location = 'usuarios';
                            }
                          });
                              </script>";
                }
           }
        }
    }
?>