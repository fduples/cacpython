from flask import Flask, request, render_template
from flask_smorest import Api, Blueprint


app = Flask(__name__)

class APIConfig:
    API_TITLE = 'TAREAS API'
    API_VERSION = 'v1'
    OPENAPI_VERSION = '3.0.3'
    OPENAPI_URL_PREFIX = '/'
    OPENAPI_SWAGGER_UI_PATH = '/docs'
    OPENAPI_SWAGGER_UI_URL = 'https://cdn.jsdelivr.net/npm/swagger-ui-dist/'
    OPENAPI_REDOC_PATH = '/redoc'
    OPENAPI_REDOC_UI_URL = 'https://cdn.jsdelivr.net/npm/redoc@next/bundles/'

api = Api(app)

tareas = Blueprint('tareas', 'tareas', url_prefix='/tareas', description='TAREAS API')

@app.route('/')
def hola():
    return "Hola Mundo"

@app.route('/contacto')
def contact():
    return "<h1>Contacto de bla@vla.com</h1>\n\n"

@app.route('/login', methods=['GET', 'POST'])
def login():
    if request.method == 'POST':
        return "corroborando logueo"
    return render_template('login.html')

@app.route('/usuario/<username>')
def muestra_usuario(username):
    return f"Bienvenido {username}"

if __name__ == '__main__':
    app.run(debug=True)

