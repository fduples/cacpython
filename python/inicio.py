print("hola mundo")

#Comentario una linea

"""
Comentario
de
varias
lineas
"""

cadena = "cadena de caracteres"
print(type(cadena))
entero = 46
print(type(entero))
flotante = 4.5
print(type(flotante))
booleano = True
print(type(booleano))

#para ingresar valores por teclado

pelicula = input("Ingrese el nombre de la pelica de la")
print(pelicula)

precio = 6000
cantidad_entradas = int(input("Cuentas entradas va a comprar: "))
monto_total = print(precio * cantidad_entradas)

cadenas = "Aguante" + str(cantidad_entradas) + " precio" + str(monto_total)
print(cadenas)
cadena_facil = f"Aguante {str(cantidad_entradas)} precio {str(monto_total)}"
print(type(cadena_facil))
for i in range(20,0,-1):
    print(i)
