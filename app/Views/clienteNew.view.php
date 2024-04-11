<form action="" id="clienteFormulario">
  <input type="hidden" name="" id="id" value ="<?= $parameters['cliente']['id'] ?? '0'?>">
  <div>
    <label for="nombre">Nombre</label>
    <input type="text" id="nombre" value ="<?= $parameters['cliente']['nombre'] ?? ''?>">
  </div>
  <div>
    <label for="domicilio">Domicilio</label>
    <input type="text" id="domicilio" value ="<?= $parameters['cliente']['domicilio'] ?? ''?>">
  </div>
  <div>
    <label for="telefono">Teléfono</label>
    <input type="text" id="telefono" value ="<?= $parameters['cliente']['telefono'] ?? ''?>">
  </div>
  <div>
    <label for="cumpleanos">Cumpleaños</label>
    <input type="text" id="cumpleanos" value ="<?= $parameters['cliente']['cumpleanos'] ?? ''?>">
  </div>
  <button type="submit">Guardar</button>
</form>
<script src="<?= URL_PATH ?>/Assets/js/clienteNew.js"></script>