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

require '../app/logic/conn.php';

if(isset($_GET['id_paciente'])){
    $id_cita = $_GET['cita'];
    $id_paciente = $_GET['id_paciente'];
    $sql_paciente = "SELECT id_paciente, CONCAT(nombres,' ',a_paterno,' ',a_materno) nombre_completo FROM paciente WHERE id_paciente = '$id_paciente'";
}else{
$nombres = $_POST['nombres'];
$a_paterno = $_POST['a_paterno'];
$tel_movil = $_POST['tel_movil'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$sql_paciente = "SELECT id_paciente, CONCAT(nombres,' ',a_paterno,' ',a_materno) nombre_completo FROM paciente WHERE nombres= '$nombres' AND a_paterno = '$a_paterno' 
                AND tel_movil = '$tel_movil' AND fecha_nacimiento = '$fecha_nacimiento'";
}


$result_sql_paciente = $mysqli->query($sql_paciente);
$pacientes = $result_sql_paciente -> num_rows;

if($pacientes == 1){
    $row_paciente = $result_sql_paciente->fetch_assoc();
    $nombre_paciente = $row_paciente['nombre_completo'];
    $id_paciente = $row_paciente['id_paciente'];
}

$sql_hcg = "SELECT * FROM his_clinica_gen where id_paciente = '$id_paciente'";
                     $result_sql_his = $mysqli -> query($sql_hcg);
                     $hcg_val = $result_sql_his -> num_rows;
                    
                     if($hcg_val == 1){
                        $row_hgcold = $result_sql_his->fetch_assoc();
                     }

include_once 'consulta_sections.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../static/img/favicon.png" type="image/x-icon">
    <title>Captura His-Clínica</title>
    <link rel="stylesheet" href="../static/css/materialize.css">
    <link rel="stylesheet" href="../static/icons/iconfont/material-icons.css">
    <script type="text/javascript" src="../static/js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="../static/js/materialize.js"></script>
</head>
<body>
<header>
 <div class="navbar-fixed">
 <nav>
    <div class="nav-wrapper">
      <a href="#" class="responsive-img" class="brand-logo"><img src="../static/img/logo.png" style="max-height: 150px; margin-left: 20px;"></a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
      <li><a onclick="window.close();"><i class="material-icons right">close</i>Cerrar Detalle</a></li>
      </ul>
    </div>
  </nav>
 </div>
 </header>
<div class="container">
    <div class="row center-align">
            <div class="col s12">
                <h4 style="color: #2d83a0; font-weight:bold;">Captura de Historia Clínica del paciente: <?php echo $nombre_paciente; ?></h4>
                <div class="divider"></div>
            </div>
        </div>
    <form action="save_hcg.php" method="POST">
    <div class="row">
        <div class="col s4">
            <blockquote>
            <h6>Antecedentes heredo familiares</h6>
            </blockquote>
        </div>
        <div class="input-field col s8">
            <input type="text" id="textarea2" class="materialize-textarea" name="hcg2" required <?php if($hcg_val == 1){ echo 'value="'.$row_hgcold['hcg2'].'"';} ?>>
            <label for="textarea2">Capture los antecedentes heredo familiares</label>
        </div>
    </div>
    <div class="row">
        <div class="col s4">
            <blockquote>
                <h6>Antecedentes personales no patológicos</h6>
            </blockquote>
        </div>
        <div class="input-field col s8">
            <input type="text" id="textarea3" class="materialize-textarea" name="hcg3" required <?php if($hcg_val == 1){ echo 'value="'.$row_hgcold['hcg3'].'"';} ?>>
            <label for="textarea3">Capture los antecedentes personales no patológicos</label>
        </div>
    </div>
    <div class="row">
        <div class="col s4">
            <blockquote>
                <h6>Antecedentes personales patológicos</h6>
            </blockquote>
        </div>
        <div class="input-field col s8">
            <input type="text" id="textarea4" class="materialize-textarea" name="hcg4" required <?php if($hcg_val == 1){ echo 'value="'.$row_hgcold['hcg4'].'"';} ?>>
            <label for="textarea4">Capture los antecedentes personales patológicos</label>
        </div>
    </div>
    <div class="row">
        <div class="col s4">
            <blockquote>
                <h6>Antecedentes gineco-obstetricos</h6>
            </blockquote>
        </div>
        <div class="input-field col s8">
            <input type="text" id="textarea5" class="materialize-textarea" name="hcg5" required <?php if($hcg_val == 1){ echo 'value="'.$row_hgcold['hcg5'].'"';} ?>>
            <label for="textarea5">Capture los antecedentes gineco-obstetricos</label>
        </div>
    </div>
    <div class="row">
        <div class="col s4">
            <blockquote>
                <h6>Padecimiento Actual</h6>
            </blockquote>
        </div>
        <div class="input-field col s8">
            <input type="text" id="textarea6" class="materialize-textarea" name="hcg6" <?php if($hcg_val == 1){ echo 'value="'.$row_hgcold['hcg6'].'"';} ?>>
            <label for="textarea6">Capture el padecimiento actual</label>
        </div>
    </div>
    <div class="row">
    <div class="divider" style="margin-bottom: 3%;"></div>
        <div class="col s3">
            <blockquote>
                <h6>Interrogatorio por aparatos y sistema</h6>
            </blockquote>
        </div>
        <div class="col s9">
            <div class="row">
                <div class="input-field col s6">
                <input type="text" id="textarea7" class="materialize-textarea" name="hcg7" <?php if($hcg_val == 1){ echo 'value="'.$row_hgcold['hcg7'].'"';} ?>>
                <label for="textarea7">Respiratorio</label>
                </div>
                <div class="input-field col s6">
                <input type="text" id="textarea8" class="materialize-textarea" name="hcg8" <?php if($hcg_val == 1){ echo 'value="'.$row_hgcold['hcg8'].'"';} ?>>
                <label for="textarea8">Gastroinstestinal</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                <input type="text" id="textarea9" class="materialize-textarea" name="hcg9" <?php if($hcg_val == 1){ echo 'value="'.$row_hgcold['hcg9'].'"';} ?>>
                <label for="textarea9">Genitourinario</label>
                </div>
                <div class="input-field col s6">
                <input type="text" id="textarea10" class="materialize-textarea" name="hcg10" <?php if($hcg_val == 1){ echo 'value="'.$row_hgcold['hcg10'].'"';} ?>>
                <label for="textarea10">Hematopogénico y linfatico</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                <input type="text" id="textarea11" class="materialize-textarea" name="hcg11" <?php if($hcg_val == 1){ echo 'value="'.$row_hgcold['hcg11'].'"';} ?>>
                <label for="textarea11">Endocrino</label>
                </div>
                <div class="input-field col s6">
                <input type="text" id="textarea12" class="materialize-textarea" name="hcg12" <?php if($hcg_val == 1){ echo 'value="'.$row_hgcold['hcg12'].'"';} ?>>
                <label for="textarea12">Nervioso</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                <input type="text" id="textarea13" class="materialize-textarea" name="hcg13" <?php if($hcg_val == 1){ echo 'value="'.$row_hgcold['hcg13'].'"';} ?>>
                <label for="textarea13">Músculos esquelético</label>
                </div>
                <div class="input-field col s6">
                <input type="text" id="textarea14" class="materialize-textarea" name="hcg14" <?php if($hcg_val == 1){ echo 'value="'.$row_hgcold['hcg14'].'"';} ?>" >
                <label for="textarea14">Piel, mucosa y anexos</label>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
    <div class="divider" style="margin-bottom: 3%;"></div>
    <div class="col s12">
        <blockquote>
            <h6>Signos Vitales</h6>
        </blockquote>
    </div>
    </div>
    <div class="row">
        <div class="input-field col s2">
          <input id="txt15" type="text" class="validate" name="hcg15" <?php if($hcg_val == 1){ echo 'value="'.$row_hgcold['hcg15'].'"';} ?>>
          <label for="txt15">T/A</label>
        </div>
        <div class="input-field col s2">
          <input id="txt16" type="text" class="validate" name="hcg16" <?php if($hcg_val == 1){ echo 'value="'.$row_hgcold['hcg16'].'"';} ?>>
          <label for="txt16">TEMP</label>
        </div>
        <div class="input-field col s2">
          <input id="txt17" type="text" class="validate" name="hcg17" <?php if($hcg_val == 1){ echo 'value="'.$row_hgcold['hcg17'].'"';} ?>>
          <label for="txt17">FRE C</label>
        </div>
        <div class="input-field col s2">
          <input id="txt18" type="text" class="validate" name="hcg18" <?php if($hcg_val == 1){ echo 'value="'.$row_hgcold['hcg18'].'"';} ?>>
          <label for="txt18">FRE R</label>
        </div>
        <div class="input-field col s2">
          <input id="txt19" type="text" class="validate" name="hcg19" <?php if($hcg_val == 1){ echo 'value="'.$row_hgcold['hcg19'].'"';} ?>>
          <label for="txt19">PESO</label>
        </div>
        <div class="input-field col s2">
          <input id="txt20" type="text" class="validate" name="hcg20" <?php if($hcg_val == 1){ echo 'value="'.$row_hgcold['hcg20'].'"';} ?>>
          <label for="txt20">TALLA</label>
        </div>
    </div>
    <div class="row">
    <div class="divider" style="margin-bottom: 3%;"></div>
    <div class="col s3">
        <blockquote>
            <h6>Exploración física</h6>
        </blockquote>
    </div>
    <div class="col s9">
            <div class="row">
                <div class="input-field col s6">
                <input type="text" id="textarea21" class="materialize-textarea" name="hcg21" <?php if($hcg_val == 1){ echo 'value="'.$row_hgcold['hcg21'].'"';} ?>>
                <label for="textarea21">Habitus exterior</label>
                </div>
                <div class="input-field col s6">
                <input type="text" id="textarea22" class="materialize-textarea" name="hcg22" <?php if($hcg_val == 1){ echo 'value="'.$row_hgcold['hcg22'].'"';} ?>>
                <label for="textarea22">Cabeza y cuello</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                <input type="text" id="textarea23" class="materialize-textarea" name="hcg23" <?php if($hcg_val == 1){ echo 'value="'.$row_hgcold['hcg23'].'"';} ?>>
                <label for="textarea23">Torax</label>
                </div>
                <div class="input-field col s6">
                <input type="text" id="textarea24" class="materialize-textarea" name="hcg24" <?php if($hcg_val == 1){ echo 'value="'.$row_hgcold['hcg24'].'"';} ?>>
                <label for="textarea24">Abdomen</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                <input type="text" id="textarea25" class="materialize-textarea" name="hcg25" <?php if($hcg_val == 1){ echo 'value="'.$row_hgcold['hcg25'].'"';} ?>>
                <label for="textarea25">Genitales</label>
                </div>
                <div class="input-field col s6">
                <input type="text" id="textarea26" class="materialize-textarea" name="hcg26" <?php if($hcg_val == 1){ echo 'value="'.$row_hgcold['hcg26'].'"';} ?>>
                <label for="textarea26">Extremidades</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                <input type="text" id="textarea27" class="materialize-textarea" name="hcg27" <?php if($hcg_val == 1){ echo 'value="'.$row_hgcold['hcg27'].'"';} ?>>
                <label for="textarea27">Piel</label>
                </div>
            </div>
    </div>
    </div>
    <div class="row">
    <div class="divider" style="margin-bottom: 3%;"></div>
        <div class="col s4">
            <blockquote>
                <h6>Resultados previos y actuales de laboratorio, gabinete y otros</h6>
            </blockquote>
        </div>
        <div class="input-field col s8">
            <input type="text" id="textarea28" class="materialize-textarea" name="hcg28" <?php if($hcg_val == 1){ echo 'value="'.$row_hgcold['hcg28'].'"';} ?>>
            <label for="textarea28">Capture los resultados</label>
        </div>
    </div>
    <div class="row">
        <div class="col s4">
            <blockquote>
                <h6>Diagnósticos o problemas clínicos</h6>
            </blockquote>
        </div>
        <div class="input-field col s8">
            <input type="text" id="textarea29" class="materialize-textarea" name="hcg29" <?php if($hcg_val == 1){ echo 'value="'.$row_hgcold['hcg29'].'"';} ?>>
            <label for="textarea29">Capture los diágnosticos</label>
        </div>
    </div>
    <div class="row">
    <div class="divider" style="margin-bottom: 3%;"></div>
    <div class="col s3">
        <blockquote>
            <h6>TX Farmacológico</h6>
        </blockquote>
    </div>
    <div class="col s9">
    <div class="row">
                <div class="input-field col s12">
                <input type="text" id="textarea30" class="materialize-textarea" name="hcg30" <?php if($hcg_val == 1){ echo 'value="'.$row_hgcold['hcg30'].'"';} ?>>
                <label for="textarea30">Terapéutica empleada y resultados (previos)</label>
                </div>
            </div>
            <div class="row">
            <div class="input-field col s6">
                <input type="text" id="textarea31" class="materialize-textarea" name="hcg31" <?php if($hcg_val == 1){ echo 'value="'.$row_hgcold['hcg31'].'"';} ?>>
                <label for="textarea31">Terapéutica actual</label>
                </div>
                <div class="input-field col s6">
                <input type="text" id="textarea32" class="materialize-textarea" name="hcg32" <?php if($hcg_val == 1){ echo 'value="'.$row_hgcold['hcg32'].'"';} ?>>
                <label for="textarea32">Prónosticos</label>
                </div>
            </div>
            <div class="row">
            <div class="input-field col s12">
                <select name="medico" required>
                <option value="" disabled selected>Selecciona el médico</option>
                <option value="emartinez">Dr. Enrique Mtz</option>
                <option value="gleon">Dr. Guillermo León</option>
                <option value="amosqueda">Dra. Angélica Mosqueda</option>
                </select>
                <label>Médico que realizo la Historia Clínica</label>
                <input type="hidden" name="usuario_captura" value="<?php echo $id_user?>">
                <input type="hidden" name="id_paciente" value="<?php echo $id_paciente?>">
                <input type="hidden" name="id_cita" value="<?php echo $id_cita?>">
            </div>
            </div>
    </div>
    </div>
    <div class="row center-align">
    <div class="divider" style="margin-bottom: 3%;"></div>
    <div class="col s12">
    <button class="btn-large waves-effect waves-light" type="submit" name="action">Guardar/Actualizar Historia Clínica
                <i class="material-icons right">save</i>
            </button>
    </div>
    </div>
    </form>
</div>
<?php echo $footer_consulta;  ?>
<script>
    $(document).ready(function(){
    $('select').formSelect();
  });
</script>
</body>
</html>