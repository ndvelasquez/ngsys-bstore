  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Administración de categorías
        <small>Panel de control</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active">Administrar categorías</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarCategoria">Agregar Categoría</button>
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

                $categorias = ControladorCategorias::ctrlMostrarCategorias($item, $valor);

                foreach ($categorias as $key => $value) {
                  echo '<tr>
                          <td>'.$value["id"].'</td>
                          <td>'.$value["nombre"].'</td>
                  ';
                  echo '<td>
                          <div class="btn-group">
                          <button class="btn btn-warning btn-editarCategoria" idCategoria="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarCategoria"><i class="fa fa-pencil"></i></button>
                          <button class="btn btn-danger btn-eliminarCategoria" idCategoria="'.$value["id"].'"><i class="fa fa-times"></i></button>
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

  <!-- Modal de agregar categoria-->
<div id="modalAgregarCategoria" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <!-- 
        ===========================
          FORMULARIO DE CATEGORIA
        ===========================
       -->
      <form role="form" method="post" enctype="multipart/form-data">

        <div class="modal-header" style="background: #17a2b8; color: white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar Nueva categoría</h4>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <!-- INPUT DEL NOMBRE -->
            <div class="form-group">
              <div class="input-group">
                <label class="input-group-addon" for="nombre"><i class="fa fa-th"></i></label>
                <input type="text" id="nombre" name="nombre" class="form-control" value="" placeholder="Nombre de la categoria" data-toggle="tooltip" title="campo obligatorio" required pattern="[a-zA-ZñÑ ]+">
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar Categoría</button>
        </div>
        <?php
          $crearCategoria = new ControladorCategorias;
          $crearCategoria -> ctrlCrearCategoria();
        ?>
      </form>
    </div>

  </div>
</div>
<!-- /Modal -->

  <!-- Modal de editar categoria-->
  <div id="modalEditarCategoria" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <!-- 
        ===========================
          FORMULARIO DE CATEGORIA
        ===========================
       -->
      <form role="form" method="post" enctype="multipart/form-data">

        <div class="modal-header" style="background: #17a2b8; color: white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar Categoría</h4>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <!-- ID DE CATEGORIA -->
            <input type="hidden" id="idCategoria" name="idCategoria" value="">
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
          $editarCategoria = new ControladorCategorias;
          $editarCategoria -> ctrlEditarCategoria();
        ?>
      </form>
    </div>

  </div>
</div>
<?php
      $eliminarCategoria = new ControladorCategorias;
      $eliminarCategoria -> ctrlEliminarCategoria();
  ?>
<!-- /Modal -->