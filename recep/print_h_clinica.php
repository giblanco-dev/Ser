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

$id_paciente = $_GET['id_paciente'];

$sql_h_clin = "SELECT his_clinica_gen.*,
CONCAT(paciente.nombres,' ',paciente.a_paterno,' ',paciente.a_materno) Nombre_completo,
paciente.genero, paciente.fecha_nacimiento, paciente.id_paciente, paciente.fecha_captura,
CONCAT(user.nombre,' ',user.apellido) Medico
FROM his_clinica_gen
INNER JOIN paciente ON his_clinica_gen.id_paciente = paciente.id_paciente
INNER JOIN user ON his_clinica_gen.medico = user.usuario
where his_clinica_gen.id_paciente = '$id_paciente'";

$res_h_clin = $mysqli->query($sql_h_clin);
$val_his_clin = $res_h_clin->num_rows;

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../static/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../static/css/materialize.css">
    <title>Historia Clínica Paciente <?php echo $id_paciente; ?></title>
</head>
<body>
    <?php 
    if($val_his_clin == 1){
        $row_h_c = mysqli_fetch_assoc($res_h_clin);
    ?>
    <div class="row">
    <div class="col s4">
                <p style="font-size: 10px;">Clínica de Medicina Alternativa SER <br>
                    Elena 9, Colonia Nativitas <br>
                    Del. Benito Juárez, Distrito Federal <br>
                    (55) 5579-9896, 6365-8396</p>
            </div>
            <div class="col s4">
            <p style="font-size: 10px;">Historia Clínica <br>
            Paciente: <?php echo $row_h_c['Nombre_completo']; ?><br>
            Fecha Nacimiento: <?php echo $row_h_c['fecha_nacimiento']; ?><br>
            Genéro: <?php echo $row_h_c['genero']; ?><br>
            Fecha de Alta: <?php echo $row_h_c['fecha_captura']; ?></p>    

            </div>
            <div class="col s4">
            <img src="../static/img/logo.png" style="max-height: 100px; float:right;">
            </div>
    </div>
    <div class="divider" style="margin: 5px;"></div>
    <div class="row">
        <div class="col s12 center-align">
            <h6>Historia Clínica</h6>
        </div>
        <div class="col s12">
            <div>
            <b><p style="font-size: 11px; width: 300px; display:inline-block; background-color:antiquewhite;">Antecedentes heredo familiares </p></b> 
            <p style="font-size: 11px; display:inline-block;"><?php echo $row_h_c['hcg2']; ?></p>
            </div>
            <div style="margin-top: -15px;">
            <b><p style="font-size: 11px;  width: 300px; display:inline-block; background-color:antiquewhite;">Antecedentes personales no patológicos</p></b>
            <p style="font-size: 11px; display:inline-block;"><?php echo $row_h_c['hcg3']; ?></p>
            </div>
            <div style="margin-top: -15px;">
            <b><p style="font-size: 11px; display:inline-block; width: 300px; background-color:antiquewhite;">Antecedentes personales patológicos</p></b>
            <p style="font-size: 11px; display:inline-block;"><?php echo $row_h_c['hcg4']; ?></p>
            </div>
            <div style="margin-top: -15px;">
            <b><p style="font-size: 11px; display:inline-block; width: 300px; background-color:antiquewhite;">Antecedentes gineco-obstetricos</p></b>
            <p style="font-size: 11px; display:inline-block;"><?php echo $row_h_c['hcg5']; ?></p>
            </div>
            <div style="margin-top: -15px;">
            <b><p style="font-size: 11px; display:inline-block; width: 300px; background-color:antiquewhite;">Padecimiento Actual</p></b>
            <p style="font-size: 11px; display:inline-block;"><?php echo $row_h_c['hcg6']; ?></p>
            </div>

            <div class="divider"></div>
            <div style="margin-top: -15px;">
            <b><p style="font-size: 12px;">Interrogatorio por aparatos y sistema</p></b>
            </div>
            <div style="margin-top: -15px;">
            <b><p style="font-size: 11px; display:inline-block; width: 300px; background-color:antiquewhite;">Respiratorio</p></b>
            <p style="font-size: 11px; display:inline-block;"><?php echo $row_h_c['hcg7']; ?></p>
            </div>
            <div style="margin-top: -15px;">
            <b><p style="font-size: 11px; display:inline-block; width: 300px; background-color:antiquewhite;">Gastroinstestinal</p></b>
            <p style="font-size: 11px; display:inline-block;"><?php echo $row_h_c['hcg8']; ?></p>
            </div>
            <div style="margin-top: -15px;">
            <b><p style="font-size: 11px; display:inline-block; width: 300px; background-color:antiquewhite;">Genitourinario</p></b>
            <p style="font-size: 11px; display:inline-block;"><?php echo $row_h_c['hcg9']; ?></p>
            </div>
            <div style="margin-top: -15px;">
            <b><p style="font-size: 11px; display:inline-block; width: 300px; background-color:antiquewhite;">Hematopogénico y linfatico</p></b>
            <p style="font-size: 11px; display:inline-block;"><?php echo $row_h_c['hcg10']; ?></p>
            </div>
            <div style="margin-top: -15px;">
            <b><p style="font-size: 11px; display:inline-block; width: 300px; background-color:antiquewhite;">Endocrino</p></b>
            <p style="font-size: 11px; display:inline-block;"><?php echo $row_h_c['hcg11']; ?></p>
            </div>
            <div style="margin-top: -15px;">
            <b><p style="font-size: 11px; display:inline-block; width: 300px; background-color:antiquewhite;">Nervioso</p></b>
            <p style="font-size: 11px; display:inline-block;"><?php echo $row_h_c['hcg12']; ?></p>
            </div>
            <div style="margin-top: -15px;">
            <b><p style="font-size: 11px; display:inline-block; width: 300px; background-color:antiquewhite;">Músculos esquelético</p></b>
            <p style="font-size: 11px; display:inline-block;"><?php echo $row_h_c['hcg13']; ?></p>
            </div>
            <div style="margin-top: -15px;">
            <b><p style="font-size: 11px; display:inline-block; width: 300px; background-color:antiquewhite;">Piel, mucosa y anexos</p></b>
            <p style="font-size: 11px; display:inline-block;"><?php echo $row_h_c['hcg14']; ?></p>
            </div>

            <div class="divider"></div>
            <div style="margin-top: -15px;">
            <b><p style="font-size: 12px;">Signos Vitales</p></b>
            </div>
            <div style="margin-top: -15px;">
            <b><p style="font-size: 11px; display:inline-block; width: 100px; background-color:antiquewhite;">T/A</p></b>
            <p style="font-size: 11px; display:inline-block;"><?php echo $row_h_c['hcg15']; ?> mm Hg</p>
            <b><p style="font-size: 11px; display:inline-block; width: 100px; background-color:antiquewhite;">TEMP</p></b>
            <p style="font-size: 11px; display:inline-block;"><?php echo $row_h_c['hcg16']; ?> °C</p>
            <b><p style="font-size: 11px; display:inline-block; width: 100px; background-color:antiquewhite;">FRE C</p></b>
            <p style="font-size: 11px; display:inline-block;"><?php echo $row_h_c['hcg17']; ?> ''</p>
            <b><p style="font-size: 11px; display:inline-block; width: 100px; background-color:antiquewhite;">FRE R</p></b>
            <p style="font-size: 11px; display:inline-block;"><?php echo $row_h_c['hcg18']; ?></p>
            <b><p style="font-size: 11px; display:inline-block; width: 100px; background-color:antiquewhite;">PESO</p></b>
            <p style="font-size: 11px; display:inline-block;"><?php echo $row_h_c['hcg19']; ?> KG</p>
            <b><p style="font-size: 11px; display:inline-block; width: 100px; background-color:antiquewhite;">TALLA</p></b>
            <p style="font-size: 11px; display:inline-block;"><?php echo $row_h_c['hcg20']; ?> M</p>
            </div>

            <div class="divider"></div>
            <div style="margin-top: -15px;">
            <b><p style="font-size: 12px;">Exploración física</p></b>
            </div>
            <div style="margin-top: -15px;">
            <b><p style="font-size: 11px; display:inline-block; width: 300px; background-color:antiquewhite;">Habitus exterior</p></b>
            <p style="font-size: 11px; display:inline-block;"><?php echo $row_h_c['hcg21']; ?></p>
            </div>
            <div style="margin-top: -15px;">
            <b><p style="font-size: 11px; display:inline-block; width: 300px; background-color:antiquewhite;">Cabeza y cuello</p></b>
            <p style="font-size: 11px; display:inline-block;"><?php echo $row_h_c['hcg22']; ?></p>
            </div>
            <div style="margin-top: -15px;">
            <b><p style="font-size: 11px; display:inline-block; width: 300px; background-color:antiquewhite;">Torax</p></b>
            <p style="font-size: 11px; display:inline-block;"><?php echo $row_h_c['hcg23']; ?></p>
            </div>
            <div style="margin-top: -15px;">
            <b><p style="font-size: 11px; display:inline-block; width: 300px; background-color:antiquewhite;">Abdomen</p></b>
            <p style="font-size: 11px; display:inline-block;"><?php echo $row_h_c['hcg24']; ?></p>
            </div>
            <div style="margin-top: -15px;">
            <b><p style="font-size: 11px; display:inline-block; width: 300px; background-color:antiquewhite;">Genitales</p></b>
            <p style="font-size: 11px; display:inline-block;"><?php echo $row_h_c['hcg25']; ?></p>
            </div>
            <div style="margin-top: -15px;">
            <b><p style="font-size: 11px; display:inline-block; width: 300px; background-color:antiquewhite;">Extremidades</p></b>
            <p style="font-size: 11px; display:inline-block;"><?php echo $row_h_c['hcg26']; ?></p>
            </div>
            <div style="margin-top: -15px;">
            <b><p style="font-size: 11px; display:inline-block; width: 300px; background-color:antiquewhite;">Piel</p></b>
            <p style="font-size: 11px; display:inline-block;"><?php echo $row_h_c['hcg27']; ?></p>
            </div>
            <div class="divider"></div>
            <div>
            <b><p style="font-size: 11px; display:inline-block; width: 300px; background-color:antiquewhite;">Resultados previos y actuales de laboratorio, gabinete y otros</p></b>
            <p style="font-size: 11px; display:inline-block;"><?php echo $row_h_c['hcg28']; ?></p>
            </div>
            <div style="margin-top: -15px;">
            <b><p style="font-size: 11px; display:inline-block; width: 300px; background-color:antiquewhite;">Diagnósticos o problemas clínicos</p></b>
            <p style="font-size: 11px; display:inline-block;"><?php echo $row_h_c['hcg29']; ?></p>
            </div>

            <div class="divider"></div>
            <div style="margin-top: -15px;">
            <b><p style="font-size: 12px;">TX Farmacológico</p></b>
            </div>
            <div style="margin-top: -15px;">
            <b><p style="font-size: 11px; display:inline-block; width: 300px; background-color:antiquewhite;">Terapéutica empleada y resultados (previos)</p></b>
            <p style="font-size: 11px; display:inline-block;"><?php echo $row_h_c['hcg30']; ?></p>
            </div>
            <div style="margin-top: -15px;">
            <b><p style="font-size: 11px; display:inline-block; width: 300px; background-color:antiquewhite;">Terapéutica actual</p></b>
            <p style="font-size: 11px; display:inline-block;"><?php echo $row_h_c['hcg31']; ?></p>
            </div>
            <div style="margin-top: -15px;">
            <b><p style="font-size: 11px; display:inline-block; width: 300px; background-color:antiquewhite;">Pronósticos</p></b>
            <p style="font-size: 11px; display:inline-block;"><?php echo $row_h_c['hcg31']; ?></p>
            </div>

            </div>

            
            <div class="col s4"></div>
            <div class="col s4 center-align">
            <br><br>
                <div class="divider" style="background-color: #000;"></div>
                <p>Médico<br>(Nombre fecha y firma)</p>
            </div>
            <div class="col s4"></div>
            

        </div>
    </div>
    <?php 
        }else{
            echo "<h1>Existe un error con la historia clínica del Paciente: ".$id_paciente."</h1>";
        }
    
    ?>
</body>
</html>