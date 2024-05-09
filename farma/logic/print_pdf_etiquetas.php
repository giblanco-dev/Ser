<?php

use Dompdf\Dompdf;

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
    ob_start();
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

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="../../static/img/favicon.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Impresión de etiquetas</title>
    <style>
        table, tr,td {
                border: 1px solid black;
                border-collapse: collapse;
                }
        html{
            margin: 5px;
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>
<body>
    <?php 
    if($flag_trat_gen == 1){
        for($i = 1; $i <= $cantidad_trat_gen; $i++){
        
        $sql_det_gen = "SELECT frasco, tipo_fras, med1, med2, med3, med4, med5
        FROM rec_med_home
        WHERE id_cita = '$cita' AND cancelado = 0 AND tipo_fras = 'gen'";
        $res_det_gen = $mysqli->query($sql_det_gen);
        $cont_gen = 0;
        $total_trat_gen = $res_det_gen->num_rows;
            while($row_det_gen = mysqli_fetch_assoc($res_det_gen)){
                // Comienza impresión de tabla con etiquetas del tratamiento general
                ?>
        <table>
                <caption style="font-size: 12px;"><?php echo $nom_paciente; ?></caption>
                <tr>
                    <td style="font-size: 10px;">Frasco</td>
                    <td style="font-size: 10px;">Fecha: <?php echo $fecha_cita; ?></td>
                </tr>
                <tr>
                    <td rowspan="5" style="font-size: 30px; text-align: center;"><?php echo $row_det_gen['frasco']; ?></td>
                    <td style="font-size: 11px;"><?php if($row_det_gen['med1'] == ''){echo '---';}else{echo $row_det_gen['med1'];} ?></td>
                </tr>
                
                <tr><td style="font-size: 11px;"><?php if($row_det_gen['med2'] == ''){echo '---';}else{echo $row_det_gen['med2'];} ?></td></tr>
                <tr><td style="font-size: 11px;"><?php if($row_det_gen['med3'] == ''){echo '---';}else{echo $row_det_gen['med3'];} ?></td></tr>
                <tr><td style="font-size: 11px;"><?php if($row_det_gen['med4'] == ''){echo '---';}else{echo $row_det_gen['med4'];} ?></td></tr>
                <tr><td style="font-size: 11px;"><?php if($row_det_gen['med5'] == ''){echo '---';}else{echo $row_det_gen['med5'];} ?></td></tr>
                <tr><td colspan="2" style="font-size: 9px;">Dra. Bertha Angélica Mosqueda Hdz Ced:11105190</td></tr>        
        </table>
                       
          <?php
          $cont_gen ++;
          if($cont_gen != $total_trat_gen){
          echo '<div style="page-break-before: always;"></div>';  
          }    
        }
        }
        $upd_imp_trat_gen = "UPDATE resu_med_home SET flag_impr_et = 1, user_imp_et = '$id_user', fecha_imp_et = '$hoy'
                                WHERE id_cita = '$cita' AND cancelado = 0 AND tipo_fras = 'gen' ";
        if($mysqli->query($upd_imp_trat_gen) === True){
            $update_flag_imp = 0;
        }else{
            $update_flag_imp = 1;
        }
    }
    
    if($flag_trat_ext > 0){
        $sql_det_ext = "SELECT frasco, tipo_fras, med1, med2, med3, med4, med5
                    FROM rec_med_home
                    WHERE id_cita = '$cita' AND cancelado = 0 AND tipo_fras = 'ext'";
                    $res_det_ext = $mysqli->query($sql_det_ext);
                    $cont_extra = 0;
                    $total_extras = $res_det_ext->num_rows;
        while($row_det_ext = mysqli_fetch_assoc($res_det_ext)){
                // Comienza impresión de tabla con etiquetas del tratamiento general
            ?>
        <table>
                <caption style="font-size: 12px;"><?php echo $nom_paciente; ?></caption>
                <tr>
                    <td style="font-size: 10px;">F.Extra</td>
                    <td style="font-size: 10px;">Fecha: <?php echo $fecha_cita; ?></td>
                </tr>
                <tr>
                    <td rowspan="5" style="font-size: 30px; text-align: center;"><?php echo $row_det_ext['frasco']; ?></td>
                    <td style="font-size: 11px;"><?php if($row_det_ext['med1'] == ''){echo '---';}else{echo $row_det_ext['med1'];} ?></td>
                </tr>
    
                <tr><td style="font-size: 11px;"><?php if($row_det_ext['med2'] == ''){echo '---';}else{echo $row_det_ext['med2'];} ?></td></tr>
                <tr><td style="font-size: 11px;"><?php if($row_det_ext['med3'] == ''){echo '---';}else{echo $row_det_ext['med3'];} ?></td></tr>
                <tr><td style="font-size: 11px;"><?php if($row_det_ext['med4'] == ''){echo '---';}else{echo $row_det_ext['med4'];} ?></td></tr>
                <tr><td style="font-size: 11px;"><?php if($row_det_ext['med5'] == ''){echo '---';}else{echo $row_det_ext['med5'];} ?></td></tr>
                <tr><td colspan="2" style="font-size: 9px;">Dra. Bertha Angélica Mosqueda Hdz Ced:11105190</td></tr>        
        </table>
        <?php 
        $cont_extra ++;
        if($cont_extra != $total_extras){
            echo '<div style="page-break-before: always;"></div>';  
            }  
        
        }
       $upd_imp_trat_EXT = "UPDATE resu_med_home SET flag_impr_et = 1, user_imp_et = '$id_user', fecha_imp_et = '$hoy'
                                WHERE id_cita = '$cita' AND cancelado = 0 AND tipo_fras = 'ext'";
        if($mysqli->query($upd_imp_trat_EXT) === True){
            $update_flag_imp_2 = 0;
        }else{
            $update_flag_imp_2 = 1;
        }
    }
    
    
    if($flag_flores > 0){
        $sql_det_flor = "SELECT frasco, tipo_fras, med1, med2, med3, med4, med5
                    FROM rec_med_home
                    WHERE id_cita = '$cita' AND cancelado = 0 AND tipo_fras in ('flo','floc')";
                    $res_det_flor = $mysqli->query($sql_det_flor);
                    $cont_flores = 0;
                    $total_reg_flo = $res_det_flor->num_rows;
        while($row_det_flor = mysqli_fetch_assoc($res_det_flor)){
            // Comienza impresión de tabla con etiquetas del tratamiento general
            if($row_det_flor['tipo_fras'] == 'flo'){
                $tipo_flor = 'Flor B Gotas';
            }else{
                $tipo_flor = 'Flor B Conce';
            }
            ?>
        <table>
                <caption style="font-size: 12px;"><?php echo $nom_paciente; ?></caption>
                <tr>
                    <td style="font-size: 11px;"><?php echo $tipo_flor; ?></td>
                    <td style="font-size: 11px;">Fecha: <?php echo $fecha_cita; ?></td>
                </tr>
                <tr>
                    <td rowspan="3" style="font-size: 30px; text-align:center;"><?php echo $row_det_flor['frasco']; ?></td>
                    <td style="font-size: 11px;"><?php if($row_det_flor['med1'] == ''){echo '---';}else{echo $row_det_flor['med1'];} ?></td>
                </tr>
                <tr><td style="font-size: 11px;"><?php if($row_det_flor['med2'] == ''){echo '---';}else{echo $row_det_flor['med2'];} ?></td></tr>
                <tr><td style="font-size: 11px;"><?php if($row_det_flor['med3'] == ''){echo '---';}else{echo $row_det_flor['med3'];} ?></td></tr>
                
                <tr><td colspan="2" style="font-size: 9px;">Dra. Bertha Angélica Mosqueda Hdz Ced:11105190</td></tr>        
        </table>
        <?php
            $cont_flores ++;  
           if($cont_flores != $total_reg_flo){
            echo '<div style="page-break-before: always;"></div>';  
            }      
        }
         $upd_imp_flor = "UPDATE resu_med_home SET flag_impr_et = 1, user_imp_et = '$id_user', fecha_imp_et = '$hoy'
                                WHERE id_cita = '$cita' AND cancelado = 0 AND tipo_fras = 'flo'";
        if($mysqli->query($upd_imp_flor) === True){
            $update_flag_imp_3 = 0;
        }else{
            $update_flag_imp_3 = 1;
        }
    }
    ?>

</body>
</html>
<?php

if(($update_flag_imp + $update_flag_imp_2 + $update_flag_imp_3) == 0){

$html_etiquetas = ob_get_clean();

//echo $html_etiquetas;

require_once '../../lib/dompdf/autoload.inc.php';

$dompdf = new Dompdf();

$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled'=>true));
$dompdf->setOptions($options); 

$dompdf->loadHtml($html_etiquetas);

$dompdf->setPaper(array(0, 0, 170.0784 , 113.38546));

$dompdf->render();

$dompdf->stream("ETIQUETAS-CMA".$cita.".pdf",array("Attachment" => false));
}

}

?>