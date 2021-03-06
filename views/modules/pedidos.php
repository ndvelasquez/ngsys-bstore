  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Administración de pedidos
        <small>Panel de control</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="pedidos">pedidos</a></li>
        <li class="active">Administrar pedidos</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <a href="crear-pedido"><button class="btn btn-primary">Agregar Pedido</button></a>
          <button type="button" class="btn btn-default pull-right" id="daterange-btn">
            <span>
              <i class="far fa-calendar-alt"></i> Rango de fecha
            </span>
              <i class="fa fa-caret-down"></i>
          </button>
        </div>
        <div class="box-body">
          <table class="table table-bordered table-striped dt-responsive tablas">
            <thead>
              <tr>
                <th style="width: 10px">#</th>
                <th>Recibo</th>
                <th>Cliente</th>
                <th>Vendedor</th>
                <th>Neto</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if (isset($_GET["fechaInicial"])) {
                $fechaInicial = $_GET["fechaInicial"];
                $fechaFinal = $_GET["fechaFinal"];
              }
              else {
                $fechaInicial = null;
                $fechaFinal = null;
              }

                $ventas = ControladorVentas::ctrlRangoFechasVenta($fechaInicial, $fechaFinal);

                foreach ($ventas as $key => $value) {
                  echo '<tr>
                          <td>'.$value["id"].'</td>
                          <td>'.$value["codigo"].'</td>
                          <td>'.$value["cliente"].'</td>
                          <td>'.$value["vendedor"].'</td>
                          <td>S/'.$value["neto"].'</td>
                          <td>S/'.$value["total"].'</td>';
                          if ($value["estado"] == 3) {
                            echo '<td><span class="bg-yellow">Pendiente de envío</span></td>';
                          }
                          else if ($value["estado"] == 4) {
                            echo '<td><span class="bg-blue">En proceso de envío</span></td>';
                          }
                          else if ($value["estado"] == 1) {
                            echo '<td><span class="bg-green">Enviado</span></td>';
                          }
                          else {
                            echo '<td><span class="bg-red">Anulado</span></td>';
                          }
                  echo    '<td>'.$value["fecha_creacion"].'</td>';
                    echo '<td>';
                    echo    '<div class="btn-group">';
                    if ($_SESSION["perfil"] == "Administrador") {
                      echo     '<button class="btn btn-primary btn-imprimirDetalle" codVenta="'.$value["codigo"].'"><i class="fa fa-print"></i></button>';
                    }
                    else {
                      echo     '<button class="btn btn-primary btn-imprimirDetalleVendedor" codVenta="'.$value["codigo"].'"><i class="fa fa-print"></i></button>';
                    }
                    if ($_SESSION["perfil"] == "Administrador") {
                      if ($value["estado"] != 2) {

                        echo     '<button class="btn btn-warning btn-editarVenta" idVenta="'.$value["id"].'"><i class="far fa-edit"></i></button>';
                      }
                    }
                    if ($_SESSION["perfil"] == "Administrador") {
                      if ($value["estado"] != 2) {
                        echo '<button class="btn btn-danger btn-anularVenta" idVenta="'.$value["id"].'"><i class="fa fa-times"></i></button>';
                      }
                    }
                    echo    '</div>';
                    echo '</td>';
                  echo '</tr>';
                }
              ?>
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php
    $anularVenta = new ControladorVentas;
    $anularVenta -> ctrlAnularVenta();
  ?>