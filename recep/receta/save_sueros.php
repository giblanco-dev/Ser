<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../static/css/materialize.css">
    <link rel="stylesheet" href="../../static/icons/iconfont/material-icons.css">
    <title>Guardar Sueros</title>
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
<div class="col s3">
<?php 
include_once '../../app/logic/conn.php';
$id_cita = $_POST['id_cita'];
$user = $_POST['user'];
$sql_sueros = "SELECT id_suero FROM sueros";
$res_sueros = $mysqli->query($sql_sueros);

while($sueros = mysqli_fetch_assoc($res_sueros)){
    $id_suero = $sueros['id_suero'];
    $array = $_POST[$id_suero];
    
    if($array[1] == "on"){
        $sql_val = "SELECT * FROM rec_sueros WHERE suero = '$array[0]' and id_cita = '$id_cita' and cancelado = 0";
        $val = $mysqli->query($sql_val);
        $valida = $val->num_rows;

        if($valida == 0){
            //print_r($array);
            $sql_sv = "INSERT INTO rec_sueros(suero, comp1, comp2, comp3, comp4, comp5, id_cita, user_registra)
                        VALUES ('$array[0]','$array[2]', '$array[3]','$array[4]', '$array[5]', '$array[6]','$id_cita','$user')";
                if($mysqli -> query($sql_sv) === true){
                    echo '<p>El suero: '.$array[7].', fue registrado correctamente con sus complementos</p>';
                }else{
                    echo '<p>Ha ocurrido un error favor de comunicarse con el administrador del sistema</p>';
                }
        }elseif($valida == 1){
            $suero_prev = mysqli_fetch_assoc($val);
                    $sql_up = "UPDATE rec_sueros SET comp1 = '$array[2]', comp2 = '$array[3]', comp3 = '$array[4]',
                                                    comp4 = '$array[5]', comp5 = '$array[6]', user_registra = '$user'
                               WHERE suero = '$array[0]' and id_cita = '$id_cita'";
                    if($mysqli -> query($sql_up) === true){
                        echo '<p>El suero: '.$array[7].', ya había sido registrada previamente, se han actualizado los complementos</p>';
                    }else{
                        echo '<p>Ha ocurrido un error al actualizar favor de comunicarse con el administrador del sistema</p>';
                    }
            }
    }
} 
   
?>
</div>
<div class="col s9">
<?php 
$sql_rec_sueros = "SELECT sueros.nom_suero, sueros.precio,
(Select complementos.nom_complemento from complementos WHERE complementos.id_comple = rec_sueros.comp1) Complemento1,
(Select complementos.precio from complementos WHERE complementos.id_comple = rec_sueros.comp1) Precio1,
(Select complementos.nom_complemento from complementos WHERE complementos.id_comple = rec_sueros.comp2) Complemento2,
(Select complementos.precio from complementos WHERE complementos.id_comple = rec_sueros.comp2) Precio2,
(Select complementos.nom_complemento from complementos WHERE complementos.id_comple = rec_sueros.comp3) Complemento3,
(Select complementos.precio from complementos WHERE complementos.id_comple = rec_sueros.comp3) Precio3,
(Select complementos.nom_complemento from complementos WHERE complementos.id_comple = rec_sueros.comp4) Complemento4,
(Select complementos.precio from complementos WHERE complementos.id_comple = rec_sueros.comp4) Precio4,
(Select complementos.nom_complemento from complementos WHERE complementos.id_comple = rec_sueros.comp5) Complemento5,
(Select complementos.precio from complementos WHERE complementos.id_comple = rec_sueros.comp5) Precio5,
rec_sueros.cancelado, rec_sueros.id_registro
FROM rec_sueros
INNER JOIN sueros on rec_sueros.suero = sueros.id_suero
WHERE rec_sueros.id_cita = '$id_cita' ";
$result = $mysqli->query($sql_rec_sueros);
$val_sueros = $result->num_rows;

if($val_sueros > 0){
    echo '<br><h5>Sueros-Complementos Registrados</h5>
    <table class="centered">
    <tr>
        <th><b>Suero</b></th>
        <th><b>Precio</b></th>
        <th colspan="5"><b>Complementos</b></th>
        <th><b>Subtotal</b></th>
        <th><b></b></th>
      </tr>';
      $total = 0;
    while($row = mysqli_fetch_assoc($result)){
        if($row['cancelado'] == 0){
            $sub_total = $row['precio'] + $row['Precio1'] + $row['Precio2'] + $row['Precio3'] + $row['Precio4'] + $row['Precio5'];
            $cancela = '<a href="cancelaciones.php?c_suero='.$row['id_registro'].'&u='.$user.'">Cancelar</a>';
        }else{
            $sub_total = 0;
            $cancela = 'Cancelado';
        }
        
        echo'
        <tr>
        <td>'.$row['nom_suero'].'</td>
        <td>$'.$row['precio'].'</td>
        <td>'.$row['Complemento1'].'<br>$'.$row['Precio1'].'</td>
        <td>'.$row['Complemento2'].'<br>$'.$row['Precio2'].'</td>
        <td>'.$row['Complemento3'].'<br>$'.$row['Precio3'].'</td>
        <td>'.$row['Complemento4'].'<br>$'.$row['Precio4'].'</td>
        <td>'.$row['Complemento5'].'<br>$'.$row['Precio5'].'</td>
        <td>$'.$sub_total.'</td>
        <td>'.$cancela.'</td>
        </tr>';
        $total = $total + $sub_total;
    }
        echo'
        </table>
        <h5>Total de Sueros y Complementos: $'.$total.'</h5>';
}else{
    echo '<h5>Aún no hay registros de sueros de la cita Actual</h5>';
}
?>
</div>
</div>
</body>
</html>