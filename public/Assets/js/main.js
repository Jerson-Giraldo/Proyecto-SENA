document.addEventListener('DOMContentLoaded', function() {
    console.log('Script cargado y DOM completamente cargado.');

    const baseUrl = document.getElementById('baseUrl').value;
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
    } else {
        console.log('El elemento dynamicForm no se encontró en el DOM, asumiendo vista de tabla.');

        // Obtener estructura de la tabla y luego los datos de la tabla
        fetch(`${baseUrl}/dynamic/getStructure/${tableName}`)
            .then(response => response.text()) // Usa .text() para ver el contenido completo
            .then(text => {
                console.log('Respuesta del servidor:', text); // Imprime la respuesta como texto
                try {
                    const structureData = JSON.parse(text); // Intenta analizar el JSON
                    console.log('Datos de la estructura de la tabla recibidos:', structureData);
                    if (structureData.success) {
                        const tableHeaders = document.getElementById('dynamicTableHeaders');
                        tableHeaders.innerHTML = '';

                        // Crear encabezados de la tabla
                        structureData.structure.forEach(column => {
                            const th = document.createElement('th');
                            th.textContent = column.Field; // Asegúrate de usar el nombre del campo
                            tableHeaders.appendChild(th);
                        });

                        // Obtener datos de la tabla y actualizar el contenido dinámicamente
                        return fetch(`${baseUrl}/dynamic/table/${tableName}`);
                    } else {
                        throw new Error('Error al obtener la estructura de la tabla');
                    }
                } catch (error) {
                    console.error('Error al analizar el JSON:', error);
                    throw new Error('Error al obtener la estructura de la tabla');
                }
            })
            .then(response => response.text()) // Usa .text() para ver el contenido completo
            .then(text => {
                console.log('Respuesta del servidor:', text); // Imprime la respuesta como texto
                try {
                    const data = JSON.parse(text); // Intenta analizar el JSON
                    console.log('Datos de la tabla recibidos:', data);
                    if (data.success) {
                        const tableBody = document.getElementById(`${tableName}TableBody`);
                        tableBody.innerHTML = '';

                        if (data.result.length > 0) {
                            const headers = Object.keys(data.result[0]);

                            // Crear filas de la tabla
                            data.result.forEach(item => {
                                const row = document.createElement('tr');

                                // Agregar celdas con datos
                                headers.forEach(header => {
                                    const cell = document.createElement('td');
                                    cell.textContent = item[header];
                                    row.appendChild(cell);
                                });

                                // Agregar botones de editar y eliminar
                                const editButton = document.createElement('button');
                                editButton.textContent = 'Editar';
                                editButton.classList.add('btn', 'btn-primary', 'mx-1');
                                editButton.addEventListener('click', () => {
                                    console.log('Editar registro:', item);
                                });
                                row.appendChild(editButton);

                                const deleteButton = document.createElement('button');
                                deleteButton.textContent = 'Eliminar';
                                deleteButton.classList.add('btn', 'btn-danger', 'mx-1');
                                deleteButton.addEventListener('click', () => {
                                    $('#confirmDeleteModal').modal('show');
                                    $('#confirmDeleteButton').on('click', () => {
                                        console.log('Eliminar registro:', item);
                                        $('#confirmDeleteModal').modal('hide');
                                    });
                                });
                                row.appendChild(deleteButton);

                                tableBody.appendChild(row);
                            });
                        }
                    } else {
                        console.error('Error en la respuesta del servidor:', data.message);
                    }
                } catch (error) {
                    console.error('Error al analizar el JSON:', error);
                }
            })
            .catch(error => {
                console.error('Error al obtener los datos de la tabla:', error);
            });
    }
});
