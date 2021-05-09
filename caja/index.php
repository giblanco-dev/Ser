<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: ../index.php');
    exit();
}elseif($_SESSION['nivel'] == 1 OR $_SESSION['nivel'] == 3){
            $id_user = $_SESSION['id'];
            $usuario = $_SESSION['name_usuario'];
            $nivel = $_SESSION['nivel'];
}else{
    header('Location: ../index.php');
    exit();
}   
include_once 'caja_sections.php';
include_once '../app/logic/conn.php';


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
            <h4>Caja</h4>
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
                <table>
                    <thead>
                        <tr>
                            <th class="center-align" colspan="4">Citas del <?php echo date("d/m/Y", strtotime($hoy)); ?></th>
                            <th class="center-align"><a href="http://localhost/ser/caja/">Actualizar <i class="material-icons">autorenew</i> </a></th>
                        </tr>
                        <tr>
                            <th>Paciente</th>
                            <th>No. Cita</th>
                            <th>Médico</th>
                            <th>Tipo</th>
                            <th colspan="2"></th>
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
                            if($citas_dia['confirma'] == 2 && $citas_dia['consulta'] == 0){
                                echo '
                                <td><div class="chip yellow darken-3 white-text">Asistencia</div></td>
                                <td><div class="chip">Consulta</div></td>
                                <td><div class="chip">Caja</div></td>
                                ';
                            }
                            if($citas_dia['confirma'] == 2 && $citas_dia['consulta'] == 1){
                                echo '
                                <td><div class="chip yellow darken-3 white-text">Asistencia</div></td>
                                <td><div class="chip  red darken-1 white-text"><a class="white-text" href="receta/?cita='.$citas_dia['id_cita'].'">Consulta</a></div></td>
                                <td><div class="chip">Caja</div></td>
                                ';
                            }
                            if($citas_dia['confirma'] == 1){
                                echo '
                                <td><div class="chip black"><a class="white-text" href="logic_recep/estatus_cita.php?asistencia='.$citas_dia['id_cita'].'&m='.$citas_dia['medico'].'">Asistencia</a></div></td>
                                <td><div class="chip grey darken-1"><a class="white-text" href="logic_recep/estatus_cita.php?cancela='.$citas_dia['id_cita'].'">Cancelar</a></div></td>
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
        <a href="http://localhost/ser/recep/" class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
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