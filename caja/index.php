<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: ../index.php');
    exit();
}elseif($_SESSION['nivel'] == 3 OR $_SESSION['nivel'] == 7){
            $id_user = $_SESSION['id'];
            $usuario = $_SESSION['name_usuario'];
            $nivel = $_SESSION['nivel'];
}else{
    header('Location: ../index.php');
    exit();
}   
include_once 'caja_sections.php';
include_once '../app/logic/conn.php';

$sql_medico = "SELECT id, concat(nombre,' ',apellido) medico FROM user WHERE nivel = 'medico' OR id = 2  ORDER BY medico";
$result_sql_medico = $mysqli -> query($sql_medico);

// Información de citas del día

$hoy = date("Y-m-d");

$sql_val_corte = "SELECT * FROM cortes_caja WHERE cajero_corte = '$id_user' AND fecha_corte = '$hoy'";
                        $res_val_corte = $mysqli->query($sql_val_corte);
                        $val_corte = $res_val_corte->num_rows;


    if($val_corte == 0){

    $sql_citas = "SELECT cita.id_cita, cita.id_paciente, paciente.id_paciente, cita.medico,
    CONCAT(paciente.nombres,' ',paciente.a_paterno,' ',paciente.a_materno) Nom_paciente,
    CONCAT(user.nombre,' ',user.apellido) medico_cita, cita.fecha, cita.horario, cita.tipo, tipos_cita.descrip_cita, confirma, consulta, caja, pagado
        FROM cita
        INNER JOIN paciente ON cita.id_paciente = paciente.id_paciente
        INNER JOIN tipos_cita on cita.tipo = tipos_cita.id_tipo_cita
        LEFT JOIN user on cita.medico = user.id
        WHERE cita.fecha = '$hoy' AND confirma = 2 AND consulta = 1 AND caja = 1 
        ORDER BY cita.pagado, cita.fecha desc , cita.horario desc";
        $mensaje_val_corte = "";
}else{
    $corte = mysqli_fetch_assoc($res_val_corte);
    $citas_corte = $corte['detalle_citas'];
    $sql_citas = "SELECT cita.id_cita, cita.id_paciente, paciente.id_paciente, cita.medico,
    CONCAT(paciente.nombres,' ',paciente.a_paterno,' ',paciente.a_materno) Nom_paciente,
    CONCAT(user.nombre,' ',user.apellido) medico_cita, cita.fecha, cita.horario, cita.tipo, tipos_cita.descrip_cita, confirma, consulta, caja, pagado
        FROM cita
        INNER JOIN paciente ON cita.id_paciente = paciente.id_paciente
        INNER JOIN tipos_cita on cita.tipo = tipos_cita.id_tipo_cita
        LEFT JOIN user on cita.medico = user.id
        WHERE cita.fecha = '$hoy' AND confirma = 2 AND consulta = 1 AND caja = 1 and cita.id_cita in ($citas_corte) and pagado = 1
        ORDER BY cita.fecha, cita.horario";
        $mensaje_val_corte = "El usuario de la sesión actual ya ejecutó su corte de caja del día. Ya no puede efectuar cobros";
}

$sql_citas2 = "SELECT cita.id_cita, cita.confirma
FROM cita
INNER JOIN paciente ON cita.id_paciente = paciente.id_paciente
INNER JOIN tipos_cita on cita.tipo = tipos_cita.id_tipo_cita
LEFT JOIN user on cita.medico = user.id
WHERE cita.fecha = '$hoy' 
ORDER BY cita.fecha, cita.horario";

$result_sql_citas = $mysqli -> query($sql_citas2);
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
    <title>Caja</title>
    <link rel="shortcut icon" href="../static/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../static/css/materialize.css">
    <link rel="stylesheet" href="../static/icons/iconfont/material-icons.css">
    <link rel="stylesheet" href="../../static/css/main.css">
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
<?php echo $nav_caja;  
?>
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
            <div class="col s8">
                <p style="color: red;"><?php echo $mensaje_val_corte; ?></p>
                <div class="table-responsive-2">
                <table>
                    <thead>
                        <tr>
                            <th class="center-align" colspan="4">Citas del <?php echo date("d/m/Y", strtotime($hoy)); ?></th>
                            <th class="center-align"><a href="index.php">Actualizar <i class="material-icons">autorenew</i> </a></th>
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
                            <td style="text-transform: capitalize; font-size:small;"><?php echo $citas_dia['Nom_paciente']; ?></td>
                            <td style="text-transform: capitalize; font-size:small;"><?php echo $citas_dia['horario']; ?></td>
                            <td style="text-transform: capitalize; font-size:small;"><?php echo $citas_dia['medico_cita']; ?></td>
                            <td style="text-transform: capitalize; font-size:small;"><?php echo $citas_dia['descrip_cita']; ?></td>
                            <?php 
                            if($citas_dia['pagado'] == 0){
                                echo '<td><div class="chip  red darken-1 white-text">
                                            <a class="white-text" href="cobro.php?c='.$citas_dia['id_cita'].'&u='.$id_user.'" target="frame-cont">Pagar</a>
                                        </div></td>';
                            }elseif($citas_dia['pagado'] == 1){
                                echo '<td><div class="chip  cyan darken-4 white-text">
                                            <a class="white-text" href="cobro.php?c='.$citas_dia['id_cita'].'&u='.$id_user.'" target="frame-cont">Pagado</a>
                                        </div></td>';
                                        /*echo '<td><div class="chip  red white-text">
                                        <a class="white-text" href="devolucion.php?c='.$citas_dia['id_cita'].'">Devolución</a>
                                        </div></td>';*/
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
            <div class="col s4">
        
            <iframe id="iframe_cobro" frameborder="0" name="frame-cont" style="min-height: 550px; width:100%;"></iframe>
        
            </div>
        </div>
    </div>
</div>
<!-- ***************************** TERMINA CONTENIDO ****************************** -->
<?php echo $footer_caja;  ?>
</body>
</html>