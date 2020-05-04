  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Administrar productos
        <small>Panel de control</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active">Administrar productos</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarProducto">Agregar producto</button>
          <div class="pull-right">
          <button class="btn btn-danger imprimirProductos">
                  <span>
                    <i class="far fa-file-pdf"></i> Descargar Lista de precios
                  </span>
                </button>
          </div>
        </div>
        <div class="box-body">
          <table class="table table-bordered table-striped dt-responsive tablaProducto">
            <thead>
              <tr>
                <th style="width: 10px">#</th>
                <th>Imagen</th>
                <th>Código</th>
                <th>Descripción</th>
                <th>Categoría</th>
                <th>Stock</th>
                <th>Precio de compra</th>
                <th>Precio de venta</th>
                <th>Agregado</th>
                <th>Acciones</th>
              </tr>
            </thead>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Modal de agregar producto-->
<div id="modalAgregarProducto" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <!-- 
        ===========================
          FORMULARIO DE PRODUCTO
        ===========================
       -->
      <form role="form" method="post" enctype="multipart/form-data">

        <div class="modal-header" style="background: #17a2b8; color: white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar Nuevo Producto</h4>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <!-- INPUT DE CATEGORÍA -->
            <div class="form-group">
              <div class="input-group">
                <label class="input-group-addon" for="categoria"><i class="fa fa-th"></i></label>
                <select name="categoria" id="categoria" class="form-control" data-toggle="tooltip" title="campo obligatorio" required>
                  <option value="">Seleccione una categoría</option>
                  <?php
                $item = null;
                $valor = null;

                $categorias = ControladorCategorias::ctrlMostrarCategorias($item, $valor);

                foreach ($categorias as $key => $value) {
                  echo "<option value='".$value["id"]."'>".$value["nombre"]."</option>";
                }
              ?>
                </select>
              </div>
            </div>
            <!-- INPUT DEL CODIGO -->
            <div class="form-group">
              <div class="input-group">
                <label class="input-group-addon" for="codProducto"><i class="fa fa-code"></i></label>
                <input type="text" name="codProducto" id="codProducto" class="form-control" value="" readonly placeholder="Código del producto" data-toggle="tooltip" title="campo obligatorio" required pattern="[0-9]+">
              </div>
            </div>
            <!-- INPUT DE DESCRIPCION DEL PRODUCTO -->
            <div class="form-group">
              <div class="input-group">
                <label class="input-group-addon" for="descripcion"><i class="fab fa-product-hunt"></i></label>
                <input type="text" name="descripcion" class="form-control" value="" placeholder="descripción del producto" data-toggle="tooltip" title="campo obligatorio" required pattern="[a-zA-ZñÑ0-9.´\- ]+">
              </div>
            </div>
            <!-- INPUT DE LA CANTIDAD DEL PRODUCTO -->
            <div class="form-group">
              <div class="input-group">
                <label class="input-group-addon" for="cantidad"><i class="fa fa-plus"></i></label>
                <input type="number" name="cantidad" class="form-control" value="" placeholder="cantidad" data-toggle="tooltip" title="campo obligatorio" required min="0" pattern="[0-9]+">
              </div>
            </div>
            <!-- INPUT DE PRECIO DE COMPRA -->
            <div class="form-group row">
              <div class="col-xs-6">
                <div class="input-group">
                  <label class="input-group-addon" for="precioCompra"><i class="fa fa-arrow-up"></i></label>
                  <input type="number" step="any" id="precioCompra" name="precioCompra" class="form-control" value="" placeholder="precio de compra" data-toggle="tooltip" title="campo obligatorio" required pattern="[0-9.]+" min="0">
                </div>
              </div>
                <!-- INPUT DE PRECIO DE VENTA -->
                <div class="col-xs-6">
                  <div class="input-group">
                    <label class="input-group-addon" for="precioVenta"><i class="fa fa-arrow-down"></i></label>
                    <input type="number" step="any" id="precioVenta" readonly name="precioVenta" class="form-control" placeholder="precio de venta" data-toggle="tooltip" title="campo obligatorio" required pattern="[0-9.]+" min="0">
                  </div>
                </div>
                <br>
                <!-- CHECKBOX DE PORCENTAJE -->
                <div class="col-xs-6">
                  <div class="form-group">
                    <label>
                      <input type="checkbox" class="minimal porcentaje" name="chkPorcentaje" id="chkPorcentaje" checked>
                      Utilizar porcentaje
                    </label>
                  </div>
                </div>
                <!-- INPUT DE PORCENTAJE -->
                <div class="col-xs-6">
                  <div class="input-group">
                    <input type="number" class="form-control porcentaje" name="porcentaje" id="porcentaje" min="0" value="40" required>
                    <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                  </div>
                </div>
            </div>
            <!-- INPUT DE IMAGEN DEL PRODUCTO -->
            <div class="form-group">
              <div class="panel">SUBIR IMAGEN</div>
              <input type="file" class="imagenProducto" name="imagenProducto">
              <p class="help-block">Tamaño máximo de la foto: 10 MB</p>
              <img src="views/img/productos/default/anonymous.png" class="img-thumbnail preview" alt="foto de producto" width="100px">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar producto</button>
        </div>
        <?php
          $crearproducto = new ControladorProductos;
          $crearproducto -> ctrlCrearproducto();
        ?>
      </form>
    </div>

  </div>
