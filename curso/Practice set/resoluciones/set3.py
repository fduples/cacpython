#SET 3.1
'''
a = 0

while a < 11:
    print(a)
    a+=1

#SET 3.2

a = [1,2,3,4,5]
cadena = ''
for i in range(len(a)) :
    cadena = cadena + " " +str(a[i])
    print(cadena)


#SET 3.3
a = [1,2,3,4,5]
cadena = ''
for i in range(len(a)) :
    cadena = cadena + " " +str(a[i]-1)
    print(cadena)

#SET 3.4
num = int(input('Ingrese el número a multiplicar: '))

for i in range(0, 10, 1):
    print(f'{num} * {i} = {num*i} ')


#SET 3.5

for i in range(10, 0, -1):
    print(f'-{i}')


#SET 3.6
# Inicializar los dos primeros términos de la serie de Fibonacci
a, b = 0, 1

# Imprimir los primeros 10 términos de la serie de Fibonacci
for _ in range(10):
    print(a, end=" ")
    # Calcular el siguiente término de la serie sumando los dos anteriores
    a, b = b, a + b
'''

#SET 3.7
num = 78432
num_str = str(num)
    # Invertir la cadena
reversed_str = num_str[::-1]
    # Convertir la cadena invertida de nuevo a un número entero
reversed_num = int(reversed_str)

print(reversed_num)