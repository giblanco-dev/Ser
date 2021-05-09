<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../static/css/materialize.css">
    <link rel="stylesheet" href="../../static/icons/iconfont/material-icons.css">
    <title>Guardar Med.Homeopáticos</title>
    <style>
        body{
            font-family: 'Roboto', sans-serif;
        }
        table{
            width: 100%;
            border-spacing: 1em;
        }
        
    </style>
</head>
<body style="background-color: #f5f5f5;">
<div class="row">

<div class="col s5">
<?php 

include_once '../../app/logic/conn.php';
if(!empty($_POST))
{
    $user = $_POST['u'];
    $cita = $_POST['c'];
    $tipo_fras = $_POST['tipo'];

if($tipo_fras == 'gen'){
    $continua = 0;
    
    for($i = 1; $i <= 10; $i++){
        $itera = "frasco".$i;
        //echo "medicamentos del frasco".$i;
        $array_frasco = $_POST[$itera];
        //print_r($ar_frasco);
        if($array_frasco[0] == 'on'){
            $no_frasco = $i;
            $med1 = $array_frasco[1];
            $med2 = $array_frasco[2];
            $med3 = $array_frasco[3];
            $med4 = $array_frasco[4];
            $med5 = $array_frasco[5];

           

            $sql_val = "SELECT id_registro FROM rec_med_home WHERE frasco = '$no_frasco' AND id_cita = '$cita' AND tipo_fras = '$tipo_fras' and cancelado = 0";
            $res_val = $mysqli->query($sql_val);
            $val = $res_val->num_rows;
            
            if($val == 1){
                $registro = mysqli_fetch_assoc($res_val);
                $id_reg = $registro['id_registro'];
                $sql_u = "UPDATE rec_med_home SET med1 = '$med1', med2 = '$med2', med3 = '$med3', med4 = '$med4', med5 = '$med5'
                            WHERE id_registro = '$id_reg'";
                if($mysqli->query($sql_u)=== True){
                    echo '<p>Los medicamentos del frasco No. '.$no_frasco.' se han actualizado</p>';
                }
            }elseif($val == 0){ 
                $sql_in = "INSERT INTO rec_med_home (frasco, tipo_fras, id_cita, med1, med2, med3, med4, med5, user_registra)
                            VALUES('$no_frasco', '$tipo_fras','$cita','$med1','$med2','$med3','$med4','$med5','$user')";
                if($mysqli->query($sql_in)=== True){
                    echo '<p>Los medicamentos del frasco No. '.$no_frasco.' se han ingresado correctamente</p>';
                    $continua ++;
                }
            }else{
                echo '<p>Hay un duplicado con los medicamentos del frasco '.$no_frasco.' de la cita '.$cita.' reportar estos datos al administrador.</p>';
            }
            
        }
    }
    if($continua > 0){
    
    $tipo_trat = $_POST['tipo_trat'];
    $cantidad = $_POST['cant_trat'];
    
    $sql_valt = "SELECT * FROM resu_med_home WHERE id_cita = '$cita' and tipo_fras = '$tipo_fras' AND cancelado = 0";
    $res_valt = $mysqli->query($sql_valt);
    $valt = $res_valt->num_rows;
        if($valt == 1){
            $row_valt = mysqli_fetch_assoc($res_valt);
            if($row_valt['id_tipo_trat'] == $tipo_trat and $row_valt['cant_tratamientos'] == $cantidad){
                echo "Actualización terminada";
            }else{
                $sql_ut =  "UPDATE resu_med_home SET id_tipo_trat = '$tipo_trat', cant_tratamientos = '$cantidad'";
                if($mysqli->query($sql_ut) === True){
                    echo "Se ha actualizado el tipo de tratamiento y/o la cantidad de tratamientos, revisar correctamente el resumen";
                }
            }
        }elseif($valt == 0){
            $sql_intrat =  "INSERT INTO resu_med_home (id_cita, tipo_fras, id_tipo_trat, cant_tratamientos, user_registra)
                            VALUES('$cita','$tipo_fras','$tipo_trat','$cantidad','$user')";
                if($mysqli->query($sql_intrat) === True){
                    echo "Se guardo correctamente el resumen del tratamiento";
                }
        }

    }
} // cierra if de inserccion actualización
}else{
    $user = $_GET['u'];
    $cita = $_GET['c'];
}
?>
</div>
<div class="col s7">
<?php 
$sql_fras = "SELECT * FROM rec_med_home WHERE id_cita = $cita";
$fras = $mysqli->query($sql_fras);
$val_fras = $fras->num_rows;

