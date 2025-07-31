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
$sql_mednutri = "SELECT *,
                IF(tipo = 'm','Med Oral','Nutriente') Descrip_tipo,
                IF(activo = 1, 'Activo', 'Inactivo') Estatus,
                IF(egreso = 1, 'SI','NO') Descrip_Egreso
                FROM med_orales ORDER BY nom_med_oral";
$result_sql_mednutri = $mysqli->query($sql_mednutri);


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicamentos y Nutrientes</title>
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
             <h4 style="color: #2d83a0; font-weight:bold;">Administración de Medicamentos Orales y Nutrientes</h4>
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
        <a href="orales-nutri.php" class="waves-effect waves-light btn-small"><i class="material-icons right">autorenew</i>Actualizar</a>
        </div>
    <table id="mytable">
        <thead>
        <tr>
            <th>Medicamento/Nutriente</th>
            <th>Precio</th>
            <th>Tipo</th>
            <th>Estatus</th>
            <th>Egreso Edo. Cta</th>
            <th class="center-align">Actualizar</th>
            <th class="center-align">Activar/Inactivar</th>
        </tr>
        </thead>
        <tbody>
            <?php
            
            while($row_mednutri = mysqli_fetch_assoc($result_sql_mednutri) ){ 
                $id_mednutri = $row_mednutri['id_med_oral'];
                if($row_mednutri['activo'] == 1){
                    $flag_status = 'Inactivar';
                    $icon = 'add_circle';
                    $color_icon = 'red-text text-darken-4';
                }else{
                    $flag_status = 'Activar';
                    $icon = 'pause_circle_filled';
                    $color_icon = '';
                }
                ?>
                
                <tr>
                <td style="text-transform: capitalize;"><?php echo $row_mednutri['nom_med_oral']; ?></td>
                <td>$ <?php echo $row_mednutri['precio']; ?></td>
                <td style="text-transform: capitalize;"><?php echo $row_mednutri['Descrip_tipo']; ?></td>
                <td class="center-align"><?php echo $row_mednutri['Estatus']; ?></td>
                <td class="center-align"><?php echo $row_mednutri['Descrip_Egreso']; ?></td>
                <td class="center-align"><a href="javascript:abrir('logic/update_med_nutri.php?id_mednutri=<?php echo $id_mednutri; ?>')"><i class="material-icons">create</i></a></td>
                <td class="center-align"><a class="<?php echo $color_icon; ?>" href="logic/process.php?id_proceso=Inactivar_mednutri&id_mednutri=<?php echo $id_mednutri; ?>&nom_mednutri=<?php echo $row_mednutri['nom_med_oral'] ?>&flag_mednutri=<?php echo $row_mednutri['activo'] ?>">
                                            <i class="material-icons"><?php echo $icon; ?></i></a></td>
                </tr>  
            <?php
        }
            ?>
        </tbody>
    </table>

    </div>
         </div>
         <div class="col s3" style="margin-left: 1%;">
            <h5 class="center-align">Nuevo Medicamento/Nutriente</h5>
            <br>
            <form action="logic/process.php" method="POST">
            <div class="row">
            <div class="input-field col s7 offset-s1">
            <input id="nombre_mednutri" type="text"  name="nombre_mednutri">
            <label for="nombre_mednutri">Nombre</label>
            </div>
            <div class="input-field col s3">
            <input id="precio" type="number"  name="precio" step="any">
            <label for="precio">Precio</label>
            </div>
          
            <div class="input-field col s9 offset-s1">
                <select name="tipo">
                <option value="" disabled selected>Seleccione el tipo</option>
                <option value="m">Med Oral</option>
                <option value="n">Nutriente</option>
                </select>
                <label>Tipo</label>
            </div>
            <div class="input-field col s9 offset-s1">
                <select name="egreso">
                <option value="" disabled selected>Seleccione si es egreso</option>
                <option value="1">SI</option>
                <option value="0">NO</option>
                </select>
                <label>Egreso Edo. Cta.</label>
            </div>
            <div class="col s5 offset-s6">
            <button class="btn waves-effect waves-light hoverable" type="submit" name="action">Guardar
                <i class="material-icons right">save</i>
            </button>
            </div>
            </div>
            <input type="hidden" name="id_proceso" value="AltaMedNutri">
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