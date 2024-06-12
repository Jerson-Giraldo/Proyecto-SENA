/*const facturaFormulario = document.getElementById('facturaFormulario');
facturaFormulario.addEventListener('submit', (e) => {
    e.preventDefault(); // Cancela la funcionalidad por defecto del botón enviar
    facturaFormularioSubmit();
});

async function facturaFormularioSubmit() {
    let factura = {};
    factura.idfactura = document.getElementById('idfactura').value;
    factura.fecha = document.getElementById('fecha').value;
    factura.cliente_idtable1 = document.getElementById('cliente_idtable1').value;
    factura.auxiliar_idusuarios = document.getElementById('auxiliar_idusuarios').value;

    let ruta = factura.idfactura > 0 ? 'update' : 'create';

    try {
        let response = await fetch(`${URL_PATH}/factura/${ruta}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(factura) // Enviamos directamente el objeto factura
        });

        let responseData = await response.json();
        console.log(responseData);
    } catch (error) {
        console.error('Error:', error);
    }
}*/
