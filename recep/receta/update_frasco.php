<?php 
require '../../app/logic/conn.php';
if(!empty($_POST)){
    $user = $_POST['u'];
    $cita = $_POST['c'];
    $tipo_fras = $_POST['tipo'];
    $num_frasco = $_POST['n_frasco'];
    $paciente = $_POST['p'];

   

    $med1 = $_POST['Med1'];
    if($med1 == '0'){
      $med1 = '';  }
    
    $med2 = $_POST['Med2'];
    if($med2 == '0'){
      $med2 = '';  
    }

    $med3 = $_POST['Med3'];
    if($med3 == '0'){
      $med3 = '';  
    }

    $med4 = $_POST['Med4'];
    if($med4 == '0'){
      $med4 = '';  
    }
    
    $med5 = $_POST['Med5'];
    if($med5 == '0'){
      $med5 = '';  
    }

 //echo $cita,"<br>";
 //echo $num_frasco,"<br>";
 //echo $tipo_fras,"<br>";

 $val_frasco = "SELECT * FROM rec_med_home WHERE id_cita = '$cita' AND tipo_fras = '$tipo_fras'
                AND frasco = '$num_frasco' AND cancelado = 0";
$res_val_frasco = $mysqli->query($val_frasco);
$val = $res_val_frasco->num_rows;

//echo "Frascos Identificados --> ",$val;

if($val == 1){
    $row_frasco = mysqli_fetch_assoc($res_val_frasco);
    $id_frasco = $row_frasco['id_registro'];

    $update_fras = "UPDATE rec_med_home SET med1 = '$med1', med2 = '$med2', med3 = '$med3', med4 = '$med4', med5 = '$med5'
                        WHERE id_registro = '$id_frasco'";
        if($mysqli->query($update_fras) === True){
            echo '<script type="text/javascript">window.location.href="todos_frascos.php?c=',$cita,'&u=',$user,'&p=',$paciente,'"</script>';
        }else{
            echo '<h4>No fue posible actualizar el frasco, intente de nuevo de lo contrario contacte con Sistemas</h4>';
        }
}else{
    echo '<h4>No fue posible identificar el frasco, intente de nuevo de lo contrario contacte con Sistemas</h4>';
}
    
/*
    if($num_frasco < 6){
      $sql_in = "INSERT INTO rec_med_home (frasco, tipo_fras, id_cita, med1, med2, med3, med4, med5, user_registra)
                            VALUES('$num_frasco', '$tipo_fras','$cita','$med1','$med2','$med3','$med4','$med5','$user')";
                if($mysqli->query($sql_in)=== True){
                    if($tipo_fras == 'ext'){
                        $tipo_trat = 6;
                    }elseif($tipo_fras == 'flo'){
                        $tipo_trat = 7;
                    }

                    

                        $sql_valt = "SELECT * FROM resu_med_home WHERE id_cita = '$cita' and tipo_fras = '$tipo_fras' AND cancelado = 0";
                        $res_valt = $mysqli->query($sql_valt);
                        $valt = $res_valt->num_rows;

                        if($valt == 1){
                            $row_resum = mysqli_fetch_assoc($res_valt);
                            $cantidad_previa = $row_resum['cant_tratamientos'];
                            $cantidad_nueva = $cantidad_previa + 1;
                            $id_resumen = $row_resum['id_registro'];

                            $sql_agrega_frasco = "UPDATE resu_med_home SET cant_tratamientos = '$cantidad_nueva'
                                                WHERE id_registro = '$id_resumen'";
                                if($mysqli->query($sql_agrega_frasco) === True){
                                    switch ($tipo_trat){
                                        case 6:
                                            echo '<script type="text/javascript">window.location.href="med_hom_ex.php?c=',$cita,'&u=',$user,'&p=',$paciente,'"</script>';
                                        break;
                                        case 7:
                                            echo '<script type="text/javascript">window.location.href="flores_bach.php?c=',$cita,'&u=',$user,'&p=',$paciente,'"</script>';
                                        break;
                                    }
                                }else{
                                    echo "Error al actualizar cantidad de frascos en tabla de resumen de tratamientos Homeopáticos";
                                }

                        }else{
                            $sql_intrat =  "INSERT INTO resu_med_home (id_cita, tipo_fras, id_tipo_trat, cant_tratamientos, user_registra)
                            VALUES('$cita','$tipo_fras','$tipo_trat',1,'$user')";
                            if($mysqli->query($sql_intrat)=== TRUE){
                                switch ($tipo_trat){
                                    case 6:
                                        echo '<script type="text/javascript">window.location.href="med_hom_ex.php?c=',$cita,'&u=',$user,'&p=',$paciente,'"</script>';
                                    break;
                                    case 7:
                                        echo '<script type="text/javascript">window.location.href="flores_bach.php?c=',$cita,'&u=',$user,'&p=',$paciente,'"</script>';
                                    break;
                                }
                            }else{
                                echo "Error al insertar en tabla de resumen de tratamientos Homeopáticos";
                            }
                        }

                  
                  
                }else{
                  echo '<p>Hay un duplicado con los medicamentos del frasco '.$no_frasco.' de la cita '.$cita.' reportar estos datos al administrador.</p>';
                }
            }

             */
          }


         
?>