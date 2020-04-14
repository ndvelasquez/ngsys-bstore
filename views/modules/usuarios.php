  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Administración de usuarios
        <small>Panel de control</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="inicio"></a></li>
        <li class="active">Administrar usuarios</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarUsuario">Agregar Usuario</button>
        </div>
        <div class="box-body">
          <table class="table table-bordered table-striped dt-responsive tablas">
            <thead>
              <tr>
                <th style="width: 10px">#</th>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Foto</th>
                <th>Perfil</th>
                <th>Estado</th>
                <th>Último Login</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $item = null;
                $valor = null;

                $usuarios = ControladorUsuarios::ctrlMostrarUsuarios($item, $valor);

                foreach ($usuarios as $key => $value) {
                  echo '<tr>
                          <td>'.$value["id"].'</td>
                          <td>'.$value["nombre"].'</td>
                          <td>'.$value["usuario"].'</td>
                  ';
                  if ($value["foto"] != "") {
                    echo '<td><img src="'.$value["foto"].'" width="50px" alt="foto-usuario"></td>';
                  }
                  else {
                    echo '<td><img src="views/img/usuarios/default/anonymous.png" alt="foto-usuario"></td>';
                  }
                  echo '<td>'.$value["perfil"].'</td>';
                  if ($value["estado"] == 1) {
                    echo '<td><button class="btn btn-success btn-xs btnActivar" idUsuario="'.$value["id"].'" estadoUsuario="0">Atcivado</button></td>';
                  }
                  else {
                    echo '<td><button class="btn btn-danger btn-xs btnActivar" idUsuario="'.$value["id"].'" estadoUsuario="1">Desactivado</button></td>';
                  }
                  echo '<td>'.$value["ultimo_login"].'</td>';
                  echo '<td>
                          <div class="btn-group">
                          <button class="btn btn-warning btn-editarUsuario" idUsuario="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarUsuario"><i class="fa fa-pencil"></i></button>
                          <button class="btn btn-danger btn-eliminarUsuario" idUsuario="'.$value["id"].'" fotoUsuario="'.$value["foto"].'" usuario="'.$value["usuario"].'"><i class="fa fa-times"></i></button>
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

  <!-- Modal de agregar Usuario-->
<div id="modalAgregarUsuario" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <!-- 
        ===========================
          FORMULARIO DE USUARIO
        ===========================
       -->
      <form role="form" method="post" enctype="multipart/form-data">

        <div class="modal-header" style="background: #17a2b8; color: white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar Nuevo Usuario</h4>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <!-- INPUT DEL NOMBRE -->
            <div class="form-group">
              <div class="input-group">
                <label class="input-group-addon" for="nombreUsuario"><i class="fa fa-user"></i></label>
                <input type="text" name="nombreUsuario" class="form-control" value="" placeholder="Nombre" data-toggle="tooltip" title="campo obligatorio" required pattern="[a-zA-ZñÑ ]+">
              </div>
            </div>
            <!-- INPUT DEL USUARIO -->
            <div class="form-group">
              <div class="input-group">
                <label class="input-group-addon" for="usuario"><i class="fa fa-key"></i></label>
                <input type="text" name="usuario" id="usuario" class="form-control" value="" placeholder="usuario" data-toggle="tooltip" title="campo obligatorio" required pattern="^[a-zA-z0-9]+$">
              </div>
            </div>
            <!-- INPUT DE CONTRASEÑA -->
            <div class="form-group">
              <div class="input-group">
                <label class="input-group-addon" for="clave"><i class="fa fa-lock"></i></label>
                <input type="password" name="clave" class="form-control" placeholder="Contraseña" data-toggle="tooltip" title="campo obligatorio" required pattern="(\W|^)[\w.\-]{0,25}">
              </div>
            </div>
            <!-- INPUT DE ROL DE USUARIO -->
            <div class="form-group">
              <div class="input-group">
                <label class="input-group-addon" for="perfilUsuario"><i class="fa fa-users"></i></label>
                <select name="perfilUsuario" class="form-control" data-toggle="tooltip" title="campo obligatorio" required>
                  <option value="">Seleccione un rol de usuario</option>
                  <option value="Administrador">Administrador</option>
                  <option value="Especial">Especial</option>
                  <option value="Vendedor">Vendedor</option>
                </select>
              </div>
            </div>
            <!-- INPUT DE FOTO DE PERFIL -->
            <div class="form-group">
              <div class="panel">SUBIR FOTO</div>
              <input type="file" class="fotoUsuario" name="fotoUsuario">
              <p class="help-block">Tamaño máximo de la foto: 10 MB</p>
              <img src="views/img/usuarios/default/anonymous.png" class="img-thumbnail preview" alt="foto de usuario" width="100px">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar Usuario</button>
        </div>
        <?php
          $crearUsuario = new ControladorUsuarios;
          $crearUsuario -> ctrlCrearUsuario();
        ?>
      </form>
    </div>

  </div>
</div>
<!-- /Modal -->

  <!-- Modal de editar Usuario-->
  <div id="modalEditarUsuario" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <!-- 
        ===========================
          FORMULARIO DE USUARIO
        ===========================
       -->
      <form role="form" method="post" enctype="multipart/form-data">

        <div class="modal-header" style="background: #17a2b8; color: white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar Usuario</h4>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <!-- ID DEL USUARIO -->
            <input type="hidden" id="idUsuario" name="idUsuario" value="">
            <!-- INPUT DEL NOMBRE -->
            <div class="form-group">
              <div class="input-group">
                <label class="input-group-addon" for="editarNombreUsuario"><i class="fa fa-user"></i></label>
                <input type="text" id="editarNombreUsuario" name="editarNombreUsuario" class="form-control" value="" placeholder="Nombre" data-toggle="tooltip" title="campo obligatorio" required pattern="[a-zA-ZñÑ ]+">
              </div>
            </div>
            <!-- INPUT DEL USUARIO -->
            <div class="form-group">
              <div class="input-group">
                <label class="input-group-addon" for="editarUsuario"><i class="fa fa-key"></i></label>
                <input type="text" id="editarUsuario" readonly name="editarUsuario" class="form-control" value="" placeholder="usuario" data-toggle="tooltip" title="campo obligatorio" required pattern="^[a-zA-z0-9]+$">
              </div>
            </div>
            <!-- INPUT DE CONTRASEÑA -->
            <div class="form-group">
              <div class="input-group">
                <label class="input-group-addon" for="editarClave"><i class="fa fa-lock"></i></label>
                <input type="password" id="editarClave" name="editarClave" class="form-control" placeholder="Contraseña Nueva (opcional)" data-toggle="tooltip" title="opcional" required pattern="(\W|^)[\w.\-]{0,25}">
                <input type="hidden" id="claveActual" name="claveActual" value="">
              </div>
            </div>
            <!-- INPUT DE ROL DE USUARIO -->
            <div class="form-group">
              <div class="input-group">
                <label class="input-group-addon" for="editarPerfil"><i class="fa fa-users"></i></label>
                <select name="editarPerfil" class="form-control" data-toggle="tooltip" title="campo obligatorio" required>
                  <option value="" id="editarPerfil"></option>
                  <option value="Administrador">Administrador</option>
                  <option value="Especial">Especial</option>
                  <option value="Vendedor">Vendedor</option>
                </select>
              </div>
            </div>
            <!-- INPUT DE FOTO DE PERFIL -->
            <div class="form-group">
              <div class="panel">SUBIR FOTO</div>
              <input type="file" class="fotoUsuario" name="editarFoto">
              <p class="help-block">Tamaño máximo de la foto: 10 MB</p>
              <img src="views/img/usuarios/default/anonymous.png" class="img-thumbnail preview" alt="foto de usuario" width="100px">
              <input type="hidden" name="fotoActual" id="fotoActual" value="">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>
        <?php
          $editarUsuario = new ControladorUsuarios;
          $editarUsuario -> ctrlEditarUsuario();
        ?>
      </form>
    </div>

  </div>
</div>
<?php
      $eliminarUsuario = new ControladorUsuarios;
      $eliminarUsuario -> ctrlEliminarUsuario();
  ?>
<!-- /Modal -->