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
                // $item = null;
                // $valor = null;

                // $clientes = ControladorClientes::ctrlMostrarClientes($item, $valor);

                // foreach ($clientes as $key => $value) {
                //   echo '<tr>
                //           <td>'.$value["id"].'</td>
                //           <td>'.$value["nombre"].'</td>
                //           <td>'.$value["tipo_documento"].'</td>
                //           <td>'.$value["documento"].'</td>
                //           <td>'.$value["email"].'</td>
                //           <td>'.$value["telefono"].'</td>
                //           <td>'.$value["direccion"].'</td>
                //           <td>'.$value["fecha_creacion"].'</td>
                //   ';
                //   echo '<td>
                //           <div class="btn-group">
                //           <button class="btn btn-warning btn-editarCliente" idCliente="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarCliente"><i class="fa fa-pencil"></i></button>
                //           <button class="btn btn-danger btn-eliminarCliente" idCliente="'.$value["id"].'"><i class="fa fa-times"></i></button>
                //           </div>
                //         </td>
                //     </tr>';
                // }
              ?>
              <td>1</td>
              <td>1001</td>
              <td>Pepito Perez</td>
              <td>Nestor Velasquez</td>
              <td>Efectivo</td>
              <td>$ 500.00</td>
              <td>$ 590.00</td>
              <td>2020-04-10</td>
              <td>
                <div class="btn-group">
                  <button class="btn btn-info btn-imprimir"><i class="fa fa-print"></i></button>
                  <button class="btn btn-danger btn-anularVenta"><i class="fa fa-times"></i></button>
                </div>
              </td>
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