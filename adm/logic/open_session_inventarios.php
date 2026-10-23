<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['nivel'] != 7) {
    header('Location: ../../index.php');
    exit();
}

require_once '../../app/logic/conn.php';

$id_user = $_SESSION['id'];
$sql_user = "SELECT usuario FROM user WHERE id = '$id_user'";
$result_user = $mysqli->query($sql_user);

if (!$result_user || $result_user->num_rows !== 1) {
    header('Location: ../index.php');
    exit();
}

$row_user = $result_user->fetch_assoc();

$erp_user_id = $id_user;
$username = $row_user['usuario'];
$nombre_completo = $_SESSION['name_usuario'];
$rol = 'Administrador';
$token = bin2hex(random_bytes(32));

require_once '../../app/logic/conn_inventario.php';

$stmt = $mysqli->prepare(
    "INSERT INTO sso_tokens (token, erp_user_id, username, nombre_completo, rol, expires_at)
     VALUES (?, ?, ?, ?, ?, NOW() + INTERVAL 60 SECOND)"
);
$stmt->bind_param('sssss', $token, $erp_user_id, $username, $nombre_completo, $rol);
$stmt->execute();
$stmt->close();

$puerto_inventarios = 8080;
$host = $_SERVER['SERVER_NAME'];
$url_inventarios = "http://{$host}:{$puerto_inventarios}/Ser-Inventarios/auth/sso?token={$token}";

header("Location: {$url_inventarios}", true, 302);
exit();
