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
$sql_complementos = "SELECT * FROM complementos ORDER BY nom_complemento";
$result_complementos = $mysqli->query($sql_complementos);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complementos</title>
    <link rel="shortcut icon" href="../static/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../static/css/materialize.css">
    <link rel="stylesheet" href="../static/css/tables.css">
    <link rel="stylesheet" href="../static/icons/iconfont/material-icons.css">
    <script type="text/javascript" src="../static/js/jquery-3.3.1.min.js"></script>
    <script src="../static/js/materialize.js"></script>
    <script>
        function abrir(url)
          { 
            open(url,'','top=0,left=100,width=600,height=400') ; 
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
         <div class="col s12 center-align">
             <h4 style="color: #2d83a0; font-weight:bold;">Gestión de Complementos</h4>
         </div>
     </div>
     <div class="row" style="margin-top: -20px;">
         <div class="col s7" style="margin-left: 1%; ">
         <div class="table-responsive-2">
         <div class="input-field col s5 center-align">
          <i class="material-icons prefix">search</i>
          <input id="search" type="text">
          <label for="search">Buscar complementos</label>
        </div>
        <div class="col s5 center-align" style="margin-top: 25px;">
        <a href="complementos.php" class="waves-effect waves-light btn-small"><i class="material-icons right">autorenew</i>Actualizar</a>
        </div>
    <table id="mytable">
        <thead>
        <tr>
            <th>Complemento</th>
            <th>Costo</th>
            <th class="center-align">Actualizar</th>
            <th class="center-align">Eliminar</th>
        </tr>
        </thead>
        <tbody>
            <?php
            
            while($complementos = mysqli_fetch_assoc($result_complementos) ){ 
                $id_complemento = $complementos['id_comple'];
              ?>
                <tr>
                <td style="text-transform: capitalize;"><?php echo $complementos['nom_complemento']; ?></td>
                <td style="text-transform: capitalize;">$ <?php echo $complementos['precio']; ?></td>
                <td class="center-align"><a href="javascript:abrir('logic/update_complemento.php?id_complemento=<?php echo $id_complemento; ?>')"><i class="material-icons">update</i></a></td>
                <td class="center-align"><a href="logic/process.php?id_proceso=Delcomplemento&id_complemento=<?php echo $id_complemento; ?>&descrip_complemento=<?php echo $complementos['nom_complemento']; ?>"><i class="material-icons">delete</i></a></td>
                </tr>  
            <?php
        }
            ?>
        </tbody>
    </table>

    </div>
         </div>
         <div class="col s4" style="margin-left: 1%;">
            <h5 class="center-align">Nuevo Complemento</h5>
            <br>
            <form action="logic/process.php" method="POST">
            <div class="row">
            <div class="input-field col s8 offset-s2">
            <input id="1" type="text"  name="descrip_complemento">
            <label for="1">Descripción</label>
            </div>
            <div class="input-field col s8 offset-s2">
            <input id="2" type="number"  name="precio_complemento">
            <label for="2">$ Costo</label>
            </div>
           
            <div class="col s5 offset-s6">
            <button class="btn waves-effect waves-light hoverable" type="submit" name="action">Guardar
                <i class="material-icons right">save</i>
            </button>
            </div>
            </div>
            <input type="hidden" name="id_proceso" value="alta_complemento">
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
</body>
</html>