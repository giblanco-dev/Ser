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
$sql_users = "SELECT user.id, concat(nombre,' ',apellido) nom_completo, user.nivel, niveles.descripcion, user.usuario FROM user 
            INNER JOIN niveles on user.nivel = niveles.nivel
            ORDER BY nom_completo";
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
    <link rel="stylesheet" href="../static/css/tables.css">
    <link rel="stylesheet" href="../static/icons/iconfont/material-icons.css">
    <script type="text/javascript" src="../static/js/jquery-3.3.1.min.js"></script>
    <script src="../static/js/materialize.js"></script>
    <script>
        function abrir(url)
          { 
            open(url,'','top=0,left=100,width=1200,height=350') ; 
          }
    </script>
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
         <div class="col s12 center-align" style="margin-bottom: 0px;">
             <h4 style="color: #2d83a0; font-weight:bold;">Administración de Usuarios</h4>
         </div>
     </div>
     <div class="row">
         <div class="col s8" style="margin-left: 1%;">
         <div class="table-responsive-2">

        <div class="input-field col s5 center-align">
          <i class="material-icons prefix">search</i>
          <input id="search" type="text">
          <label for="search">Buscar Usuarios</label>
        </div>
        <div class="col s3 center-align" style="margin-top: 25px;">
        <a href="users.php" class="waves-effect waves-light btn-small"><i class="material-icons right">autorenew</i>Actualizar</a>
        </div>
    <table id="mytable">
        <thead>
        <tr>
            <th>Nombre</th>
            <th>Usuario</th>
            <th>Nivel</th>
            <th class="center-align">Restablecer contraseña</th>
            <th class="center-align">Actualizar</th>
            <th class="center-align">Eliminar</th>
        </tr>
        </thead>
        <tbody>
            <?php
            
            while($users = mysqli_fetch_assoc($result_sql_users) ){ 
                $usuario_id = $users['id'];

                ?>
                
                <tr>
                <td style="text-transform: capitalize;"><?php echo $users['nom_completo']; ?></td>
                <td><?php echo $users['usuario']; ?></td>
                <td style="text-transform: capitalize;"><?php echo $users['descripcion']; ?></td>
                <td class="center-align"><a href="logic/process.php?id_proceso=ResetPass&id_user=<?php echo $usuario_id; ?>&nom_user=<?php echo $users['usuario'] ?>"><i class="material-icons">update</i></a></td>
                <td class="center-align"><a href="javascript:abrir('logic/update_user.php?idu=<?php echo $usuario_id; ?>')"><i class="material-icons">create</i></a></td>
                <td class="center-align"><a href="logic/process.php?id_proceso=DelUser&id_user=<?php echo $usuario_id; ?>&nom_user=<?php echo $users['usuario'] ?>"><i class="material-icons">delete</i></a></td>
                </tr>  
            <?php
        }
            ?>
        </tbody>
    </table>

    </div>
         </div>
         <div class="col s3" style="margin-left: 1%;">
            <h5 class="center-align">Nuevo Usuario</h5>
            <br>
            <form action="logic/process.php" method="POST">
            <div class="row">
            <div class="input-field col s8 offset-s2">
            <input id="last_name" type="text" placeholder="Capturé el nombre" name="nombre">
            <label for="last_name">Nombre</label>
            </div>
            <div class="input-field col s8 offset-s2">
            <input id="last_name" type="text" placeholder="Capturé apellido" name="apaterno">
            <label for="last_name">Apellido Paterno</label>
            </div>
            <!--<div class="input-field col s8 offset-s2">
            <input id="last_name" type="text" placeholder="Capturé el nombre de usuario(inicial del nombre y apellido)">
            <label for="last_name">Nombre de Usuario</label>
            </div-->
            <div class="input-field col s8 offset-s2">
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
            <div class="col s5 offset-s6">
            <button class="btn waves-effect waves-light hoverable" type="submit" name="action">Crear usuario
                <i class="material-icons right">save</i>
            </button>
            </div>
            </div>
            <input type="hidden" name="id_proceso" value="AltaUsuario">
            </form>
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
            // Write on keyup event of keyword input element
            $(document).ready(function(){
            $("#search").keyup(function(){
            _this = this;
            // Show only matching TR, hide rest of them
            $.each($("#mytable tbody tr"), function() {
            if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
            $(this).hide();
            else
            $(this).show();
            });
            });
            });
            </script>
            <script>
            $(document).ready(function(){
            $('select').formSelect();
            });
        </script>
</body>
</html>