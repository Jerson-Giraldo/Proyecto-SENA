async function productoList()
{
  let reposense = await fetch(URL_PATH + '/producto/table');
  let reposenseData = await reposense.json();

  if(reposenseData.success)
  {
    const productoTableBody = document.getElementById('productoTableBody');
    productoTableBody.innerHTML = '';
      reposenseData.result.forEach(item => {
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
      <td>${item.detalles_de_factura}</td>
      <td>${item.comentarios_producto}</td>
      <td>
        <a href="${URL_PATH}/producto/edit/?id=${item.id}">
        <button>Editar</button>
        </a>
        <button onClick="eliminarProducto(${item.id})">Eliminar</button>
      </td>
      </tr>`)
  });
}
}
productoList();

function eliminarProducto(id)
{
  BsModal.confirm({
    title: '¿Esta seguro de eliminar este registro?',
    onOk: async() =>{
      let reposense = await fetch(URL_PATH + '/producto/delete', {
        method: 'DELETE',
        body: JSON.stringify({ id }),
      });
      let reposenseData = await reposense.json();
      console.log(reposenseData);
      productoList();
    }
  })
}