import pymysql
from flask import Flask, render_template, request, jsonify
from flask_cors import CORS

app = Flask(__name__)
CORS(app)

db_conn = pymysql.connect(
    host='localhost',
    user='root',
    password='cacpython',
    database='cactest',
    cursorclass=pymysql.cursors.DictCursor  # Esto hace que el cursor devuelva diccionarios
)

@app.route("/")
def index():
    return render_template("index.html")

@app.route("/peliculas")
def peliculas():
    return render_template("peliculas.html")

@app.route("/add_peliculas")
def add_peliculas():
    return render_template("add_peliculas.html")

@app.route("/pelis/<int:id>", methods=["GET"])
def get_peli(id):
    try:
        with db_conn.cursor() as cursor:
            # Ejecuta la consulta SQL
            cursor.execute("SELECT * FROM peliculas WHERE id = %s", (id,))
            result = cursor.fetchone()

            if result:
                return jsonify(result)
            else:
                return jsonify({"error": "Pelicula no encontrada"}), 404
    except Exception as e:
        return jsonify({"error": str(e)})

@app.route("/pelis", methods=["GET"])
def get_all_pelis():
    try:
        with db_conn.cursor() as cursor:
            # Ejecuta la consulta SQL para obtener todas las películas
            cursor.execute("SELECT * FROM peliculas")
            results = cursor.fetchall()

            return jsonify(results)
    except Exception as e:
        return jsonify({"error": str(e)})
    
@app.route("/pelis/<int:id>", methods=["PUT"])
def update_pelis(id):
    try:
        data = request.get_json()
        nombre = data.get('nombre')
        peliculascol = data.get('peliculascol')  # Asegúrate de usar el nombre correcto

        if nombre is None or peliculascol is None:
            return jsonify({"error": "El nombre y peliculascol son requeridos"}), 400

        with db_conn.cursor() as cursor:
            cursor.execute("UPDATE peliculas SET nombre = %s, peliculascol = %s WHERE idpeliculas = %s", (nombre, peliculascol, id))
            db_conn.commit()

        return jsonify({'mensaje': f'La peli {nombre} ha sido actualizada correctamente'})
    except Exception as e:
        return jsonify({"error": str(e)})

@app.route("/inserta_pelis", methods=['POST'])
def insert_peli():
    try:
        data = request.get_json()
        nombre = data.get('nombre')
        col = data.get('peliculascol')
        with db_conn.cursor() as cursor:
            cursor.execute("INSERT INTO peliculas (nombre, peliculascol) VALUES (%s, %s)", (nombre, col))
            db_conn.commit()
        return jsonify({'mensaje': f'La peli {nombre} ha sido cargada correctamente'})
    except Exception as e:
        return jsonify({'error': str(e)})

@app.route("/pelis/<int:id>", methods=["DELETE"])
def delete_pelis(id):
    try:
        with db_conn.cursor() as cursor:
            cursor.execute("DELETE FROM peliculas WHERE idpeliculas = %s", (id))
            db_conn.commit()
        return jsonify({'mensaje': f'La peli ha sido borrada'})
    except Exception as e:
        return jsonify({"error": str(e)})



if __name__ == "__main__":
    app.run(debug=True)
