<?php 
require '../../app/logic/conn.php';


if(!empty($_POST)){

    

    $id_cita_fras = $_POST['id_cita_fras'];
    $tipo_fras = $_POST['tipo_fras'];
    $cita_actual = $_POST['cita_actual'];
    $usuario = $_POST['usuario'];
    $paciente = $_POST['paciente'];

    $sql_val_med_cap = "SELECT id_cita, tipo_fras, cancelado FROM rec_med_home WHERE tipo_fras = '$tipo_fras' AND id_cita = '$cita_actual' and cancelado = 0;";
        $res_val_frascos = $mysqli->query($sql_val_med_cap);
        $med_val = $res_val_frascos->num_rows;
if($med_val == 0){
    echo $sql_in = "INSERT INTO rec_med_home
                 SELECT frasco, tipo_fras, $cita_actual, med1, med2, med3, med4, med5, $usuario, NOW(), NULL, 0 FROM rec_med_home 
                                                    WHERE id_cita = $id_cita_fras AND tipo_fras = '$tipo_fras' and cancelado = 0";

            if($mysqli->query($sql_in)=== True){
            $result_in_med_h =  '<p>Los frascos del tratamiento de la cita '.$id_cita_fras.' se han ingresado correctamente</p>';
            echo '<script type="text/javascript">window.location.href="med-homeopaticos.php?c=',$cita_actual,'&u=',$usuario,'&p=',$paciente,'"</script>';
            }else{
            echo $result_in_med_h = '<p>Error al insertar los medicamentos de la cita '.$id_cita_fras.' reportar estos datos al administrador.</p>';
            }


}else{
  echo 'Ya existen frascos capturados de este tratamiento, cancele el tratamiento actual para poder generar la copia del tratamiento';
}



}else{
    echo 'Error de solicitud';
}

?>