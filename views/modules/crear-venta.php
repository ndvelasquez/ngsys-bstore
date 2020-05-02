  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Crear venta
        <small>Panel de control</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="ventas">ventas</a></li>
        <li class="active">Crear venta</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- ================================ 
          FORMULARIO
         ====================================-->
         <div class="col-lg-5 col-xs-12">
            <div class="box box-success">

              <div class="box-header with-border"></div>

              <form method="post" role="form" class="formularioVenta">

                <div class="box-body">


                  <div class="box">

                    <!-- INPUT VENDEDOR -->
                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" class="form-control" name="vendedor" id="vendedor" value="<?php echo $_SESSION["nombre"]?>" readonly>
                        <input type="hidden" name="idVendedor" value="<?php echo $_SESSION["id"] ?>">
                      </div>
                    </div>

                    <!-- INPUT CODIGO -->
                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-code"></i></span>
                        <?php
                          $item = null;
                          $valor = null;

                          $ventas = ControladorVentas::ctrlMostrarVentas($item, $valor);

                          if(!$ventas) {
                            echo '<input type="text" class="form-control" name="codVenta" id="codVenta" value="10001" readonly>';
                          }
                          else {
                            foreach ($ventas as $key => $value) {
                              # code...
                            }
                            $codigo = $value["codigo"] + 1;

                            echo '<input type="text" class="form-control" name="codVenta" id="codVenta" value="'.$codigo.'" readonly>';
                          }
                        ?>
                        
                      </div>
                    </div>

                    <!-- INPUT CLIENTE -->
                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-users"></i></span>
                        <select class="form-control" name="agregarCliente" id="agregarCliente" required>
                          <option value="">Seleccionar Cliente</option>
                          <?php
                            $item = null;
                            $valor = null;

                            $cliente = ControladorClientes::ctrlMostrarClientes($item, $valor);

                            foreach ($cliente as $key => $value) {
                              echo '<option value="'.$value["id"].'">'.$value["nombre"].'</option>';
                            }
                          ?>
                        </select>

                        <span class="input-group-addon"><button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalAgregarCliente" data-dismiss="modal">Agregar Cliente</button></span>
                      </div>
                    </div>

                    <!-- INPUT PARA AGREGAR PRODUCTO -->
                    <div class="form-group row productos">

                    </div>

                    <!-- INPUT PARA ALMACENAR LOS DATOS EN JSON -->
                    <input type="hidden" name="listaProductos" id="listaProductos">

                    <!-- BOTON PARA AGREGAR PRODUCTOS (DISPOSITIVOS MOVILES) -->
                    <button class="btn btn-default hidden-lg btnAgregarProducto">Agregar Producto</button>

                    <hr>

                    <!-- INPUT DE IMPUESTOS Y TOTAL -->
                    <div class="row">
                      <div class="col-xs-8 pull-right">
                        <table class="table">
                          <thead>
                            <tr>
                              <th>Impuestos</th>
                              <th>Total</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td style="width: 50%">
                                <div class="input-group">
                                  <input type="number" class="form-control" name="impuestoVenta" id="impuestoVenta" min="1" placeholder="0" required>
                                  <input type="hidden" name="valorImpuesto" id="valorImpuesto">
                                  <input type="hidden" name="precioNeto" id="precioNeto">
                                  <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                </div>
                              </td>

                              <td style="width: 50%">
                                <div class="input-group">
                                  <input type="text" class="form-control" name="totalVenta" total="" id="totalVenta" min="1" placeholder="0" readonly required>
                                  <span class="input-group-addon"><b>S/</b></span>
                                </div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>

                    <hr>

                    <!-- INPUT DE PORCENTAJE -->
                    <div class="form-group" style="width: 50%">
                      <div class="input-group">
                        <input type="number" class="form-control porcentajeProducto" name="porcentaje" id="editarPorcentaje" min="0" max="99" placeholder="% de descuento">
                        <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                      </div>
                    </div>

                    <!-- INPUT METODO DE PAGO -->
                    <div class="form-group row">

                      <div class="col-xs-6" style="padding-right: 0px">
                        <div class="input-group">
                          <select class="form-control" name="metodoDePago" id="metodoDePago" required>
                            <option value="">Seleccione método de pago</option>
                            <option value="efectivo">Efectivo</option>
                            <option value="TC">Tarjeta de crédito</option>
                            <option value="TD">Tarjeta de débito</option>
                          </select>
                          <input type="hidden" name="listaMetodoPago" id="listaMetodoPago">
                        </div>
                      </div>

                      <div class="cajasMetodoPago">
                        
                      </div>

                    </div>


                  </div>

                </div>
                
                <div class="box-footer">
                  <button type="submit" class="btn btn-primary pull-right">Guardar Venta</button>
                </div>
                <?php
                $crearVenta = new ControladorVentas;
                $crearVenta -> ctrlCrearVenta();
                ?>
              </form>
            </div>
         </div>
         <!-- ================================
           LISTADO DE PRODUCTOS 
          ====================================-->
          <div class="col-lg-7 hidden-md hidden-sm hidden-xs">
            <div class="box box-warning">
              <div class="box-header with-border"></div>

              <div class="box-body">
                <table class="table table-bordered table-striped dt-responsive tablaProductoVenta">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Imagen</th>
                      <th>Código</th>
                      <th>Descripción</th>
                      <th>Stock</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                </table>
              </div>

            </div>
          </div>
      </div>

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
                <label class="input-group-addon" for="fechaNacimiento"><i class="far fa-calendar-alt"></i></label>
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