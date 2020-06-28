<?php 
session_start();
if (!isset($_SESSION['id']) OR $_SESSION['nivel']!= 7) {
    header('Location: ../');
    exit();
} else {
    $id_session = $_SESSION['id'];
    $user_active = $_SESSION['usuario'];
    $nivel_acceso = $_SESSION['nivel'];
}
echo $id_session,'<br>',$user_active,'<br>',$nivel_acceso;
?>