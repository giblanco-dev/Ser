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

$nombres = $_POST['nombres'];
$a_paterno = $_POST['a_paterno'];
$tel_movil = $_POST['tel_movil'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];

require '../app/logic/conn.php';

$sql_paciente = "SELECT id_paciente, CONCAT(nombres,' ',a_paterno,' ',a_materno) nombre_completo FROM paciente WHERE nombres= '$nombres' AND a_paterno = '$a_paterno' 
                AND tel_movil = '$tel_movil' AND fecha_nacimiento = '$fecha_nacimiento'";
$result_sql_paciente = $mysqli->query($sql_paciente);
$pacientes = $result_sql_paciente -> num_rows;

if($pacientes == 1){
    $row_paciente = $result_sql_paciente->fetch_assoc();
    $nombre_paciente = $row_paciente['nombre_completo'];
    $id_paciente = $row_paciente['id_paciente'];
}

include_once 'recep_sections.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
    <title>Captura His-Clínica</title>
    <link rel="stylesheet" href="../css/materialize.css">
    <link rel="stylesheet" href="../icons/iconfont/material-icons.css">
    <script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="../js/materialize.js"></script>
</head>
<body>
<?php echo $nav_recep;  ?>
<div class="container">
    <div class="row center-align">
            <div class="col s12">
                <h4 style="color: #2d83a0; font-weight:bold;">Captura de Historia Clínica del paciente: <?php echo $nombre_paciente; ?></h4>
                <div class="divider"></div>
            </div>
        </div>
    <form action="logic_recep/save_hcg.php" method="POST">
    <div class="row">
        <div class="col s4">
            <blockquote>
            <h6>Antecedentes heredo familiares</h6>
            </blockquote>
        </div>
        <div class="input-field col s8">
            <textarea id="textarea" class="materialize-textarea" name="hcg2" required></textarea>
            <label for="textarea">Capture los antecedentes heredo familiares</label>
        </div>
    </div>
    <div class="row">
        <div class="col s4">
            <blockquote>
                <h6>Antecedentes personales no patológicos</h6>
            </blockquote>
        </div>
        <div class="input-field col s8">
            <textarea id="textarea" class="materialize-textarea" name="hcg3" required></textarea>
            <label for="textarea">Capture los antecedentes personales no patológicos</label>
        </div>
    </div>
    <div class="row">
        <div class="col s4">
            <blockquote>
                <h6>Antecedentes personales patológicos</h6>
            </blockquote>
        </div>
        <div class="input-field col s8">
            <textarea id="textarea" class="materialize-textarea" name="hcg4" required></textarea>
            <label for="textarea">Capture los antecedentes personales patológicos</label>
        </div>
    </div>
    <div class="row">
        <div class="col s4">
            <blockquote>
                <h6>Antecedentes gineco-obstetricos</h6>
            </blockquote>
        </div>
        <div class="input-field col s8">
            <textarea id="textarea" class="materialize-textarea" name="hcg5" required></textarea>
            <label for="textarea">Capture los antecedentes gineco-obstetricos</label>
        </div>
    </div>
    <div class="row">
        <div class="col s4">
            <blockquote>
                <h6>Padecimiento Actual</h6>
            </blockquote>
        </div>
        <div class="input-field col s8">
            <textarea id="textarea" class="materialize-textarea" name="hcg6" required></textarea>
            <label for="textarea">Capture el padecimiento actual</label>
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
                <textarea id="textarea" class="materialize-textarea" name="hcg7" required></textarea>
                <label for="textarea">Respiratorio</label>
                </div>
                <div class="input-field col s6">
                <textarea id="textarea" class="materialize-textarea" name="hcg8" required></textarea>
                <label for="textarea">Gastroinstestinal</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                <textarea id="textarea" class="materialize-textarea" name="hcg9" required></textarea>
                <label for="textarea">Genitourinario</label>
                </div>
                <div class="input-field col s6">
                <textarea id="textarea" class="materialize-textarea" name="hcg10" required></textarea>
                <label for="textarea">Hematopogénico y linfatico</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                <textarea id="textarea" class="materialize-textarea" name="hcg11" required></textarea>
                <label for="textarea">Endocrino</label>
                </div>
                <div class="input-field col s6">
                <textarea id="textarea" class="materialize-textarea" name="hcg12" required></textarea>
                <label for="textarea">Nervioso</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                <textarea id="textarea" class="materialize-textarea" name="hcg13" required></textarea>
                <label for="textarea">Músculos esquelético</label>
                </div>
                <div class="input-field col s6">
                <textarea id="textarea" class="materialize-textarea" name="hcg14" required></textarea>
                <label for="textarea">Piel, mucosa y anexos</label>
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
          <input id="txt" type="text" class="validate" name="hcg15">
          <label for="txt">T/A</label>
        </div>
        <div class="input-field col s2">
          <input id="txt" type="text" class="validate" name="hcg16">
          <label for="txt">TEMP</label>
        </div>
        <div class="input-field col s2">
          <input id="txt" type="text" class="validate" name="hcg17">
          <label for="txt">FRE C</label>
        </div>
        <div class="input-field col s2">
          <input id="txt" type="text" class="validate" name="hcg18">
          <label for="txt">FRE R</label>
        </div>
        <div class="input-field col s2">
          <input id="txt" type="text" class="validate" name="hcg19">
          <label for="txt">PESO</label>
        </div>
        <div class="input-field col s2">
          <input id="txt" type="text" class="validate" name="hcg20">
          <label for="txt">TALLA</label>
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
                <textarea id="textarea" class="materialize-textarea" name="hcg21" required></textarea>
                <label for="textarea">Habitus exterior</label>
                </div>
                <div class="input-field col s6">
                <textarea id="textarea" class="materialize-textarea" name="hcg22" required></textarea>
                <label for="textarea">Cabeza y cuello</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                <textarea id="textarea" class="materialize-textarea" name="hcg23" required></textarea>
                <label for="textarea">Torax</label>
                </div>
                <div class="input-field col s6">
                <textarea id="textarea" class="materialize-textarea" name="hcg24" required></textarea>
                <label for="textarea">Abdomen</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                <textarea id="textarea" class="materialize-textarea" name="hcg25" required></textarea>
                <label for="textarea">Genitales</label>
                </div>
                <div class="input-field col s6">
                <textarea id="textarea" class="materialize-textarea" name="hcg26" required></textarea>
                <label for="textarea">Extremidades</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                <textarea id="textarea" class="materialize-textarea" name="hcg27" required></textarea>
                <label for="textarea">Piel</label>
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
            <textarea id="textarea" class="materialize-textarea" name="hcg28" required></textarea>
            <label for="textarea">Capture los resultados</label>
        </div>
    </div>
    <div class="row">
        <div class="col s4">
            <blockquote>
                <h6>Diagnósticos o problemas clínicos</h6>
            </blockquote>
        </div>
        <div class="input-field col s8">
            <textarea id="textarea" class="materialize-textarea" name="hcg29" required></textarea>
            <label for="textarea">Capture los diágnosticos</label>
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
                <textarea id="textarea" class="materialize-textarea" name="hcg30" required></textarea>
                <label for="textarea">Terapéutica empleada y resultados (previos)</label>
                </div>
            </div>
            <div class="row">
            <div class="input-field col s6">
                <textarea id="textarea" class="materialize-textarea" name="hcg31" required></textarea>
                <label for="textarea">Terapéutica actual</label>
                </div>
                <div class="input-field col s6">
                <textarea id="textarea" class="materialize-textarea" name="hcg32" required></textarea>
                <label for="textarea">Prónosticos</label>
                </div>
            </div>
            <div class="row">
            <div class="input-field col s12">
                <select name="medico">
                <option value="" disabled selected>Selecciona el médico</option>
                <option value="Dr. Enrique Mtz">Option 1</option>
                <option value="Dr. León">Option 2</option>
                <option value="Dr. 3">Option 3</option>
                </select>
                <label>Médico que realizo la Historia Clínica</label>
                <input type="hidden" name="usuario_captura" value="<?php echo $id_user?>">
                <input type="hidden" name="id_paciente" value="<?php echo $id_paciente?>">
            </div>
            </div>
    </div>
    </div>
    <div class="row center-align">
    <div class="divider" style="margin-bottom: 3%;"></div>
    <div class="col s12">
    <button class="btn-large waves-effect waves-light" type="submit" name="action">Guardar Historia Clínica
                <i class="material-icons right">save</i>
            </button>
    </div>
    </div>
    </form>
</div>
<?php echo $footer_recep;  ?>
<script>
    $(document).ready(function(){
    $('select').formSelect();
  });
</script>
</body>
</html>