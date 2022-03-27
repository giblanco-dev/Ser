<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: ../../index.php');
    exit();
} elseif ($_SESSION['nivel'] == 1 or $_SESSION['nivel'] == 7) {
    $id_user = $_SESSION['id'];
    $usuario = $_SESSION['name_usuario'];
    $nivel = $_SESSION['nivel'];
} else {
    header('Location: ../../index.php');
    exit();
}
include_once '../recep_sections.php';
include_once '../../app/logic/conn.php';

$cita = $_GET['cita'];
$error_1 = '';
$cita_sql = "SELECT 
CONCAT(paciente.nombres,' ',paciente.a_paterno,' ',paciente.a_materno) Nom_paciente, cita.id_paciente,
CONCAT(user.nombre,' ',user.apellido) medico_cita, cita.fecha, cita.horario, cita.tipo, tipos_cita.descrip_cita, cita.caja, cita.pagado
    FROM cita
    INNER JOIN paciente ON cita.id_paciente = paciente.id_paciente
    INNER JOIN tipos_cita on cita.tipo = tipos_cita.id_tipo_cita
    LEFT JOIN user on cita.medico = user.id
    WHERE cita.id_cita = '$cita' and consulta = 1";
$res_cita = $mysqli->query($cita_sql);
$val_cita = $res_cita->num_rows;

if($val_cita == 1){
    $datos_cita = mysqli_fetch_assoc($res_cita);
    $fecha_cita = date("d/m/Y", strtotime($datos_cita['fecha']));
    $paciente = $datos_cita['id_paciente'];
}else{
    $error_1 = '<h5 style="color: red; font-weight:bold;">Hay un error con esta cita, ponerse en contacto con el administrador y proporcionar ID CITA: '.$cita.'</h5>';
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receta Interna</title>
    <link rel="shortcut icon" href="../../static/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../static/css/materialize.css">
    <link rel="stylesheet" href="../../static/icons/iconfont/material-icons.css">
    <link rel="stylesheet" href="../../static/css/main.css">
    <script type="text/javascript" src="../../static/js/jquery-3.3.1.min.js"></script>
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
        <div class="row">
            <div class="col s4">
                <h5 style="color: #2d83a0; font-weight:bold;">RECETA INTERNA</h5><?php echo $error_1; ?>
            </div>
            <div class="col s4">
                <h6>Cita: <?php echo "CMA".$cita?></h6>
                <h6 style="text-transform: capitalize;">Médico: <?php if($datos_cita['tipo'] <= 90){
                  echo $datos_cita['medico_cita'];}else{echo "N/A";} ?></h6>
                <h6>Fecha : <?php echo $fecha_cita; ?> </h6>
            </div>
            <div class="col s4">
            <h6 style="text-transform: capitalize;">Paciente: <?php echo $datos_cita['Nom_paciente']; ?></h6>
                <h6>Tipo de Cita: <?php echo $datos_cita['descrip_cita']; ?></h6>
                
                <h6>Horario: <?php echo $datos_cita['horario']; ?></h6>
                
            </div>
        </div>
    </div>
    
    <?php 
    if($datos_cita['tipo'] == 0){ ?>
    <div class="row center-align" style="width: 98%;">
        <div class="col s2">
        <?php 
        if($datos_cita['pagado'] == 0){   ?>
        <div class="divider" style="margin-top: 10px; margin-bottom: 10px;"></div>
        <a href="terapias.php?c=<?php echo $cita; ?>&u=<?php echo $id_user; ?>" 
        target="frame-cont" class="waves-effect waves-light btn" style="width: 100%;">TERAPIAS</a>
        <div class="divider" style="margin-top: 10px; margin-bottom: 10px;"></div>
        <a href="sueros.php?c=<?php echo $cita; ?>&u=<?php echo $id_user; ?>" target="frame-cont" class="waves-effect waves-light btn" style="width: 100%;">SUEROS</a>
        <div class="divider" style="margin-top: 10px; margin-bottom: 10px;"></div>
        <h6>MEDICAMENTOS HOMEOPÁTICOS</h6>
        <a href="med-homeopaticos.php?c=<?php echo $cita; ?>&u=<?php echo $id_user; ?>&p=<?php echo $paciente; ?>"
        target="frame-cont" class="waves-effect waves-light btn-small" style="width: 80%;">Tratamiento</a>
        <br><br>
        <a href="med_hom_ex.php?c=<?php echo $cita; ?>&u=<?php echo $id_user; ?>&p=<?php echo $paciente; ?>"
        target="frame-cont" class="waves-effect waves-light btn-small" style="width: 80%;">Frascos Extra</a>
        <br><br>
        <a href="flores_bach.php?c=<?php echo $cita; ?>&u=<?php echo $id_user; ?>&p=<?php echo $paciente; ?>"
        target="frame-cont" class="waves-effect waves-light btn-small" style="width: 80%;">Flores de Bach</a>

        <div class="divider" style="margin-top: 10px; margin-bottom: 10px;"></div>
        <a href="med-orales.php?c=<?php echo $cita; ?>&u=<?php echo $id_user; ?>"
        target="frame-cont" class="waves-effect waves-light btn" style="width: 100%;">MEDICAMENTOS ORALES</a>
        <div class="divider" style="margin-top: 10px; margin-bottom: 10px;"></div>
        <a href="svitales.php?c=<?php echo $cita; ?>&u=<?php echo $id_user; ?>"
        target="frame-cont" class="waves-effect waves-light btn" style="width: 100%;">ACTUALIZAR S.VITALES</a>
        <div class="divider" style="margin-top: 10px; margin-bottom: 10px;"></div>
        <?php }
        
        ?>
        <div class="divider" style="margin-top: 10px; margin-bottom: 10px;"></div>
        <a href="todos_frascos.php?c=<?php echo $cita; ?>&u=<?php echo $id_user; ?>&p=<?php echo $paciente; ?>"
        target="frame-cont" class="waves-effect waves-light btn" style="width: 100%;">CORREGIR HOMEOPÁTICOS</a>
        <br><br>
        <a href="total_rec.php?c=<?php echo $cita; ?>&u=<?php echo $id_user; ?>"
        target="frame-cont" class="waves-effect waves-light btn" style="width: 100%;">Resumen/Enviar a Caja</a>
        </div>
        <div class="col s10">
            <iframe id="iframe_receta" frameborder="0" name="frame-cont"></iframe>
        </div>
    </div>
    <?php   }else{
       if($datos_cita['pagado'] == 0){  
      ?>
      <div class="row center-align" style="width: 98%;">
      <div class="col s2">
      <div class="divider" style="margin-top: 50px; margin-bottom: 10px;"></div>
      <a href="svitales.php?c=<?php echo $cita; ?>&u=<?php echo $id_user; ?>"
        target="frame-cont" class="waves-effect waves-light btn" style="width: 100%;">ACTUALIZAR S.VITALES</a>
      <div class="divider" style="margin-top: 50px; margin-bottom: 10px;"></div>
        <a href="total_otros.php?c=<?php echo $cita; ?>&u=<?php echo $id_user; ?>" 
        target="frame-cont" class="waves-effect waves-light btn" style="width: 100%;">Resumen/Enviar a Caja</a>  
        </div>
        <div class="col s10">
            <iframe id="iframe_receta" frameborder="0" name="frame-cont"></iframe>
        </div>   
      </div>
<?php }  
    } 
    ?>
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
            © 2020 Copyright
            </div>
          </div>
        </footer>
</body>
</html>