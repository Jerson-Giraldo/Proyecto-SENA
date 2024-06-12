<form action="FacturaController.php" method="POST" id="facturaFormulario" class="formulario-producto d-flex flex-column align-items-center justify-content-center">
  <input type="hidden" name="idfactura" id="idfactura" value="<?= $parameters['factura']['idfactura'] ?? '0' ?>">
  <div class="col-12 col-md-4">
    <label class="form-label" for="fecha">Fecha</label>
    <input class="form-control" type="date" id="fecha" name="fecha" value="<?= $parameters['factura']['fecha'] ?? '' ?>">
  </div>
  <div class="col-12 col-md-4">
    <label class="form-label" for="cliente_idtable1">Tipo_Cliente</label>
    <input class="form-control" type="text" id="cliente_idtable1" name="cliente_idtable1" value="<?= $parameters['factura']['cliente_idtable1'] ?? '' ?>">
  </div>
  <div class="col-12 col-md-4">
    <label class="form-label" for="auxiliar_idusuarios">Auxiliar</label>
    <input class="form-control" type="text" id="auxiliar_idusuarios" name="auxiliar_idusuarios" value="<?= $parameters['factura']['auxiliar_idusuarios'] ?? '' ?>">
  </div>
  <div class="col-12 col-md-4">
    <button type="submit" class="btn btn-primary" value="guardar">Guardar</button>
  </div>
</form>
<script src="<?= URL_PATH ?>/Assets/js/facturaNew.js"></script>