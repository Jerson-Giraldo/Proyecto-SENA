const productoFormulario = document.getElementById('productoFormulario');
productoFormulario.addEventListener('submit', (e) => {
    e.preventDefault(); // Cancela la funcionalidad por defecto del botón enviar
    productoFormularioSubmit();
});

async function productoFormularioSubmit() {
    let producto = {};
    producto.id = document.getElementById('id').value;
    producto.nombre = document.getElementById('nombre').value;
    producto.tipo_producto = document.getElementById('tipo_producto').value;
    producto.ubicacion = document.getElementById('ubicacion').value;
    producto.cantidad_stock = document.getElementById('cantidad_stock').value;
    producto.codigo_barras = document.getElementById('codigo_barras').value;
    producto.lote = document.getElementById('lote').value;
    producto.fecha_ingreso = document.getElementById('fecha_ingreso').value;
    producto.fecha_salida = document.getElementById('fecha_salida').value;
    producto.precio = document.getElementById('precio').value;
    producto.detalles_de_factura = document.getElementById('detalles_de_factura').value;
    producto.comentarios_producto = document.getElementById('comentarios_producto').value;

    let ruta = producto.id > 0 ? 'update' : 'create';

    try {
        let response = await fetch(`${URL_PATH}/producto/${ruta}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(producto) // Enviamos directamente el objeto producto
        });

        let responseData = await response.json();
        console.log(responseData);
    } catch (error) {
        console.error('Error:', error);
    }
}
