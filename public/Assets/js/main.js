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
        fetch(`${baseUrl}/dynamic/structure/${tableName}`)
            .then(response => response.json())
            .then(structureData => {
                console.log('Datos de la estructura de la tabla recibidos:', structureData);
                if (structureData.success) {
                    const tableHeaders = document.getElementById('dynamicTableHeaders');
                    tableHeaders.innerHTML = '';

                    // Crear encabezados de la tabla
                    structureData.structure.forEach(column => {
                        const th = document.createElement('th');
                        th.textContent = column;
                        tableHeaders.appendChild(th);
                    });

                    // Obtener datos de la tabla y actualizar el contenido dinámicamente
                    return fetch(`${baseUrl}/dynamic/table/${tableName}`);
                } else {
                    throw new Error('Error al obtener la estructura de la tabla');
                }
            })
            .then(response => response.json())
            .then(data => {
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
                                // Lógica para editar el registro (puedes implementar aquí)
                                console.log('Editar registro:', item);
                            });
                            row.appendChild(editButton);

                            const deleteButton = document.createElement('button');
                            deleteButton.textContent = 'Eliminar';
                            deleteButton.classList.add('btn', 'btn-danger', 'mx-1');
                            deleteButton.addEventListener('click', () => {
                                // Mostrar modal de confirmación para eliminar
                                $('#confirmDeleteModal').modal('show'); // Utilizando jQuery para el modal
                                
                                // Lógica para eliminar el registro si se confirma
                                $('#confirmDeleteButton').on('click', () => {
                                    console.log('Eliminar registro:', item);
                                    $('#confirmDeleteModal').modal('hide');
                                    // Aquí puedes llamar a la función para eliminar el registro
                                    // fetch(`${baseUrl}/eliminar/${tableName}/${item.id}`)
                                    //    .then(response => response.json())
                                    //    .then(data => {
                                    //        console.log('Registro eliminado:', data);
                                    //    })
                                    //    .catch(error => {
                                    //        console.error('Error al eliminar el registro:', error);
                                    //    });
                                });
                            });
                            row.appendChild(deleteButton);

                            tableBody.appendChild(row);
                        });
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
