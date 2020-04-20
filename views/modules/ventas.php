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
        <li><a href="#"></a></li>
        <li class="active">Administrar ventas</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <a href="crear-venta"><button class="btn btn-primary">Agregar Venta</button></a>
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
                <th>Fecha</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $item = null;
                $valor = null;

                $ventas = ControladorVentas::ctrlMostrarVentas($item, $valor);

                foreach ($ventas as $key => $value) {
                  echo '<tr>
                          <td>'.$value["id"].'</td>
                          <td>'.$value["codigo"].'</td>
                          <td>'.$value["cliente"].'</td>
                          <td>'.$value["vendedor"].'</td>
                          <td>'.$value["metodo_pago"].'</td>
                          <td>$'.$value["neto"].'</td>
                          <td>$'.$value["total"].'</td>
                          <td>'.$value["fecha_creacion"].'</td>
                  ';
                  echo '<td>
                          <div class="btn-group">
                          <button class="btn btn-primary btn-imprimirDetalle" idVenta="'.$value["id"].'"><i class="fa fa-print"></i></button>
                          <button class="btn btn-danger btn-eliminarVenta" idVenta="'.$value["id"].'"><i class="fa fa-times"></i></button>
                          </div>
                        </td>
                    </tr>';
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