</div>
<!-- /Modal -->

  <!-- Modal de editar producto-->
  <div id="modalEditarProducto" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <!-- 
        ===========================
          FORMULARIO DE PRODUCTO
        ===========================
       -->
      <form role="form" method="post" enctype="multipart/form-data">

        <div class="modal-header" style="background: #17a2b8; color: white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar producto</h4>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <!-- ID DEL PRODUCTO -->
            <input type="hidden" id="idProducto" name="idProducto" value="">
            <!-- INPUT DE CATEGORÍA -->
            <div class="form-group">
              <div class="input-group">
                <label class="input-group-addon" for="categoria"><i class="fa fa-th"></i></label>
                <select name="editarCategoria" class="form-control" data-toggle="tooltip" title="campo obligatorio" required>
                  <option id="editarCategoria" value=""></option>
                  <?php
                $item = null;
                $valor = null;

                $categorias = ControladorCategorias::ctrlMostrarCategorias($item, $valor);

                foreach ($categorias as $key => $value) {
                  echo "<option value='".$value["id"]."'>".$value["nombre"]."</option>";
                }
              ?>
                </select>
              </div>
            </div>
            <!-- INPUT DEL CODIGO -->
            <div class="form-group">
              <div class="input-group">
                <label class="input-group-addon" for="editarCodProducto"><i class="fa fa-code"></i></label>
                <input type="text" id="editarCodProducto" name="editarCodProducto" readonly class="form-control" value="" placeholder="Código del producto" data-toggle="tooltip" title="campo obligatorio" required pattern="[0-9]+">
              </div>
            </div>
            <!-- INPUT DE DESCRIPCION DEL PRODUCTO -->
            <div class="form-group">
              <div class="input-group">
                <label class="input-group-addon" for="editarDescripcion"><i class="fa fa-product-hunt"></i></label>
                <input type="text" id="editarDescripcion" name="editarDescripcion" class="form-control" value="" placeholder="descripción del producto" data-toggle="tooltip" title="campo obligatorio" required pattern="[a-zA-ZñÑ 0-9]+">
              </div>
            </div>
            <!-- INPUT DE LA CANTIDAD DEL PRODUCTO -->
            <div class="form-group">
              <div class="input-group">
                <label class="input-group-addon" for="cantidad"><i class="fa fa-plus"></i></label>
                <input type="number" id="editarCantidad" name="editarCantidad" readonly class="form-control" value="" placeholder="cantidad" data-toggle="tooltip" title="campo obligatorio" required min="0" pattern="[0-9]+">
              </div>
            </div>
            <!-- INPUT DE PRECIO DE COMPRA -->
            <div class="form-group row">
              <div class="col-xs-12 col-sm-6">
                <div class="input-group">
                  <label class="input-group-addon" for="precioCompra"><i class="fa fa-arrow-up"></i></label>
                  <input type="number" step="any" id="editarPrecioCompra" name="precioCompra" class="form-control" value="" placeholder="precio de compra" data-toggle="tooltip" title="campo obligatorio" required pattern="[0-9.]+" min="0">
                </div>
              </div>
                <!-- INPUT DE PRECIO DE VENTA -->
                <div class="col-xs-12 col-sm-6">
                  <div class="input-group">
                    <label class="input-group-addon" for="precioVenta"><i class="fa fa-arrow-down"></i></label>
                    <input type="number" step="any" id="editarPrecioVenta" readonly name="precioVenta" class="form-control" placeholder="precio de venta" data-toggle="tooltip" title="campo obligatorio" required pattern="[0-9.]+" min="0">
                  </div>
                </div>
                <br>
                <!-- CHECKBOX DE PORCENTAJE -->
                <div class="col-xs-6">
                  <div class="form-group">
                    <label>
                      <input type="checkbox" class="minimal porcentaje" name="chkPorcentaje" id="editarChkPorcentaje" checked>
                      Utilizar porcentaje
                    </label>
                  </div>
                </div>
                <!-- INPUT DE PORCENTAJE -->
                <div class="col-xs-6">
                  <div class="input-group">
                    <input type="number" class="form-control porcentaje" name="porcentaje" id="editarPorcentaje" min="0" value="40" required>
                    <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                  </div>
                </div>
            </div>
            <!-- INPUT DE IMAGEN DEL PRODUCTO -->
            <div class="form-group">
              <div class="panel">SUBIR IMAGEN</div>
              <input type="file" class="imagenProducto" name="imagenProducto">
              <p class="help-block">Tamaño máximo de la foto: 10 MB</p>
              <img src="views/img/productos/default/anonymous.png" class="img-thumbnail preview" alt="foto de producto" width="100px">
              <input type="hidden" name="imagenActual" id="imagenActual">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>
        <?php
          $editarproducto = new Controladorproductos;
          $editarproducto -> ctrlEditarProducto();
        ?>
      </form>
    </div>

  </div>
</div>
<?php
      $eliminarproducto = new Controladorproductos;
      $eliminarproducto -> ctrlEliminarproducto();
  ?>
<!-- /Modal -->