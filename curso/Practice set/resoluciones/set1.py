#SET 1.1
'''
cadena = "Twinkle, twinkle, little star,\n \tHow I wonder what you are!\n \t\tUp above the world so high,\n \t\tLike a diamond in the sky.\n Twinkle, twinkle, little star,\n \tHow I wonder what you are"

print(cadena)
'''
#SET 1.2
'''
import math
radio = float(input("Ingrese el radio del círculo: "))
pi = math.pi

area = pi * pow(radio, 2)

print(f"El área del un círculo de radio {radio} es: {area}")
'''

#SET 1.3
'''
primer_nombre = input("Ingrese su primer nombre: ")
segundo_nombre = input("Ingrese su segundo nombre: ")

print(f"Su nombre es: {primer_nombre} {segundo_nombre}")
'''

#SET1.4
'''
nombre = input("Por favor, ingresa tu nombre: ")

print(nombre, end='****')
'''

#SET1.5 .6 .7 .8
def suma(a,b,c):
    return a + b + c

def resta(a,b,c):
    return a - b - c

num1 = int(input("Ingrese un número entero: "))
num2 = int(input("Ingrese otro número entero: "))
num3 = int(input("Ingrese el último número entero: "))

desi1 = float(input("Ingrese un número con decimales: "))
desi2 = float(input("Ingrese otro número con decimales: "))
desi3 = float(input("Ingrese el último numero con decimales: "))

print(f"La suma de los enteros es: {suma(num1, num2, num3)}, \nLa resta de los enteros es: {resta(num1, num2, num3)}\n")

print(f"La suma de los decimales es: {suma(desi1, desi2, desi3)} \nLa resta de los decimales es: {resta(desi1, desi2, desi3)}")