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

include_once '../../app/logic/conn.php';

if(!empty($_GET))
{
$id_agenda = $_GET['iag'];

$medico = $_GET['m'];
$fecha_agenda = $_GET['fa'];
$cita = $_GET['c'];

if($id_agenda != 'sna'){
$sql_data_cita = "SELECT DISTINCT HOR.IdDr
                                    , HOR.NumDiaSemana
                                    , HOR.Horario
                                    , AG.FechaAgenda
                                    , AG.id_paciente
                                    , AG.telefono
                                    , CONCAT(PA.nombres,' ',PA.a_paterno,' ',PA.a_materno) Paciente
                                    , cita.id_cita
                                    , AG.id_agenda
                                    , cita.confirma
                                    , AG.folio
                                    , AG.monto_cita
                                    , caja.abono
                                    , cita.pagado
                                    , caja.status_pago
                                    FROM ag_horarios HOR
                                    LEFT OUTER JOIN agenda AG ON AG.FechaAgenda = '$fecha_agenda'
                                        AND HOR.IdDr = AG.medico and HOR.NumDiaSemana = AG.NumDiaSemana
                                        AND HOR.Horario = AG.Horario
                                    LEFT OUTER JOIN paciente PA ON AG.id_paciente = PA.id_paciente
                                    LEFT OUTER JOIN cita ON AG.id_agenda = cita.id_agenda AND AG.id_paciente = cita.id_paciente and cita.confirma != 3
                                    AND AG.medico = cita.medico AND AG.FechaAgenda = cita.fecha
                                    LEFT OUTER join caja on cita.id_cita = caja.id_cita
                                    where AG.id_agenda = '$id_agenda';";
}else{
 $sql_data_cita = "SELECT
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
, caja.abono 
, caja.status_pago
FROM cita
INNER JOIN paciente PA ON cita.id_paciente = PA.id_paciente
INNER JOIN ag_calendario CAL ON cita.fecha = CAL.Fecha
INNER JOIN caja ON cita.id_cita = caja.id_cita
WHERE cita.id_cita = $cita;";   
}
            //echo $sql_data_cita;

$res_data_cita = $mysqli->query($sql_data_cita);
$val_data_cita = $res_data_cita->num_rows;

if($val_data_cita == 1){
    $row_data_cita = mysqli_fetch_assoc($res_data_cita);
    $paciente = $row_data_cita['Paciente'];
    $horario = $row_data_cita['Horario'];
    $monto = $row_data_cita['abono'];
    $status_pago = $row_data_cita['status_pago'];

    if($status_pago == 'SI'){
        $mensaje_pago = '(El paciente ya liquido el importe de su cita)';
    }else{
        $mensaje_pago = '';   
    }
}
}

if(!empty($_POST)){
    $folio = $_POST['folio'];
    $monto = $_POST['monto'];
    $id_agenda2 = $_POST['iag2'];
    $id_cita2 = $_POST['c2'];
    $medico = $_POST['m2'];
    $fecha_ag = $_POST['fecha2'];

    if($id_agenda2 != 'sna'){
        $sql_upd_fol = "UPDATE agenda SET folio = '$folio', monto_cita = '$monto' WHERE id_agenda = $id_agenda2";
    }else{
        $sql_upd_fol = "UPDATE cita SET folio = '$folio' WHERE id_cita = $id_cita2";    
    }
    


if($mysqli->query($sql_upd_fol) === true){    
    header('Location: ../agenda?medico='.$medico.'&fecha='.$fecha_ag);                   
}else{
    echo '<script>alert("Error no se pudo actualizar el folio y el monto");
            window.location.href="../agenda?medico='.$medico.'&fecha='.$fecha_agenda.'";</script>';
}

}


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asigna Folio/Monto</title>
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
      <li><a href="../"><i class="material-icons right">home</i>Inicio</a></li>
      <li><a href="../agenda?medico=<?php echo $medico; ?>&fecha=<?php echo $fecha_agenda; ?>"><i class="material-icons right">arrow_back</i>Regresar</a></li>
      <li><a href="../../app/logic/logout.php"><i class="material-icons right">close</i>Cerrar Sistema</a></li>
      </ul>
    </div>
  </nav>
 </div>
 </header>
<div class="container">

    <div class="row">
       
        <div class="col s12">
            <div class="center-align">
                <h5 style="color: #2d83a0; font-weight:bold;">Folio y monto de cita <br><br>
                Paciente: <?php echo $paciente;?><br>
                Horario: <?php echo $fecha_agenda; ?> - <?php echo $horario; ?>
                </h5>
            </div>
        </div>
    </div>
            <br>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="row">
                <div class="col s3"></div>
                <div class="input-field col s6">
                <br>
                    <input placeholder="Capture el folio" id="fol"  type="text" class="validate" name="folio" autocomplete="ÑÖcompletes" required>
                    <label for="fol">Folio</label> 
                </div>
                <div class="col s3"></div>
                </div>
                <div class="row">
                <div class="col s3"></div>
                <div class="input-field col s6">
                    <br>
                    <input placeholder="Capture el monto" id="mon"  type="number" class="validate" name="monto" value="<?php echo $monto; ?>" autocomplete="ÑÖcompletes" step="0.01" required>
                    <label for="mon">Monto <?php echo $mensaje_pago; ?></label>
                </div>
                <div class="col s3"></div>
                </div>
                <div class="row">
                <div class="col s3"></div>
                <div class="col s6 center-align">
                    <button class="btn waves-effect waves-light" type="submit" name="action" style="margin-top: 5%;">Guardar Datos
                        <i class="material-icons right">save</i>
                    </button>
                </div>
                <div class="col s3"></div>
                </div>
                <input type="hidden" name="fecha2" value="<?php echo $fecha_agenda; ?>">
                <input type="hidden" name="m2" value="<?php echo $medico; ?>">
                <input type="hidden" name="iag2" value="<?php echo $id_agenda;?>">
                <input type="hidden" name="c2" value="<?php echo $cita;?>">
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
</body>
</html>