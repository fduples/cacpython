const dataElement = document.querySelector('.pelis');
const addMovieForm = document.getElementById('addMovieForm');

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
    // Crear un contenedor para cada película con clases de Bootstrap
    let movieContainer = document.createElement('div');
    movieContainer.className = 'card mb-3';
    movieContainer.dataset.id = element.idpeliculas;

    // Crear un cuerpo de tarjeta para el contenido de la película
    let cardBody = document.createElement('div');
    cardBody.className = 'card-body';

    // Iterar sobre cada clave-valor del objeto de la película
    for (const key in element) {
      if (element.hasOwnProperty(key)) {
        let p = document.createElement('p');
        p.className = 'card-text';
        p.innerHTML = `<strong>${key}:</strong> ${element[key]}`;
        cardBody.appendChild(p);
      }
    }

    // Botón de borrar
    let deleteButton = document.createElement('button');
    deleteButton.className = 'btn btn-danger mr-2';
    deleteButton.textContent = 'Borrar';
    deleteButton.onclick = () => deleteMovie(element.idpeliculas);

    // Botón de editar
    let editButton = document.createElement('button');
    editButton.className = 'btn btn-warning';
    editButton.textContent = 'Editar';
    editButton.onclick = () => editMovie(element);

    cardBody.appendChild(deleteButton);
    cardBody.appendChild(editButton);

    // Añadir el cuerpo de la tarjeta al contenedor de la película
    movieContainer.appendChild(cardBody);

    // Añadir el contenedor de la película al elemento principal
    dataElement.appendChild(movieContainer);
  });
}

function deleteMovie(id) {
  fetch(`http://127.0.0.1:5000/pelis/${id}`, {
    method: 'DELETE'
  })
    .then(() => {
      // Actualizar la lista de películas después de borrar
      return fetch('http://127.0.0.1:5000/pelis');
    })
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
      body: JSON.stringify({ nombre, peliculascol })
    })
      .then(res => {
        if (!res.ok) {
          throw new Error(`HTTP error! status: ${res.status}`);
        }
        return res.json();
      })
      .then(data => {
        console.log(data); 
        return fetch('http://127.0.0.1:5000/pelis');
      })
      .then(res => res.json())
      .then(data => handler(data))
      .catch(error => console.error('Error:', error));
  }
}

addMovieForm.addEventListener('submit', (event) => {
  event.preventDefault();

  const nombre = document.getElementById('nombre').value;
  const peliculascol = document.getElementById('peliculascol').value;

  fetch('http://127.0.0.1:5000/inserta_pelis', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({ nombre, peliculascol })
  })
    .then(() => {
      // Actualizar la lista de películas después de agregar
      return fetch('http://127.0.0.1:5000/pelis');
    })
    .then(res => res.json())
    .then(data => {
      handler(data);
      addMovieForm.reset(); // Limpiar el formulario después de agregar
    })
    .catch(error => console.error('Error:', error));
});