<?php
/**
 * Configuración central del proyecto MiEscuela.
 *
 * Antes estos valores estaban repetidos en cada vista y clase.
 * Si necesitás cambiar la API o las credenciales, hacelo solo acá.
 */

// Base de la API (GODD)
define('API_BASE_URL', 'http://100.65.8.133:3000/godd/alumno');

// Credenciales de la API
define('API_CLIENT_ID', 'godd');
define('API_SECRET', '249db411dc038e06a');

// Endpoints derivados
define('API_URL_MATRICULA', API_BASE_URL . '/matricula');
define('API_URL_PRESENTISMO', API_BASE_URL . '/presentismo_x_cue_x_dia_v2');
