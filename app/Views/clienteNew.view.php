<form action="ClienteController.php" method="POST" id="clienteFormulario">
  <input type="hidden" name="id" id="id" value="<?= $parameters['cliente']['id'] ?? '0' ?>">
  <div>
    <label for="nombre">Nombre</label>
    <input type="text" id="nombre" name="nombre" value="<?= $parameters['cliente']['nombre'] ?? '' ?>">
  </div>
  <div>
    <label for="domicilio">Domicilio</label>
    <input type="text" id="domicilio" name="domicilio" value="<?= $parameters['cliente']['domicilio'] ?? '' ?>">
  </div>
  <div>
    <label for="telefono">Teléfono</label>
    <input type="text" id="telefono" name="telefono" value="<?= $parameters['cliente']['telefono'] ?? '' ?>">
  </div>
  <div>
    <label for="cumpleanos">Cumpleaños</label>
    <input type="text" id="cumpleanos" name="cumpleanos" value="<?= $parameters['cliente']['cumpleanos'] ?? '' ?>">
  </div>
  <button type="submit" value="Enviar">Guardar</button>
</form>
<script src="<?= URL_PATH ?>/Assets/js/clienteNew.js"></script>