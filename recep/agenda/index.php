<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: ../../../index.php');
    exit();
} elseif ($_SESSION['nivel'] == 1 or $_SESSION['nivel'] == 7) {
    $id_user = $_SESSION['id'];
    $usuario = $_SESSION['name_usuario'];
    $nivel = $_SESSION['nivel'];
    $agenda = $_SESSION['agenda'];
} else {
    header('Location: ../../../index.php');
    exit();
}
include_once '../recep_sections.php';
include_once '../../app/logic/conn.php';

$val_res_cita_snagenda = 0;

$sql_medico = "SELECT id, concat(nombre,' ',apellido) medico FROM user WHERE nivel = 'medico' and id in (5,6,7) ORDER BY medico";
$result_sql_medico = $mysqli -> query($sql_medico);
$despliega = 0;

if(!empty($_POST)){

    $id_medico = $_POST['medico'];
    $fecha = $_POST['fecha'];
    $despliega = 1;

    $sql_cita_snagenda = "SELECT
    cita.medico IdDr
    , CAL.NumDiaSemana NumDiaSemana
    , cita.horario Horario
    , cita.fecha FechaAgenda
    , cita.id_paciente
    , IF(PA.tel_movil = '' OR PA.tel_movil = NULL OR PA.tel_movil = ' ',PA.tel_casa, PA.tel_movil) telefono
    , CONCAT(PA.nombres,' ',PA.a_paterno,' ',PA.a_materno) Paciente 
    , cita.id_cita
    , cita.id_agenda
    , cita.confirma
    , cita.pagado
    , cita.folio
    , caja.abono monto_cita
    FROM cita
    INNER JOIN paciente PA ON cita.id_paciente = PA.id_paciente
    INNER JOIN ag_calendario CAL ON cita.fecha = CAL.Fecha
    INNER JOIN caja ON cita.id_cita = caja.id_cita
    WHERE cita.medico = $id_medico AND cita.fecha = '$fecha' AND confirma = 2 AND pagado  = 1 AND cita.id_agenda IS NULL;";
    
    $res_cita_snagenda = $mysqli->query($sql_cita_snagenda);
    $val_res_cita_snagenda = $res_cita_snagenda->num_rows;

}elseif(!empty($_GET)){
    $id_medico = $_GET['medico'];
    $fecha = $_GET['fecha'];
    $despliega = 1;

    $sql_cita_snagenda = "SELECT
    cita.medico IdDr
    , CAL.NumDiaSemana NumDiaSemana
    , cita.horario Horario
    , cita.fecha FechaAgenda
    , cita.id_paciente
    , IF(PA.tel_movil = '' OR PA.tel_movil = NULL OR PA.tel_movil = ' ',PA.tel_casa, PA.tel_movil) telefono
    , CONCAT(PA.nombres,' ',PA.a_paterno,' ',PA.a_materno) Paciente 
    , cita.id_cita
    , cita.id_agenda
    , cita.confirma
    , cita.pagado
    , cita.folio
    , caja.abono monto_cita
    FROM cita
    INNER JOIN paciente PA ON cita.id_paciente = PA.id_paciente
    INNER JOIN ag_calendario CAL ON cita.fecha = CAL.Fecha
    INNER JOIN caja ON cita.id_cita = caja.id_cita
    WHERE cita.medico = $id_medico AND cita.fecha = '$fecha' AND confirma = 2 AND pagado  = 1 AND cita.id_agenda IS NULL;";
    
    $res_cita_snagenda = $mysqli->query($sql_cita_snagenda);
    $val_res_cita_snagenda = $res_cita_snagenda->num_rows;

}



