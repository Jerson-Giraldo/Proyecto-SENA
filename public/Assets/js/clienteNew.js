const clienteFormulario = document.getElementById('clienteFormulario');
clienteFormulario.addEventListener('submit', (e) => {
    e.preventDefault(); // Cancela la funcionalidad por defecto del botón enviar
    clienteFormularioSubmit();
});

async function clienteFormularioSubmit() {
    let cliente = {};
    cliente.id = document.getElementById('id').value;
    cliente.nombre = document.getElementById('nombre').value;
    cliente.domicilio = document.getElementById('domicilio').value;
    cliente.telefono = document.getElementById('telefono').value;
    cliente.cumpleanos = document.getElementById('cumpleanos').value;

    let ruta = cliente.id > 0 ? 'update' : 'create';

    try {
        let response = await fetch(`${URL_PATH}/cliente/${ruta}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(cliente) // Enviamos directamente el objeto cliente
        });

        let responseData = await response.json();
        console.log(responseData);
    } catch (error) {
        console.error('Error:', error);
    }
}
