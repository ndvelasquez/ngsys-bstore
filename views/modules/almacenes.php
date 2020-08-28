  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Administración de almacenes
        <small>Panel de control</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active">Administrar almacenes</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarAlmacen">Agregar Almacén</button>
        </div>
        <div class="box-body">
          <table class="table table-bordered table-striped dt-responsive tablas">
            <thead>
              <tr>
                <th style="width: 10px">#</th>
                <th>Nombre</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $item = null;
                $valor = null;

                $almacenes = ControladorAlmacenes::ctrlMostrarAlmacen($item, $valor);

                foreach ($almacenes as $key => $value) {
                  echo '<tr>
                          <td>'.$value["id"].'</td>
                          <td>'.$value["nombre"].'</td>
                  ';
                  echo '<td>
                          <div class="btn-group">
                          <button class="btn btn-warning btn-editarAlmacen" idAlmacen="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarAlmacen"><i class="far fa-edit"></i></button>
                          <button class="btn btn-danger btn-eliminarAlmacen" idAlmacen="'.$value["id"].'"><i class="fa fa-times"></i></button>
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

  <!-- Modal de agregar almacen-->
<div id="modalAgregarAlmacen" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <!-- 
        ===========================
          FORMULARIO DE ALMACEN
        ===========================
       -->
      <form role="form" method="post" enctype="multipart/form-data">

        <div class="modal-header" style="background: #17a2b8; color: white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar Nuevo Almacén</h4>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <!-- INPUT DEL NOMBRE -->
            <div class="form-group">
              <div class="input-group">
                <label class="input-group-addon" for="nombre"><i class="fa fa-th"></i></label>
                <input type="text" id="nombre" name="nombre" class="form-control" value="" placeholder="Nombre del almacen" data-toggle="tooltip" title="campo obligatorio" required pattern="[a-zA-ZñÑ ]+">
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar Almacén</button>
        </div>
        <?php
          $crearAlmacen = new ControladorAlmacenes;
          $crearAlmacen -> ctrlCrearAlmacen();
        ?>
      </form>
    </div>

  </div>
</div>
<!-- /Modal -->

  <!-- Modal de editar almacen-->
  <div id="modalEditarAlmacen" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <!-- 
        ===========================
          FORMULARIO DE ALMACEN
        ===========================
       -->
      <form role="form" method="post" enctype="multipart/form-data">

        <div class="modal-header" style="background: #17a2b8; color: white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar Almacén</h4>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <!-- ID DE ALMACEN -->
            <input type="hidden" id="idAlmacen" name="idAlmacen" value="">
            <!-- INPUT DEL NOMBRE -->
            <div class="form-group">
              <div class="input-group">
                <label class="input-group-addon" for="editarNombre"><i class="fa fa-th"></i></label>
                <input type="text" id="editarNombre" name="editarNombre" class="form-control" value="" placeholder="Nombre" data-toggle="tooltip" title="campo obligatorio" required pattern="[a-zA-ZñÑ ]+">
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>
        <?php
          $editarAlmacen = new ControladorAlmacenes;
          $editarAlmacen -> ctrlEditarAlmacen();
        ?>
      </form>
    </div>

  </div>
</div>
<?php
      $eliminarAlmacen = new ControladorAlmacenes;
      $eliminarAlmacen -> ctrlEliminarAlmacen();
  ?>
<!-- /Modal -->