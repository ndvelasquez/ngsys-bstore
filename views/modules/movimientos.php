  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Movimientos de productos
        <small>Panel de control</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="#"><i class="ion ion-clipboard"></i> Inventario</a></li>
        <li class="active">Ver movimientos</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          
        </div>
        <div class="box-body">
          <table class="table table-bordered table-striped dt-responsive tablas">
            <thead>
              <tr>
                <th style="width: 10px">#</th>
                <th>Producto</th>
                <th>Tipo de movimiento</th>
                <th>Cantidad</th>
                <th>Fecha</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $item = null;
                $valor = null;

                $movimientos = ControladorInventario::ctrlMostrarMovimientos($item, $valor);

                foreach ($movimientos as $key => $value) {
                  echo '<tr>
                          <td>'.$value["id"].'</td>
                          <td>'.$value["producto"].'</td>
                          <td>'.$value["tipo_movimiento"].'</td>
                          <td>'.$value["cantidad"].'</td>
                          <td>'.$value["fecha"].'</td>
                  ';
                //   echo '<td>
                //           <div class="btn-group">
                //           <button class="btn btn-warning btn-editarCategoria" idCategoria="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarCategoria"><i class="fa fa-pencil"></i></button>
                //           <button class="btn btn-danger btn-eliminarCategoria" idCategoria="'.$value["id"].'"><i class="fa fa-times"></i></button>
                //           </div>
                //         </td>
                //     </tr>';
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
