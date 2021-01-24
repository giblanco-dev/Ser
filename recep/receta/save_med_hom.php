<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
<body style="background-color: #e0e0e0;">
<div style="width: 50%; display:inline-block;">
<?php 

include_once '../../app/logic/conn.php';

if($_POST['tipo'] == 'gen'){
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

            $user = $_POST['u'];
            $cita = $_POST['c'];

            $sql_val = "SELECT id_registro FROM rec_med_home WHERE frasco = '$no_frasco' AND id_cita = '$cita'";
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
                $sql_in = "INSERT INTO rec_med_home (frasco, id_cita, med1, med2, med3, med4, med5, user_registra)
                            VALUES('$no_frasco','$cita','$med1','$med2','$med3','$med4','$med5','$user')";
                if($mysqli->query($sql_in)=== True){
                    echo '<p>Los medicamentos del frasco No. '.$no_frasco.' se han ingresado correctamente</p>';
                }
            }else{
                echo '<p>Hay un duplicado con los medicamentos del frasco '.$no_frasco.' de la cita '.$cita.' reportar estos datos al administrador.</p>';
            }
            
        }
    }
}
?>
</div>
<div style="width: 50%; display:inline-block;">
</div>
</body>
</html>