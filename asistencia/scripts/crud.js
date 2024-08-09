document.addEventListener('DOMContentLoaded', function() {
    sendRequest('getAll', false);
});

document.getElementById('createBtn').addEventListener('click', function() {
    sendRequest('create');
});

document.getElementById('updateBtn').addEventListener('click', function() {
    sendRequest('update');
});

document.getElementById('deleteBtn').addEventListener('click', function() {
    sendRequest('delete');
});

document.getElementById('getAllBtn').addEventListener('click', function() {
    sendRequest('getAll', false);
});

document.getElementById('filter').addEventListener('input', function() {
    const filterValue = this.value.toLowerCase();
    const rows = document.querySelectorAll('#result .data-row');
    rows.forEach(row => {
        const key = row.querySelector('.key').textContent.toLowerCase();
        row.style.display = key.includes(filterValue) ? 'block' : 'none';
    });
});

function sendRequest(action, withKeyAndValue = true) {
    const formData = new FormData();
    formData.append('action', action);
    if (withKeyAndValue) {
        formData.append('key', document.getElementById('key').value);
        formData.append('value', document.getElementById('value').value);
    }

    fetch('../clases/CodController.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (action === 'getAll') {
            displayAllData(data);
        } else {
            document.getElementById('result').textContent = JSON.stringify(data, null, 2);
        }
    })
    .catch(error => console.error('Error:', error));
}

function displayAllData(data) {
    const resultDiv = document.getElementById('result');
    resultDiv.innerHTML = '';

    for (const key in data) {
        const div = document.createElement('div');
        div.classList.add('data-row', 'mb-2', 'p-2', 'border', 'rounded');
        div.innerHTML = `<strong class="key">${key}</strong>: ${data[key]}`;
        resultDiv.appendChild(div);
    }
}
