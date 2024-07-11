<div class="table-responsive tablas-generales">
  <table class="table table-striped table-bordered table-hover text-center">
    <thead class="table-dark text-center">
      <!--Aqui se crean los encabezados de las columnas -->
      <tr id="dynamicTableHeaders"></tr>
    </thead>
    <tbody id="<?= $tableName ?>TableBody">
      <!-- Este es el cuerpo de la tabla donde se insertarán las filas de datos. -->
    </tbody>
  </table>
</div>

<a id="newButtonLink" href="<?= URL_PATH ?>/<?= $tableName ?>/new">
  <!--Esto me redirige a una URL dinamica -->
  <button type="button">Nuevo</button>
</a>
