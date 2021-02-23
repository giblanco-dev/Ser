<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../static/css/materialize.css">
    <link rel="stylesheet" href="../../static/icons/iconfont/material-icons.css">
    <title>Total Receta</title>
</head>
<body>
    <?php 
    // ******************** Inicia totales de Terapias *****************
    include_once '../../app/logic/conn.php';
    $id_cita = $_GET['c'];
    $usuario = $_GET['u'];
    ?>
    
    <div class="row">
     <div class="col s8">
         <h5>Resumen Receta</h5>
     </div>
     <div class="col s4">
     <h5>Importes a cargar</h5>
     </div>   
    <div class="col s8">
    <?php 
    $sum_terapias = 0;
    $sql_total = "SELECT terapia, indicaciones, monto, no_terapias FROM rec_terapias WHERE id_cita = '$id_cita'";
    $res_tot_ter = $mysqli->query($sql_total);
    $tot_ter = $res_tot_ter-> num_rows;

    if($tot_ter > 0){
        echo '
                <table>
                <tr>
                <td colspan="2"><b>Terapias registradas previamente</h5></b></td>
                </tr>
                <tr>
                    <td><b>Terapia</b></td>
                    <td><b>Cantidad</b></td>
                    <td><b>Precio</b></td>
                    <td><b>Sub-Total</b></td>
                  </tr>
                ';
        while($ter_reg = mysqli_fetch_assoc($res_tot_ter)){
            echo '<tr>
                    <td>'.$ter_reg['terapia'].'</td>
                    <td>'.$ter_reg['no_terapias'].'</td>
                    <td>$ '.$ter_reg['monto'].'</td>
                    <td>$ '.$ter_reg['monto']*$ter_reg['no_terapias'].'</td>
                  </tr>';
            $sum_terapias = $sum_terapias + ($ter_reg['monto']*$ter_reg['no_terapias']); 
        }
        echo '
            <tr>
            <td><b>Total de terapias</b></td>
            <td><b>$'.$sum_terapias.'</b></td>
            </tr>
            </table>';
    }else{
        echo '<h5>No se registraron terapias de la receta de esta cita.</h5>';
    }

    // ******************** Inicia totales de Sueros y Complementos *****************

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
(Select complementos.precio from complementos WHERE complementos.id_comple = rec_sueros.comp5) Precio5
FROM rec_sueros
INNER JOIN sueros on rec_sueros.suero = sueros.id_suero
WHERE rec_sueros.id_cita = '$id_cita' ";
$result = $mysqli->query($sql_rec_sueros);
$val_sueros = $result->num_rows;
$total_sueros = 0;
if($val_sueros > 0){
    echo '
    <table>
    <tr>
    <td colspan="7"><b>Sueros-Complementos Registrados</b></td>
    <tr>
    <tr>
        <td><b>Suero/Precio</b></td>
        <td colspan="5"><b>Complementos</b></td>
        <td><b>Subtotal</b></td>
      </tr>';
      
    while($row = mysqli_fetch_assoc($result)){
        $sub_total = $row['precio'] + $row['Precio1'] + $row['Precio2'] + $row['Precio3'] + $row['Precio4'] + $row['Precio5'];
        echo'
        <tr>
        <td>'.$row['nom_suero'].'<br> $'.$row['precio'].'</td>
        <td>'.$row['Complemento1'].'<br>$'.$row['Precio1'].'</td>
        <td>'.$row['Complemento2'].'<br>$'.$row['Precio2'].'</td>
        <td>'.$row['Complemento3'].'<br>$'.$row['Precio3'].'</td>
        <td>'.$row['Complemento4'].'<br>$'.$row['Precio4'].'</td>
        <td>'.$row['Complemento5'].'<br>$'.$row['Precio5'].'</td>
        <td>$'.$sub_total.'</td>
        </tr>';
        $total_sueros = $total_sueros + $sub_total;
    }
        echo'
        <tr>
        <td colspan="6"><b>Total de Sueros y Complementos</b></td>
        <td><b>$'.$total_sueros.'</b></td>
        </tr>
        </table>';
}else{
    echo '<h5>Aún no hay registros de sueros de la cita Actual</h5>';
}

// *********************** Inicia totales de Medicamentos Homeopaticos *********

