<form action="ProductoController.php" method="POST" id="productoFormulario" class="formulario-producto d-flex flex-column align-items-center justify-content-center">
  <input type="hidden" name="idproducto" id="idproducto" value="<?= $parameters['producto']['idproducto'] ?? '0' ?>">
  <div class="col-12 col-md-4">
    <label class="form-label" for="nombre">Nombre</label>
    <input class="form-control" type="text" id="nombre" name="nombre" value="<?= $parameters['producto']['nombre'] ?? '' ?>">
  </div>
  <div class="col-12 col-md-4">
    <label class="form-label" for="tipo_producto">Tipo_producto</label>
    <input class="form-control" type="text" id="tipo_producto" name="tipo_producto" value="<?= $parameters['producto']['tipo_producto'] ?? '' ?>">
  </div>
  <div class="col-12 col-md-4">
    <label class="form-label" for="ubicacion">Ubicación</label>
    <input class="form-control" type="text" id="ubicacion" name="ubicacion" value="<?= $parameters['producto']['ubicacion'] ?? '' ?>">
  </div>
  <div class="col-12 col-md-4">
    <label class="form-label" for="cantidad_stock">Cantidad_stock</label>
    <input class="form-control" type="text" id="cantidad_stock" name="cantidad_stock" value="<?= $parameters['producto']['cantidad_stock'] ?? '' ?>">
  </div>
  <div class="col-12 col-md-4">
    <label class="form-label" for="codigo_barras">Código_barras</label>
    <input class="form-control" type="text" id="codigo_barras" name="codigo_barras" value="<?= $parameters['producto']['codigo_barras'] ?? '' ?>">
  </div>
  <div class="col-12 col-md-4">
    <label class="form-label" for="lote">Lote</label>
    <input class="form-control" type="text" id="lote" name="lote" value="<?= $parameters['producto']['lote'] ?? '' ?>">
  </div>
  <div class="col-12 col-md-4">
    <label class="form-label" for="fecha_ingreso">Fecha_ingreso</label>
    <input class="form-control" type="text" id="fecha_ingreso" name="fecha_ingreso" value="<?= $parameters['producto']['fecha_ingreso'] ?? '' ?>">
  </div>
  <div class="col-12 col-md-4">
    <label class="form-label" for="fecha_salida">Fecha_salida</label>
    <input class="form-control" type="text" id="fecha_salida" name="fecha_salida" value="<?= $parameters['producto']['fecha_salida'] ?? '' ?>">
  </div>
  <div class="col-12 col-md-4">
    <label class="form-label" for="precio">Precio</label>
    <input class="form-control type="text" id="precio" name="precio" value="<?= $parameters['producto']['precio'] ?? '' ?>">
  </div>
  <div class="col-12 col-md-4">
    <label class="form-label" for="detalles_de_factura_iddetalles_de_factura">Detalles_de_factura</label>
    <input class="form-control" type="number" id="detalles_de_factura_iddetalles_de_factura" name="detalles_de_factura_iddetalles_de_factura" value="<?= $parameters['producto']['detalles_de_factura_iddetalles_de_factura'] ?? '' ?>">
  </div>
  <div class="col-12 col-md-4">
    <label class="form-label" for="comentarios_producto">Comentarios_producto</label>
    <input class="form-control" type="text" id="comentarios_producto" name="comentarios_producto" value="<?= $parameters['producto']['comentarios_producto'] ?? '' ?>">
  </div>
  <div class="col-12 col-md-4">
    <button type="submit" class="btn btn-primary" value="guardar">Guardar</button>
  </div>
</form>
<script src="<?= URL_PATH ?>/Assets/js/productoNew.js"></script>