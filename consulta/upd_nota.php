<?php 
require_once '../app/logic/conn.php';

if(!empty($_POST)){
   $id_cita = $_POST['id_cita'];
   $nota = $_POST['nota_evo'];
   $paciente = $_POST['paciente'];
    //echo $id_cita;    c=33&p=23411
    //echo $nota;

    
    if($nota != ""){

    $sql_nota_evo = "UPDATE consulta SET nota_evolucion = '$nota' WHERE id_cita = '$id_cita'";
        if($mysqli->query($sql_nota_evo) === true){
            echo '<script type="text/javascript">window.location.href="detalle_consulta.php?c='.$id_cita.'&p='.$paciente.'"</script>';
        }else{
            echo '<h3 style="color: red; margin-top; 800px;">No se pudo actualizar al paciente favor de comunicarse con Sistemas</h3>';
        }
    }   
}
?>
