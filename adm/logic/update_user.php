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
$usuario_id = $_GET['idu'];
$sql_users = "SELECT user.id, nombre ,apellido, user.nivel, niveles.descripcion, usuario FROM user 
            INNER JOIN niveles on user.nivel = niveles.nivel WHERE user.id = '$usuario_id'";
$result_sql_users = $mysqli->query($sql_users);

$sql_nivel = "SELECT nivel, descripcion FROM niveles";
$result_sql_nivel = $mysqli->query($sql_nivel);

$retorno = 0;

}



$mensaje_proceso = "";

if(!empty($_POST)){

  $nombre_user = $_POST['nombre'];
  $apellido_user = $_POST['apellido'];
  $username = $_POST['nom_usuario'];
  $nivel = $_POST['nivel']; 
  $id_user_sis = $_POST['id_user_sis'];

  $sql_update_user = "UPDATE user SET nombre = '$nombre_user', apellido = '$apellido_user', usuario = '$username', nivel = '$nivel' WHERE id = '$id_user_sis'";
  if($mysqli->query($sql_update_user) === true){
    $mensaje_proceso = "Usuario actualizado";
    $retorno = 1;
  }else{
    $mensaje_proceso = "Error al actualizar usuario, intente de nuevo o contacte al administrador del sistema";
    $retorno = 1;
  }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualización::Usuarios</title>
    <link rel="shortcut icon" href="../../static/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../static/css/materialize.css">
    <link rel="stylesheet" href="../../static/icons/iconfont/material-icons.css">
    <script type="text/javascript" src="../../static/js/jquery-3.3.1.min.js"></script>
    <script src="../../static/js/materialize.js"></script>
</head>
<body>


 
     <div class="row">
         <div class="col s12 center-align">
             <h4 style="color: #2d83a0; font-weight:bold;">Actualización de Usuario</h4>
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
            
            while($users = mysqli_fetch_assoc($result_sql_users) ){ ?>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                
                <div class="row center-align">
                  <div class="col s3">
                    <input type="text" name="nombre" value="<?php echo $users['nombre']; ?>">
                  </div>
                  <div class="col s3">
                    <input type="text" name="apellido" value="<?php echo $users['apellido']; ?>">
                  </div>
                  <div class="col s3">
                  <input type="text" name="nom_usuario" value="<?php echo $users['usuario']; ?>">
                  </div>
                  <div class="col s3">
                        <div class="input-field">
                      <select name="nivel">
                      <option value="" disabled selected>Seleccione el nivel</option>
                      <?php 
                      while($niveles = mysqli_fetch_assoc($result_sql_nivel)){
                          echo '<option value="'.$niveles['nivel'].'">'.$niveles['descripcion'].'</option>';
                      }
                      ?>
                      </select>
                      <label>Nivel Anterior: <?php echo $users['descripcion']; ?></label>
                      </div>
                  </div>
                </div>
                <input type="submit" class="btn-small" value="Actualizar">
                <input type="hidden" value="<?php echo $usuario_id; ?>" name="id_user_sis">
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