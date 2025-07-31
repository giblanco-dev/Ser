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
require '../app/logic/conn.php';
include_once 'recep_sections.php';
$error = '';
if(!empty($_POST)){
    $nombres = trim(ucwords(($_POST['nombres'])));
    $a_paterno = trim(ucwords(($_POST['a_paterno'])));
    $a_materno = trim(ucwords(($_POST['a_materno'])));
    $genero = $_POST['genero'];
    $calle = ucwords(($_POST['calle']));
    $num_domicilio = $_POST['num_domicilio'];
    $colonia = ucwords(($_POST['colonia']));
    $cod_postal = $_POST['cod_postal'];
    $muni_alcaldia = ucwords(($_POST['muni_alcaldia']));
    $estado = $_POST['estado'];
    $tel_recados = $_POST['tel_recados'];
    $tel_casa = $_POST['tel_casa'];
    $tel_movil = $_POST['tel_movil'];
    $tel_oficina = $_POST['tel_oficina'];
    $ext_tel = $_POST['ext_tel'];
    $email = $_POST['email'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $ocupacion = ucwords(($_POST['ocupacion']));
    $nombre_titular = ucwords(($_POST['nombre_titular']));
    $fecha_alta = $_POST['fecha_alta'];
    $usuario_captura = $_POST['usuario_captura'];

    $sql_validacion = "SELECT  nombres, a_paterno  FROM paciente WHERE nombres = '$nombres' AND a_paterno = '$a_paterno' AND a_materno = '$a_materno';";
    $result_sql_validacion = $mysqli -> query($sql_validacion);
    $registros = $result_sql_validacion -> num_rows;


    if($registros == 0){
        $sql_save_paciente = "INSERT INTO paciente(id_paciente, nombres, a_paterno, a_materno, fecha_captura, genero, calle, num_domicilio, colonia,
            cod_postal, muni_alcaldia, estado, tel_recados, tel_casa, tel_movil, tel_oficina, ext_tel, email, fecha_nacimiento, ocupacion,
            nombre_titular, fecha_alta, usuario_captura) VALUES ( NULL, '$nombres', '$a_paterno','$a_materno',CURRENT_TIMESTAMP,'$genero',
        '$calle','$num_domicilio','$colonia','$cod_postal','$muni_alcaldia','$estado','$tel_recados','$tel_casa','$tel_movil','$tel_oficina',
        '$ext_tel','$email','$fecha_nacimiento','$ocupacion','$nombre_titular','$fecha_alta','$usuario_captura');";
            
            if ($mysqli->query($sql_save_paciente) === TRUE) {
                //echo '<script type="text/javascript" async="async">alert("El paciente registro correctamente");window.location.href="../"</script>';
                $continua = 1;
                $titulo = 'Paciente registrado';
            } else {
                //echo '<script type="text/javascript" async="async">alert("Ha ocurrido un error, intente nuevamente \n , de lo contrario contacte con el administrador del sistema");window.location.href="../"</script>';
                $continua = 0;
                $titulo = 'Error';
            }
        
        }else{
            $titulo = 'Registro duplicado';
            $continua = 2;
            $pacientes_duplicados = $result_sql_validacion;
        }
    }else{
        $titulo = "Error";
        $error = '
        <h3 style="color: red; margin-top; 800px;">No se ha recibido ninguna petición de alta de usuarios</h3>
        ';
    }

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo; ?></title>
    <link rel="stylesheet" href="../static/css/materialize.css">
    <link rel="stylesheet" href="../static/icons/iconfont/material-icons.css">
    <script type="text/javascript" src="../static/js/jquery-3.3.1.min.js"></script>
    <script src="../static/js/materialize.js"></script>
</head>
<body>
<?php echo $nav_recep;  ?>
    <div class="container">
        <div class="row">
            <div class="col s12">
            <h4 style="color: #2d83a0; font-weight:bold;"><?php echo $titulo; ?></h4>
            <div class="divider"></div>
            <?php echo $error; ?>
            </div>
        </div>
    <?php if($continua == 1 AND $error == ''){  
        ?>
        <div class="row">
            <div class="col s12">
                <p>Listo! Paciente dado de alta correctamente</p>
            </div>
        </div>
        <div class="row center-align">
            <div class="col s12">
            <form action="captura_hcg.php" method="POST">  
                <input type="hidden" name="nombres" value="<?php echo $nombres ?>">
                <input type="hidden" name="a_paterno" value="<?php echo $a_paterno ?>">
                <input type="hidden" name="fecha_nacimiento" value="<?php echo $fecha_nacimiento ?>">
                <input type="hidden" name="tel_movil" value="<?php echo $tel_movil ?>">
                <button class="btn waves-effect waves-light btn-large" type="submit" name="action">Capturar Historia Clínica General
                <i class="material-icons right">accessibility</i>
                </button>
            </form>
            <br>
            <p>De lo contrario clic en Inicio</p>
            </div>
        </div>
    <?php
        }elseif($continua == 0 AND $error == ''){
            echo '<h3 style="color: red; margin-top; 800px;">No se ha podido guardar el registro
                  <br>Intentetelo de nuevo o contacte al administrador del sistema</h3>';
        }elseif($continua == 2 AND $error == ''){    ?>
            <div class="row center-align">
                <div class="col s12">
                    <h3 style="color: red; font-weight: 'bold'">Existen <?php echo $registros; ?> duplicados</h3>
                </div>
            </div>

        <?php    }
        ?>
    </div>
    <div style="margin-top: 30%;"></div>

<!-- Modal Nueva Cita -->
<div id="modal1" class="modal modal-fixed-footer" style="height: 100%;">
      <div class="modal-content">
        <h4>Nueva Cita</h4>
        <iframe frameborder="0" allowFullScreen="true" src="cita.php" style="width: 100%; height: 100%;"></iframe>

      </div>
      <div class="modal-footer">
        <a href="#" class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
      </div>
    </div>

<?php echo $footer_recep;  ?>
<script>
    $(document).ready(function(){
    $('.modal').modal();
  });
</script>
</body>
</html>