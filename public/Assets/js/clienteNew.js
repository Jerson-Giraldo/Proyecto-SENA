const clienteFormulario = document.getElementById('clienteFormulario');
clienteFormulario.addEventListener('submit', (e)=>{
  e.preventDafault();//sirve para cancelar la funcionalidad por defecto del botón enviar
  clienteFormularioSubmit()
});
async function clienteFormularioSubmit()
{
  let cliente = {};
  cliente.nombre = document.getElementById('nombre').value;
  cliente.nombre = document.getElementById('domicilio').value;
  cliente.nombre = document.getElementById('telefono').value;
  cliente.nombre = document.getElementById('cumpleaños').value;

  let reposense = await fetch('http://localhost/Proyecto-SENA/public/cliente/create', {
    method:'POST',
    body: JSON.stringify(cliente),
  });
  let reposenseData = await reposense.json();  
  console.log(reposenseData);
}