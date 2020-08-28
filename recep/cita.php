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

$sql_medico = "SELECT id, concat(nombre,' ',apellido) medico FROM user WHERE nivel = 'medico'";
$result_sql_medico = $mysqli -> query($sql_medico);

if(!empty($_POST))
{
$paciente = $_POST['paciente'];
$fecha_cita = $_POST['fecha_cita'];
$horario = $_POST['horario'];
$medico = $_POST['medico'];

$paciente;
$fecha_cita;
$horario;
$medico;

$sql_val_cita = 'SELECT id_cita FROM citas where ';

}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="../css/select2.min.css">
    <link rel="stylesheet" href="../css/materialize.css">
    <link rel="stylesheet" href="../icons/iconfont/material-icons.css">
    <script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/select2.min.js"></script>
</head>
<body>
<div class="row">
    <div class="col s12">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <div class="row">
        <div class="col s6">
        <label for="pacientes">Selecciona Paciente</label>
        <select id="pacientes" name="paciente" style="width: 100%;">
			<?php while ($pacientes=mysqli_fetch_assoc($result_sql_pacientes)) {?>
			<option value="<?php echo $pacientes['id_paciente']; ?>">
				<?php echo $pacientes['nombre_com'];?>
			</option>
			<?php  }?>
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
    <div class="col s9">
        <p>Asigna la Cita</p>
            <?php while ($medicos=mysqli_fetch_assoc($result_sql_medico)) {?>
                <label>
                <input name="medico" type="radio" value="<?php echo $medicos['id']; ?>" checked />
                <span><?php echo $medicos['medico']; ?></span>
            </label>
			<?php  }?>
        </select>
        </div>
        <div class="col s3">
        <button class="btn waves-effect waves-light" type="submit" name="action" style="margin-top: 30%;">Guardar Cita
            <i class="material-icons right">save</i>
        </button>
        </div>
    </div>    
        </form>
        <div class="row">
        <div class="col s12">
            <p><?php echo $mensaje; ?></p>
        </div>
    </div>  
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#pacientes').select2();
        $('select').formSelect();
	});
</script>
</body>
</html>