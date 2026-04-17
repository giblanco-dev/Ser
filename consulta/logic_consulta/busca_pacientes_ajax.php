<?php
session_start();

// Validar que el usuario está autenticado
if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'mensaje' => 'Sesión no válida']);
    exit();
}

// Validar que tiene permiso (nivel 1 o 2)
if ($_SESSION['nivel'] != 1 AND $_SESSION['nivel'] != 2) {
    echo json_encode(['success' => false, 'mensaje' => 'Permiso denegado']);
    exit();
}

// Incluir la conexión a la base de datos
include_once '../../app/logic/conn.php';

// Obtener el parámetro de búsqueda
$busqueda = isset($_POST['busqueda']) ? trim($_POST['busqueda']) : '';

// Validar que tenga al menos 3 caracteres
if (strlen($busqueda) < 3) {
    echo json_encode(['success' => false, 'mensaje' => 'Ingresa al menos 3 caracteres']);
    exit();
}

// Sanitizar la entrada
$busqueda = $mysqli->real_escape_string($busqueda);

// Construir la consulta SQL para buscar en la tabla busca_pacientes
// Buscamos coincidencias en el nombre del paciente
$sql = "SELECT id_paciente, nom_paciente 
        FROM busca_pacientes 
        WHERE nom_paciente LIKE '%$busqueda%' 
        ORDER BY nom_paciente ASC 
        LIMIT 20";

$resultado = $mysqli->query($sql);

if (!$resultado) {
    echo json_encode(['success' => false, 'mensaje' => 'Error en la consulta: ' . $mysqli->error]);
    exit();
}

// Obtener los resultados
$pacientes = [];
while ($fila = $resultado->fetch_assoc()) {
    $pacientes[] = [
        'id_paciente' => $fila['id_paciente'],
        'nom_paciente' => $fila['nom_paciente']
    ];
}

// Retornar los resultados en JSON
echo json_encode([
    'success' => true,
    'resultados' => $pacientes,
    'total' => count($pacientes)
]);

$resultado->free();
$mysqli->close();
?>
