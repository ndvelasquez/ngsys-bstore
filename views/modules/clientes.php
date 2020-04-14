  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Administración de clientes
        <small>Panel de control</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="#"></a></li>
        <li class="active">Administrar clientes</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarCliente">Agregar Cliente</button>
        </div>
        <div class="box-body">
          <table class="table table-bordered table-striped dt-responsive tablas">
            <thead>
              <tr>
                <th style="width: 10px">#</th>
                <th>Nombre</th>
                <th>Tipo de documento</th>
                <th>N° de documento</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Agregado</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $item = null;
                $valor = null;

                $clientes = ControladorClientes::ctrlMostrarClientes($item, $valor);

                foreach ($clientes as $key => $value) {
                  echo '<tr>
                          <td>'.$value["id"].'</td>
                          <td>'.$value["nombre"].'</td>
                          <td>'.$value["tipo_documento"].'</td>
                          <td>'.$value["documento"].'</td>
                          <td>'.$value["email"].'</td>
                          <td>'.$value["telefono"].'</td>
                          <td>'.$value["direccion"].'</td>
                          <td>'.$value["fecha_creacion"].'</td>
                  ';
                  echo '<td>
                          <div class="btn-group">
                          <button class="btn btn-warning btn-editarCliente" idCliente="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarCliente"><i class="fa fa-pencil"></i></button>
                          <button class="btn btn-danger btn-eliminarCliente" idCliente="'.$value["id"].'"><i class="fa fa-times"></i></button>
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

  <!-- Modal de agregar Cliente-->
<div id="modalAgregarCliente" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <!-- 
        ===========================
          FORMULARIO DE CLIENTE
        ===========================
       -->
      <form role="form" method="post">

        <div class="modal-header" style="background: #17a2b8; color: white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar Nuevo cliente</h4>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <!-- INPUT DEL TIPO DE DOCUMENTO -->
            <div class="form-group">
              <div class="input-group">
                <label class="input-group-addon" for="tipoDocumento"><i class="fa fa-id-badge"></i></label>
                <select id="tipoDocumento" name="tipoDocumento" class="form-control" data-toggle="tooltip" title="campo obligatorio" required>
                  <option value="">Seleccione un tipo de documento</option>
                  <option value="dni">DNI</option>
                  <option value="carnet de extranjeria">Carnet de extranjería</option>
                  <option value="ruc">RUC</option>
                  <option value="pasaporte">Pasaporte</option>
                </select>
              </div>
            </div>
            <!-- INPUT DEL NUMERO DE DOCUMENTO -->
            <div class="form-group">
              <div class="input-group">
                <label class="input-group-addon" for="documento"><i class="fa fa-id-card"></i></label>
                <input type="number" id="documento" name="documento" class="form-control" value="" placeholder="N° de documento" data-toggle="tooltip" title="campo obligatorio" required min="0" minlength="7" pattern="[0-9]+">
              </div>
            </div>
            <!-- INPUT DEL NOMBRE -->
            <div class="form-group">
              <div class="input-group">
                <label class="input-group-addon" for="nombre"><i class="fa fa-font"></i></label>
                <input type="text" id="nombre" name="nombre" class="form-control" value="" placeholder="Nombre del Cliente" data-toggle="tooltip" title="campo obligatorio" required pattern="[a-zA-ZñÑ ]+">
              </div>
            </div>
            <!-- INPUT DEL EMAIL -->
            <div class="form-group">
              <div class="input-group">
                <label class="input-group-addon" for="email"><i class="fa fa-envelope"></i></label>
                <input type="email" id="email" name="email" class="form-control" value="" placeholder="Email del Cliente" data-toggle="tooltip" title="campo obligatorio" required>
              </div>
            </div>
            <!-- INPUT DEL TELEFONO -->
            <div class="form-group">
              <div class="input-group">
                <label class="input-group-addon" for="telefono"><i class="fa fa-phone"></i></label>
                <input type="text" id="telefono" name="telefono" class="form-control" value="" placeholder="Télefono del Cliente" data-toggle="tooltip" title="campo obligatorio" data-inputmask='"mask": "(99) 999-999-999"' data-mask required>
              </div>
            </div>
            <!-- INPUT DE FECHA DE NACIMIENTO -->
            <div class="form-group">
              <div class="input-group">
                <label class="input-group-addon" for="fechaNacimiento"><i class="fa fa-calendar"></i></label>
                <input type="text" id="fechaNacimiento" name="fechaNacimiento" class="form-control" value="" placeholder="Fecha de nacimiento" data-toggle="tooltip" title="campo obligatorio" required>
              </div>
            </div>
            <!-- INPUT DE DIRECCION -->
            <div class="form-group">
              <div class="input-group">
                <label class="input-group-addon" for="direcicon"><i class="fa fa-map-marker"></i></label>
                <textarea name="direccion" class="form-control" placeholder="Dirección del cliente" data-toggle="tooltip" title="campo obligatorio" id="direccion" cols="5" rows="3" required></textarea>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar Cliente</button>
        </div>
        <?php
          $crearCliente = new ControladorClientes;
          $crearCliente -> ctrlCrearCliente();
        ?>
      </form>
    </div>

  </div>
</div>
<!-- /Modal -->

  <!-- Modal de editar Cliente-->
  <div id="modalEditarCliente" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <!-- 
        ===========================
          FORMULARIO DE CLIENTE
        ===========================
       -->
      <form role="form" method="post" enctype="multipart/form-data">

        <div class="modal-header" style="background: #17a2b8; color: white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar Cliente</h4>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <!-- ID DE Cliente -->
            <input type="hidden" id="idCliente" name="idCliente" value="">
            <!-- INPUT DEL TIPO DE DOCUMENTO -->
            <div class="form-group">
              <div class="input-group">
                <label class="input-group-addon" for="editarTipoDocumento"><i class="fa fa-users"></i></label>
                <select name="editarTipoDocumento" class="form-control" data-toggle="tooltip" title="campo obligatorio" required>
                  <option value="" id="editarTipoDocumento"></option>
                  <option value="dni">DNI</option>
                  <option value="carnet de extranjeria">Carnet de extranjería</option>
                  <option value="ruc">RUC</option>
                  <option value="pasaporte">Pasaporte</option>
                </select>
              </div>
            </div>
            <!-- INPUT DEL NUMERO DE DOCUMENTO -->
            <div class="form-group">
              <div class="input-group">
                <label class="input-group-addon" for="editarDocumento"><i class="fa fa-id-card"></i></label>
                <input type="number" id="editarDocumento" name="editarDocumento" class="form-control" value="" placeholder="N° de documento" data-toggle="tooltip" title="campo obligatorio" required min="0" minlength="7" pattern="[0-9]+">
              </div>
            </div>
            <!-- INPUT DEL NOMBRE -->
            <div class="form-group">
              <div class="input-group">
                <label class="input-group-addon" for="editarNombre"><i class="fa fa-font"></i></label>
                <input type="text" id="editarNombre" name="editarNombre" class="form-control" value="" placeholder="Nombre del Cliente" data-toggle="tooltip" title="campo obligatorio" required pattern="[a-zA-ZñÑ ]+">
              </div>
            </div>
            <!-- INPUT DEL EMAIL -->
            <div class="form-group">
              <div class="input-group">
                <label class="input-group-addon" for="editarEmail"><i class="fa fa-envelope"></i></label>
                <input type="email" id="editarEmail" name="editarEmail" class="form-control" value="" placeholder="Email del Cliente" data-toggle="tooltip" title="campo obligatorio" required>
              </div>
            </div>
            <!-- INPUT DEL TELEFONO -->
            <div class="form-group">
              <div class="input-group">
                <label class="input-group-addon" for="editarTelefono"><i class="fa fa-phone"></i></label>
                <input type="text" id="editarTelefono" name="editarTelefono" class="form-control" value="" placeholder="Télefono del Cliente" data-toggle="tooltip" title="campo obligatorio" data-inputmask='"mask": "(99) 999-999-999"' data-mask required>
              </div>
            </div>
            <!-- INPUT DE FECHA DE NACIMIENTO -->
            <div class="form-group">
              <div class="input-group">
                <label class="input-group-addon" for="editarFechaNacimiento"><i class="fa fa-calendar"></i></label>
                <input type="text" id="editarFechaNacimiento" name="editarFechaNacimiento" class="form-control" value="" placeholder="Fecha de nacimiento" data-toggle="tooltip" title="campo obligatorio" required>
              </div>
            </div>
            <!-- INPUT DE DIRECCION -->
            <div class="form-group">
              <div class="input-group">
                <label class="input-group-addon" for="editarDirecicon"><i class="fa fa-map-marker"></i></label>
                <textarea name="editarDireccion" id="editarDireccion" class="form-control" placeholder="Dirección del cliente" data-toggle="tooltip" title="campo obligatorio" cols="5" rows="3" required></textarea>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>
        <?php
          $editarCliente = new ControladorClientes;
          $editarCliente -> ctrlEditarCliente();
        ?>
      </form>
    </div>

  </div>
</div>
<?php
      $eliminarCliente = new ControladorClientes;
      $eliminarCliente -> ctrlEliminarCliente();
  ?>
<!-- /Modal -->