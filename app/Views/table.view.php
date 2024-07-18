<input type="hidden" id="tableName" value="<?= htmlspecialchars($tableName) ?>">
<input type="hidden" id="baseUrl" value="<?= URL_PATH ?>">
<div class="table-responsive tablas-generales">
<a id="newButtonLink" href="<?= URL_PATH ?>/dynamic/new/<?= htmlspecialchars($tableName) ?>">
  <button type="button">Nuevo</button>
</a>
  <table class="table table-striped table-bordered table-hover text-center">
    <thead class="table-dark text-center" id="dynamicTableHeaders">
      <!-- Aquí se crean los encabezados de las columnas dinámicamente -->
    </thead>
    <tbody id="<?= htmlspecialchars($tableName) ?>TableBody">
      <!-- Este es el cuerpo de la tabla donde se insertarán las filas de datos -->
    </tbody>
  </table>
</div>


