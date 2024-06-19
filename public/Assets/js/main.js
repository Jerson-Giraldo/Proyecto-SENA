console.log('Archivo main.js cargado.');

// Asegúrate de que este código se ejecute después de que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', function() {
    console.log('Script cargado y DOM completamente cargado.');

    const tableName = document.getElementById('tableName').value; // Asegúrate de que este elemento existe y tiene el valor correcto

    // Ajustar el href del botón "Nuevo" dinámicamente
    const newButtonLink = document.getElementById('newButtonLink');
    if (newButtonLink) {
        newButtonLink.setAttribute('href', `${URL_PATH}/${tableName}/new`);
    } else {
        console.error('El elemento newButtonLink no se encontró en el DOM.');
        return; // Sal del script si newButtonLink no existe
    }

    // Event listener para el botón "Nuevo"
    const newButton = newButtonLink.querySelector('button');
    if (newButton) {
        newButton.addEventListener('click', function(event) {
            event.preventDefault(); // Prevenir comportamiento por defecto
            window.location.href = newButtonLink.getAttribute('href');
        });
    } else {
        console.error('El botón "Nuevo" no se encontró en el DOM.');
    }

    // Otros event listeners y funciones
    const dynamicForm = document.getElementById('dynamicForm');
    if (dynamicForm) {
        dynamicForm.addEventListener('submit', (e) => {
            e.preventDefault();
            submitForm();
        });
    } else {
        console.error('El elemento dynamicForm no se encontró en el DOM.');
    }

    fetchTableStructure(tableName);
    fetchTableData(tableName);
});

async function fetchTableData(tableName) {
    try {
        let response = await fetch(`${URL_PATH}/Dynamic/table/${tableName}`);
        let responseData = await response.json();

        if (responseData.success) {
            const tableBody = document.getElementById(`${tableName}TableBody`);
            if (tableBody) {
                tableBody.innerHTML = '';
                responseData.result.forEach(item => {
                    let rowHTML = '<tr>';
                    for (let key in item) {
                        rowHTML += `<td>${item[key]}</td>`;
                    }
                    rowHTML += `<td>
                                    <a href="${URL_PATH}/${tableName}/edit/?id=${item.id}">
                                        <button type="button">Editar</button>
                                    </a>
                                    <button onClick="deleteRecord('${tableName}', ${item.id})">Eliminar</button>
                                </td>`;
                    rowHTML += '</tr>';
                    tableBody.insertAdjacentHTML('beforeend', rowHTML);
                });
            } else {
                console.error(`El elemento ${tableName}TableBody no se encontró en el DOM.`);
            }
        } else {
            console.error('Error en la respuesta del servidor:', responseData);
        }
    } catch (error) {
        console.error('Error al obtener los datos de la tabla:', error);
    }
}

function deleteRecord(tableName, id) {
    BsModal.confirm({
        title: '¿Está seguro de eliminar este registro?',
        onOk: async () => {
            try {
                let response = await fetch(`${URL_PATH}/${tableName}/delete`, {
                    method: 'DELETE',
                    body: JSON.stringify({ id }),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });
                let responseData = await response.json();
                console.log(responseData);
                fetchTableData(tableName);
            } catch (error) {
                console.error('Error al eliminar el registro:', error);
            }
        }
    });
}

async function submitForm() {
    const formElements = document.getElementById('dynamicForm').elements;
    let formData = {};
    for (let element of formElements) {
        if (element.name) {
            formData[element.name] = element.value;
        }
    }

    let route = formData.id > 0 ? 'update' : 'create';
    let tableName = formData.tableName;

    try {
        let response = await fetch(`${URL_PATH}/${tableName}/${route}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        });

        let responseData = await response.json();
        console.log(responseData);
        fetchTableData(tableName);
    } catch (error) {
        console.error('Error al enviar el formulario:', error);
    }
}

async function fetchTableStructure(tableName) {
    try {
        let response = await fetch(`${URL_PATH}/Dynamic/structure/${tableName}`);
        let responseData = await response.json();

        if (responseData.success) {
            // Generate table headers
            const headersRow = document.getElementById('dynamicTableHeaders');
            if (headersRow) {
                headersRow.innerHTML = '';
                responseData.structure.forEach(column => {
                    headersRow.insertAdjacentHTML('beforeend', `<th>${column}</th>`);
                });
            } else {
                console.error('El elemento dynamicTableHeaders no se encontró en el DOM.');
            }

            // Generate form fields
            const form = document.getElementById('dynamicForm');
            if (form) {
                form.innerHTML = `<input type="hidden" name="tableName" id="tableName" value="${tableName}">`;
                responseData.structure.forEach(column => {
                    if (column !== 'id') { 
                        form.insertAdjacentHTML('beforeend', `
                            <div class="col-12 col-md-4">
                                <label class="form-label" for="${column}">${column}</label>
                                <input class="form-control" type="text" id="${column}" name="${column}">
                            </div>
                        `);
                    }
                });
                form.insertAdjacentHTML('beforeend', '<button type="submit" class="btn btn-primary" value="guardar">Guardar</button>');
            } else {
                console.error('El elemento dynamicForm no se encontró en el DOM.');
            }
        } else {
            console.error('Error en la respuesta del servidor:', responseData);
        }
    } catch (error) {
        console.error('Error al obtener la estructura de la tabla:', error);
    }
}
