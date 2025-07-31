<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: ../../../index.php');
    exit();
} elseif ($_SESSION['nivel'] == 1 or $_SESSION['nivel'] == 7) {
    $id_user = $_SESSION['id'];
    $usuario = $_SESSION['name_usuario'];
    $nivel = $_SESSION['nivel'];
} else {
    header('Location: ../../../index.php');
    exit();
}
include_once '../recep_sections.php';
include_once '../../app/logic/conn.php';

$sql_medico = "SELECT id, concat(nombre,' ',apellido) medico FROM user WHERE nivel = 'medico' and id in (5,6,7) ORDER BY medico";
$result_sql_medico = $mysqli -> query($sql_medico);
$despliega = 0;


if(!empty($_POST)){

    $id_medico = $_POST['medico'];
    $no_dia = $_POST['no_dia'];
    
    $despliega = 1;

}elseif(!empty($_GET)){
    $id_medico = $_GET['medico'];
    $no_dia = $_GET['no_dia'];
    $despliega = 1;
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda</title>
    <link rel="shortcut icon" href="../../static/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../static/css/materialize.css">
    <link rel="stylesheet" href="../../static/icons/iconfont/material-icons.css">
    <link rel="stylesheet" href="../../static/css/main.css">
    <script type="text/javascript" src="../../static/js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="../../static/js/materialize.js"></script>
    <script src="../../static/js/select2.min.js"></script>
    <style type="text/css"> 
        thead tr th { 
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: #ffffff;
        }
    
        .table-responsive-2 { 
            height: 350px; /* Mover a 400 para demostrar el scroll*/
            overflow-y:scroll;
        }
    </style>
</head>

<body>
<header>
 <div class="navbar-fixed">
 <nav>
    <div class="nav-wrapper">
      <a href="#" class="responsive-img" class="brand-logo"><img src="../../static/img/logo.png" style="max-height: 150px; margin-left: 20px;"></a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
      <!--li><a href="../"><i class="material-icons right">home</i>Inicio</a></li-->
      <li><a href="../agenda/"><i class="material-icons right">perm_contact_calendar</i>Agenda</a></li>
      <!--li><a href="../../app/logic/logout.php"><i class="material-icons right">close</i>Cerrar Sistema</a></li-->
      </ul>
    </div>
  </nav>
 </div>
 </header>
    <div class="container">
        <div class="row center-align">
            <div class="col s12">
                <h5 style="color: #2d83a0; font-weight:bold;">Administrar Horarios</h5>
            </div>
        </div>
    </div>
    
    <div class="row" style="width: 99%;">
        <div class="col s3" style="margin-bottom: 10%; margin-top: 3%;">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                  <div class="input-field col s12">
                    <select name="medico" required>
                    <option value="" disabled selected>Seleccione médico</option>
                    <?php 
                    while($medicos = mysqli_fetch_assoc($result_sql_medico)){
                        echo '<option value="'.$medicos['id'].'">'.$medicos['medico'].'</option>';
                    }
                    ?>
                    </select>
                    <label>Médico</label>
                </div>
                <div class="input-field col s12">
                    <select name="no_dia" required>
                    <option value="" disabled selected>Seleccione día</option>
                    <option value="1">Lunes</option>
                    <option value="2">Martes</option>
                    <option value="3">Miércoles</option>
                    <option value="4">Jueves</option>
                    <option value="5">Viernes</option>
                    <option value="6">Sabádo</option>
                    <option value="7">Domingo</option>
                    </select>
                    <label>Día</label>
                </div>
                <button style="width: 100%; font-size:12" class="btn-small waves-effect waves-light  light-green darken-4" type="submit" name="action">Gestionar Horarios
                    <i class="material-icons right">date_range</i>
                </button>
            </form>
        </div>
        
                    <!--  SECCION DE CARGA DE HORARIOS -->
            <?php 
            if($despliega == 1){
            
            $colum_medico = "";
            $name_dia = "";
            switch ($id_medico){
                case 5:
                    $name_medico = "Dr. Enrique";
                    break;
                case 6:
                    $name_medico = "Dr. Guillermo";
                    break;
                case 7:
                    $name_medico = "Dra. Angélica";
                    break;
                default:
                $colum_medico = "";
            }

            switch ($no_dia){
                case 1:
                    $name_dia = "Lunes";
                    break;
                case 2:
                    $name_dia = "Martes";
                    break;
                case 3:
                    $name_dia = "Miércoles";
                    break;
                case 4:
                    $name_dia = "Jueves";
                    break;
                case 5:
                    $name_dia = "Viernes";
                    break;
                case 6:
                    $name_dia = "Sabádo";
                    break;
                case 7:
                    $name_dia = "Domingo";
                    break;
                default:
                $name_dia = "";
                break;
            }

              $sql_horarios = "SELECT * FROM ag_horarios WHERE IdDr = $id_medico and NumDiaSemana = $no_dia ORDER BY Horario;";
                                        
            //echo $sql_horarios;
            ?>
       
            <div class="col s4 center-align">
            <p><b>Nuevo horario <?php echo $name_medico ?> para el día <?php echo $name_dia;  ?></b></p>
            <br>
            
                   
                    <p>Horario</p>
                    <form action="nvo_horario.php" method="post">
                    <input style="max-width: 50%;" type="time" name="horario">
                    <br>
                  
                    <br>
                    <button style="width: 50%; font-size:12" class="btn-small waves-effect waves-light  light-green darken-4" type="submit" name="action">Guardar Horario
                    <i class="material-icons right">save</i>
                    <input type="hidden" name="id_dr" value="<?php echo $id_medico; ?>">
                    <input type="hidden" name="no_dia" value="<?php echo $no_dia; ?>">
                    <input type="hidden" name="dia" value="<?php echo $name_dia; ?>">
                    <input type="hidden" name="name_medico" value="<?php echo $name_medico; ?>">
                    </form>
                      
                   
             </div>

            <div class="col s5">
            <div class="table-responsive-2">
            <table>
                <thead>
                    <tr>
                        <th colspan="7">Horarios <?php echo $name_medico; ?></th>
                    </tr>
                    <tr>
                        <th>Día Semana</th>
                        <th>Horario</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <?php 
                    
                     $res_horarios = $mysqli->query($sql_horarios);
                     $val_res_horarios = $res_horarios->num_rows;
                     
                     if($val_res_horarios > 0){
                         while($row_horario = mysqli_fetch_assoc($res_horarios)){
                            $horario = $row_horario['Horario'];
                            $id_horario = $row_horario['IDHorario'];
                                        echo '
                                        <form action="libera_horario.php" method="post">
                                        <tr>
                                        <td>'.$name_dia.'</td>
                                        <td>'.$horario.'</td>
                                        <td class="center-align"><button style="width: 75%;" class="btn-small waves-effect waves-light deep-orange darken-1" type="submit" name="action">Eliminar Horario
                                        <i class="material-icons right">close</i></td>
                                        <input type="hidden" name="id_dr" value="'.$id_medico.'">
                                        <input type="hidden" name="id_horario" value="'.$id_horario.'">
                                        <input type="hidden" name="no_dia" value="'.$no_dia.'">
                                        </tr></form>';

                         } // Cierra while
                     }// cierra if de validación que la consulta arrojo resultados
                    
                    ?>

                </tbody>
            </table>
            </div>
            <?php 
            } // Cierre validación despliega
            ?>
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
            © 2024 Copyright
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