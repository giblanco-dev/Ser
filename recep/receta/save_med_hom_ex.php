<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../static/css/materialize.css">
    <link rel="stylesheet" href="../../static/icons/iconfont/material-icons.css">
    <title>Frascos ExMed.Hom</title>
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

if($tipo_fras == 'ext'){
    $continua = 0;
    
    for($i = 1; $i <= 3; $i++){
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

           

            $sql_val = "SELECT id_registro FROM rec_med_home WHERE frasco = '$no_frasco' AND id_cita = '$cita' AND tipo_fras = '$tipo_fras' AND cancelado = 0";
            $res_val = $mysqli->query($sql_val);
            $val = $res_val->num_rows;
            
            if($val == 1){
                $registro = mysqli_fetch_assoc($res_val);
                $id_reg = $registro['id_registro'];
                $sql_u = "UPDATE rec_med_home SET med1 = '$med1', med2 = '$med2', med3 = '$med3', med4 = '$med4', med5 = '$med5'
                            WHERE id_registro = '$id_reg'";
                if($mysqli->query($sql_u)=== True){
                    echo '<p>Los medicamentos del frasco Extra No. '.$no_frasco.' se han actualizado</p>';
                }
            }elseif($val == 0){ 
                $sql_in = "INSERT INTO rec_med_home (frasco, tipo_fras, id_cita, med1, med2, med3, med4, med5, user_registra)
                            VALUES('$no_frasco', '$tipo_fras','$cita','$med1','$med2','$med3','$med4','$med5','$user')";
                if($mysqli->query($sql_in)=== True){
                    echo '<p>Los medicamentos del frasco Extra No. '.$no_frasco.' se han ingresado correctamente</p>';
                    $continua ++;
                }
            }else{
                echo '<p>Hay un duplicado con los medicamentos del frasco Extra '.$no_frasco.' de la cita '.$cita.' reportar estos datos al administrador.</p>';
            }
            
        }
    }
    if($continua > 0){
    
    $tipo_trat = 6;
    
    $sql_c = "SELECT id_registro FROM rec_med_home WHERE id_cita = '$cita' AND tipo_fras = 'ext' AND cancelado = 0";
    $res_c = $mysqli->query($sql_c);
    $cantidad = $res_c->num_rows;

    $sql_valt = "SELECT * FROM resu_med_home WHERE id_cita = '$cita' and tipo_fras = '$tipo_fras' AND cancelado = 0";
    $res_valt = $mysqli->query($sql_valt);
    $valt = $res_valt->num_rows;
        if($valt == 1){
            $row_valt = mysqli_fetch_assoc($res_valt);
            if($row_valt['id_tipo_trat'] == $tipo_trat and $row_valt['cant_tratamientos'] == $cantidad){
                echo "Actualización Frascos Extra terminada";
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
                    echo "Se guardo correctamente el resumen de Frascos Extra";
                }
        }

    }
} // Cierra if de inserccion/actualización tratamientos
}
?>
</div>
<div class="col s7 center-align">

<a href="save_med_hom.php?c=<?php echo $cita; ?>&u=<?php echo $user; ?>" style="margin-top: 5%;" class="waves-effect waves-light btn">Resumen Medicamentos Homeopáticos</a>

</div>
</div>
</body>
</html>