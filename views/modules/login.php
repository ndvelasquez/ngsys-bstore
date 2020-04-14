<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>Ng </b>SYS</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Iniciar sesión</p>

    <form method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Usuario" name="Iusuario">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Contraseña" name="Ipassword">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
        </div>
      </div>
      <?php
      $login = new ControladorUsuarios();
      $login -> ctrlValidaUsuario();
      ?>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
