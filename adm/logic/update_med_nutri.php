<?php 
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: ../index.php');
    exit();
}elseif($_SESSION['nivel'] == 7){
            $id_user = $_SESSION['id'];
            $usuario = $_SESSION['name_usuario'];
            $nivel = $_SESSION['nivel'];
}else{
    header('Location: ../../index.php');
    exit();
}   
require_once '../../app/logic/conn.php';



if(!empty($_GET)){
$id_registro = $_GET['id_mednutri'];
$sql_actualiza = "SELECT *,
                    IF(tipo = 'm','Med Oral','Nutriente') Descrip_tipo,
                    IF(activo = 1, 'Activo', 'Inactivo') Estatus,
                    IF(egreso = 1, 'SI','NO') Descrip_Egreso
                    FROM med_orales WHERE id_med_oral =  '$id_registro'";
$result_sql = $mysqli->query($sql_actualiza);

$retorno = 0;

}



$mensaje_proceso = "";

if(!empty($_POST)){

  $nom_mednutria = $_POST['descripcion'];
  $costo_mednutri = floatval($_POST['precio']);
  $id_mednutri = $_POST['id_actualiza'];
  $tipo_mednutri = $_POST['tipo'];
  $egreso_mednutri = $_POST['egreso'];
  
  

  $sql_update = "UPDATE med_orales SET nom_med_oral = '$nom_mednutria', precio = '$costo_mednutri', tipo = '$tipo_mednutri', egreso = '$egreso_mednutri' WHERE id_med_oral = '$id_mednutri'";
  if($mysqli->query($sql_update) === true){
    $mensaje_proceso = "Complemento Actualizado";
    $retorno = 1;
  }else{
    $mensaje_proceso = "Error al actualizar, intente de nuevo o contacte al administrador del sistema";
    $retorno = 1;
  }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualización::MedOrales Nutri</title>
    <link rel="shortcut icon" href="../../static/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../static/css/materialize.css">
    <link rel="stylesheet" href="../../static/icons/iconfont/material-icons.css">
    <script type="text/javascript" src="../../static/js/jquery-3.3.1.min.js"></script>
    <script src="../../static/js/materialize.js"></script>
</head>
<body>


 
     <div class="row">
         <div class="col s12 center-align">
             <h4 style="color: #2d83a0; font-weight:bold;">Actualización Medicamentos Orales y Nutrientes</h4>
         </div>
     </div>
    
     <div class="row center-align">
         <div class="col s12">
         <h5 class="center-align"><?php echo $mensaje_proceso; ?></h5>
        </div>

         <?php 
         if($retorno == 0){         
         ?>
    <div class="col-s12 center-align">
            <?php
            
            while($row = mysqli_fetch_assoc($result_sql) ){ 
                ?>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                
                <div class="row center-align">
                  <div class="col s3">
                    <p><?php echo $row['Descrip_tipo']; ?></p>
                    <input type="text" name="descripcion" value="<?php echo $row['nom_med_oral']; ?>" required>
                  </div>
                  <div class="col s3">
                    <p>Precio <?php echo $row['Descrip_tipo']; ?></p>
                    <input type="number" name="precio" value="<?php echo $row['precio']; ?>" required step="any">
                  </div>
                  <br><br>
                  <div class=" input-field col s3">
                        <select name="tipo" required>
                        <option value="" disabled selected>Seleccione el tipo</option>
                        <option value="m">Med Oral</option>
                        <option value="n">Nutriente</option>
                        </select>
                        <label>Tipo</label>
                  </div>
                  
                  <div class=" input-field col s3">
                        <select name="egreso" required>
                        <option value="" disabled selected>Seleccione si es egreso</option>
                        <option value="1">SI</option>
                        <option value="0">NO</option>
                        </select>
                        <label>Egreso Edo. Cta.</label>
                  </div>
                </div>
                <input type="submit" class="btn-small" value="Actualizar">
                <input type="hidden" value="<?php echo $id_registro; ?>" name="id_actualiza">
                </form>
            <?php
        }
        echo '<br><a onclick="window.close();" class="btn orange">Cancelar</a>';
        }else{
          echo '<a onclick="window.close();" class="btn">Cerrar</a>';
        }
        ?>
    </div>
         </div>
         
        <script>
            $(document).ready(function(){
            $('select').formSelect();
            });
        </script>
</body>
</html>