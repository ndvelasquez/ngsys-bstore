<!-- Left side column. contains the sidebar -->

<aside class="main-sidebar">
    <!-- sidebar -->

    <section class="sidebar">

      <!-- Sidebar user panel -->

      <div class="user-panel">
        <div class="pull-left image">
        <?php 
                  if ($_SESSION["foto"] != "") {
                    echo '<img src="'.$_SESSION["foto"].'" class="img-circle" alt="user-image">';
                  }
                  else {
                    echo '<img src="views/img/usuarios/default/anonymous.png" class="img-circle" alt="user-image">';
                  }
                ?>
        </div>
        <div class="pull-left info">
          <p><?=$_SESSION["nombre"]?></p>
        </div>
      </div>

      <!-- sidebar menu -->

      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Navegación principal</li>
        <?php
          if($_SESSION["perfil"] == "Administrador") {
            echo '
            <li class="active">
              <a href="inicio">
                <i class="fa fa-home"></i> <span>Inicio</span>
              </a>
            </li>
            <li>
              <a href="usuarios">
                <i class="fa fa-user"></i> <span>Usuarios</span>
              </a>
            </li>
            <li>
              <a href="productos">
                <i class="fab fa-product-hunt"></i> <span>Productos</span>
              </a>
            </li>
            <li>
              <a href="categorias">
                <i class="fa fa-th"></i> <span>Categorías</span>
              </a>
            </li>
            ';
          }
        ?>
        
        <li>
          <a href="clientes">
            <i class="fa fa-user"></i> <span>Clientes</span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fas fa-list-ul"></i>
            <span>Pedidos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
                <a href="pedidos">
                    <i class="far fa-circle"></i>
                    <span>Ver pedidos</span>
                </a>
            </li>
            <li>
                <a href="crear-pedido">
                    <i class="far fa-circle"></i>
                    <span>Crear pedido</span>
                </a>
            </li>
            <?php
              if($_SESSION["perfil"] == "Administrador") {
                echo '
                <li>
                  <a href="cotizaciones">
                    <i class="far fa-circle"></i>
                    <span>cotizaciones</span>
                  </a>
                </li>
                <li>
                  <a href="crear-cotizacion">
                    <i class="far fa-circle"></i>
                    <span>Crear cotización</span>
                  </a>
                </li>
                ';
              }
            ?>
            <?php
              if($_SESSION["perfil"] == "Administrador") {
                echo '
                <li>
                  <a href="reporte-ventas">
                      <i class="far fa-circle"></i>
                      <span>Reporte de ventas</span>
                  </a>
                </li>
                ';
              }
            ?>
            
          </ul>
          <?php
            if($_SESSION["perfil"] == "Administrador") {
              echo '
              <li class="treeview">
              <a href="#">
                <i class="ion ion-clipboard"></i> 
                <span>Inventario</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li>
                  <a href="movimientos">
                    <i class="fas fa-exchange-alt"></i>
                    <span>Ver movimientos</span>
                  </a>
                </li>
              </ul>
            </li>
              ';
            }
          ?>
          
      </li>
    </ul>
    </section>
    <!-- /.sidebar -->
  </aside>