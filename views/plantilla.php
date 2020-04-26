<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>NG SYS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Icono -->
  <link rel="icon" href="views/img/plantilla/logo.png">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="views/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="views/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="views/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="views/dist/css/AdminLTE.css">
  <!-- AdminLTE Skins -->
  <link rel="stylesheet" href="views/dist/css/skins/_all-skins.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="views/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="views/bower_components/datatables.net-bs/css/responsive.bootstrap.min.css">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="views/plugins/iCheck/all.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="views/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="views/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- Morris js -->
  <link rel="stylesheet" href="views/bower_components/morris.js/morris.css">
  <!-- 
========================
SCRIPTS
========================
 -->
<!-- jQuery 3 -->
<script src="views/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="views/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="views/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- DataTables -->
<script src="views/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="views/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="views/bower_components/datatables.net-bs/js/dataTables.responsive.min.js"></script>
<script src="views/bower_components/datatables.net-bs/js/responsive.bootstrap.min.js"></script>
<!-- FastClick -->
<script src="views/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="views/dist/js/adminlte.min.js"></script>
<!-- Sweet Alert 2 -->
<script src="views/plugins/sweetalert/sweetalert2.all.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="views/plugins/iCheck/icheck.min.js"></script>
<!-- bootstrap datepicker -->
<script src="views/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- InputMask -->
<script src="views/plugins/input-mask/jquery.inputmask.js"></script>
<script src="views/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="views/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- Jquery number -->
<script src="views/plugins/jquery-number/jquery.number.js"></script>
<!-- date-range-picker -->
<script src="views/bower_components/moment/min/moment.min.js"></script>
<script src="views/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- Morris js -->
<script src="views/bower_components/raphael/raphael.min.js"></script>
<script src="views/bower_components/morris.js/morris.min.js"></script>
<!-- ChartJS -->
<script src="views/bower_components/chart.js/Chart.js"></script>

</head>
<body class="hold-transition skin-blue sidebar-collapse sidebar-mini login-page">

  <?php
  if (isset($_SESSION["validaLogin"]) && $_SESSION["validaLogin"] == "validado") {
    echo '<div class="wrapper">';
      include "modules/header.php";
      include "modules/menu.php";
  
      if(isset($_GET["ruta"])) {
        if ($_GET["ruta"] == "inicio"
            || $_GET["ruta"] == "usuarios"
            || $_GET["ruta"] == "productos"
            || $_GET["ruta"] == "categorias"
            || $_GET["ruta"] == "clientes"
            || $_GET["ruta"] == "ventas"
            || $_GET["ruta"] == "cotizaciones"
            || $_GET["ruta"] == "crear-venta"
            || $_GET["ruta"] == "crear-cotizacion"
            || $_GET["ruta"] == "editar-venta"
            || $_GET["ruta"] == "editar-cotizacion"
            || $_GET["ruta"] == "reporte-ventas"
            || $_GET["ruta"] == "salir") {
          include "modules/".$_GET["ruta"].".php";
        }
        else {
          include "modules/404.php";
        }
      }
      else {
        include "modules/inicio.php";
      }
  
      include "modules/footer.php";
    echo '</div>';
  }
  else {
    include "modules/login.php";
  }
  ?>
  <!-- Main js -->
<script src="views/js/main.js"></script>
</body>
</html>