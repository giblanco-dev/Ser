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
require_once '../app/logic/conn.php';
$usuario_id = $_GET['idu'];
$sql_users = "SELECT user.id, nombre ,apellido, user.nivel, niveles.descripcion, usuario FROM user 
            INNER JOIN niveles on user.nivel = niveles.nivel WHERE user.id = '$usuario_id'";
$result_sql_users = $mysqli->query($sql_users);

$sql_nivel = "SELECT nivel, descripcion FROM niveles";
$result_sql_nivel = $mysqli->query($sql_nivel);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <link rel="shortcut icon" href="../static/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../static/css/materialize.css">
    
    <link rel="stylesheet" href="../static/icons/iconfont/material-icons.css">
    <script type="text/javascript" src="../static/js/jquery-3.3.1.min.js"></script>
    <script src="../static/js/materialize.js"></script>
</head>
<body>
<header>
 <div class="navbar-fixed">
 <nav>
    <div class="nav-wrapper">
      <a href="#" class="responsive-img" class="brand-logo"><img src="../static/img/logo.png" style="max-height: 150px; margin-left: 20px;"></a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
      <li><a href="index.php"><i class="material-icons right">home</i>Inicio</a></li>
      <li><a href="../app/logic/logout.php"><i class="material-icons right">close</i>Cerrar Sistema</a></li>
      </ul>
    </div>
  </nav>
 </div>
 </header>

 
     <div class="row">
         <div class="col s12 center-align">
             <h4 style="color: #2d83a0; font-weight:bold;">Actualización del Usuario</h4>
         </div>
     </div>
     <div class="container">
     <div class="row">
         <div class="col s12">
         <h5 class="center-align">Usuarios Activos</h5>
         <div style="min-height: 350px;">
    <table>
        <thead>
        <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Usuario</th>
            <th>Nivel</th>
            <th>Actualizar Nivel</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
            <?php
            
            while($users = mysqli_fetch_assoc($result_sql_users) ){ ?>
                <form action="" method="post">
                <tr>
                <td style="text-transform: capitalize;"><input type="text" name="nombre" value="<?php echo $users['nombre']; ?>"></td>
                <td style="text-transform: capitalize;"><input type="text" name="apellido" value="<?php echo $users['apellido']; ?>"></td>
                <td style="text-transform: capitalize;"><input type="text" name="nom_usuario" value="<?php echo $users['usuario']; ?>"></td>
                <td style="text-transform: capitalize;"><?php echo $users['descripcion']; ?></td>
                <td>
                <div class="input-field">
                <select name="nivel">
                <option value="" disabled selected>Seleccione el nivel</option>
                <?php 
                while($niveles = mysqli_fetch_assoc($result_sql_nivel)){
                    echo '<option value="'.$niveles['nivel'].'">'.$niveles['descripcion'].'</option>';
                }
                ?>
                </select>
                <label>Nivel</label>
                </div>

                </td>
                <td class="center-align"><input type="submit" value="Actualizar"></td>
                </tr>
                </form>
            <?php
        }
            ?>
        </tbody>
    </table>

    </div>
         </div>
         
     </div>
     </div>


 <footer class="page-footer">
          <div class="container">
            <div class="row">
              <div class="col l6 s12 center-align">
                <h5 class="white-text">Usuario Activo <br><?php echo $usuario; ?></h5>
              </div>
              <div class="col l4 offset-l2 s12">
                <h5 class="white-text">Contacto</h5>
              </div>
            </div>
          </div>
          <div class="footer-copyright">
            <div class="container">
            © 2020 Copyright
            </div>
          </div>
        </footer>
        <script>
            $(document).ready(function(){
            $('select').formSelect();
            });
        </script>
</body>
</html>