$sql_resu = "SELECT id_cita, tipo_fras, cant_tratamientos ,tipo_trat_hom.des_tratamiento, tipo_trat_hom.costo, cancelado, id_registro FROM resu_med_home
INNER JOIN tipo_trat_hom ON id_tipo_trat = id_trat WHERE id_cita = $cita";
$resumen = $mysqli->query($sql_resu);

if($val_fras > 0){
    $total_trat = 0;
    echo '<br><h5 style="margin-top: 0;">Medicamentos Homeopáticos registrados</h5>
                <table class="centered">
                <tr>
                    <td><b>Frasco</b></td>
                    <td><b>Tipo</b></td>
                    <td><b>Medicamentos</b></td>
                  </tr>
                ';
        while($rows2 = mysqli_fetch_assoc($fras)){
            if($rows2['cancelado'] == 0){
                $medicamentos = $rows2['med1'].' '.$rows2['med2'].' '.$rows2['med3'].' '.$rows2['med4'].' '.$rows2['med5'];
                if($rows2['tipo_fras']== "gen"){$tipo_frasco = "Principal"; $no_frasco = $rows2['frasco'];}
                if($rows2['tipo_fras']== "ext"){$tipo_frasco = "Extra";$no_frasco = $rows2['frasco'].' Ex';}
                echo '<tr>
                        <td>'.$no_frasco.'</td>
                        <td>'.$tipo_frasco.'</td>
                        <td>'.$medicamentos.'</td>
                    </tr>';
            }
        }

        echo '
                <tr>
                    <td colspan="4"><b>Totales</b></td>
                </tr>
                <tr>
                    <td><b>Tipo tratamiento</b></td>
                    <td><b>Precio</b></td>
                    <td><b>Cantidad de Tratamientos</b></td>
                    <td><b>Sub-Total</b></td>
                    <td></td>
                  </tr>
                ';

        while($rows3 = mysqli_fetch_assoc($resumen)){
            if($rows3['tipo_fras']== "gen"){$tipo_frasco = "Principal";}
            if($rows3['tipo_fras']== "ext"){$tipo_frasco = "Extra";}
            if($rows3['cancelado'] == 0){
                $sub_total_trat = $rows3['cant_tratamientos'] * $rows3['costo'];
                $cancela = '<a href="cancelaciones.php?rmehome='.$rows3['id_registro'].'&u='.$user.'&c='.$rows3['id_cita'].'&tf='.$rows3['tipo_fras'].'">Cancelar</a>';
            }else{
                $sub_total_trat = 0;
                $cancela = 'Cancelado';
            }
            
            echo '<tr>
                    <td>'.$rows3['des_tratamiento'].'</td>
                    <td>'.$rows3['costo'].'</td>
                    <td>'.$rows3['cant_tratamientos'].'</td>
                    <td>$ '.$sub_total_trat.'</td>
                    <td> '.$cancela.'</td>
                  </tr>';
                  $total_trat = $total_trat + $sub_total_trat;
        }
        echo '
        </table>
        <br>
        <h5>Total Tratamiento Medicamentos Homeopáticos: $'.$total_trat.'</h5>';

}else{
    echo '<h5>No se regsitro tratamiento homeopático de esta cita</h5>';
}


?>

</div>
</div>
</body>
</html>