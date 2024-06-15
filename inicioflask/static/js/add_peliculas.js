document.addEventListener('DOMContentLoaded', function () {
    const addMovieForm = document.getElementById('addMovieForm');
  
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
        .then(() => fetch('http://127.0.0.1:5000/pelis'))
        .then(res => res.json())
        .then(data => {
          console.log(data);  // Verifica la respuesta del servidor
          addMovieForm.reset();
          alert('Película agregada exitosamente');
        })
        .catch(error => console.error('Error:', error));
    });
  });
  