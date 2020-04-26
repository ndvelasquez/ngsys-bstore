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
            <i class="fa fa-product-hunt"></i> <span>Productos</span>
          </a>
        </li>
        <li>
          <a href="categorias">
            <i class="fa fa-th"></i> <span>Categorías</span>
          </a>
        </li>
        <li>
          <a href="clientes">
            <i class="fa fa-user"></i> <span>Clientes</span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-list-ul"></i> 
            <span>Ventas</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
                <a href="ventas">
                    <i class="fa fa-circle-o"></i>
                    <span>Administrar ventas</span>
                </a>
            </li>
            <li>
                <a href="cotizaciones">
                    <i class="fa fa-circle-o"></i>
                    <span>cotizaciones</span>
                </a>
            </li>
            <li>
                <a href="crear-venta">
                    <i class="fa fa-circle-o"></i>
                    <span>Crear venta</span>
                </a>
            </li>
            <li>
                <a href="crear-cotizacion">
                    <i class="fa fa-circle-o"></i>
                    <span>Crear cotización</span>
                </a>
            </li>
            <li>
                <a href="reporte-ventas">
                    <i class="fa fa-circle-o"></i>
                    <span>Reporte de ventas</span>
                </a>
            </li>
          </ul>
        </li>
    </ul>
    </section>
    <!-- /.sidebar -->
  </aside>