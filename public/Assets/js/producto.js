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

document.addEventListener('DOMContentLoaded', () => {
    const URL_PATH = "http://localhost/Proyecto-SENA/public/"; 

    // Función para manejar el envío del formulario
    function setupFormHandler(formId, submitHandler) {
        const form = document.getElementById(formId);
        if (form) {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                submitHandler();
            });
        } else {
            console.error(`Form with ID ${formId} not found`);
        }
    }

    // Función para obtener los datos del formulario de manera dinámica
    function getFormData(formId) {
        const form = document.getElementById(formId);
        const formData = new FormData(form);
        const data = {};
        formData.forEach((value, key) => {
            data[key] = value;
        });
        return data;
    }

    // Función genérica para enviar datos del formulario
    async function submitForm(formId, urlPath, idField, endpointSuffixes) {
        const data = getFormData(formId);
        const ruta = data[idField] > 0 ? endpointSuffixes.update : endpointSuffixes.create;

        try {
            let response = await fetch(`${URL_PATH}${urlPath}/${ruta}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });

            let responseData = await response.json();
            console.log(responseData);
        } catch (error) {
            console.error('Error:', error);
        }
    }

    // Función genérica para listar datos
    async function fetchList(urlPath, tableBodyId) {
        let response = await fetch(`${URL_PATH}${urlPath}/table`);
        let responseData = await response.json();

        if (responseData.success) {
            const tableBody = document.getElementById(tableBodyId);
            if (tableBody) {
                tableBody.innerHTML = '';
                responseData.result.forEach(item => {
                    const row = document.createElement('tr');
                    Object.keys(item).forEach(key => {
                        const cell = document.createElement('td');
                        cell.textContent = item[key];
                        row.appendChild(cell);
                    });

                    const actionsCell = document.createElement('td');
                    actionsCell.innerHTML = `
                        <a href="${URL_PATH}${urlPath}/edit/?id=${item.id}">
                            <button type="button">Editar</button>
                        </a>
                        <button onClick="deleteItem('${urlPath}', ${item.id})">Eliminar</button>
                    `;
                    row.appendChild(actionsCell);

                    tableBody.appendChild(row);
                });
            } else {
                console.error(`Table body with ID ${tableBodyId} not found`);
            }
        }
    }

    // Función genérica para eliminar datos
    async function deleteItem(urlPath, itemId) {
        BsModal.confirm({
            title: '¿Está seguro de eliminar este registro?',
            onOk: async () => {
                let response = await fetch(`${URL_PATH}${urlPath}/delete`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: itemId })
                });

                let responseData = await response.json();
                console.log(responseData);
                fetchList(urlPath, `${urlPath}TableBody`);
            }
        });
    }

    // Configurar el formulario y la lista de productos
    setupFormHandler('productoFormulario', () => {
        submitForm('productoFormulario', 'producto', 'idproducto', { create: 'create', update: 'update' });
    });
    fetchList('producto', 'productoTableBody');

    // Configurar el formulario y la lista de facturas
    setupFormHandler('facturaFormulario', () => {
        submitForm('facturaFormulario', 'factura', 'idfactura', { create: 'create', update: 'update' });
    });
    fetchList('factura', 'facturaTableBody');
});

// Función para llenar un formulario genérico con datos específicos
function llenarFormularioGenerico(data, templateId, targetId) {
    const template = document.getElementById(templateId);
    const target = document.getElementById(targetId);
  
    const formulario = template.content.cloneNode(true).querySelector('.formulario-generico');
    
    // Rellenar el formulario con los datos específicos
    Object.keys(data).forEach(key => {
      const input = formulario.querySelector(`[name="${key}"]`);
      if (input) {
        input.value = data[key];
      }
    });
  
    target.appendChild(formulario);
  }
  
  // Función para llenar una tabla genérica con datos específicos
  function llenarTablaGenerica(dataList, templateId, targetId) {
    const template = document.getElementById(templateId);
    const target = document.getElementById(targetId);
  
    const tabla = template.content.cloneNode(true).querySelector('.tabla-generica');
  
    // Crear filas de tabla para cada elemento de la lista de datos
    dataList.forEach(data => {
      const fila = document.createElement('tr');
      Object.values(data).forEach(value => {
        const celda = document.createElement('td');
        celda.textContent = value;
        fila.appendChild(celda);
      });
      tabla.appendChild(fila);
    });
  
    target.appendChild(tabla);
  }
  
  // Ejemplo de uso: llenar un formulario de producto
  const datosProducto = {
    nombre: 'Producto 1',
    precio: '$10.00',
    cantidad: 5
  };
  llenarFormularioGenerico(datosProducto, 'formulario-generico', 'formulario-container');
  
  // Ejemplo de uso: llenar una tabla de productos
  const listaProductos = [
    { nombre: 'Producto 1', precio: '$10.00', cantidad: 5 },
    { nombre: 'Producto 2', precio: '$15.00', cantidad: 3 },
    { nombre: 'Producto 3', precio: '$20.00', cantidad: 8 }
  ];
  llenarTablaGenerica(listaProductos, 'tabla-generica', 'tabla-container');
  
