async function productoList()
{
  let response = await fetch(URL_PATH + '/producto/table');
  let responseData = await response.json();

  if(responseData.success)
  {
    const productoTableBody = document.getElementById('productoTableBody');
    productoTableBody.innerHTML = '';
    responseData.result.forEach(item => {
        productoTableBody.insertAdjacentHTML('beforeend', `<tr>
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
}