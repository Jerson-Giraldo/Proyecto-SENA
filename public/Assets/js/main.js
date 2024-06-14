/*async function productoList()
{
  let response = await fetch(URL_PATH + '/producto/table');
  let responseData = await response.json();

  if(responseData.success)
  {
    const productoTableBody = document.getElementById('productoTableBody');
    productoTableBody.innerHTML = '';
      responseData.result.forEach(item => {
        productoTableBody.insertAdjacentHTML('beforeend', 
      `<tr>
      <td>${item.nombre}</td>
      <td>${item.tipo_producto}</td>
      <td>${item.ubicacion}</td>
      <td>${item.cantidad_stock}</td>
      <td>${item.codigo_barras}</td>
      <td>${item.lote}</td>
      <td>${item.fecha_ingreso}</td>
      <td>${item.fecha_salida}</td>
      <td>${item.precio}</td>
      <td>${item.detalles_de_factura_iddetalles_de_factura}</td>
      <td>${item.comentarios_producto}</td>
      <td>
        <a href="${URL_PATH}/producto/edit/?idproducto=${item.idproducto}">
        <button type="button">Editar</button>
        </a>
        <button onClick="eliminarProducto(${item.idproducto})">Eliminar</button>
      </td>
      </tr>`);
  });
}
}
productoList();

function eliminarProducto(idproducto)
{
  BsModal.confirm({
    title: '¿Esta seguro de eliminar este registro?',
    onOk: async() =>{
      let response = await fetch(URL_PATH + '/producto/delete', {
        method: 'DELETE',
        body: JSON.stringify({ idproducto }),
      });
      let responseData = await response.json();
      console.log(responseData);
      productoList();
    }
  })
}*/

// Asegúrate de que este código se ejecute después de que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', function() {
  // Aquí va tu código JavaScript

  // Ejemplo de código dentro del event listener
  const dynamicForm = document.getElementById('dynamicForm');
  if (dynamicForm) {
      dynamicForm.addEventListener('submit', (e) => {
          e.preventDefault();
          submitForm();
      });
  } else {
      console.error('El elemento dynamicForm no se encontró en el DOM.');
  }

  // También asegúrate de llamar a otras funciones después del DOM cargado, si es necesario
  fetchTableStructure('producto');
  fetchTableData('producto');
});

async function fetchTableData(tableName) {
  let response = await fetch(`${URL_PATH}/${tableName}/table`);
  let responseData = await response.json();

  if (responseData.success) {
      const tableBody = document.getElementById(`${tableName}TableBody`);
      if (tableBody) {
          tableBody.innerHTML = '';
          responseData.result.forEach(item => {
              let rowHTML = '<tr>';
              for (let key in item) {
                  rowHTML += `<td>${item[key]}</td>`;
              }
              rowHTML += `<td>
                              <a href="${URL_PATH}/${tableName}/edit/?id=${item.id}">
                                  <button type="button">Editar</button>
                              </a>
                              <button onClick="deleteRecord('${tableName}', ${item.id})">Eliminar</button>
                          </td>`;
              rowHTML += '</tr>';
              tableBody.insertAdjacentHTML('beforeend', rowHTML);
          });
      } else {
          console.error(`El elemento ${tableName}TableBody no se encontró en el DOM.`);
      }
  }
}

function deleteRecord(tableName, id) {
  BsModal.confirm({
      title: '¿Está seguro de eliminar este registro?',
      onOk: async () => {
          let response = await fetch(`${URL_PATH}/${tableName}/delete`, {
              method: 'DELETE',
              body: JSON.stringify({ id }),
          });
          let responseData = await response.json();
          console.log(responseData);
          fetchTableData(tableName);
      }
  });
}

async function submitForm() {
  const formElements = document.getElementById('dynamicForm').elements;
  let formData = {};
  for (let element of formElements) {
      if (element.name) {
          formData[element.name] = element.value;
      }
  }

  let route = formData.id > 0 ? 'update' : 'create';
  let tableName = formData.tableName;

  try {
      let response = await fetch(`${URL_PATH}/${tableName}/${route}`, {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json'
          },
          body: JSON.stringify(formData)
      });

      let responseData = await response.json();
      console.log(responseData);
      fetchTableData(tableName);
  } catch (error) {
      console.error('Error:', error);
  }
}

async function fetchTableStructure(tableName) {
  let response = await fetch(`${URL_PATH}/${tableName}/structure`);
  let responseData = await response.json();

  if (responseData.success) {
      // Generate table headers
      const headersRow = document.getElementById('dynamicTableHeaders');
      if (headersRow) {
          headersRow.innerHTML = '';
          responseData.structure.forEach(column => {
              headersRow.insertAdjacentHTML('beforeend', `<th>${column}</th>`);
          });
      } else {
          console.error('El elemento dynamicTableHeaders no se encontró en el DOM.');
      }

      // Generate form fields
      const form = document.getElementById('dynamicForm');
      if (form) {
          form.innerHTML = `<input type="hidden" name="tableName" id="tableName" value="${tableName}">`;
          responseData.structure.forEach(column => {
              if (column !== 'id') { 
                  form.insertAdjacentHTML('beforeend', `
                      <div class="col-12 col-md-4">
                          <label class="form-label" for="${column}">${column}</label>
                          <input class="form-control" type="text" id="${column}" name="${column}">
                      </div>
                  `);
              }
          });
          form.insertAdjacentHTML('beforeend', '<button type="submit" class="btn btn-primary" value="guardar">Guardar</button>');
      } else {
          console.error('El elemento dynamicForm no se encontró en el DOM.');
      }
  }
}




  
