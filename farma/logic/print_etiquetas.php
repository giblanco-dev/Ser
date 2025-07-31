<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: ../index.php');
    exit();
}elseif($_SESSION['nivel'] == 5 OR $_SESSION['nivel'] == 7){
            $id_user = $_SESSION['id'];
            $usuario = $_SESSION['name_usuario'];
            $nivel = $_SESSION['nivel'];
}else{
    header('Location: ../index.php');
    exit();
}   

require '../../app/logic/conn.php';

if(!empty($_POST)){

    $hoy = date("Y-m-d H:i:s"); 

$cita = $_POST['cita'];
$flag_trat_gen = $_POST['trat_gen'];
$cantidad_trat_gen = $_POST['cant_trat_gen'];
$flag_trat_ext = $_POST['trat_ext'];
$flag_flores = $_POST['trat_flores'];
$user_print = $_POST['user'];
$nom_paciente = $_POST['nom_paciente'];
$fecha_cita = $_POST['fecha_cita'];

$update_flag_imp_2 = "";
$update_flag_imp = "";

$ruta = 'ETIQUETAS-CMA'.$cita.'.TXT';

$file_etiquetas = fopen($ruta, "wb") or die("Hay un problema con el archivo");

if($flag_trat_gen == 1){
    for($i = 1; $i <= $cantidad_trat_gen; $i++){
    $sql_det_gen = "SELECT frasco, tipo_fras, med1, med2, med3, med4, med5
    FROM rec_med_home
    WHERE id_cita = '$cita' AND cancelado = 0 AND tipo_fras = 'gen'";
    $res_det_gen = $mysqli->query($sql_det_gen);
        while($row_det_gen = mysqli_fetch_assoc($res_det_gen)){
            
            fwrite($file_etiquetas,'*** FRASCO NO. '.$row_det_gen['frasco'].' *** Fecha: '.$fecha_cita.chr(13));
            fwrite($file_etiquetas,$nom_paciente.chr(13));
            fwrite($file_etiquetas,' '.$row_det_gen['med1'].chr(13));
            fwrite($file_etiquetas,' '.$row_det_gen['med2'].chr(13));
            fwrite($file_etiquetas,' '.$row_det_gen['med3'].chr(13));
            fwrite($file_etiquetas,' '.$row_det_gen['med4'].chr(13));
            fwrite($file_etiquetas,' '.$row_det_gen['med5'].chr(13));
            fwrite($file_etiquetas,' Dra. Bertha Angélica Mosqueda Hernandez'.chr(13));
            fwrite($file_etiquetas,' Céd.Prof.11105190'.chr(13));
    }
    }
    $upd_imp_trat_gen = "UPDATE resu_med_home SET flag_impr_et = 1, user_imp_et = '$id_user', fecha_imp_et = '$hoy'
                            WHERE id_cita = '$cita' AND cancelado = 0 AND tipo_fras = 'gen' ";
    if($mysqli->query($upd_imp_trat_gen) === True){
        $update_flag_imp = "";
    }else{
        $update_flag_imp = "Error al actualizar bandera de impresión de tratamiento hom. general";
    }
}

if($flag_trat_ext == 1){
    $sql_det_ext = "SELECT frasco, tipo_fras, med1, med2, med3, med4, med5
                FROM rec_med_home
                WHERE id_cita = '$cita' AND cancelado = 0 AND tipo_fras = 'ext'";
                $res_det_ext = $mysqli->query($sql_det_ext);
    while($row_det_ext = mysqli_fetch_assoc($res_det_ext)){
        
            fwrite($file_etiquetas,'*** EXTRA NO. '.$row_det_ext['frasco'].' *** Fecha: '.$fecha_cita.chr(13));
            fwrite($file_etiquetas,$nom_paciente.chr(13));
            fwrite($file_etiquetas,' '.$row_det_ext['med1'].chr(13));
            fwrite($file_etiquetas,' '.$row_det_ext['med2'].chr(13));
            fwrite($file_etiquetas,' '.$row_det_ext['med3'].chr(13));
            fwrite($file_etiquetas,' '.$row_det_ext['med4'].chr(13));
            fwrite($file_etiquetas,' '.$row_det_ext['med5'].chr(13));
            fwrite($file_etiquetas,' Dra. Bertha Angélica Mosqueda Hernandez'.chr(13));
            fwrite($file_etiquetas,' Céd.Prof.11105190'.chr(13));
    }
    $upd_imp_trat_EXT = "UPDATE resu_med_home SET flag_impr_et = 1, user_imp_et = '$id_user', fecha_imp_et = '$hoy'
                            WHERE id_cita = '$cita' AND cancelado = 0 AND tipo_fras = 'ext'";
    if($mysqli->query($upd_imp_trat_EXT) === True){
        $update_flag_imp_2 = "";
    }else{
        $update_flag_imp_2 = "Error al actualizar bandera de impresión de tratamiento hom. Extra";
    }
}

if($flag_flores >= 1){
    $sql_det_flor = "SELECT frasco, tipo_fras, med1, med2, med3, med4, med5
                FROM rec_med_home
                WHERE id_cita = '$cita' AND cancelado = 0 AND tipo_fras = 'flo'";
                $res_det_ext = $mysqli->query($sql_det_ext);
    while($row_det_ext = mysqli_fetch_assoc($res_det_ext)){
        
            fwrite($file_etiquetas,'*** FLOR NO. '.$row_det_ext['frasco'].' *** Fecha: '.$fecha_cita.chr(13));
            fwrite($file_etiquetas,$nom_paciente.chr(13));
            fwrite($file_etiquetas,' '.$row_det_ext['med1'].chr(13));
            fwrite($file_etiquetas,' '.$row_det_ext['med2'].chr(13));
            fwrite($file_etiquetas,' '.$row_det_ext['med3'].chr(13));
            fwrite($file_etiquetas,' '.$row_det_ext['med4'].chr(13));
            fwrite($file_etiquetas,' '.$row_det_ext['med5'].chr(13));
            fwrite($file_etiquetas,' Dra. Bertha Angélica Mosqueda Hernandez'.chr(13));
            fwrite($file_etiquetas,' Céd.Prof.11105190'.chr(13));
    }
    $upd_imp_trat_EXT = "UPDATE resu_med_home SET flag_impr_et = 1, user_imp_et = '$id_user', fecha_imp_et = '$hoy'
                            WHERE id_cita = '$cita' AND cancelado = 0 AND tipo_fras = 'flo'";
    if($mysqli->query($upd_imp_trat_EXT) === True){
        $update_flag_imp_2 = "";
    }else{
        $update_flag_imp_2 = "Error al actualizar bandera de impresión de tratamiento hom. Extra";
    }
}


fclose($file_etiquetas);

header('Content-Description: File Transfer');
header('Content-Disposition: attachment; filename='.basename($ruta));
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($ruta));
header("Content-Type: text/plain");
readfile($ruta);

if($update_flag_imp != "" OR $update_flag_imp_2 != ""){
    echo $update_flag_imp,"<br>";
    echo $update_flag_imp_2,"<br>";
}

}




?>