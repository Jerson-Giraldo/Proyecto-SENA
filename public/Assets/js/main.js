console.log('Archivo main.js cargado.');

document.addEventListener('DOMContentLoaded', function() {
    console.log('Script cargado y DOM completamente cargado.');

    const tableNameInput = document.getElementById('tableName');
    if (tableNameInput) {
        const tableName = tableNameInput.value;

        const newButtonLink = document.getElementById('newButtonLink');
        if (newButtonLink) {
            newButtonLink.setAttribute('href', `${URL_PATH}/dynamic/new/${tableName}`);
        } else {
            console.error('El elemento newButtonLink no se encontró en el DOM.');
            return;
        }

        const newButton = newButtonLink.querySelector('button');
        if (newButton) {
            newButton.addEventListener('click', function(event) {
                event.preventDefault();
                window.location.href = newButtonLink.getAttribute('href');
            });
        } else {
            console.error('El botón "Nuevo" no se encontró en el DOM.');
        }

        const dynamicForm = document.getElementById('dynamicForm');
        if (dynamicForm) {
            dynamicForm.addEventListener('submit', (e) => {
                e.preventDefault();
                submitForm();
            });
        } else {
            console.error('El elemento dynamicForm no se encontró en el DOM.');
        }

        fetchTableData(tableName);
    } else {
        console.error('El input con id "tableName" no se encontró en el DOM.');
    }
});

async function fetchTableData(tableName) {
    try {
        let response = await fetch(`${URL_PATH}/Dynamic/table/${tableName}`);
        let responseData = await response.json();

        if (responseData.success) {
            renderTableHeaders(Object.keys(responseData.result[0])); // Renderizar los encabezados
            renderTableData(responseData.result); // Renderizar los datos de la tabla
        } else {
            console.error('Error en la respuesta del servidor:', responseData);
        }
    } catch (error) {
        console.error('Error al obtener los datos de la tabla:', error);
    }
}

function renderTableHeaders(columns) {
    const tableHeaders = document.getElementById('dynamicTableHeaders');
    if (tableHeaders) {
        tableHeaders.innerHTML = '';
        columns.forEach(column => {
            tableHeaders.insertAdjacentHTML('beforeend', `<th>${column}</th>`);
        });
    } else {
        console.error('El elemento dynamicTableHeaders no se encontró en el DOM.');
    }
}

function renderTableData(data) {
    const tableBody = document.getElementById(`${tableName}TableBody`);
    if (tableBody) {
        tableBody.innerHTML = '';
        data.forEach(item => {
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
