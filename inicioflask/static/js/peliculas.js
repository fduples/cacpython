document.addEventListener('DOMContentLoaded', function () {
    const dataElement = document.querySelector('.pelis');
  
    fetch('http://127.0.0.1:5000/pelis')
      .then(res => res.json())
      .then(data => {
        console.log(data); // Verificar la estructura de data
        handler(data);
      })
      .catch(error => console.error('Error:', error));
  
    function handler(data) {
      dataElement.innerHTML = ''; // Limpiar el contenedor antes de llenarlo
      data.forEach(element => {
        let movieContainer = document.createElement('div');
        movieContainer.className = 'card mb-3';
        movieContainer.dataset.id = element.idpeliculas;
  
        let cardBody = document.createElement('div');
        cardBody.className = 'card-body';
  
        for (const key in element) {
          if (element.hasOwnProperty(key)) {
            let p = document.createElement('p');
            p.className = 'card-text';
            p.innerHTML = `<strong>${key}:</strong> ${element[key]}`;
            cardBody.appendChild(p);
          }
        }
  
        let deleteButton = document.createElement('button');
        deleteButton.className = 'btn btn-danger mr-2';
        deleteButton.textContent = 'Borrar';
        deleteButton.onclick = () => deleteMovie(element.idpeliculas);
  
        let editButton = document.createElement('button');
        editButton.className = 'btn btn-warning';
        editButton.textContent = 'Editar';
        editButton.onclick = () => editMovie(element);
  
        cardBody.appendChild(deleteButton);
        cardBody.appendChild(editButton);
  
        movieContainer.appendChild(cardBody);
        dataElement.appendChild(movieContainer);
      });
    }
  
    function deleteMovie(id) {
      fetch(`http://127.0.0.1:5000/pelis/${id}`, {
        method: 'DELETE'
      })
        .then(() => fetch('http://127.0.0.1:5000/pelis'))
        .then(res => res.json())
        .then(data => handler(data))
        .catch(error => console.error('Error:', error));
    }
  
    function editMovie(movie) {
      const nombre = prompt('Editar nombre:', movie.nombre);
      const peliculascol = prompt('Editar descripción:', movie.peliculascol);
  
      if (nombre && peliculascol) {
        fetch(`http://127.0.0.1:5000/pelis/${movie.idpeliculas}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({ nombre, peliculascol })  // Asegúrate de usar los nombres correctos
        })
          .then(res => {
            if (!res.ok) {
              throw new Error(`HTTP error! status: ${res.status}`);
            }
            return res.json();
          })
          .then(data => {
            console.log(data);  // Verifica la respuesta del servidor
            return fetch('http://127.0.0.1:5000/pelis');
          })
          .then(res => res.json())
          .then(data => handler(data))
          .catch(error => console.error('Error:', error));
      }
    }
  });
  
  