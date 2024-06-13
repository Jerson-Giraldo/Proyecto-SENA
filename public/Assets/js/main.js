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

document.addEventListener('DOMContentLoaded', function() {
  // Función para cargar datos existentes en el formulario
  function cargarDatosProducto(idProducto) {
      // Simulación de una petición AJAX
      // En tu aplicación real, reemplaza esto con una petición AJAX real a tu backend
      // para obtener los datos del producto según el idProducto.
      const url = `url_de_tu_backend_para_obtener_producto?id=${idProducto}`;
      
      fetch(url)
          .then(response => response.json())
          .then(data => {
              llenarFormulario(data); // Llenar el formulario con los datos obtenidos
          })
          .catch(error => console.error('Error al obtener datos del producto:', error));
  }

  // Función para llenar el formulario con datos
  function llenarFormulario(data) {
      document.getElementById('idproducto').value = data.idproducto || '';
      document.getElementById('nombre').value = data.nombre || '';
      // Llenar otros campos del formulario según sea necesario
  }

  // Cuando se cargue la página, cargar datos del producto con id = 1 (ejemplo)
  cargarDatosProducto(1); // Aquí puedes poner el ID del producto que deseas cargar dinámicamente
});



  
