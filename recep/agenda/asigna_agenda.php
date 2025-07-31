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
    header('Location: ../../../index.php');
    exit();
}

$mensaje = '';
$continua = 99999;

include_once '../../app/logic/conn.php';


if(!empty($_POST))
{
$fecha_agenda = $_POST['fecha'];
$horario = $_POST['horario'];
$medico = $_POST['medico'];
$num_dia = $_POST['num_dia'];
$des_dia = $_POST['des_dia'];
$name_medico = $_POST['name_medico'];
$des_fecha = $_POST['des_fecha'];

if($_POST['flag'] == 1 and $_POST['new_paciente'] == 0){
    $id_paciente = $_POST['paciente'];
    $tel_agenda = $_POST['tel'];

    if($id_paciente != 0){
        $sql_insert_agenda = "INSERT INTO agenda(FechaAgenda, medico, id_paciente, Horario, telefono, 
                                                user_registra, fecha_registro, NumDiaSemana, Dia) 
                                    VALUES ('$fecha_agenda','$medico','$id_paciente','$horario','$tel_agenda',
                                            '$id_user',now(),$num_dia,'$des_dia')";
        if($mysqli->query($sql_insert_agenda) === true){    
            header('Location: ../agenda?medico='.$medico.'&fecha='.$fecha_agenda);                    
        }else{
            echo '<script>alert("Error no se pudo guardar la agenda");
                    window.location.href="../agenda?medico='.$medico.'&fecha='.$fecha_agenda.'";</script>';
            
        }
    }

}elseif($_POST['flag'] == 1 and $_POST['new_paciente'] == 1){

    $nombre_nvo = $_POST['nombres'];
    $apaterno = $_POST['apaterno'];
    $amaterno = $_POST['amaterno'];
    $genero = $_POST['genero'];
    $tel_new = $_POST['tel_new'];

    $sql_validacion = "SELECT  nombres, a_paterno  FROM paciente WHERE nombres = '$nombre_nvo' AND a_paterno = '$apaterno' AND a_materno = '$amaterno';";
    $result_sql_validacion = $mysqli -> query($sql_validacion);
    $registros = $result_sql_validacion -> num_rows;


    if($registros == 0){
        $sql_save_paciente = "INSERT INTO paciente(id_paciente, nombres, a_paterno, a_materno, fecha_captura, genero, calle, num_domicilio, colonia,
            cod_postal, muni_alcaldia, estado, tel_recados, tel_casa, tel_movil, tel_oficina, ext_tel, email, fecha_nacimiento, ocupacion,
            nombre_titular, fecha_alta, usuario_captura) VALUES ( NULL, '$nombre_nvo', '$apaterno','$amaterno',CURRENT_TIMESTAMP,'$genero',
        'Pendiente','Pendiente','Pendiente','Pendiente','Pendiente','Pendiente','Pendiente','Pendiente','$tel_new','Pendiente',
        'Pendiente','Pendiente',NULL,'Pendiente','Pendiente',NOW(),'$id_user');";
            
            if ($mysqli->query($sql_save_paciente) === TRUE) {
                $continua = 1;
                $id_paciente_new = $mysqli->insert_id;
            } else {
                echo '<script>alert("Error no se pudo guardar el paciente");
                    window.location.href="../agenda?medico='.$medico.'&fecha='.$fecha_agenda.'";</script>';
            }
        
        }else{
            echo '<script>alert("Error el paciente ya existe");
                    window.location.href="../agenda?medico='.$medico.'&fecha='.$fecha_agenda.'";</script>';
        }

    if($continua == 1){
        $sql_insert_agenda = "INSERT INTO agenda(FechaAgenda, medico, id_paciente, Horario, telefono, 
                                                user_registra, fecha_registro, NumDiaSemana, Dia) 
                                    VALUES ('$fecha_agenda','$medico','$id_paciente_new','$horario','$tel_new',
                                            '$id_user',now(),$num_dia,'$des_dia')";
        if($mysqli->query($sql_insert_agenda) === true){    
            header('Location: ../agenda?medico='.$medico.'&fecha='.$fecha_agenda);                    
        }else{
            echo '<script>alert("Error no se pudo guardar la agenda");
                    window.location.href="../agenda?medico='.$medico.'&fecha='.$fecha_agenda.'";</script>';
            
        }

    }
}
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asigna Agenda</title>
    <link rel="shortcut icon" href="../../static/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="../../static/css/select2.min.css">
    <link rel="stylesheet" href="../../static/css/materialize.css">
    <link rel="stylesheet" href="../../static/icons/iconfont/material-icons.css">
    <link rel="stylesheet" href="../../static/css/main.css">
    <script type="text/javascript" src="../../static/js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="../../static/js/materialize.js"></script>
    <script src="../../static/js/select2.min.js"></script>
</head>
<body>
<header>
 <div class="navbar-fixed">
 <nav>
    <div class="nav-wrapper">
      <a href="#" class="responsive-img" class="brand-logo"><img src="../../static/img/logo.png" style="max-height: 150px; margin-left: 20px;"></a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
      <!--li><a href="../"><i class="material-icons right">home</i>Inicio</a></li-->
      <li><a href="../agenda?medico=<?php echo $medico; ?>&fecha=<?php echo $fecha_agenda; ?>"><i class="material-icons right">arrow_back</i>Regresar</a></li>
      <!--li><a href="../../app/logic/logout.php"><i class="material-icons right">close</i>Cerrar Sistema</a></li-->
      </ul>
    </div>
  </nav>
 </div>
 </header>
