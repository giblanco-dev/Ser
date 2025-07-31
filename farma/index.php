<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: ../index.php');
    exit();
}elseif($_SESSION['nivel'] == 5 OR $_SESSION['nivel'] == 7){
            $id_user = $_SESSION['id'];
            $usuario = $_SESSION['name_usuario'];
            $nivel = $_SESSION['nivel'];
}else{
    header('Location: ../index.php');
    exit();
}   
include_once 'farma_sections.php';
include_once '../app/logic/conn.php';

// Información de citas del día

$hoy = date("Y-m-d");

require_once '../app/conteo_citas.php';

    $sql_citas = "SELECT DISTINCT cita.id_cita, cita.id_paciente, paciente.id_paciente, cita.medico,
    CONCAT(paciente.nombres,' ',paciente.a_paterno,' ',paciente.a_materno) Nom_paciente,
    CONCAT(user.nombre,' ',user.apellido) medico_cita, cita.fecha, cita.horario, cita.tipo, tipos_cita.descrip_cita, confirma, consulta, caja, pagado
        FROM cita
        INNER JOIN paciente ON cita.id_paciente = paciente.id_paciente
        INNER JOIN tipos_cita on cita.tipo = tipos_cita.id_tipo_cita
        INNER JOIN resu_med_home ON cita.id_cita = resu_med_home.id_cita
        LEFT JOIN user on cita.medico = user.id
        WHERE cita.fecha = '$hoy' AND confirma = 2 AND consulta = 1 AND caja = 1 and pagado = 1 AND cita.tipo = 0
        ORDER BY cita.fecha, cita.horario";

    $datos_cita = $mysqli -> query($sql_citas);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmacia</title>
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
            <h4>Farmacia</h4>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
            <iframe src="../static/clock/clock.html" width="100%" frameborder="0"></iframe> 
            </div>
        </div>
        <div class="row" style="margin-top: -2em;">
            <div class="col s12">
            <h2 style="color: #424242;"><?php echo $citas_confirmadas; ?> <i class="medium material-icons">check_circle</i></h2>
            <p>Citas Confirmadas</p>
            <h2 style="color: #424242;"><?php echo $total_citas; ?> <i class="medium material-icons">book</i></h2>
            <p>Citas Agendadas</p>
            </div>
        </div>
        <div class="row">
            
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
                            <th class="center-align" colspan="2">Citas del <?php echo date("d/m/Y", strtotime($hoy)); ?></th>
                            <th class="center-align"><a href="index.php">Actualizar <i class="material-icons">autorenew</i> </a></th>
                            <th class="center-align" colspan="2">
                            <div class="input-field col s12">
                            <i class="material-icons prefix">search</i>
                            <input id="search" type="text" class="validate">
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
                            <td><div class="chip  red darken-1 white-text">
                            <a class="white-text" href="med_homoeopaticos.php?c=<?php echo $citas_dia['id_cita']; ?>">Ver Tratamiento</a>
                            </div></td>
                           
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
<?php echo $footer_caja;  ?>

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