/*async function facturaList()
{
  let response = await fetch(URL_PATH + '/factura/table');
  let responseData = await response.json();

  if(responseData.success)
  {
    const facturaTableBody = document.getElementById('facturaTableBody');
    facturaTableBody.innerHTML = '';
      responseData.result.forEach(item => {
        facturaTableBody.insertAdjacentHTML('beforeend', 
      `<tr>
      <td>${item.fecha}</td>
      <td>${item.cliente_idtable1}</td>
      <td>${item.auxiliar_idusuarios}</td>
      <td>
        <a href="${URL_PATH}/factura/edit/?idfactura=${item.idfactura}">
        <button type="button">Editar</button>
        </a>
        <button onClick="eliminarFactura(${item.idfactura})">Eliminar</button>
      </td>
      </tr>`);
  });
  }
}
facturaList();

function eliminarFactura(idfactura)
{
  BsModal.confirm({
    title: '¿Esta seguro de eliminar este registro?',
    onOk: async() =>{
      let response = await fetch(URL_PATH + '/factura/delete', {
        method: 'DELETE',
        body: JSON.stringify({ idfactura }),
      });
      let responseData = await response.json();
      console.log(responseData);
      facturaList();
    }
  })
}*/