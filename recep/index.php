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

$sql_medico = "SELECT id, concat(nombre,' ',apellido) medico FROM user WHERE nivel = 'medico' OR id = 2  ORDER BY medico";
$result_sql_medico = $mysqli -> query($sql_medico);

// Información de citas del día

$hoy = date("Y-m-d");

if(!empty($_POST)){
    $id_medico = $_POST['agenda'];
    if($id_medico == 'x'){
        $sql_citas = "SELECT cita.id_cita, cita.id_paciente, paciente.id_paciente, cita.medico,
        CONCAT(paciente.nombres,' ',paciente.a_paterno,' ',paciente.a_materno) Nom_paciente,
        CONCAT(user.nombre,' ',user.apellido) medico_cita, cita.fecha, cita.horario, cita.tipo, tipos_cita.descrip_cita, confirma, consulta, caja, pagado
        FROM cita
        INNER JOIN paciente ON cita.id_paciente = paciente.id_paciente
        INNER JOIN tipos_cita on cita.tipo = tipos_cita.id_tipo_cita
        LEFT JOIN user on cita.medico = user.id
        WHERE cita.fecha = '$hoy' 
        ORDER BY cita.fecha, cita.horario";
    }else{
        $sql_citas = "SELECT cita.id_cita, cita.id_paciente, paciente.id_paciente, cita.medico,
        CONCAT(paciente.nombres,' ',paciente.a_paterno,' ',paciente.a_materno) Nom_paciente,
        CONCAT(user.nombre,' ',user.apellido) medico_cita, cita.fecha, cita.horario, cita.tipo, tipos_cita.descrip_cita, confirma, consulta, caja, pagado
        FROM cita
        INNER JOIN paciente ON cita.id_paciente = paciente.id_paciente
        INNER JOIN tipos_cita on cita.tipo = tipos_cita.id_tipo_cita
        LEFT JOIN user on cita.medico = user.id
        WHERE cita.fecha = '$hoy' AND medico = '$id_medico'
        ORDER BY cita.fecha, cita.horario";
    }
}else{
    $sql_citas = "SELECT cita.id_cita, cita.id_paciente, paciente.id_paciente, cita.medico,
    CONCAT(paciente.nombres,' ',paciente.a_paterno,' ',paciente.a_materno) Nom_paciente,
    CONCAT(user.nombre,' ',user.apellido) medico_cita, cita.fecha, cita.horario, cita.tipo, tipos_cita.descrip_cita, confirma, consulta, caja, pagado
        FROM cita
        INNER JOIN paciente ON cita.id_paciente = paciente.id_paciente
        INNER JOIN tipos_cita on cita.tipo = tipos_cita.id_tipo_cita
        LEFT JOIN user on cita.medico = user.id
        WHERE cita.fecha = '$hoy'
        ORDER BY cita.fecha, cita.horario";

}
$result_sql_citas = $mysqli -> query($sql_citas);
$total_citas = $result_sql_citas -> num_rows;

$citas_confirmadas = 0;
while($contar_citas_confirm = mysqli_fetch_assoc($result_sql_citas)){
    if($contar_citas_confirm['confirma'] == 2){
        $citas_confirmadas ++;
    }
}

$datos_cita = $mysqli -> query($sql_citas);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recepción</title>
    <link rel="shortcut icon" href="../static/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../static/css/materialize.css">
    <link rel="stylesheet" href="../static/icons/iconfont/material-icons.css">
    <script type="text/javascript" src="../static/js/jquery-3.3.1.min.js"></script>
    <script src="../static/js/materialize.js"></script>
    <style type="text/css"> 
        thead tr th { 
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: #ffffff;
        }
    
        .table-responsive-2 { 
            height: 500px; /* Mover a 400 para demostrar el scroll*/
            overflow-y:scroll;
        }
    </style>
