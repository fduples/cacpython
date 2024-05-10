class Movie{

    constructor(id,title,director,rating,releaseDate,banner){
        this.id=id;
        this.title=title;
        this.director=director;
        this.rating=rating;
        this.releaseDate=releaseDate;
        this.banner=banner
    }

}

const movie1 = new Movie(1,'Damsel','Un director',4.5,'2024-03-01','https://image.tmdb.org/t/p/w500//sMp34cNKjIb18UBOCoAv4DpCxwY.jpg');

const movie2 = new Movie(2,'Dune 2','Un director 2',5,'2024-04-01','https://image.tmdb.org/t/p/w500//8b8R8l88Qje9dn9OE8PY05Nxl1X.jpg');

const movie3 = new Movie(3,'Kunfu panda 4','Un director 2',5,'2024-04-01','https://image.tmdb.org/t/p/w500//kDp1vUBnMpe8ak4rjgl3cLELqjU.jpg');

// let movies = [movie1,movie2,movie3];

// localStorage.setItem('movies',JSON.stringify(movies));

// console.log(movies);

function showMovies(){
    // const allInputs = document.querySelectorAll('.input-search');
    // console.log(allInputs);

    //BUSCAR LO QUE HAY EN LOCAL STORAGE
    let movies = JSON.parse(localStorage.getItem('movies'));

    //buscar elemento HTML donde quiero insertar las peliculas
    const tbodyMovies = document.querySelector('#list-table-movies tbody');
    // const tbodyMovies = document.getElementById('#tbody-table-movies');
    //limpio el contenido de la tabla
    tbodyMovies.innerHTML = '';
    movies.forEach(movie => {
        //TEMPLATE STRING - TEMPLATE LITERAL 
        const tr = `
                    <tr>
                        <td>${movie.title}</td>
                        <td>${movie.director}</td>
                        <td>${movie.rating}</td>
                        <td>${movie.releaseDate}</td>
                        <td>
                            <img src="${movie.banner}" alt="${movie.title}" width="30%">
                        </td>
                        <td>
                            <button class="btn-cac"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
        `;
        tbodyMovies.insertAdjacentHTML('beforeend',tr);
    });

}

function saveMovie(){
    
    const inputTitle = document.querySelector('#title');
    const inputDirector = document.querySelector('#director');
    const inputRating = document.querySelector('#rating');
    const inputReleaseDate = document.querySelector('#release-date');
    const inputBanner = document.querySelector('#banner-form');
    
    if(inputTitle.value.trim() !== ''){
        //Busca en localstorage el item movies, si no existe asigna el array vacio.
        let movies = JSON.parse(localStorage.getItem('movies')) || [];

        const newMovie = new Movie(
            movies.length+1,
            inputTitle.value,
            inputDirector.value,
            inputRating.value,
            inputReleaseDate.value,
            inputBanner.value,
        );
        // agrego al final del array movies la nueva pelicula
        movies.push(newMovie);
        //Actualizo el localstorage
        localStorage.setItem('movies',JSON.stringify(movies));
        showMovies();
    }else{
        alert('Error, por favor complete el titulo')
    }

}

// NOS ASEGURAMOS QUE SE CARGUE EL CONTENIDO DE LA PAGINA EN EL DOM
document.addEventListener('DOMContentLoaded',function(){

    const btnSaveMovie = document.querySelector('#btn-save-movie');

    //ASOCIAR UNA FUNCION AL EVENTO CLICK DEL BOTON
    btnSaveMovie.addEventListener('click',saveMovie);
    showMovies();
});
