<?php 
require '../../app/logic/conn.php';
$error = '';
if(!empty($_POST)){
    $id_paciente = $_POST['id_paciente'];
    $hcg2 = $_POST['hcg2'];
    $hcg3 = $_POST['hcg3'];
    $hcg4 = $_POST['hcg4'];
    $hcg5 = $_POST['hcg5'];
    $hcg6 = $_POST['hcg6'];
    $hcg7 = $_POST['hcg7'];
    $hcg8 = $_POST['hcg8'];
    $hcg9 = $_POST['hcg9'];
    $hcg10 = $_POST['hcg10'];
    $hcg11 = $_POST['hcg11'];
    $hcg12 = $_POST['hcg12'];
    $hcg13 = $_POST['hcg13'];
    $hcg14 = $_POST['hcg14'];
    $hcg15 = $_POST['hcg15'];
    $hcg16 = $_POST['hcg16'];
    $hcg17 = $_POST['hcg17'];
    $hcg18 = $_POST['hcg18'];
    $hcg19 = $_POST['hcg19'];
    $hcg20 = $_POST['hcg20'];
    $hcg21 = $_POST['hcg21'];
    $hcg22 = $_POST['hcg22'];
    $hcg23 = $_POST['hcg23'];
    $hcg24 = $_POST['hcg24'];
    $hcg25 = $_POST['hcg25'];
    $hcg26 = $_POST['hcg26'];
    $hcg27 = $_POST['hcg27'];
    $hcg28 = $_POST['hcg28'];
    $hcg29 = $_POST['hcg29'];
    $hcg30 = $_POST['hcg30'];
    $hcg31 = $_POST['hcg31'];
    $hcg32 = $_POST['hcg32'];
    $medico = $_POST['medico'];
    $usuario_captura = $_POST['usuario_captura'];

    $sql_validacion = "SELECT id_paciente FROM his_clinica_gen WHERE id_paciente = '$id_paciente'";
    $result_sql_validacion = $mysqli -> query($sql_validacion);
    $registros = $result_sql_validacion -> num_rows;
    //echo $registros;
    
    if($registros == 0){
        $sql_save_historia = "INSERT INTO his_clinica_gen(id_paciente, fecha_captura, hcg2, hcg3, hcg4, hcg5, hcg6, hcg7, hcg8,
            hcg9, hcg10, hcg11, hcg12, hcg13, hcg14, hcg15, hcg16, hcg17, hcg18, hcg19, hcg20, hcg21, hcg22, hcg23, hcg24, hcg25, hcg26,
            hcg27, hcg28, hcg29, hcg30, hcg31, hcg32, medico, usuario_captura) 
            VALUES ( '$id_paciente', CURRENT_TIMESTAMP, '$hcg2','$hcg3','$hcg4','$hcg5','$hcg6','$hcg7','$hcg8','$hcg9','$hcg10','$hcg11', '$hcg12', '$hcg13',
            '$hcg14','$hcg15','$hcg16','$hcg17', '$hcg18', '$hcg19', '$hcg20', '$hcg21', '$hcg22', '$hcg23', '$hcg24', '$hcg25', '$hcg26', '$hcg27', '$hcg28',
            '$hcg29','$hcg30','$hcg31','$hcg32','$medico', '$usuario_captura');";
            
            if ($mysqli->query($sql_save_historia) === TRUE) {
                echo '<script type="text/javascript" async="async">alert("Se ha registrado correctamente la Historia Clinica del Paciente CSA'.$id_paciente.'");window.location.href="../"</script>';
            } else {
                echo '<script type="text/javascript" async="async">alert("Ha ocurrido un error, intente nuevamente \n , de lo contrario contacte con el administrador del sistema");window.location.href="../"</script>';
            }
        
        }else{
            $sql_save_historia = "UPDATE his_clinica_gen SET  fecha_captura = 'CURRENT_TIMESTAMP', hcg2 = '$hcg2', hcg3 = '$hcg3', hcg4 = '$hcg4', hcg5 = '$hcg5', 
            hcg6 = '$hcg6', hcg7 = '$hcg7', hcg8 = '$hcg8', hcg9 = '$hcg9', hcg10 = '$hcg10', hcg11 = '$hcg11', hcg12 = '$hcg12', hcg13 = '$hcg13', hcg14 = '$hcg14', 
            hcg15 = '$hcg15', hcg16 = '$hcg16', hcg17 = '$hcg17', hcg18 = '$hcg18', hcg19 = '$hcg19', hcg20 = '$hcg20', hcg21 = '$hcg21', hcg22 = '$hcg22', hcg23 = '$hcg23', 
            hcg24 = '$hcg24', hcg25 = '$hcg25', hcg26 = '$hcg26', hcg27 = '$hcg27', hcg28 = '$hcg28', hcg29 = '$hcg29', hcg30 = '$hcg30', hcg31 = '$hcg31', hcg32 = '$hcg32',
            medico = '$medico', usuario_captura = '$usuario_captura' WHERE id_paciente = '$id_paciente';";

            //echo $sql_save_historia;
            
            if ($mysqli->query($sql_save_historia) === TRUE) {
                //echo "OK";
                echo '<script type="text/javascript" async="async">alert("Se ha actualizado correctamente la Historia Clinica del Paciente CSA'.$id_paciente.'");window.location.href="../"</script>';
            } else {
                //echo "Error";
                echo '<script type="text/javascript" async="async">alert("Ha ocurrido un error, intente nuevamente \n , de lo contrario contacte con el administrador del sistema");window.location.href="../"</script>';
            }
        } 
    }else{
        echo '<script type="text/javascript" async="async">alert("No se ha recibido una petición por parte del sistema contacte con el administrador del sistema");window.location.href="../"</script>';
    }
?>