</head>
<body>
<?php echo $nav_recep;  ?>
<!-- ***************************** INICIA CONTENIDO ****************************** -->
<div class="row center-align">
    <div class="col s2 grey lighten-3" style="margin-bottom: -20px;"> <!-- ***************************** INICIA BARRA LATERAL ****************************** -->
        <div class="row" style="margin-top: 65px;">
            <div class="col s12">
            <h4>Recepción</h4>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
            <iframe src="../static/clock/clock.html" width="100%" frameborder="0"></iframe> 
            </div>
        </div>
        <div class="row" style="margin-top: -2em;">
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
            <h2 style="color: #424242;"><?php echo $citas_confirmadas; ?> <i class="medium material-icons">check_circle</i></h2>
        <p>Citas Confirmadas</p>
        <h2 style="color: #424242;"><?php echo $total_citas; ?> <i class="medium material-icons">book</i></h2>
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
                <div class="table-responsive-2">
                <table id="mytable">
                    <thead>
                        <tr>
                            <th class="center-align" colspan="4">Citas del <?php echo date("d/m/Y", strtotime($hoy)); ?></th>
                            <th class="center-align"><a href="index.php">Actualizar <i class="material-icons">autorenew</i> </a></th>
                            <th class="center-align" colspan="2">
                            <div class="input-field col s12">
                            <i class="material-icons prefix">search</i>
                            <input id="search" type="text" class="validate" autocomplete="off" >
                            <label for="search">Buscar pacientes</label>
                            </div>
                            </th>
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
                        <?php 
                        while($citas_dia = mysqli_fetch_assoc($datos_cita)){
                        ?>
                        <tr>
                            <td style="text-transform: capitalize;"><?php echo $citas_dia['Nom_paciente']; ?></td>
                            <td style="text-transform: capitalize;"><?php echo $citas_dia['horario']; ?></td>
                            <td style="text-transform: capitalize;"><?php echo $citas_dia['medico_cita']; ?></td>
                            <td style="text-transform: capitalize;"><?php echo $citas_dia['descrip_cita']; ?></td>
                            <?php
                            switch($citas_dia['confirma']){
                                case 1:
                                    echo '
                                        <td><div class="chip black"><a class="white-text" href="logic_recep/estatus_cita.php?asistencia='.$citas_dia['id_cita'].'&m='.$citas_dia['medico'].'">Asistencia</a></div></td>
                                        <td><div class="chip grey darken-1"><a class="white-text" href="logic_recep/estatus_cita.php?cancela='.$citas_dia['id_cita'].'">Cancelar</a></div></td>
                                        ';
                                    break;
                                case 2:
                                    echo '
                                        <td><div class="chip yellow darken-3 white-text">Asistencia</div></td>  ';
                                        // Se evaluan estatus de Consulta
                                        if($citas_dia['consulta'] == 0){
                                            echo '<td><div class="chip ">Sin Consulta</div></td>';
                                        }elseif($citas_dia['consulta'] == 1){
                                            echo'
                                            <td><div class="chip  red darken-1 white-text"><a class="white-text" href="receta/?cita='.$citas_dia['id_cita'].'">Salió Consulta</a></div></td>
                                            ';    
                                        }else{
                                            echo '
                                            <td><div class="chip  red darken-1 white-text"><a class="white-text">Error ponerse en contacto con Sistemas</a></div></td>
                                            ';            
                                        }
                                        // Se valuan estatus de caja
                                        if($citas_dia['caja'] == 0){
                                            echo '<td><div class="chip ">Sin envio Caja</div></td>';
                                        }elseif($citas_dia['caja'] == 1){
                                            echo'
                                            <td><div class="chip  green darken-4 white-text">Enviado Caja</div></td>
                                            ';    
                                        }else{
                                            echo '
                                            <td><div class="chip  red darken-1 white-text"><a class="white-text">Error ponerse en contacto con Sistemas</a></div></td>
                                            ';            
                                        }

                                        // Se valuan estatus de PAGO
                                        if($citas_dia['pagado'] == 0){
                                            echo '<td><div class="chip ">Pago Pendiente</div></td>';
                                        }elseif($citas_dia['pagado'] == 1){
                                            echo'
                                            <td><div class="chip  light-blue darken-4 white-text">Pagado</div></td>
                                            ';    
                                        }else{
                                            echo '
                                            <td><div class="chip  red darken-1 white-text"><a class="white-text">Error ponerse en contacto con Sistemas</a></div></td>
                                            ';            
                                        }
                                        
                                        


                                        
                                    break;
                                case 3:
                                    echo '
                                        <td><div class="chip  orange darken-4 white-text"><a class="white-text">Cancelada</a></div></td>
                                        ';
                                        //<td><div class="chip  red darken-1 white-text"><a class="white-text" href="receta/?cita='.$citas_dia['id_cita'].'">Recativar</a></div></td>
                                    break;
                                default:
                                echo '
                                <td><div class="chip  red darken-1 white-text"><a class="white-text">Error ponerse en contacto con Sistemas</a></div></td>
                                ';
                            }
                        
                                   
                            ?>
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
</div>



<!-- ***************************** TERMINA CONTENIDO ****************************** -->

<!-- ***************************** Modal de creación de Citas ****************************** -->    

  <!-- Modal Nueva Cita -->
  <div id="modal1" class="modal modal-fixed-footer" style="height: 100%;">
      <div class="modal-content">
        <h4>Nueva Cita</h4>
        <iframe frameborder="0" allowFullScreen="true" src="cita.php" style="width: 100%; height: 100%;"></iframe>

      </div>
      <div class="modal-footer">
        <a href="index.php" class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
      </div>
    </div>

<?php echo $footer_recep;  ?>

<script>
    $(document).ready(function(){
    $('.modal').modal();
  });
</script>
<script>
 // Write on keyup event of keyword input element
 $(document).ready(function(){
 $("#search").keyup(function(){
 _this = this;
 // Show only matching TR, hide rest of them
 $.each($("#mytable tbody tr"), function() {
 if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
 $(this).hide();
 else
 $(this).show();
 });
 });
});
</script>
</body>
</html>
