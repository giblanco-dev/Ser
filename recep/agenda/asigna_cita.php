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
    header('Location: ../../../index.php');
    exit();
}

include_once '../../app/logic/conn.php';

if(!empty($_GET))
{
$id_agenda = $_GET['iag'];
$medico = $_GET['m'];
$fecha_agenda = $_GET['fa'];


$sql_val_ag = "SELECT id_paciente, medico, FechaAgenda, Horario FROM agenda WHERE id_agenda = $id_agenda;";
$res_age = $mysqli->query($sql_val_ag);
$val_ag = $res_age->num_rows;

if($val_ag == 1){

    $row_ag = mysqli_fetch_assoc($res_age);
    $paciente = $row_ag['id_paciente'];
    $medico_cita = $row_ag['medico'];
    $fecha_cita = $row_ag['FechaAgenda'];
    $horario_cita = $row_ag['Horario'];

    $sql_val_cita = "SELECT id_cita FROM cita where id_paciente = '$paciente' and fecha = '$fecha_cita' and medico = '$medico_cita' and confirma != '3'";
    //echo $sql_val_cita;
    $res_val_cita = $mysqli->query($sql_val_cita);
    $val_cita = $res_val_cita->num_rows;

    if($val_cita == 0){
        
        $sql_new_cita = "INSERT INTO cita(id_cita, id_paciente, medico, fecha, horario, registrado, user_registra, tipo, confirma,id_agenda)
        VALUES (NULL, '$paciente', '$medico_cita', '$fecha_cita', '$horario_cita', CURRENT_TIMESTAMP, '$id_user', 0, 1,$id_agenda)";
    
                if($mysqli -> query($sql_new_cita) === true){
                    header('Location: ../agenda?medico='.$medico.'&fecha='.$fecha_agenda);  
                }else{
                    echo '<script>alert("Error al guardar la cita");
                            window.location.href="../agenda?medico='.$medico.'&fecha='.$fecha_agenda.'";</script>';
                }


    }else{
        echo '<script>alert("Error el paciente ya tiene una cita con el médico para la fecha solicitada");
        window.location.href="../agenda?medico='.$medico.'&fecha='.$fecha_agenda.'";</script>';
    }


}

}


?>