  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Administración de ventas
        <small>Panel de control</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="ventas">ventas</a></li>
        <li class="active">Administrar ventas</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <a href="crear-venta"><button class="btn btn-primary">Agregar Venta</button></a>
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
                <th>COD Factura</th>
                <th>Cliente</th>
                <th>Vendedor</th>
                <th>Forma de pago</th>
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
                          <td>'.$value["metodo_pago"].'</td>
                          <td>$'.$value["neto"].'</td>
                          <td>$'.$value["total"].'</td>';
                          if ($value["estado"] == 1) {
                            echo '<td>Activa</td>';
                          }
                          else {
                            echo '<td>Anulada</td>';
                          }
                  echo    '<td>'.$value["fecha_creacion"].'</td>';
                    echo '<td>';
                    echo    '<div class="btn-group">';
                    echo     '<button class="btn btn-primary btn-imprimirDetalle" codVenta="'.$value["codigo"].'"><i class="fa fa-print"></i></button>';
                    echo     '<button class="btn btn-warning btn-editarVenta" idVenta="'.$value["id"].'"><i class="far fa-edit"></i></button>';
                    if ($value["estado"] != 2) {
                      echo '<button class="btn btn-danger btn-anularVenta" idVenta="'.$value["id"].'"><i class="fa fa-times"></i></button>';
                    }
                    else {
                      echo '<button class="btn btn-default"><i class="fa fa-times"></i></button>';
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