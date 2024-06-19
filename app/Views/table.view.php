<input type="hidden" id="tableName" value="<?= $tableName ?>">

<div class="table-responsive tablas-generales">
  <table class="table table-striped table-bordered table-hover text-center">
    <thead class="table-dark text-center">
      <tr id="dynamicTableHeaders"></tr>
    </thead>
    <tbody id="<?= $tableName ?>TableBody">
    </tbody>
  </table>
</div>
<a id="newButtonLink" href="<?= URL_PATH ?>/<?= $tableName ?>/new">
  <button type="button">Nuevo</button>
</a>
<form id="dynamicForm"></form>
