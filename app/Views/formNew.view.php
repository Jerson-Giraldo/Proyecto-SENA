<form id="dynamicForm" class="formulario-producto d-flex flex-column align-items-center justify-content-center">
    <?php if (isset($tableName)) : ?>
        <input type="hidden" name="tableName" id="tableName" value="<?= htmlspecialchars($tableName) ?>">
        <!-- Genere dinámicamente los campos de formulario basados en la estructura de la tabla -->
        <p>Table Name in Form: <?= htmlspecialchars($tableName) ?></p>
    <?php else : ?>
        <p>Error: Table Name no está definido.</p>
    <?php endif; ?>
</form>
