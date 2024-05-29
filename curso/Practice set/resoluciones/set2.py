"""
#SET 2.1
def todos_operadores(a,b):
    suma = a + b
    resta = a - b
    multiplica = a * b
    mayor = max(a,b)
    menor = min(a,b)
    divide =  mayor / menor
    entero_divide = mayor // menor
    resto_divide = mayor % menor
    potencia = a ** b

    resultados = {
        'suma': suma,
        'resta': resta,
        'multiplicacion': multiplica,
        'mayor': mayor,
        'menor': menor,
        'division': divide,
        'division_entera': entero_divide,
        'resto_division': resto_divide,
        'potencia': potencia
    }
    return resultados

num1 = int(input('Ingrese un numero: '))
num2 = int(input('Ingrese otro numero: '))

resultados = todos_operadores(num1, num2)
print(f'''La suma de sus números es: {resultados['suma']},
      La resta es {resultados['resta']},
      La multiplicacion es {resultados['multiplicacion']},
      La división es {resultados['division']},
      el entero del cosciente es {resultados['division_entera']},
      el resto del cosciente es {resultados['resto_division'],},
      finalmente la pontecia es {resultados['potencia']}''')

#SET 2.5
largo = int(input('ingrese el largo del rectangulo: '))
altos = int(input('ingrese el alto del rectangulo: '))

if largo == altos:
    print('es un cuadrado')
else:
    print('es un rectangulo')
"""

