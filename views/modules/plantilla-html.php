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
                <th>Contraseña</th>
                <th>Foto</th>
                <th>Perfil</th>
                <th>Estado</th>
                <th>Último Login</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>Usuario Administrador</td>
                <td>admin</td>
                <td>admin123</td>
                <td><img src="views/img/usuarios/default/anonymous.png" alt="foto-usuario"></td>
                <td>Adminitrador</td>
                <td><button class="btn btn-success btn-xs">Activo</button></td>
                <td>18/03/2020 19:30</td>
                <td>
                  <div class="btn-group">
                    <button class="btn btn-warning"><i class="far fa-edit"></i></button>
                    <button class="btn btn-danger"><i class="fa fa-times"></i></button>
                  </div>
                </td>
              </tr>
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

  <!-- Modal -->
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
                <input type="text" name="nombreUsuario" class="form-control" placeholder="Nombre">
              </div>
            </div>
            <!-- INPUT DEL USUARIO -->
            <div class="form-group">
              <div class="input-group">
                <label class="input-group-addon" for="usuario"><i class="fa fa-key"></i></label>
                <input type="text" name="usuario" class="form-control" placeholder="usuario">
              </div>
            </div>
            <!-- INPUT DE CONTRASEÑA -->
            <div class="form-group">
              <div class="input-group">
                <label class="input-group-addon" for="clave"><i class="fa fa-lock"></i></label>
                <input type="text" name="clave" class="form-control" placeholder="Contraseña">
              </div>
            </div>
            <!-- INPUT DE ROL DE USUARIO -->
            <div class="form-group">
              <div class="input-group">
                <label class="input-group-addon" for="perfilUsuario"><i class="fa fa-users"></i></label>
                <select name="perfilUsuario" class="form-control">
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
              <input type="file" name="fotoUsuario" id="fotoUsuario">
              <p class="help-block">Tamaño máximo de la foto: 100 MB</p>
              <img src="views/img/usuarios/default/anonymous.png" class="img-thumbnail" alt="foto de usuario" width="100px">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar Usuario</button>
        </div>
      </form>
    </div>

  </div>
</div>
<!-- /Modal -->