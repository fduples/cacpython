peliculas = ['Batman', 'Titanic', 'Entrevista con el Vampiro', 'Matrix']

rango = range(1, len(peliculas), 2)

for i in range(1, len(peliculas), 2):
    print(i)
print(rango)

#Tuplas
#Desempaquetado de tuplas

pelis = 'Batman', 1998, 'David Cámeron'

#desempaquetado completo
titulo, anio, director = pelis
#Desempaquetado parcial:
titulo2, anio2, *_ = pelis #Se usa *_ para el final. y saltea todas las que quedan
titulo3, _ , director3 = pelis #Se una solo _ para saltear datos intermedios
peli1, peli2, peli3, peli4 = peliculas

print(f'Titulo: {titulo}, Año de creación: {anio}, director: {director}')
print(peli1)
print(peli2)
print(peli3)
print(peli4)