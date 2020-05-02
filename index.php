<?php

require_once "controllers/plantilla.controlador.php";
require_once "controllers/usuarios.controlador.php";
require_once "controllers/clientes.controlador.php";
require_once "controllers/ventas.controlador.php";
require_once "controllers/productos.controlador.php";
require_once "controllers/categorias.controlador.php";
require_once "controllers/cotizaciones.controlador.php";
require_once "controllers/inventario.controlador.php";

require_once "models/usuarios.modelo.php";
require_once "models/clientes.modelo.php";
require_once "models/ventas.modelo.php";
require_once "models/productos.modelo.php";
require_once "models/categorias.modelo.php";
require_once "models/detalle-venta.modelo.php";
require_once "models/cotizaciones.modelo.php";
require_once "models/inventario.modelo.php";
require_once "models/auditoria.modelo.php";

$plantilla = new ControladorPlantilla();
$plantilla -> ctrlPlantilla();