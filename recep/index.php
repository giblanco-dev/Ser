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
include_once '../app/logic/conn.php';

//$sql_pacientes = "SELECT id_paciente, concat(nombres,' ',a_paterno,' ',a_materno) nombre_com FROM paciente";
$sql_pacientes = "SELECT id,nombre from t_paises";
$result_sql_pacientes = $mysqli -> query($sql_pacientes);

$sql_medico = "SELECT id, concat(nombre,' ',apellido) medico FROM user WHERE nivel = 'medico' ORDER BY medico";
$result_sql_medico = $mysqli -> query($sql_medico);

// Información de citas del día

$hoy = date("Y-m-d");

if(!empty($_POST)){
    $id_medico = $_POST['agenda'];
    if($id_medico == 'x'){
        $sql_citas = "SELECT cita.id_cita, cita.id_paciente, paciente.id_paciente, CONCAT(paciente.nombres,' ',paciente.a_paterno,' ',paciente.a_materno) Nom_paciente,CONCAT(user.nombre,' ',user.apellido) medico_cita, cita.fecha, cita.horario, cita.tipo, tipos_cita.descrip_cita
        FROM cita
        INNER JOIN paciente ON cita.id_paciente = paciente.id_paciente
        INNER JOIN tipos_cita on cita.tipo = tipos_cita.id_tipo_cita
        LEFT JOIN user on cita.medico = user.id
        WHERE cita.fecha = '$hoy'
        ORDER BY cita.fecha, cita.horario";
    }else{
        $sql_citas = "SELECT cita.id_cita, cita.id_paciente, paciente.id_paciente, CONCAT(paciente.nombres,' ',paciente.a_paterno,' ',paciente.a_materno) Nom_paciente,CONCAT(user.nombre,' ',user.apellido) medico_cita, cita.fecha, cita.horario, cita.tipo, tipos_cita.descrip_cita
        FROM cita
        INNER JOIN paciente ON cita.id_paciente = paciente.id_paciente
        INNER JOIN tipos_cita on cita.tipo = tipos_cita.id_tipo_cita
        LEFT JOIN user on cita.medico = user.id
        WHERE cita.fecha = '$hoy' AND medico = '$id_medico'
        ORDER BY cita.fecha, cita.horario";
    }
}else{
    $sql_citas = "SELECT cita.id_cita, cita.id_paciente, paciente.id_paciente, CONCAT(paciente.nombres,' ',paciente.a_paterno,' ',paciente.a_materno) Nom_paciente,CONCAT(user.nombre,' ',user.apellido) medico_cita, cita.fecha, cita.horario, cita.tipo, tipos_cita.descrip_cita
        FROM cita
        INNER JOIN paciente ON cita.id_paciente = paciente.id_paciente
        INNER JOIN tipos_cita on cita.tipo = tipos_cita.id_tipo_cita
        LEFT JOIN user on cita.medico = user.id
        WHERE cita.fecha = '$hoy'
        ORDER BY cita.fecha, cita.horario";

}
$result_sql_citas = $mysqli -> query($sql_citas);
$total_citas = $result_sql_citas -> num_rows;

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recepción</title>
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/materialize.css">
    <link rel="stylesheet" href="../icons/iconfont/material-icons.css">
    <script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/materialize.js"></script>
</head>
<body>
<?php echo $nav_recep;  ?>
<!-- ***************************** INICIA CONTENIDO ****************************** -->
<div class="row center-align">
    <div class="col s2 grey lighten-3" style="margin-bottom: -20px;"> <!-- ***************************** INICIA BARRA LATERAL ****************************** -->
        <div class="row" style="margin-top: 100px;">
            <div class="col s12">
            <h4>Recepción</h4>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
            <iframe src="https://www.zeitverschiebung.net/clock-widget-iframe-v2?language=es&size=large&timezone=America%2FMexico_City" width="100%" height="125" frameborder="0" seamless></iframe> 
            </div>
        </div>
        <div class="row">
            <div class="col s12">
            <ul class="collection with-header">
            <li class="collection-item">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" >
                        <input type="hidden" name="agenda" value="x" >
                        <input type="submit" value="Todas las citas" style="border: navajowhite; background-color: #fff; ">
                    </form>
                </li>
                <?php
                    while($medicos = mysqli_fetch_assoc($result_sql_medico)){    ?>
                    <li class="collection-item">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <input type="hidden" name="agenda" value="<?php echo $medicos['id']; ?>" >
                        <input type="submit" value="<?php echo $medicos['medico']; ?>" style="border: navajowhite; background-color: #fff; ">
                    </form>
                </li>
                <?php    }
                ?>
            </ul>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
            <h2 style="color: #424242;"><?php echo $total_citas; ?> <i class="medium material-icons">check_circle</i></h2>
        <p>Citas Confirmadas</p>
        <h2 style="color: #424242;">00 <i class="medium material-icons">book</i></h2>
        <p>Citas Agendadas</p>
            </div>
        </div>
    </div>
    <div class="col s10"> <!-- ***************************** INICIA CUERPO DEL SISTEMA ****************************** -->
        <div class="row center-align">
            <div class="col s12">
                <h4 style="color: #2d83a0; font-weight:bold;">CONSULTORIO DE MEDICINA ALTERNATIVA SER</h4>
                <div class="divider"></div>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <table>
                    <thead>
                        <tr>
                            <th class="center-align" colspan="4">Citas del <?php echo date("d/m/Y", strtotime($hoy)); ?></th>
                            <th class="center-align"><a href="http://localhost/ser/recep/">Actualizar <i class="material-icons">autorenew</i> </a></th>
                        </tr>
                        <tr>
                            <th>Paciente</th>
                            <th>Horario</th>
                            <th>Médico</th>
                            <th></th>
                            <th colspan="3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($citas_dia = mysqli_fetch_assoc($result_sql_citas)){ ?>
                        <tr>
                            <td style="text-transform: capitalize;"><?php echo $citas_dia['Nom_paciente']; ?></td>
                            <td style="text-transform: capitalize;"><?php echo $citas_dia['horario']; ?></td>
                            <td style="text-transform: capitalize;"><?php echo $citas_dia['medico_cita']; ?></td>
                            <td style="text-transform: capitalize;"><?php echo $citas_dia['descrip_cita']; ?></td>
                            <td><div class="chip">Asistencia</div></td>
                            <td><div class="chip">Terapias</div></td>
                            <td><div class="chip">Caja</div></td>
                        </tr>

                        <?php 
                        }
                        ?>
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
</div>



<!-- ***************************** TERMINA CONTENIDO ****************************** -->

<!-- ***************************** Modal de creación de Citas ****************************** -->    

  <!-- Modal Nueva Cita -->
  <div id="modal1" class="modal modal-fixed-footer" style="height: 620px;">
      <div class="modal-content">
        <h4>Nueva Cita</h4>
        <iframe frameborder="0" allowFullScreen="true" src="cita.php" style="width: 100%; height: 340px;"></iframe>

      </div>
      <div class="modal-footer">
        <a href="http://localhost/ser/recep/" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
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
