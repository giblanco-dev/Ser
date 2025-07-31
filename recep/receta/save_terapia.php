<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../static/css/materialize.css">
    <link rel="stylesheet" href="../../static/icons/iconfont/material-icons.css">
    <title>Guardar Terapias</title>
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
<body>
<div class="row">
<div class="col s5">
<?php 
include_once '../../app/logic/conn.php';
$id_cita = $_POST['id_cita'];
$user = $_POST['user'];

$sql_terapias = "SELECT id_terapia FROM terapias WHERE activo = 1";
$res_terapias = $mysqli->query($sql_terapias);


while($terapia = mysqli_fetch_assoc($res_terapias)){
    $ter = $terapia['id_terapia'];
    $array = $_POST[$ter];
    
    if($array[1] > 0){
        $sql_val = "SELECT * FROM rec_terapias WHERE id_terapia = '$array[0]' and id_cita = '$array[5]' and cancelado = 0";
        $val = $mysqli->query($sql_val);
        $valida = $val->num_rows;

        if($valida == 0){
            if($array[3]== "-"){
                $indicaciones = "Sin Indicaciones";
            }else{
                $indicaciones = $array[3];
            }
            //print_r($array);
            $sql_sv = "INSERT INTO rec_terapias(id_terapia, terapia, indicaciones, monto, id_cita, user_registra, no_terapias)
                        VALUES ('$array[0]','$array[2]', '$indicaciones','$array[4]', '$array[5]', '$array[6]', '$array[1]')";
                if($mysqli -> query($sql_sv) === true){
                    echo '<p>La terapia: '.$array[2].', fue registrada correctamente. $'.$array[4].'</p>';
                }else{
                    echo '<p>Ha ocurrido un error favor de comunicarse con el administrador del sistema</p>';
                }
        }elseif($valida == 1){
            $ter_prev = mysqli_fetch_assoc($val);
                $indicaciones = $ter_prev['indicaciones'];
                if($indicaciones != $array[3]){
                    $sql_up = "UPDATE rec_terapias SET indicaciones = '$array[3]' WHERE id_terapia = '$array[0]' and id_cita = '$array[5]'";
                    if($mysqli -> query($sql_up) === true){
                        echo '<p>La terapia: '.$array[2].', ya había sido registrada previamente, se han actualizado las indicaciones</p>';
                    }
                }else{
                    echo '<p>La terapia: '.$array[2].', ya había sido registrada previamente.</p>';
                }
            }
        
    }
}
?>
</div>
<div class="col s7">
<?php 
    $sum_terapias = 0;
    $sql_total = "SELECT id_registro, terapia, indicaciones, monto, no_terapias, cancelado FROM rec_terapias WHERE id_cita = '$id_cita'";
    $res_tot_ter = $mysqli->query($sql_total);
    $tot_ter = $res_tot_ter-> num_rows;

    if($tot_ter > 0){
        echo '<h5>Terapias registradas previamente</h5>
                <table>
                <tr>
                    <td><b>Terapia</b></td>
                    <td><b>Cantidad</b></td>
                    <td><b>Indicaciones</b></td>
                    <td><b>Precio</b></td>
                    <td><b>Sub-Total</b></td>
                    <td></td>
                  </tr>
                ';
        while($ter_reg = mysqli_fetch_assoc($res_tot_ter)){
            
            echo '<tr>
                    <td>'.$ter_reg['terapia'].'</td>
                    <td>'.$ter_reg['no_terapias'].'</td>
                    <td>'.$ter_reg['indicaciones'].'</td>
                    <td>$'.$ter_reg['monto'].'</td>
                    <td>$ '.$ter_reg['monto']*$ter_reg['no_terapias'].'</td>';
                    if($ter_reg['cancelado']==0){
                        echo '<td><a href="cancelaciones.php?c_terapia='.$ter_reg['id_registro'].'&u='.$user.'">Cancelar</a></td></tr>';
                        $sum_terapias = $sum_terapias + ($ter_reg['monto'] * $ter_reg['no_terapias']); 
                    }else{
                        echo '<td>Cancelado</td></tr>';
                    }
                  
            
        }
        echo '</table>
                <h5>Total de terapias: $'.$sum_terapias.'</h5>';
    }else{
        echo '<h5>Aún no se ha registrado ninguna terapia de la receta de esta cita.</h5>';
    }

?>

</div>
</div>
</body>
</html>