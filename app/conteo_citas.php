<?php 
include_once 'logic/conn.php';

$hoy = date("Y-m-d");

$sql_citas = "SELECT cita.id_cita, cita.confirma
FROM cita
INNER JOIN paciente ON cita.id_paciente = paciente.id_paciente
INNER JOIN tipos_cita on cita.tipo = tipos_cita.id_tipo_cita
LEFT JOIN user on cita.medico = user.id
WHERE cita.fecha = '$hoy' 
ORDER BY cita.fecha, cita.horario";

$result_sql_citas = $mysqli -> query($sql_citas);
$total_citas = $result_sql_citas -> num_rows;

$citas_confirmadas = 0;
while($contar_citas_confirm = mysqli_fetch_assoc($result_sql_citas)){
    if($contar_citas_confirm['confirma'] == 2){
        $citas_confirmadas ++;
    }
}

?>