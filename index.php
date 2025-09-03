<?php
// ===== Salida y CORS =====
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { exit; }

ob_start();
ini_set('display_errors', '0');    // no mezclar errores con JSON
error_reporting(E_ALL);

$debug = isset($_GET['debug']);

// ===== Capturar FATALES (500) y devolverlos como JSON =====
register_shutdown_function(function () use ($debug) {
  $e = error_get_last();
  if ($e && in_array($e['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
    while (ob_get_level() > 0) ob_end_clean();
    http_response_code(500);
    echo json_encode([
      'fatal'   => true,
      'type'    => $e['type'],
      'file'    => $e['file'],
      'line'    => $e['line'],
      'message' => $e['message'],
    ], JSON_UNESCAPED_UNICODE);
  }
});

// ===== Carga núcleo (TUS rutas reales) =====
require_once __DIR__ . '/Config/conexion.php';
require_once __DIR__ . '/Core/Container.php';
require_once __DIR__ . '/Core/Router.php';

// ===== Construcción =====
$db        = getConexion();
$container = new Container($db);
$router    = new Router($container);

// ===== Entrada =====
$tipo   = isset($_GET['tipo']) ? strtolower(trim($_GET['tipo'])) : '';
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

$raw  = file_get_contents('php://input');
$data = null;
if ($raw !== false && strlen($raw)) {
  $tmp = json_decode($raw, true);
  if (json_last_error() === JSON_ERROR_NONE) $data = $tmp;
}
if ($data === null && !empty($_POST)) $data = $_POST; // fallback form-data

try {
  $result = $router->dispatch($tipo, $method, $data);
  if ($result === null) $result = ['error' => 'Sin contenido'];

  $stray = ob_get_clean();      // lo que se imprimió por accidente
  while (ob_get_level() > 0) ob_end_clean();

  if ($debug) {
    echo json_encode([
      '_debug' => [
        'method' => $method,
        'tipo'   => $tipo,
        'raw'    => $raw,
        'data'   => $data,
        'stray'  => $stray,
      ],
      'result' => $result,
    ], JSON_UNESCAPED_UNICODE);
  } else {
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
  }
} catch (Throwable $e) {
  while (ob_get_level() > 0) ob_end_clean();
  http_response_code(500);
  echo json_encode([
    'error'   => 'Excepción en servidor',
    'message' => $e->getMessage(),
  ], JSON_UNESCAPED_UNICODE);
}
