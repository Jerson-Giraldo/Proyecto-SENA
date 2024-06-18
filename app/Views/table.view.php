<input type="hidden" id="tableName" value="producto">

<div class="table-responsive tablas-generales">
  <table class="table table-striped table-bordered table-hover text-center">
    <thead class="table-dark text-center">
      <!-- Definir los encabezados de la tabla dinámicamente. -->
      <tr id="dynamicTableHeaders"></tr>
    </thead>
    <tbody id="productoTableBody">
    <a id="newButtonLink" href="/Proyecto-SENA/public/<?= $tableName ?>/new">
            <button type="button">Nuevo</button>
          </a>
    </tbody>
  </table>
</div>

<form id="dynamicForm"></form>