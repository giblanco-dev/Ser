<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: ../index.php');
    exit();
}elseif($_SESSION['nivel'] == 1 OR $_SESSION['nivel'] == 2){
            $id_user = $_SESSION['id'];
            $usuario = $_SESSION['name_usuario'];
            $nivel = $_SESSION['nivel'];
}else{
    //header('Location: ../index.php');
    //exit();
}   
include_once 'consulta_sections.php';
include_once '../app/logic/conn.php';

$sql_medico = "SELECT id, concat(nombre,' ',apellido) medico FROM user WHERE nivel = 'medico' AND id = '$id_user'";
$result_sql_medico = $mysqli -> query($sql_medico);

// Información de citas del día

$hoy = date("Y-m-d");


        $sql_citas = "SELECT cita.id_cita, cita.id_paciente, paciente.id_paciente, 
        CONCAT(paciente.nombres,' ',paciente.a_paterno,' ',paciente.a_materno) Nom_paciente,
        CONCAT(user.nombre,' ',user.apellido) medico_cita, cita.fecha, cita.horario, cita.tipo, tipos_cita.descrip_cita, confirma, consulta
        FROM cita
        INNER JOIN paciente ON cita.id_paciente = paciente.id_paciente
        INNER JOIN tipos_cita on cita.tipo = tipos_cita.id_tipo_cita
        LEFT JOIN user on cita.medico = user.id
        WHERE cita.fecha = '$hoy' AND medico = '$id_user'
        ORDER BY cita.fecha, cita.horario";


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
    <title>Consulta</title>
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
<?php echo $nav_consulta;  ?>
<!-- ***************************** INICIA CONTENIDO ****************************** -->
<div class="row center-align">
    <div class="col s2 grey lighten-3" style="margin-bottom: -20px;"> <!-- ***************************** INICIA BARRA LATERAL ****************************** -->
        <div class="row" style="margin-top: 100px;">
            <div class="col s12">
            <h4>Consulta</h4>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
            <iframe src="../static/clock/clock.html" width="100%" frameborder="0"></iframe> 
            </div>
        </div>
        <div class="row" style="margin-top: -4em;">
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
            <div class="col s10 offset-s1">
            <div class="table-responsive-2">
                <table class="centered striped" id="mytable"> 
                    <thead>
                        <tr>
                            <th class="center-align">Citas del <?php echo date("d/m/Y", strtotime($hoy)); ?></th>
                            <th class="center-align"><a href="index.php">Actualizar <i class="material-icons">autorenew</i> </a></th>
                            <th class="center-align">
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
                            <th colspan="1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        while($citas_dia = mysqli_fetch_assoc($datos_cita)){
                            
                                $idp = $citas_dia['id_paciente'];
                                $idc = $citas_dia['id_cita'];
                        ?>
                        <tr>
                            <td style="text-transform: capitalize;"><?php echo $citas_dia['Nom_paciente']; ?></td>
                            <td style="text-transform: capitalize;"><?php echo $citas_dia['horario']; ?></td>
                            
                            <?php
                            if($citas_dia['confirma'] == 2){
                                if($citas_dia['consulta'] == 0){
                                    echo '<td><div class="chip"><a href="consulta.php?idp='.$idp.'&idc='.$idc.'">Seguimiento</a></div></td>';
                                }else{
                                    echo '<td><div class="chip cyan #2d83a0"><a class="white-text" href="consulta.php?idp='.$idp.'&idc='.$idc.'">Actualizar Seguimiento</a></div></td>';
                                }
                            }else{
                                echo '<td><div class="chip">El paciente no ha llegado</div></td>';
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


<?php echo $footer_consulta;  ?>


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
