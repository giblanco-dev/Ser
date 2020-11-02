<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: ../index.php');
    exit();
}elseif($_SESSION['nivel'] == 1 OR $_SESSION['nivel'] == 7){
            $id_user = $_SESSION['id'];
            $usuario = $_SESSION['name_usuario'];
            $nivel = $_SESSION['nivel'];
}else{
    header('Location: ../index.php');
    exit();
}
include_once 'recep_sections.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="shortcut icon" href="../static/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../static/css/materialize.css">
    <link rel="stylesheet" href="../static/icons/iconfont/material-icons.css">
    <script src="../js/static/materialize.js"></script>
    <script type="text/javascript" src="../static/js/jquery-3.3.1.min.js"></script>
</head>
<body>
<?php echo $nav_recep;  ?>

<?php echo $footer_recep;  ?>
</body>
</html>