document.addEventListener('DOMContentLoaded', function() {
    console.log('Script cargado y DOM completamente cargado.');
    
    const tableName = document.getElementById('tableName').value;
    const newButtonLink = document.getElementById('newButtonLink');
    if (newButtonLink) {
        console.log('Elemento newButtonLink encontrado en el DOM.');
    } else {
        console.log('Elemento newButtonLink no encontrado en el DOM.');
    }
    
    const dynamicForm = document.getElementById('dynamicForm');
    if (dynamicForm) {
        console.log('Elemento dynamicForm encontrado en el DOM.');
        // Aquí podrías añadir cualquier código específico para manejar el formulario dinámico
    } else {
        console.log('El elemento dynamicForm no se encontró en el DOM, asumiendo vista de tabla.');
        
        // Obtener datos de la tabla y actualizar el contenido dinámicamente
        fetch(`http://localhost/Proyecto-SENA/public/dynamic/table/${tableName}`)
            .then(response => response.json())
            .then(data => {
                console.log('Datos de la tabla recibidos:', data);
                
                if (data.success) {
                    // Aquí puedes procesar y mostrar los datos de la tabla
                    console.log('Datos de la tabla:', data.result);
                    // Lógica para actualizar la tabla en el DOM
                    const tableBody = document.getElementById(`${tableName}TableBody`);
                    const tableHeaders = document.getElementById('dynamicTableHeaders');
                    
                    if (tableBody && tableHeaders) {
                        // Limpiar el contenido actual de la tabla y encabezados
                        tableBody.innerHTML = '';
                        tableHeaders.innerHTML = '';

                        // Crear encabezados de la tabla
                        if (data.result.length > 0) {
                            const headers = Object.keys(data.result[0]);
                            headers.forEach(header => {
                                const th = document.createElement('th');
                                th.textContent = header;
                                tableHeaders.appendChild(th);
                            });

                            // Crear filas de la tabla
                            data.result.forEach(item => {
                                const row = document.createElement('tr');
                                headers.forEach(header => {
                                    const cell = document.createElement('td');
                                    cell.textContent = item[header];
                                    row.appendChild(cell);
                                });
                                tableBody.appendChild(row);
                            });
                        }
                    }
                } else {
                    console.error('Error en la respuesta del servidor:', data.message);
                }
            })
            .catch(error => {
                console.error('Error al obtener los datos de la tabla:', error);
            });
    }
});