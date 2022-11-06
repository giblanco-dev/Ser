<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../static/css/materialize.css">
    <link rel="stylesheet" href="../../static/icons/iconfont/material-icons.css">
    <title>Guardar Med.Orales</title>
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
$user = $_POST['user'];
$id_cita = $_POST['id_cita'];
$sql_1 = "SELECT id_med_oral FROM med_orales WHERE activo = 1";
$res_1 = $mysqli->query($sql_1);

while($rows = mysqli_fetch_assoc($res_1)){  
    $id = $rows['id_med_oral'];
    $array = $_POST[$id];
    
    if($array[1] > 0){
        $sql_val = "SELECT * FROM rec_med_orales WHERE id_med_oral = '$array[0]' and id_cita = '$array[5]' AND cancelado = 0";
        $val = $mysqli->query($sql_val);
        $valida = $val->num_rows;

        if($valida == 0){
            //print_r($array);
            $sql_sv = "INSERT INTO rec_med_orales(id_med_oral, med_oral, indicaciones, cantidad_med ,monto, id_cita, user_registra)
                        VALUES ('$array[0]','$array[2]', '$array[3]','$array[1]','$array[4]', '$array[5]', '$array[6]')";
                if($mysqli -> query($sql_sv) === true){
                    echo '<p>El medicamento: '.$array[2].', fue registrado correctamente. $'.$array[4].'</p>';
                }else{
                    echo '<p>Ha ocurrido un error favor de comunicarse con el administrador del sistema</p>';
                }
        }elseif($valida == 1){
            $reg_prev = mysqli_fetch_assoc($val);
                $indicaciones = $reg_prev['indicaciones'];
                if($indicaciones != $array[3]){
                    $sql_up = "UPDATE rec_med_orales SET indicaciones = '$array[3]' WHERE id_med_oral = '$array[0]' and id_cita = '$array[5]'";
                    if($mysqli -> query($sql_up) === true){
                        echo '<p>El medicamento: '.$array[2].', ya había sido registrado previamente, se han actualizado las indicaciones</p>';
                    }
                }else{
                    echo '<p>El medicamento: '.$array[2].', ya había sido registrado previamente.</p>';
                }
            }
        
    }
}
?>
</div>
<div class="col s7">
<?php 
    $sum = 0;
    $sql_total = "SELECT med_oral, indicaciones, cantidad_med, monto, id_registro, cancelado FROM rec_med_orales WHERE id_cita = '$id_cita'";
    $res_tot = $mysqli->query($sql_total);
    $total = $res_tot-> num_rows;

    if($total > 0){
        echo '<h5>Medicamentos Orales y Nutrientes registrados</h5>
                <table>
                <tr>
                    <td><b>Medicamento Oral</b></td>
                    <td><b>Cantidad</b></td>
                    <td><b>Precio</b></td>
                    <td><b>Total</b></td>
                    <td></td>
                  </tr>
                ';
        while($rows2 = mysqli_fetch_assoc($res_tot)){
            $id_med_oral = $rows2['id_registro'];
            echo '<tr>
                    <td>'.$rows2['med_oral'].'</td>
                    <td>'.$rows2['cantidad_med'].'</td>
                    <td>$ '.$rows2['monto'].'</td>
                    <td>$ '.$rows2['monto'] * $rows2['cantidad_med'].'</td>
                    ';
            if($rows2['cancelado'] == 0){
                echo'<td><a href="cancelaciones.php?med_oral='.$id_med_oral.'&u='.$user.'">Cancelar</a></td>
                    </tr>';
                    $total_med = $rows2['monto'] * $rows2['cantidad_med'];
            }else{
                echo'<td>Cancelado</td>
                    </tr>';
                    $total_med = 0;
            }
                  
            $sum = $sum + $total_med; 

            
        }
        echo '</table>
                <h5>Total de medicamentos orales: $'.$sum.'</h5>';
    }else{
        echo '<h5>Aún no se ha registrado ninguna terapia de la receta de esta cita.</h5>';
    }

?>
</div>
</div>
</body>
</html>