$sql_resu = "SELECT id_cita, tipo_fras, cant_tratamientos ,tipo_trat_hom.des_tratamiento, tipo_trat_hom.costo FROM resu_med_home
INNER JOIN tipo_trat_hom ON id_tipo_trat = id_trat WHERE id_cita = '$id_cita'";
$resumen = $mysqli->query($sql_resu);
$val_resu = $resumen->num_rows;
$total_trat = 0;
if($val_resu > 0){
    
            echo '
            <table>
                <tr>
                    <td colspan="4"><b>Total Tratamiento Homeopático</b></td>
                </tr>
                <tr>
                    <td><b>Tipo tratamiento</b></td>
                    <td><b>Precio</b></td>
                    <td><b>No. Tratamientos</b></td>
                    <td><b>Sub-Total</b></td>
                  </tr>
                ';

        while($rows3 = mysqli_fetch_assoc($resumen)){
            if($rows3['tipo_fras']== "gen"){$tipo_frasco = "Principal";}
            if($rows3['tipo_fras']== "ext"){$tipo_frasco = "Extra";}
            $sub_total_trat = $rows3['cant_tratamientos'] * $rows3['costo'];
            echo '<tr>
                    <td>'.$rows3['des_tratamiento'].'</td>
                    <td>'.$rows3['costo'].'</td>
                    <td>'.$rows3['cant_tratamientos'].'</td>
                    <td>$ '.$sub_total_trat.'</td>
                  </tr>';
                  $total_trat = $total_trat + $sub_total_trat;
        }
        echo '
        <tr>
        <td colspan="3"><b>Total Tratamiento Medicamentos Homeopáticos</b></td>
        <td><b>$'.$total_trat.'</b></td>
        </tr>
        </table>';
}else{
    echo '<h5>No se regsitro tratamiento homeopático de esta cita</h5>';
}

// Total medicamentos orales

$sum_orales = 0;
    $sql_total = "SELECT med_oral, indicaciones, cantidad_med, monto FROM rec_med_orales WHERE id_cita = '$id_cita'";
    $res_tot = $mysqli->query($sql_total);
    $total = $res_tot-> num_rows;

    if($total > 0){
        echo '
                <table>
                <tr>
                <td><b>Medicamentos Orales registrados</b></td>
                </tr>
                <tr>
                    <td><b>Medicamento Oral</b></td>
                    <td><b>Cantidad</b></td>
                    <td><b>Precio</b></td>
                  </tr>
                ';
        while($rows2 = mysqli_fetch_assoc($res_tot)){
            echo '<tr>
                    <td>'.$rows2['med_oral'].'</td>
                    <td>'.$rows2['cantidad_med'].'</td>
                    <td>$ '.$rows2['monto'].'</td>
                  </tr>';
                  $total_med = $rows2['monto'] * $rows2['cantidad_med'];
            $sum_orales = $sum_orales + $total_med; 
        }
        echo '
                <tr>
                <td colspan="2"><b>Total de medicamentos orales</b></td>
                <td><b>$'.$sum_orales.'</b></td>
                </tr>
        </table>';
                
    }else{
        echo '<h5>Aún no se ha registrado ninguna terapia de la receta de esta cita.</h5>';
    }

    ?>
    </div>


    <div class="col s4">
    <form action="" method="post">
    <table class="striped">
        <thead>
            <tr>
                <td>Resumen</td>
                <td>Importe</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Terapias</td>
                <td>$ <?php echo $sum_terapias;?></td>
            </tr>
            <tr>
                <td>Sueros</td>
                <td>$<?php echo  $total_sueros;?></td>
            </tr>
            <tr>
                <td>Med. Homeopáticos</td>
                <td>$<?php echo $total_trat;?></td>
            </tr>
            <tr>
                <td>Med. Orales</td>
                <td>$<?php echo $sum_orales;?></td>
            </tr>
            <tr>
                <td>Total a Pagar</td>
                <?php $total_receta = $sum_terapias + $total_sueros + $total_trat + $sum_orales;?>
                <td><b>$<?php echo $total_receta;?></b></td>
            </tr>
        </tbody>
    </table>
    <div class="row">
        <div class="col s6 center-align">
            <p>¿Se incluye consulta?</p>
            <br>
            <div class="switch">
            <label>
            No
            <input type="checkbox" name="consulta">
            <span class="lever"></span>
            Si
            </label>
            </div>
        </div>
        <div class="col s6">
         <p>Aplicar Descuento %</p>
         <input type="number" name="descuentos" min="0" max="100" step="5">
        </div>
        <div class="col s12 center-align">
            <br>
        <button class="btn waves-effect waves-light" type="submit" name="action">Enviar para cobro
            <i class="material-icons right">send</i>
        </button>
        </div>
    </div>
    </form>
    </div>
    </div>
</body>
</html>