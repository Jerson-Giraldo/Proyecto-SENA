<!--<div class="table-responsive tablas-generales">
<table class="table table-striped table-bordered table-hover text-center">
  <thead class="table-dark text-center">
  <tr>
      <th>Nombre</th>
      <th>Tipo_producto</th>
      <th>Ubicación</th>
      <th>Cantidad_stock</th>
      <th>Código_barras</th>
      <th>Lote</th>
      <th>Fecha_ingreso</th>
      <th>Fecha_salida</th>
      <th>Precio</th>
      <th>Detalles_de_factura</th>
      <th>Comentarios_producto</th>
    </tr>
  </thead>
  <tbody id="productoTableBody">
  <a href="/Proyecto-SENA/public/producto/new">
  <button type="button">Nuevo</button>
</a>
  </tbody>
</table>
</div>
<script src="<?= URL_PATH ?>/Assets/js/producto.js"></script>-->
<div class="table-responsive tablas-generales">
        <table class="table table-striped table-bordered table-hover text-center">
            <thead class="table-dark text-center">
                <!-- Definir los encabezados de la tabla dinámicamente. -->
                <tr id="dynamicTableHeaders"></tr>
            </thead>
            <tbody id="productoTableBody">
                <a href="/Proyecto-SENA/public/producto/new">
                    <button type="button">Nuevo</button>
                </a>
            </tbody>
        </table>
    </div>

<form id="dynamicForm" class="formulario-producto d-flex flex-column align-items-center justify-content-center">
        <input type="hidden" name="tableName" id="tableName" value="producto">
        <!-- Genere dinámicamente campos de formulario basados ​​en la estructura de la tabla -->
    </form>
    <script src="<?= URL_PATH ?>/Assets/js/main.js"></script>


