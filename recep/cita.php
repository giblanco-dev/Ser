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

$mensaje = '';

include_once '../app/logic/conn.php';
$sql_pacientes = "SELECT id_paciente, concat(nombres,' ',a_paterno,' ',a_materno) nombre_com FROM paciente";
$result_sql_pacientes = $mysqli -> query($sql_pacientes);

$sql_medico = "SELECT id, concat(nombre,' ',apellido) medico FROM user WHERE nivel = 'medico' or id = 2 ORDER BY medico";
$result_sql_medico = $mysqli -> query($sql_medico);

if(!empty($_POST))
{
$paciente = $_POST['paciente'];
$fecha_cita = $_POST['fecha_cita'];
$horario = $_POST['horario'];
$medico = $_POST['medico'];

switch($medico){
    case $medico > 90:
        $medico_cita = 0;
        $tipo_cita = $medico;
    break;
    case 2:
        $medico_cita = $medico;
        $tipo_cita = 90;
    break;
    case 8:
        $medico_cita = $medico;
        $tipo_cita = 90;
    break;
    default:
    $medico_cita = $medico;
    $tipo_cita = 0;
}


if($tipo_cita > 90){
    $sql_val_cita = "SELECT id_cita FROM cita where id_paciente = '$paciente' and fecha = '$fecha_cita' and tipo = '$tipo_cita'";
}else{
    $sql_val_cita = "SELECT id_cita FROM cita where id_paciente = '$paciente' and fecha = '$fecha_cita' and medico = '$medico_cita'";
}

$result_sql_val = $mysqli -> query($sql_val_cita);
$val_cita = $result_sql_val -> num_rows;
if($val_cita > 0){
    $mensaje = '<h4 class="red-text">El paciente ya tiene una cita para el día: '.date("d-m-Y", strtotime($fecha_cita)).'</h4>';
}else{
    if($tipo_cita >= 90){
        $sql_new_cita = "INSERT INTO cita(id_cita, id_paciente, medico, fecha, horario, registrado, user_registra, tipo, confirma, consulta)
        VALUES (NULL, '$paciente', '$medico', '$fecha_cita', '$horario', CURRENT_TIMESTAMP, '$id_user', '$tipo_cita', 1, 1)";
    }else{
        $sql_new_cita = "INSERT INTO cita(id_cita, id_paciente, medico, fecha, horario, registrado, user_registra, tipo, confirma)
    VALUES (NULL, '$paciente', '$medico', '$fecha_cita', '$horario', CURRENT_TIMESTAMP, '$id_user', '$tipo_cita', 1)";
    }

    if($mysqli -> query($sql_new_cita) === true){
        $mensaje = '<h4>Cita registrada correctamente</h4>';
    }else{
        $mensaje = '<h4 class="red-text">Ocurrió un error intentelo nuevamente o contacte al administrador del sistema</h4>';
    }
}
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="shortcut icon" href="../static/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="../static/css/select2.min.css">
    <link rel="stylesheet" href="../static/css/materialize.css">
    <link rel="stylesheet" href="../static/icons/iconfont/material-icons.css">
    <script type="text/javascript" src="../static/js/jquery-3.3.1.min.js"></script>
    <script src="../static/js/select2.min.js"></script>
</head>
<body>
<div class="row">
    <div class="col s12">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <div class="row">
        <div class="col s6">
        <label>Selecciona Paciente</label>
        <select id='buscador' style='width: 200px;' name="paciente">
            <option value='0'> Buscar paciente </option>
        </select>
        </div>
        <div class="col s3">
        <label for="inputs_cita">Fecha de la Cita</label>
        <input id="inputs_cita" type="date" name="fecha_cita" class="validate" required>
        </div>
        <div class="col s3">
        <label for="inputs_cita">Horario</label>
        <input id="inputs_cita" type="time" name="horario" class="validate" required>
        </div>
        
    </div>
    <div class="row">
    <div class="col s12">
        <p>Asigna la Cita</p>
            <?php while ($medicos=mysqli_fetch_assoc($result_sql_medico)) {?>
                <label>
                <input name="medico" type="radio" value="<?php echo $medicos['id']; ?>" required/>
                <span><?php echo $medicos['medico']; ?></span>
                </label>
            <?php  }?>
            <p>Otros</p>
            <label>
                <input name="medico" value="91" type="radio" required/>
                <span>Factor de Crecimiento</span>
            </label>
            <label>
                <input name="medico" value="92" type="radio" required/>
                <span>Pellet</span>
            </label>
        </div>
    </div>
    <div class="row center-align">
        <div class="divider"></div>
    <div class="col s6">
    <button class="btn waves-effect waves-light" type="reset" style="margin-top: 5%;">Limpiar
            <i class="material-icons right">settings_backup_restore</i>
        </button>
    </div>
    <div class="col s6">
        <button class="btn waves-effect waves-light" type="submit" name="action" style="margin-top: 5%;">Guardar Cita
            <i class="material-icons right">save</i>
        </button>
        </div>
    </div>
        </form>
        <div class="row">
        <div class="col s12">
            <?php echo $mensaje; ?>
        </div>
    </div>  
    </div>
</div>
<script>
        $(document).ready(function(){
            $("#buscador").select2({
                ajax: {
                    url: "proceso.php",
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            palabraClave: params.term // search term
                        };
                    },
                    processResults: function (response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });
        });
        </script>
</body>
</html>