?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda</title>
    <link rel="shortcut icon" href="../../static/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../static/css/materialize.css">
    <link rel="stylesheet" href="../../static/icons/iconfont/material-icons.css">
    <link rel="stylesheet" href="../../static/css/main.css">
    <script type="text/javascript" src="../../static/js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="../../static/js/materialize.js"></script>
    <script src="../../static/js/select2.min.js"></script>
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
<header>
 <div class="navbar-fixed">
 <nav>
    <div class="nav-wrapper">
      <a href="#" class="responsive-img" class="brand-logo"><img src="../../static/img/logo.png" style="max-height: 150px; margin-left: 20px;"></a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
      <li><a href="../"><i class="material-icons right">home</i>Inicio</a></li>
      <li><a href="../../app/logic/logout.php"><i class="material-icons right">close</i>Cerrar Sistema</a></li>
      </ul>
    </div>
  </nav>
 </div>
 </header>
    <div class="container">
        <div class="row center-align">
            <div class="col s12">
                <h5 style="color: #2d83a0; font-weight:bold;">Agenda</h5>
            </div>
        </div>
    </div>
    
    <div class="row" style="width: 98%;">
        <div class="col s3">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <h6>Seleccione el médico</h6>
        <?php
                    while($medicos = mysqli_fetch_assoc($result_sql_medico)){    ?>
                    <p>
                        <label>
                            <input name="medico" type="radio" value="<?php echo $medicos['id']; ?>" />
                            <span><?php echo $medicos['medico']; ?></span>
                        </label>
                        </p>
                <?php    }
                ?>
            <input type="date" placeholder="Seleccione la fecha" name="fecha" required>
                <button style="width: 100%;" class="btn waves-effect waves-light  light-green darken-4" type="submit" name="action">Cargar agenda
                    <i class="material-icons right">date_range</i>
                </button>
            </form>
            <?php if($agenda == 1){ ?>
            <div class="divider" style="margin-top: 30px; margin-bottom: 10px;"></div>
            <a href="admin_calendar.php"class="waves-effect waves-light btn" style="width: 100%;">Administrar Calendario</a>
            <div class="divider" style="margin-top: 10px; margin-bottom: 10px;"></div>
            <a href="admin_horarios.php"class="waves-effect waves-light btn" style="width: 100%;">Administrar Horarios</a>
            <?php } ?>
        </div>
        <div class="col s9">
                    <!--  SECCION DE CARGA DE HORARIOS -->
            
            <?php 
            if($despliega == 1){
            
            $colum_medico = "";
            $name_medico = "";
            switch ($id_medico){
                case 5:
                    $colum_medico = "DrEnrique";
                    $name_medico = "Dr. Enrique";
                    break;
                case 6:
                    $colum_medico = "DrGuillermo";
                    $name_medico = "Dr. Guillermo";
                    break;
                case 7:
                    $colum_medico = "DraAngelica";
                    $name_medico = "Dra. Angélica";
                    break;
                default:
                $colum_medico = "";
            }

              $sql_val_calendario = "SELECT Fecha, Dia, NumDiaSemana, $colum_medico, Festivo, concat(Dia,' ',NumDia,' de ',Mes,' de ',Anio) des_fecha
                                        FROM ag_calendario where Fecha = '$fecha'";
                                        
            //echo $sql_val_calendario;

            $res_calendario = $mysqli->query($sql_val_calendario);
            $val_res_calendario = $res_calendario->num_rows;
            
            if($val_res_calendario == 1){

                $row_calendario = mysqli_fetch_assoc($res_calendario);

                //echo $row_calendario['Festivo'];
                //echo $row_calendario[$colum_medico];

                if($row_calendario['Festivo'] == 1){
                    echo '<a class="waves-effect waves-light btn yellow darken-2"><i class="material-icons right">error</i>El día seleccionado es festivo</a>';
                }elseif($row_calendario[$colum_medico] == 0){
                    echo '<a class="waves-effect waves-light btn yellow darken-2"><i class="material-icons right">error</i>El médico no opera en el día seleccionado</a>';
                }else{
                    $dia_semana = $row_calendario['NumDiaSemana'];
                    $des_dia_sem = $row_calendario['Dia'];
                    $des_fecha = $row_calendario['des_fecha'];
                    $sql_horarios = "SELECT DISTINCT HOR.IdDr
                                    , HOR.NumDiaSemana
                                    , HOR.Horario
                                    , AG.FechaAgenda
                                    , AG.id_paciente
                                    , AG.telefono
                                    , CONCAT(PA.nombres,' ',PA.a_paterno,' ',PA.a_materno) Paciente
                                    , cita.id_cita
                                    , AG.id_agenda
                                    , cita.confirma
                                    , cita.pagado
                                    , AG.folio
                                    , AG.monto_cita
                                    FROM ag_horarios HOR
                                    LEFT OUTER JOIN agenda AG ON AG.FechaAgenda = '$fecha'
                                        AND HOR.IdDr = AG.medico and HOR.NumDiaSemana = AG.NumDiaSemana
                                        AND HOR.Horario = AG.Horario
                                    LEFT OUTER JOIN paciente PA ON AG.id_paciente = PA.id_paciente
                                    LEFT OUTER JOIN cita ON AG.id_agenda = cita.id_agenda AND AG.id_paciente = cita.id_paciente and cita.confirma != 3
                                    AND AG.medico = cita.medico AND AG.FechaAgenda = cita.fecha
                                    where HOR.NumDiaSemana = $dia_semana and HOR.IdDr = $id_medico
                                    ORDER BY HOR.Horario;";

                    //echo $sql_horarios;
                    $res_horarios = $mysqli->query($sql_horarios);
                    $val_res_horarios = $res_horarios->num_rows;

                    if($val_res_horarios > 0){
                        ?>
                <h5 style="color: #2d83a0; font-weight:bold;"><?php echo $name_medico.':  '.$des_fecha; ?></h5>
                <div class="table-responsive-2">
                <table id="mytable">
                    <thead>
                        <tr>
                            <th>Horario</th>
                            <th>Paciente</th>
                            <th>Teléfono</th>
                            <th>Folio</th>
                            <th>Monto Cita</th>
                            <th colspan="2">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        while($row_horario = mysqli_fetch_assoc($res_horarios)){
                            $id_agenda = $row_horario['id_agenda'];
                            $id_cita = $row_horario['id_cita'];
                        ?>
                        <form action="asigna_agenda.php" method="post">
                        <tr>
                            <td><?php echo $row_horario['Horario']; ?></td>
                            <td><?php if($row_horario['Paciente'] == null){ echo "Horario no asignado"; }else{  echo $row_horario['Paciente'];    } ?>
                            </td>
                            <td><?php echo $row_horario['telefono']; ?></td>
                            <td><?php echo $row_horario['folio']; ?></td>
                            <td><?php echo $row_horario['monto_cita']; ?></td>
                            <?php if($id_cita == null AND $id_agenda == null){ 
                                echo '<input type="hidden" name="op" value="cargar_agenda">';    
                                echo '<td colspan="2"><button class="btn-small waves-effect waves-light  light-green darken-4" type="submit" name="action">Asignar agenda
                                        <i class="material-icons right">save</i>
                                        </button></td>';
                            }elseif($id_cita == null AND $id_agenda != null){
                                echo'<td><a href="libera_agenda.php?iag='.$id_agenda.'&m='.$id_medico.'&fa='.$fecha.'" class="btn-small waves-effect waves-light amber darken-4">Liberar agenda
                                        <i class="material-icons right">remove_circle</i>
                                        </a></td>';
                                echo'<td><a href="asigna_cita.php?iag='.$id_agenda.'&m='.$id_medico.'&fa='.$fecha.'" class="btn-small waves-effect waves-light  light-blue darken-3">Crear cita
                                      <i class="material-icons right">check_circle</i>
                                      </a></td>';
                            }elseif($id_agenda != null AND $id_cita != null){
                                if($row_horario['confirma'] == 1){
                                    echo'<td colspan="2"><a href="libera_cita_ag.php?iag='.$id_agenda.'&m='.$id_medico.'&fa='.$fecha.'&c='.$id_cita.'" class="btn-small waves-effect waves-light amber darken-4">Liberar cita/agenda
                                        <i class="material-icons right">remove_circle</i>
                                        </a></td>';
                                }elseif($row_horario['confirma'] == 2 and $row_horario['pagado'] == 1){
        
                                    echo'<td colspan="2"><a href="upd_folio.php?iag='.$id_agenda.'&m='.$id_medico.'&fa='.$fecha.'&c='.$id_cita.'" class="btn-small waves-effect waves-light amber darken-4">Actualizar Folio
                                        <i class="material-icons right">monetization_on</i>
                                        </a></td>';
                                 }elseif($row_horario['confirma'] == 2 and $row_horario['pagado'] == 0){
                                    echo'<td>Cita en proceso</td>';
                                    echo'<td><a href="upd_folio.php?iag='.$id_agenda.'&m='.$id_medico.'&fa='.$fecha.'&c='.$id_cita.'" class="btn-small waves-effect waves-light amber darken-4">Actualizar Folio
                                        <i class="material-icons right">monetization_on</i>
                                        </a></td>';
                                 }
                            }
                            ?>
                            
                            <input type="hidden" name="fecha" value="<?php echo $fecha; ?>">
                            <input type="hidden" name="horario" value="<?php echo $row_horario['Horario']; ?>">
                            <input type="hidden" name="medico" value="<?php echo $id_medico; ?>">
                            <input type="hidden" name="num_dia" value="<?php echo $dia_semana; ?>">
                            <input type="hidden" name="des_dia" value="<?php echo $des_dia_sem; ?>">
                            <input type="hidden" name="name_medico" value="<?php echo $name_medico; ?>">
                            <input type="hidden" name="des_fecha" value="<?php echo $des_fecha; ?>">
                            <input type="hidden" name="flag" value="0">
                        
                        </tr>
                        </form>
                        <?php
                    }   
                    
                    if($val_res_cita_snagenda > 0){
                        echo '<tr><td colspan="7" style="background-color: #f0f0f0;">Citas sin agenda</td></tr>';
                        while($row_cita_snagenda = mysqli_fetch_assoc($res_cita_snagenda)){
                            $id_citasnagenda = $row_cita_snagenda['id_cita'];
                            ?>
                            <tr>
                            <td><?php echo $row_cita_snagenda['Horario']; ?></td>
                            <td><?php echo $row_cita_snagenda['Paciente']; ?></td>
                            <td><?php echo $row_cita_snagenda['telefono']; ?></td>
                            <td><?php echo $row_cita_snagenda['folio']; ?></td>
                            <td><?php echo $row_cita_snagenda['monto_cita']; ?></td>
                            <td colspan="2"><a href="upd_folio.php?iag=sna&m=<?php echo $id_medico; ?>&fa=<?php echo $fecha; ?>&c=<?php echo $id_citasnagenda; ?>" class="btn-small waves-effect waves-light amber darken-4">Actualizar Folio
                                        <i class="material-icons right">monetization_on</i>
                                        </a></td>
                            </tr>
                            <?php
                        }
                    }
                    
                    ?>   

                    </tbody>
                </table>

                </div>
                    
                       <?php

                    }

                }

            }else{

            }
            }
            ?>
        </div>   
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
           setTimeout(() => {
                location.reload();
            }, 60000); // Se actualiza cada 5 segundos

        </script>
</body>
</html>