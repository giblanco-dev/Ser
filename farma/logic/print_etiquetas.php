<?php
require '../../app/logic/conn.php';

if(!empty($_POST)){

$cita = $_POST['cita'];
$flag_trat_gen = $_POST['trat_gen'];
$cantidad_trat_gen = $_POST['cant_trat_gen'];
$flag_trat_ext = $_POST['trat_ext'];
$user_print = $_POST['user'];

$ruta = 'ETIQUETAS-CMA'.$cita.'.TXT';

$file_etiquetas = fopen($ruta, "wb") or die("Hay un problema con el archivo");

if($flag_trat_gen == 1){
    $sql_det_gen = "SELECT frasco, tipo_fras, med1, med2, med3, med4, med5
    FROM rec_med_home
    WHERE id_cita = '$cita' AND cancelado = 0 AND tipo_fras = 'gen'";
    $res_det_gen = $mysqli->query($sql_det_gen);
    while($row_det_gen = mysqli_fetch_assoc($res_det_gen)){
        
        fwrite($file_etiquetas,'*** FRASCO NO. '.$row_det_gen['frasco'].' *** Fecha: 29/12/2021'.chr(13));
            fwrite($file_etiquetas,' Janet Yazmin Reyes Antonio'.chr(13));
            fwrite($file_etiquetas,' '.$row_det_gen['med1'].chr(13));
            fwrite($file_etiquetas,' '.$row_det_gen['med2'].chr(13));
            fwrite($file_etiquetas,' '.$row_det_gen['med3'].chr(13));
            fwrite($file_etiquetas,' '.$row_det_gen['med4'].chr(13));
            fwrite($file_etiquetas,' '.$row_det_gen['med5'].chr(13));
            fwrite($file_etiquetas,' Dra. Bertha Angélica Mosqueda Hernandez'.chr(13));
            fwrite($file_etiquetas,' Céd.Prof.11105190'.chr(13));
            //fwrite($file_etiquetas,chr(13));
    }
}

if($flag_trat_ext == 1){
    $sql_det_ext = "SELECT frasco, tipo_fras, med1, med2, med3, med4, med5
                FROM rec_med_home
                WHERE id_cita = '$cita' AND cancelado = 0 AND tipo_fras = 'ext'";
                $res_det_ext = $mysqli->query($sql_det_ext);
    while($row_det_ext = mysqli_fetch_assoc($res_det_ext)){
        
            fwrite($file_etiquetas,'*** EXTRA NO. '.$row_det_ext['frasco'].' *** Fecha: 29/12/2021'.chr(13));
            fwrite($file_etiquetas,' Janet Yazmin Reyes Antonio'.chr(13));
            fwrite($file_etiquetas,' '.$row_det_ext['med1'].chr(13));
            fwrite($file_etiquetas,' '.$row_det_ext['med2'].chr(13));
            fwrite($file_etiquetas,' '.$row_det_ext['med3'].chr(13));
            fwrite($file_etiquetas,' '.$row_det_ext['med4'].chr(13));
            fwrite($file_etiquetas,' '.$row_det_ext['med5'].chr(13));
            fwrite($file_etiquetas,' Dra. Bertha Angélica Mosqueda Hernandez'.chr(13));
            fwrite($file_etiquetas,' Céd.Prof.11105190'.chr(13));
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

}
?>