<header class="main-header">
    <!-- Logo -->
    <a href="inicio" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img src="views/img/plantilla/logo.png"></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img src="views/img/plantilla/logo-grande.png"></span>
    </a>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <?php 
                  if ($_SESSION["foto"] != "") {
                    echo '<img src="'.$_SESSION["foto"].'" class="user-image">';
                  }
                  else {
                    echo '<img src="views/img/usuarios/default/anonymous.png" class="user-image">';
                  }
                ?>
                <span class="hidden-xs"><?=$_SESSION["nombre"]?></span>
                </a>
                <ul class="dropdown-menu">
                <!-- Menu Body -->
                    <li class="user-body">
                        <div class="pull-right">
                            <a href="salir" class="btn btn-default btn-flat">Salir</a>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
      </div>
    </nav>
  </header>

  