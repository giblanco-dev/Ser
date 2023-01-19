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
    header('Location: ../index.php');
    exit();
}   
require_once '../../app/logic/conn.php';



if(!empty($_GET)){
$id_registro = $_GET['idtrath'];
$sql_actualiza = "SELECT * FROM tipo_trat_hom WHERE id_trat =  '$id_registro'";
$result_sql = $mysqli->query($sql_actualiza);

$retorno = 0;

}



$mensaje_proceso = "";

if(!empty($_POST)){

  $descrip_trath = $_POST['descripcion'];
  $costo_trath = $_POST['precio'];
  $id_trat_h = $_POST['id_actualiza'];
  

  $sql_update = "UPDATE tipo_trat_hom SET des_tratamiento = '$descrip_trath', costo = '$costo_trath' WHERE id_trat = '$id_trat_h'";
  if($mysqli->query($sql_update) === true){
    $mensaje_proceso = "Tratamiento Actualizado";
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
    <title>Actualización::Tratamientos</title>
    <link rel="shortcut icon" href="../../static/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../static/css/materialize.css">
    <link rel="stylesheet" href="../../static/icons/iconfont/material-icons.css">
    <script type="text/javascript" src="../../static/js/jquery-3.3.1.min.js"></script>
    <script src="../../static/js/materialize.js"></script>
</head>
<body>


 
     <div class="row">
         <div class="col s12 center-align">
             <h4 style="color: #2d83a0; font-weight:bold;">Actualización de Tipo de Tratamientos Homeopáticos</h4>
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
            
            while($row = mysqli_fetch_assoc($result_sql) ){ ?>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                
                <div class="row center-align">
                  <div class="col s6">
                    <p>Descripción del tipo de Tratamiento</p>
                    <input type="text" name="descripcion" value="<?php echo $row['des_tratamiento']; ?>">
                  </div>
                  <div class="col s6">
                    <p>Precio del tipo de Tratamiento</p>
                    <input type="text" name="precio" value="<?php echo $row['costo']; ?>">
                    
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