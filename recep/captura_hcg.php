<?php 
$nombres = $_POST['nombres'];
$a_paterno = $_POST['a_paterno'];
$tel_movil = $_POST['tel_movil'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];

echo $nombres,'<br>';
echo $a_paterno,'<br>';
echo $tel_movil,'<br>';
echo $fecha_nacimiento,'<br>';

require '../app/logic/conn.php';
//include_once 'recep_sections.php';
$sql_paciente = "SELECT id_paciente, CONCAT(nombres,' ',a_paterno,' ',a_materno) nombre_completo FROM paciente WHERE nombres= '$nombres' AND a_paterno = '$a_paterno' 
                AND tel_movil = '$tel_movil' AND fecha_nacimiento = '$fecha_nacimiento'";
$result_sql_paciente = $mysqli->query($sql_paciente);
$pacientes = $result_sql_paciente -> num_rows;

if($pacientes == 1){
    
}

?>