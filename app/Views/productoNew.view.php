<form action="ProductoController.php" method="POST" id="productoFormulario">
  <input type="hidden" name="id" id="id" value="<?= $parameters['producto']['id'] ?? '0' ?>">
  <div>
    <label for="nombre">Nombre</label>
    <input type="text" id="nombre" name="nombre" value="<?= $parameters['producto']['nombre'] ?? '' ?>">
  </div>
  <div>
    <label for="domicilio">Tipo_producto</label>
    <input type="text" id="tipo_producto" name="tipo_producto" value="<?= $parameters['producto']['tipo_producto'] ?? '' ?>">
  </div>
  <div>
    <label for="telefono">Ubicación</label>
    <input type="text" id="ubicacion" name="ubicacion" value="<?= $parameters['producto']['ubicacion'] ?? '' ?>">
  </div>
  <div>
    <label for="cumpleanos">Cantidad_stock</label>
    <input type="text" id="cantidad_stock" name="cantidad_stock" value="<?= $parameters['producto']['cantidad_stock'] ?? '' ?>">
  </div>
  <div>
    <label for="nombre">Código_barras</label>
    <input type="text" id="codigo_barras" name="codigo_barras" value="<?= $parameters['producto']['codigo_barras'] ?? '' ?>">
  </div>
  <div>
    <label for="nombre">Lote</label>
    <input type="text" id="lote" name="lote" value="<?= $parameters['producto']['lote'] ?? '' ?>">
  </div>
  <div>
    <label for="nombre">Fecha_ingreso</label>
    <input type="text" id="fecha_ingreso" name="fecha_ingreso" value="<?= $parameters['producto']['fecha_ingreso'] ?? '' ?>">
  </div>
  <div>
    <label for="nombre">Fecha_salida</label>
    <input type="text" id="fecha_salida" name="fecha_salida" value="<?= $parameters['producto']['fecha_salida'] ?? '' ?>">
  </div>
  <div>
    <label for="nombre">Precio</label>
    <input type="text" id="precio" name="precio" value="<?= $parameters['producto']['precio'] ?? '' ?>">
  </div>
  <div>
    <label for="nombre">Detalles_de_factura</label>
    <input type="text" id="detalles_de_factura" name="detalles_de_factura" value="<?= $parameters['producto']['detalles_de_factura'] ?? '' ?>">
  </div>
  <div>
    <label for="nombre">Comentarios_producto</label>
    <input type="text" id="comentarios_producto" name="comentarios_producto" value="<?= $parameters['producto']['comentarios_producto'] ?? '' ?>">
  </div>
  <button type="submit" value="Enviar">Guardar</button>
</form>
<script src="<?= URL_PATH ?>/Assets/js/productoNew.js"></script>