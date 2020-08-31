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
include_once '../app/logic/conn.php';
include_once 'recep_sections.php';
$id_paciente = $_GET['id_paciente'];

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
LEFT JOIN user on cita.medico = user.id WHERE id_paciente = '$id_paciente' ORDER BY cita.fecha DESC";
$result_sql_citas = $mysqli->query($sql_citas);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/materialize.css">
    <link rel="stylesheet" href="../icons/iconfont/material-icons.css">
    <script src="../js/materialize.js"></script>
    <script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
</head>
<body>
<?php echo $nav_recep;  ?>
<div class="container">
<div class="row center-align">
    <div class="col s12">
    <h4 style="color: #2d83a0; font-weight:bold;">Información del paciente: 
        <span style="text-transform: capitalize;"><?php echo $datos_paciente['nombres']." ".$datos_paciente['a_paterno']; ?></span></h4>
                <div class="divider"></div>
    </div>
</div>
</div>
<div class="row">
<div class="col s6 offset-s1">
    <blockquote>Datos Generales</blockquote>
    <p style="text-transform: capitalize;">Nombre: <?php echo $datos_paciente['nombres']." ".$datos_paciente['a_paterno']." ".$datos_paciente['a_materno']; ?></p>
    <p>Fecha de Nacimiento: <?php echo $datos_paciente['fecha_nacimiento']; ?></p>
    <p>Género: <?php echo $datos_paciente['genero']; ?> </p>
    <blockquote>Domicilio</blockquote>
    <p style="text-transform: capitalize;">Calle <?php echo $datos_paciente['calle']; ?>
    No. <?php echo $datos_paciente['num_domicilio']; ?>
    Colonia <?php echo $datos_paciente['colonia']; ?>
    CP. <?php echo $datos_paciente['cod_postal']; ?>, <?php echo $datos_paciente['muni_alcaldia']; ?>.
    <?php echo $datos_paciente['estado']; ?>
    </p>
    <blockquote>Contacto</blockquote>
    <p>Telefóno de Casa: <?php echo $datos_paciente['tel_casa']; ?></p>
    <p>Telefóno de Móvil: <?php echo $datos_paciente['tel_movil']; ?></p>
    <p>Telefóno de Oficina: <?php echo $datos_paciente['tel_oficina']; ?> Ext: <?php echo $datos_paciente['ext_tel']; ?></p>
    <p>Telefóno de Recados: <?php echo $datos_paciente['tel_recados']; ?></p>
    <p>Correo electrónico: <?php echo $datos_paciente['email']; ?></p>
    <blockquote>Otros</blockquote>
    <p style="text-transform: capitalize;">Ocupación: <?php echo $datos_paciente['ocupacion']; ?></p>
    <p style="text-transform: capitalize;">Titular: <?php echo $datos_paciente['nombre_titular']; ?></p>
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

<?php echo $footer_recep;  ?>
</body>
</html>