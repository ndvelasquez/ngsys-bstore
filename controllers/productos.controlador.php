<?php
    class ControladorProductos {
        /*
        =====================================
        MOSTRAR PRODUCTOS
        =====================================
        */

        static public function ctrlMostrarProductos($item, $valor) {
            $tabla = "productos";
            $respuesta = ModeloProductos::mdlMostrarProducto($tabla, $item, $valor);

            return $respuesta;
        }

        /*
        =====================================
        GUARDAR PRODUCTO
        =====================================
        */

        static public function ctrlCrearProducto() {

            if (isset($_POST["codProducto"])
               && isset($_POST["descripcion"])
               && isset($_POST["categoria"])
               && isset($_POST["almacen"])
               && isset($_POST["precioCompra"])
               && isset($_POST["precioVenta"])) {

                   if (preg_match('/[0-9]+/', $_POST["codProducto"])
                  && preg_match('/[0-9.]+/', $_POST["precioCompra"])
                  && preg_match('/[0-9.]+/', $_POST["precioVenta"])) {

                    $ruta = "";
                    /*
                    =======================================
                    VALIDAR IMAGEN DEL PRODUCTO
                    =======================================
                    */
                    if(isset($_FILES["imagenProducto"]["tmp_name"])) {
                        
                        // creo un array para obtener las dimensiones de la foto de origen 
                        list($ancho, $alto) = getimagesize($_FILES["imagenProducto"]["tmp_name"]);

                        // tamaño al que quiero redimensionar en pixeles
                        $nuevoAncho = 500;
                        $nuevoAlto = 500;

                        /*
                        =============================================
                        CREO DIRECTORIO DONDE SE GUARDARAN LAS FOTOS
                        =============================================
                        */
                        $directorio = "views/img/productos/".$_POST["codProducto"];
                        mkdir($directorio, 0755); //0755 es el codigo de lectura y escritura

                        
                        /*
                        =============================================
                        SUBO LA FOTO DE ACUERDO AL TIPO DE IMAGEN
                        =============================================
                        */

                        if ($_FILES["imagenProducto"]["type"] == "image/jpeg" || $_FILES["imagenProducto"]["type"] == "image/jpg") {
                            /*
                            =============================================
                            PROCESO DE GUARDADO
                            =============================================
                            */
                            $aleatorio = mt_rand(100, 999);

                            $ruta = "views/img/productos/".$_POST["codProducto"]."/".$aleatorio.".jpg";
                            $origen = imagecreatefromjpeg($_FILES["imagenProducto"]["tmp_name"]);
                            $destino = imagecreatetruecolor($nuevoAncho,$nuevoAncho);
                            imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $alto, $ancho);
                            imagejpeg($destino, $ruta);
                        }

                        if ($_FILES["imagenProducto"]["type"] == "image/png") {
                            /*
                            =============================================
                            PROCESO DE GUARDADO
                            =============================================
                            */
                            $aleatorio = mt_rand(100, 999);

                            $ruta = "views/img/productos/".$_POST["codProducto"]."/".$aleatorio.".png";
                            $origen = imagecreatefrompng($_FILES["imagenProducto"]["tmp_name"]);
                            $destino = imagecreatetruecolor($nuevoAncho,$nuevoAncho);
                            imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $alto, $ancho);
                            imagepng($destino, $ruta);
                        }
                    }
                    
                    $tabla = "productos";
                    $datos = array(
                            "codigo" => $_POST["codProducto"],
                            "descripcion" => $_POST["descripcion"],
                            "categoria" => $_POST["categoria"],
                            "almacen" => $_POST["almacen"],
                            "stock" => $_POST["cantidad"],
                            "precioCompra" => $_POST["precioCompra"],
                            "precioVenta" => $_POST["precioVenta"],
                            "imagen" => $ruta
                    );
                    $respuesta = ModeloProductos::mdlCrearProducto($tabla,$datos);
                    /*======================================================
                    ASIGNA UN ALMACEN AL PRODUCTO
                    ========================================================*/
                    $itemProducto = "codigo";
                    $traerProducto = ModeloProductos::mdlTraerSoloProducto($tabla,$itemProducto,$datos["codigo"]);
                    if($traerProducto) {
                        $tablaProductoAlmacen = "productos_almacen";
                        $datosProductoAlmacen = array("id_producto" => $traerProducto["id"], "id_almacen" => $_POST["almacen"]);
                        $respuestaProductoAlmacen = ModeloProductoAlmacen::mdlCrearProductoAlmacen($tablaProductoAlmacen, $datosProductoAlmacen);
                    }

                    /*======================================================
                    INSERTA EL LOG DE AUDITORIA
                    ========================================================*/
                    $datosAuditoria = array(
                        "usuario" => $_SESSION["usuario"],
                        "accion" => "INSERTAR",
                        "tabla" => $tabla
                    );
                    $respuestoaAuditoria = ModeloAuditoria::mdlInsertaLog($datosAuditoria);
                    if ($respuestaProductoAlmacen == "ok") {
                        echo "<script>
                        Swal.fire({
                            type: 'success',
                            title: 'Producto creado',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            closeOnConfirm: false
                          }).then((result) =>{
                            if(result.value){
                                window.location = 'productos';
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
                                window.location = 'productos';
                            }
                          });
                              </script>";
                    }
                }
            }
        }

        /*
        ================================
        EDITAR PRODUCTO
        ================================
        */
        static public function ctrleditarProducto() {
            if (isset($_POST["idProducto"])) {

                if (preg_match('/[a-zA-ZñÑ]\w+/', $_POST["editarDescripcion"])) {
                    
                    $ruta = $_POST["imagenActual"];

                    /*
                    =======================================
                    VALIDAR FOTO DEL PRODUCTO
                    =======================================
                    */
                    if(isset($_FILES["editarImagen"]["tmp_name"]) && !empty($_FILES["editarImagen"]["tmp_name"])) {
                        
                        // creo un array para obtener las dimensiones de la foto de origen 
                        list($ancho, $alto) = getimagesize($_FILES["editarImagen"]["tmp_name"]);

                        // tamaño al que quiero redimensionar en pixeles
                        $nuevoAncho = 500;
                        $nuevoAlto = 500;

                        /*
                        =============================================
                        CREO DIRECTORIO DONDE SE GUARDARAN LAS FOTOS
                        =============================================
                        */
                        $directorio = "views/img/productos/".$_POST["editarCodProducto"];

                        /* 
                        =============================================
                        VERIFICO QUE EXISTA EL DIRECTORIO DEL USUARIO
                        =============================================
                        */
                        if (!empty($_POST["imagenActual"])) {
                            unlink($_POST["imagenActual"]);
                        }
                        else {
                            mkdir($directorio, 0755); //0755 es el codigo de lectura y escritura
                        }

                        
                        /*
                        =============================================
                        SUBO LA FOTO DE ACUERDO AL TIPO DE IMAGEN
                        =============================================
                        */

                        if ($_FILES["editarImagen"]["type"] == "image/jpeg") {
                            /*
                            =============================================
                            PROCESO DE GUARDADO
                            =============================================
                            */
                            $aleatorio = mt_rand(100, 999);

                            $ruta = "views/img/productos/".$_POST["editarCodProducto"]."/".$aleatorio.".jpg";
                            $origen = imagecreatefromjpeg($_FILES["editarImagen"]["tmp_name"]);
                            $destino = imagecreatetruecolor($nuevoAncho,$nuevoAncho);
                            imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $alto, $ancho);
                            imagejpeg($destino, $ruta);
                        }

                        if ($_FILES["editarImagen"]["type"] == "image/png") {
                            /*
                            =============================================
                            PROCESO DE GUARDADO
                            =============================================
                            */
                            $aleatorio = mt_rand(100, 999);

                            $ruta = "views/img/productos/".$_POST["editarCodProducto"]."/".$aleatorio.".png";
                            $origen = imagecreatefrompng($_FILES["editarImagen"]["tmp_name"]);
                            $destino = imagecreatetruecolor($nuevoAncho,$nuevoAncho);
                            imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $alto, $ancho);
                            imagepng($destino, $ruta);
                        }
                    }
                    
                    
                    $tabla = "productos";
                    $datos = array(
                            "id" => $_POST["idProducto"],
                            "codigo" => $_POST["editarCodProducto"],
                            "descripcion" => $_POST["editarDescripcion"],
                            "cantidad" => $_POST["editarCantidad"],
                            "categoria" => $_POST["editarCategoria"],
                            "almacen" => $_POST["editarAlmacen"],
                            "precioCompra" => $_POST["editarPrecioCompra"],
                            "precioVenta" => $_POST["editarPrecioVenta"],
                            "imagen" => $ruta
                    );
                    $respuesta = Modeloproductos::mdleditarProducto($tabla,$datos);
                    /*======================================================
                    ACTUALIZA LA UBICACION (ALMACEN) DEL PRODUCTO
                    ========================================================*/
                    $tablaProductoAlmacen = "productos_almacen";
                    $actualizaProductoAlmacen = ModeloProductoAlmacen::mdlEditarAlmacen($tablaProductoAlmacen, $datos);
                    /*======================================================
                    INSERTA EL LOG DE AUDITORIA
                    ========================================================*/
                    $datosAuditoria = array(
                        "usuario" => $_SESSION["usuario"],
                        "accion" => "MODIFICAR",
                        "tabla" => $tabla
                    );
                    $respuestoaAuditoria = ModeloAuditoria::mdlInsertaLog($datosAuditoria);
                    if ($actualizaProductoAlmacen == "ok") {
                        echo "<script>
                        Swal.fire({
                            type: 'success',
                            title: 'producto editado',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            closeOnConfirm: false
                          }).then((result) =>{
                            if(result.value){
                                window.location = 'productos';
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
                                window.location = 'productos';
                            }
                          });
                              </script>";
                    }
                }
                else {
                    echo "<script>
                        Swal.fire({
                            title: 'Error!',
                            text: 'La descripción no puede ir vacía',
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            closeOnConfirm: false
                          }).then((result) =>{
                            if(result.value){
                                window.location = 'productos';
                            }
                          });
                              </script>";
                }
            }
        }
        /*
        =====================================
        ELIMINAR PRODUCTOS
        =====================================
        */

        static public function ctrlEliminarProducto() {
           if (isset($_GET["idProducto"])) {
                $tabla = "productos";
                $datos = $_GET["idProducto"];

                if ($_GET["imagenProducto"] != "") {
                    unlink($_GET["imagenProducto"]);
                    rmdir("views/img/productos/".$_GET["codProducto"]);
                }
                $respuesta = Modeloproductos::mdlEliminarProducto($tabla, $datos);
                 /*======================================================
                    ELIMINA EL PRODUCTO DEL ALMACEN
                    ========================================================*/
                    $tablaProductoAlmacen = "productos_almacen";
                    $actualizaProductoAlmacen = ModeloProductoAlmacen::mdlEditarAlmacen($tablaProductoAlmacen, $datos);
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
                            title: 'Producto eliminado',
                            icon: 'success',
                            confirmButtonText: 'Cerrar',
                            closeOnConfirm: false
                          }).then((result) =>{
                            if(result.value){
                                window.location = 'productos';
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
                                window.location = 'productos';
                            }
                          });
                              </script>";
                }
           }
        }

        /*
        =====================================
        MOSTRAR PRODUCTOS MAS VENDIDOS
        =====================================
        */
        static public function ctrlMasVendidos($tabla) {
            $respuesta = ModeloProductos::mdlMasVendidos($tabla);
            return $respuesta;
        }
    }
?>