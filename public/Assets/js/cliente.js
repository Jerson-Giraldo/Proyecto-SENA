async function clienteList()
{
  let reposense = await fetch('http://localhost/Proyecto-SENA/public/cliente/table');
  let reposenseData = await reposense.json();
  
  if(reposenseData.success)
  {
    const clienteTableBody = document.getElementById(clienteTableBody);
    reposenseData.result.forEach(item =>{
      clienteTableBody.insertAdjacentHTML('beforebegin', `<tr>
      <td>${item.nombre}</td>
      <td>${item.domicilio}</td>
      <td>${item.telefono}</td>
      <td>${item.cumpleaños}</td>

      </tr>`)
  });

}
clienteList();