<div class="container">

    <div class="row">
       
        <div class="col s12">
            <div class="center-align">
                <h5 style="color: #2d83a0; font-weight:bold;">Asignar agenda para el <?php echo $name_medico;?> a las <?php echo $horario; ?><br> 
                el <?php echo $des_fecha; ?>
                </h5>
            </div>
        </div>
    </div>
            <br>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="row">
                <div class="col s5">
                        <label>Selecciona Paciente</label>
                        <br><br>
                        <select id='buscador' style='width:300px;' name="paciente">
                            <option value='0'> Buscar paciente </option>
                        </select>
                </div>
                <div class="input-field col s4">
                    <br>
                    <input placeholder="Capturé Teléfono" id="tel1"  type="tel" class="validate" name="tel" autocomplete="ÑÖcompletes">
                    <label for="tel1">Teléfono de Contacto Agenda</label>
                </div>
                <div class="s3 center-align">
                    <button class="btn waves-effect waves-light" type="submit" name="action" style="margin-top: 5%;">Guardar Agenda
                        <i class="material-icons right">save</i>
                    </button>
                </div>
            
            </div>
                <input type="hidden" name="flag" value = 1>
                <input type="hidden" name="fecha" value="<?php echo $fecha_agenda; ?>">
                <input type="hidden" name="horario" value="<?php echo $horario; ?>">
                <input type="hidden" name="medico" value="<?php echo $medico; ?>">
                <input type="hidden" name="num_dia" value="<?php echo $num_dia; ?>">
                <input type="hidden" name="des_dia" value="<?php echo $des_dia; ?>">
                <input type="hidden" name="name_medico" value="<?php echo $name_medico; ?>">
                <input type="hidden" name="des_fecha" value="<?php echo $des_fecha; ?>">
                <input type="hidden" name="new_paciente" value="0">
            </form>


            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="row">
                <div class="col s12"><p><b>Nuevo Paciente</b></p>
                <blockquote style="font-size: 12px;">
                        Recuerde haber buscado previamente al paciente, para evitar crear pacientes duplicados.
                    </blockquote>
                </div>
                <div class="input-field col s3">
                    <input placeholder="Captura nombre(s)" id="n1" type="text" class="validate" name="nombres" autocomplete="ÑÖcompletes">
                    <label for="n1">Nombre(s)</label>
                </div>
                <div class="input-field col s3">
                    <input placeholder="Captura apellido paterno" id="ap" type="text" class="validate" name="apaterno" autocomplete="ÑÖcompletes">
                    <label for="ap">Apellido Paterno</label>
                </div>
                <div class="input-field col s3">
                    <input placeholder="Captura apellido materno" id="am"  type="text" class="validate" name="amaterno" autocomplete="ÑÖcompletes">
                    <label for="am">Apellido Materno</label>
                </div>
                <div class="input-field  col s3">
                    <input placeholder="Capturé Teléfono" id="tel1"  type="tel" class="validate" name="tel_new" autocomplete="ÑÖcompletes">
                    <label for="tel1">Teléfono de Contacto Agenda</label>
                </div>
            </div>
                <div class="row">
                <div>
                <p style="font-size: 14px; color:grey;">Seleccione el genéro</p>
                <div class=" col s2">
                    
                    <p style="margin-bottom: 0;">
                    <label>
                        <input name="genero" type="radio" value="Desconocido" checked />
                        <span>Desconocido</span>
                    </label>
                    </p>
                </div>
                <div class=" col s2">
                    <p>
                    <label>
                        <input name="genero" type="radio" value="Femenino" />
                        <span>Femenino</span>
                    </label>
                    </p>
                </div>
                <div class=" col s2">
                    <p>
                    <label>
                        <input name="genero" type="radio" value="Masculino" />
                        <span>Masculino</span>
                    </label>
                    </p>          
                </div>
                </div>
                <div class="col s5 center-align">
                    <button class="btn waves-effect waves-light" type="submit" name="action" style="margin-top: 5%;">Guardar Agenda y Paciente
                        <i class="material-icons right">save</i>
                    </button>
                </div>
                </div>
                <input type="hidden" name="flag" value = 1>
                <input type="hidden" name="fecha" value="<?php echo $fecha_agenda; ?>">
                <input type="hidden" name="horario" value="<?php echo $horario; ?>">
                <input type="hidden" name="medico" value="<?php echo $medico; ?>">
                <input type="hidden" name="num_dia" value="<?php echo $num_dia; ?>">
                <input type="hidden" name="des_dia" value="<?php echo $des_dia; ?>">
                <input type="hidden" name="name_medico" value="<?php echo $name_medico; ?>">
                <input type="hidden" name="des_fecha" value="<?php echo $des_fecha; ?>">
                <input type="hidden" name="new_paciente" value="1">
            </form>
            <br>
            <br>

</div>
<footer class="page-footer">
          <div class="container">
            <div class="row">
              <div class="col l6 s12 center-align">
                <h5 class="white-text">Usuario Activo <br><?php echo $usuario; ?></h5>
              </div>
              <div class="col l4 offset-l2 s12">
                <h5 class="white-text">Contacto</h5>
              </div>
            </div>
          </div>
          <div class="footer-copyright">
            <div class="container">
            © 2024 Copyright
            </div>
          </div>
        </footer>
<script>
        $(document).ready(function(){
            $("#buscador").select2({
                ajax: {
                    url: "../proceso.php",
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
    <script type="text/javascript">
	    function showContent() {
		element = document.getElementById("content");
		check = document.getElementById("extra");
		if (check.checked) {
			element.style.display='block';
		}
		else {
			element.style.display='none';
		}
	}
	</script>
    <script>
</script>
</body>
</html>