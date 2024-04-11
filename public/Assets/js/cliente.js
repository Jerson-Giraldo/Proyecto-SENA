async function clienteList()
{
  let reposense = await fetch('http://localhost/Proyecto-SENA/public/cliente/table');
  let reposenseData = await reposense.json();
  
  if(reposenseData.success)
  {
    const clienteTableBody = document.getElementById('clienteTableBody');
      clienteTableBody.innerHTML = '';
      reposenseData.result.forEach(item => {
      clienteTableBody.insertAdjacentHTML('beforeend', `<tr>
      <td>${item.nombre}</td>
      <td>${item.domicilio}</td>
      <td>${item.telefono}</td>
      <td>${item.cumpleanos}</td>
      <td>
        <a href="http://localhost/Proyecto-SENA/public/cliente/edit/?id=${item.id}">
        <button>Editar</button>
        </a>
        <button onclick="eliminarCliente(${item.id})">Eliminar</button>
      </td>
      </tr>`)
  });
}
}
clienteList();

async function eliminarCliente(id)
{
  let reposense = await fetch('http://localhost/Proyecto-SENA/public/cliente/delete', {
    method: 'DELETE',
    body: JSON.stringify({id}),
  });
  let reposenseData = await reposense.json();
  console.log(reposenseData);
  clienteList();
}