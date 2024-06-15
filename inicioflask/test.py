from flask import Flask, request, jsonify
import pymysql

app = Flask(__name__)

db_config = {
    'host': 'localhost',
    'user': 'root',
    'password': 'cacpython',
    'database': 'cactest'
    #'cursorclass' : pymysql.cursors.DictCursor  # Esto hace que el cursor devuelva diccionarios
}

db_conn = pymysql.connect(**db_config)
cursor = db_conn.cursor()

#Ruta para obtener los items de la base
@app.route("/pelis", methods=["GET"])
def get_pelis():
    try:
        cursor.execute("SELECT * FROM peliculas")
        pelis = [{'id': idpeliculas, 'nombre': nombre, 'col': peliculascol} for idpeliculas, nombre, peliculascol in cursor.fetchall()]
        return jsonify(pelis)
    except Exception as e:
        return jsonify({"error": str(e)})


#Ruta para insertar pelis
@app.route('/inserta_pelis', methods=['POST'])
def insert_pelis():
    try:
        data = request.get_json()
        #id = data.get('id')
        nombre = data.get('nombre')
        col = data.get('col')

        cursor.execute("INSERT INTO peliculas (nombre, peliculascol) VALUES (%s, %s)", (nombre, col))
        db_conn.commit()

        return jsonify({'mensaje': 'Pelicula guardada correctamente'})
    except Exception as e:
        return jsonify({"error": str(e)})

#Ruta para obtener los items de la base
@app.route("/pelis/<int:id>", methods=["PUT"])
def update_pelis(id):
    try:
        data = request.get_json()
        nombre = data.get('nombre')
        col = data.get('col')

        if nombre is None or col is None:
            return jsonify({"error": "El nombre y col son requeridos"}), 400
        
        cursor.execute("UPDATE peliculas SET nombre = %s, peliculascol = %s WHERE idpeliculas = %s", (nombre, col, id))
        db_conn.commit()

        return jsonify({'mensaje': f'La peli {nombre} ha sido actualizada correctamente'})
    except Exception as e:
        return jsonify({"error": str(e)})

    
if __name__ == "__main__":
    app.run(debug=True)