edad = int(input('Ingrese su edad: '))
if edad < 12:
    precio = 5000
elif edad >= 12 and edad <= 18:
    precio = 6000
else:
    precio = 8000

print(f'El precio de su entrada es: {str(precio)}')

match edad:
    case 12:
        print(f'El precio de una entrada {str(edad  + 1)}')

