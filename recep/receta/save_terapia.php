<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
<div style="width: 40%; display:inline-block;">
<?php 
include_once '../../app/logic/conn.php';
$id_cita = $_POST['id_cita'];
$sql_terapias = "SELECT id_terapia FROM terapias WHERE activo = 1";
$res_terapias = $mysqli->query($sql_terapias);

while($terapia = mysqli_fetch_assoc($res_terapias)){
    $ter = $terapia['id_terapia'];
    $array = $_POST[$ter];
    
    if($array[1] == "on"){
        $sql_val = "SELECT * FROM rec_terapias WHERE id_terapia = '$array[0]' and id_cita = '$array[5]'";
        $val = $mysqli->query($sql_val);
        $valida = $val->num_rows;

        if($valida == 0){
            //print_r($array);
            $sql_sv = "INSERT INTO rec_terapias(id_terapia, terapia, indicaciones, monto, id_cita, user_registra)
                        VALUES ('$array[0]','$array[2]', '$array[3]','$array[4]', '$array[5]', '$array[6]')";
                if($mysqli -> query($sql_sv) === true){
                    echo '<h4>La terapia: '.$array[2].', fue registrada correctamente. $'.$array[4].'</h4>';
                }else{
                    echo '<h4>Ha ocurrido un error favor de comunicarse con el administrador del sistema</h4>';
                }
        }elseif($valida == 1){
            $ter_prev = mysqli_fetch_assoc($val);
                $indicaciones = $ter_prev['indicaciones'];
                if($indicaciones != $array[3]){
                    $sql_up = "UPDATE rec_terapias SET indicaciones = '$array[3]' WHERE id_terapia = '$array[0]' and id_cita = '$array[5]'";
                    if($mysqli -> query($sql_up) === true){
                        echo '<h4>La terapia: '.$array[2].', ya había sido registrada previamente, se han actualizado las indicaciones</h4>';
                    }
                }else{
                    echo '<h4>La terapia: '.$array[2].', ya había sido registrada previamente.</h4>';
                }
            }
        
    }
}
?>
</div>
<div style="width: 50%; display:inline-block;">
<?php 
    $sum_terapias = 0;
    $sql_total = "SELECT terapia, indicaciones, monto FROM rec_terapias WHERE id_cita = '$id_cita'";
    $res_tot_ter = $mysqli->query($sql_total);
    $tot_ter = $res_tot_ter-> num_rows;

    if($tot_ter > 0){
        echo '<h3>Terapias registradas previamente</h3>
                <table>
                <tr>
                    <td><b>Terapia</b></td>
                    <td><b>Indicaciones</b></td>
                    <td><b>Precio</b></td>
                  </tr>
                ';
        while($ter_reg = mysqli_fetch_assoc($res_tot_ter)){
            echo '<tr>
                    <td>'.$ter_reg['terapia'].'</td>
                    <td>'.$ter_reg['indicaciones'].'</td>
                    <td>$ '.$ter_reg['monto'].'</td>
                  </tr>';
            $sum_terapias = $sum_terapias + $ter_reg['monto']; 
        }
        echo '</table>
                <h3 style="float: right;">Total de terapias: $'.$sum_terapias.'</h3>';
    }else{
        echo '<h3>Aún no se ha registrado ninguna terapia de la receta de esta cita.</h3>';
    }

?>

</div>
</body>
</html>