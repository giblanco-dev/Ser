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

  $val_meds = $med1.$med2.$med3.$med4.$med;
    

    if($num_frasco < 11 and $val_meds != ''){
      $sql_in = "INSERT INTO rec_med_home (frasco, tipo_fras, id_cita, med1, med2, med3, med4, med5, user_registra)
                            VALUES('$num_frasco', '$tipo_fras','$cita','$med1','$med2','$med3','$med4','$med5','$user')";
                if($mysqli->query($sql_in)=== True){
                  $result_in_med_h =  '<p>Los medicamentos del frasco No. '.$no_frasco.' se han ingresado correctamente</p>';
                  echo '<script type="text/javascript">window.location.href="med-homeopaticos.php?c=',$cita,'&u=',$user,'&p=',$paciente,'"</script>';
                }else{
                  echo $result_in_med_h = '<p>Hay un duplicado con los medicamentos del frasco '.$no_frasco.' de la cita '.$cita.' reportar estos datos al administrador.</p>';
                }
            }else{
              echo '<script type="text/javascript">window.location.href="med-homeopaticos.php?c=',$cita,'&u=',$user,'&p=',$paciente,'"</script>';
            }
          }
?>