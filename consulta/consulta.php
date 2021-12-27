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
    header('Location: ../index.php');
    exit();
}
include_once '../app/logic/conn.php';
include_once 'consulta_sections.php';

$id_paciente = $_GET['idp'];
$id_cita = $_GET['idc'];

$sql_paciente = "SELECT * FROM paciente WHERE id_paciente = '$id_paciente'";
$res_sql_paciente = $mysqli -> query($sql_paciente);
$paciente_val = $res_sql_paciente -> num_rows;

if($paciente_val == 1){
    $datos_paciente = $res_sql_paciente -> fetch_assoc();
}else {
    echo "Hay un error";
}

$sql_citas = "SELECT cita.id_cita, cita.id_paciente, CONCAT(user.nombre,' ',user.apellido) medico_cita, cita.fecha, cita.tipo, tipos_cita.descrip_cita 
FROM cita INNER JOIN tipos_cita on cita.tipo = tipos_cita.id_tipo_cita 
LEFT JOIN user on cita.medico = user.id WHERE id_paciente = '$id_paciente' and medico = '$id_user' ORDER BY cita.fecha DESC LIMIT 5";
$result_sql_citas = $mysqli->query($sql_citas);

$sql_cita_actual = "SELECT consulta.*, cita.fecha, cita.horario FROM consulta 
                    INNER JOIN  cita ON consulta.id_cita = cita.id_cita
                    WHERE consulta.id_cita = '$id_cita'";
$res_sql_cita_act = $mysqli->query($sql_cita_actual);
$val_cita = $res_sql_cita_act->num_rows;

if($val_cita == 1){
    $row_cita = mysqli_fetch_assoc($res_sql_cita_act);

}else{
    echo "Cita duplicada contacte con el administrador del sistema";
}

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
    <script src="../static/js/materialize.js"></script>
    <script type="text/javascript" src="../static/js/jquery-3.3.1.min.js"></script>
</head>
<body>
<?php echo $nav_consulta;  ?>
<div class="container">
<div class="row center-align">
    <div class="col s12">
    <h4 style="color: #2d83a0; font-weight:bold;">Cita CMA<?php echo $row_cita['id_cita'];?> de: 
        <span style="text-transform: capitalize;"><?php echo $datos_paciente['nombres']." ".$datos_paciente['a_paterno']; ?></span></h4>
                <div class="divider"></div>
    </div>
</div>
</div>
<div class="row">
<div class="col s6 offset-s1">
    <blockquote>Datos Generales</blockquote>
    <p style="text-transform: capitalize;">Nombre: <?php echo $datos_paciente['nombres']." ".$datos_paciente['a_paterno']." ".$datos_paciente['a_materno']; ?></p>
    <p>Fecha de Nacimiento: <?php echo date("d/m/Y", strtotime($datos_paciente['fecha_nacimiento'])); ?></p>
    <p>Género: <?php echo $datos_paciente['genero']; ?> </p>
    <div class="divider"></div>
    <blockquote>
    Fecha Cita: <?php echo date("d/m/Y", strtotime($row_cita['fecha'])); ?> Horario: <?php echo $row_cita['horario']; ?>
    </blockquote>
    <div class="divider"></div>
    <blockquote>Signos Vitales</blockquote>
    <?php 
    if($row_cita['peso'] == 'x'){
        echo '<h6 class="yellow-text text-darken-2">No se le han tomado signos vitales al Paciente</h6>';
    }else{  ?>
      <ul>
        <li>T/A: <?php echo $row_cita['ta'];?> mm Hg</li>
        <li>TEMP: <?php echo $row_cita['temp']; ?>°C</li>
        <li>FRE C: <?php echo $row_cita['fre_c']; ?>''</li>
        <li>FRE R: <?php echo $row_cita['fre_r']; ?></li>
        <li>PESO: <?php echo $row_cita['peso']; ?> KG</li>
        <li>TALLA: <?php echo $row_cita['talla']; ?> M</li>
    </ul>  
    <?php    }
    ?>
    <form action="save_nota.php" method="POST">
    <blockquote>Nota de evolución <span style="color: red;">(Obligatorio)</span></blockquote>
        <textarea name="nota_evo" id="" cols="30" rows="50" required></textarea>
        <?php 
        if($row_cita['nota_evolucion'] != ''){
            echo '<p><b>Nota previa: '.$row_cita['nota_evolucion'].'</b></p>';
        }
        ?>
        
        <input type="hidden" value = '<?php echo $id_cita;?>' name="id_cita">
        <br><br>
        <div class="center-align">
        <button class="btn waves-effect waves-light" type="submit" name="action">Actualizar
        <i class="material-icons right">send</i>
        </button>
        </div>

    </form>
</div>
<div class="col s4">
    <blockquote>Citas</blockquote>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Médico</th>
                <th></th>
                <th>Detalle</th>
            </tr>
        </thead>
        <tbody>
            <?php   while($citas_pac = mysqli_fetch_assoc($result_sql_citas)){ ?>
                <tr>
                    <td><?php echo date("d/m/Y", strtotime($citas_pac['fecha'])); ?></td>
                    <td><?php echo $citas_pac['medico_cita'];   ?></td>
                    <td><?php echo $citas_pac['descrip_cita']; ?></td>
                    <td><a href="#?vercita=<?php echo $citas_pac['id_cita']; ?>">Ir al detalle</a></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
</div>

<div class="container">


</div>

<?php echo $footer_consulta;  ?>
</body>
</html>