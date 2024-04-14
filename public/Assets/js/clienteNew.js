const clienteFormulario = document.getElementById('clienteFormulario');
clienteFormulario.addEventListener('submit', (e)=>{
  e.preventDafault();//sirve para cancelar la funcionalidad por defecto del botón enviar
  clienteFormularioSubmit();
});
async function clienteFormularioSubmit()
{
  let cliente = {};
  cliente.nombre = document.getElementById('nombre').value;
  cliente.domicilio = document.getElementById('domicilio').value;
  cliente.telefono = document.getElementById('telefono').value;
  cliente.cumpleanos = document.getElementById('cumpleanos').value;
  cliente.id = document.getElementById('id').value;

  let ruta = cliente.id > 0 ? 'update' : 'create';

  let reposense = await fetch(URL_PATH + '/cliente/' + ruta, {
    method:'POST',
    body: JSON.stringify({ cliente }),
  });
  let reposenseData = await reposense.json();  
  console.log(reposenseData);
}