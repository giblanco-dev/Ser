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
$sql_trat = "SELECT * FROM tipo_trat_hom";
$result_trat = $mysqli->query($sql_trat);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tratamientos</title>
    <link rel="shortcut icon" href="../static/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../static/css/materialize.css">
    <link rel="stylesheet" href="../static/css/tables.css">
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
             <h4 style="color: #2d83a0; font-weight:bold;">Gestión de Tratamientos</h4>
         </div>
     </div>
     <div class="row">
         <div class="col s7" style="margin-left: 1%;">
         <h5 class="center-align">Catálogo de Tratamientos</h5>
         <div class="table-responsive-2">
    <table>
        <thead>
        <tr>
            <th>Tipo de Tratamiento</th>
            <th>Costo</th>
            <th class="center-align">Actualizar</th>
            <th class="center-align">Eliminar</th>
        </tr>
        </thead>
        <tbody>
            <?php
            
            while($tratamientos = mysqli_fetch_assoc($result_trat) ){ ?>
                <tr>
                <td style="text-transform: capitalize;"><?php echo $tratamientos['des_tratamiento']; ?></td>
                <td style="text-transform: capitalize;">$ <?php echo $tratamientos['costo']; ?></td>
                <td class="center-align"><a href=""><i class="material-icons">update</i></a></td>
                <td class="center-align"><a href=""><i class="material-icons">delete</i></a></td>
                </tr>  
            <?php
        }
            ?>
        </tbody>
    </table>

    </div>
         </div>
         <div class="col s4" style="margin-left: 1%;">
            <h5 class="center-align">Nuevo Tipo de Tratamiento</h5>
            <br>
            <form action="user/altas.php" method="POST">
            <div class="row">
            <div class="input-field col s8 offset-s2">
            <input id="last_name" type="text"  name="">
            <label for="last_name">Descripción</label>
            </div>
            <div class="input-field col s8 offset-s2">
            <input id="last_name" type="number"  name="">
            <label for="last_name">$ Costo</label>
            </div>
           
            <div class="col s5 offset-s6">
            <button class="btn waves-effect waves-light hoverable" type="submit" name="action">Guardar
                <i class="material-icons right">save</i>
            </button>
            </div>
            </div>
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
            $(document).ready(function(){
            $('select').formSelect();
            });
        </script>
</body>
</html>