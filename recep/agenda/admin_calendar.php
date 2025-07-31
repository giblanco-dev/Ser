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

$sql_anio = "SELECT DISTINCT Anio FROM ag_calendario";
$res_anio = $mysqli -> query($sql_anio);

$sql_mes = "SELECT DISTINCT Mes FROM ag_calendario";
$res_mes = $mysqli -> query($sql_mes);

if(!empty($_POST)){

    $id_medico = $_POST['medico'];
    $anio = $_POST['anio'];
    $mes = $_POST['mes'];
    $despliega = 1;

}elseif(!empty($_GET)){
    $id_medico = $_GET['medico'];
    $fecha = $_GET['fecha'];
    $anio = $_GET['anio'];
    $mes = $_GET['mes'];
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
            height: 500px; /* Mover a 400 para demostrar el scroll*/
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
                <h5 style="color: #2d83a0; font-weight:bold;">Administrar Agenda</h5>
            </div>
        </div>
    </div>
    
    <div class="row" style="width: 99%;">
        <div class="col s2">
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
                    <select name="anio" required>
                    <option value="" disabled selected>Seleccione año</option>
                    <?php 
                    while($row_anio = mysqli_fetch_assoc($res_anio)){
                        echo '<option value="'.$row_anio['Anio'].'">'.$row_anio['Anio'].'</option>';
                    }
                    ?>
                    </select>
                    <label>Año</label>
                </div>
                <div class="input-field col s12">
                    <select name="mes">
                    <option value="" disabled selected>Seleccione mes</option>
                    <?php 
                    while($row_mes = mysqli_fetch_assoc($res_mes)){
                        echo '<option value="'.$row_mes['Mes'].'">'.$row_mes['Mes'].'</option>';
                    }
                    ?>
                    </select>
                    <label>Mes</label>
                </div>
                <button style="width: 100%; font-size:12" class="btn-small waves-effect waves-light  light-green darken-4" type="submit" name="action">Gestionar agenda
                    <i class="material-icons right">date_range</i>
                </button>
            </form>
        </div>
        <div class="col s10">
                    <!--  SECCION DE CARGA DE HORARIOS -->
          
            
            <?php 
            if($despliega == 1){
            
            $colum_medico = "";
            $name_medico = "";
            switch ($id_medico){
                case 5:
                    $colum_medico = "DrEnrique";
                    $name_medico = "Dr. Enrique";
                    break;
                case 6:
                    $colum_medico = "DrGuillermo";
                    $name_medico = "Dr. Guillermo";
                    break;
                case 7:
                    $colum_medico = "DraAngelica";
                    $name_medico = "Dra. Angélica";
                    break;
                default:
                $colum_medico = "";
            }

              $sql_val_calendario = "SELECT Fecha, Dia, NumDiaSemana, $colum_medico, Festivo, NumDia
                                        FROM ag_calendario where anio = '$anio' and Mes = '$mes' ORDER BY Fecha, NumDiaSemana;";
                                        
            //echo $sql_val_calendario;
            ?>
            <div class="table-responsive-2">
            <table>
                <thead>
                    <tr>
                        <th colspan="7">Agenda <?php echo $name_medico; ?> de <?php echo $mes;?> de <?php echo $anio;?></th>
                    </tr>
                    <tr>
                        <th>Lunes</th>
                        <th>Martes</th>
                        <th>Miercóles</th>
                        <th>Jueves</th>
                        <th>Viernes</th>
                        <th>Sabádo</th>
                        <th>Domingo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <?php 
                    $contador = 0;
                     $res_calendario = $mysqli->query($sql_val_calendario);
                     $val_res_calendario = $res_calendario->num_rows;
                     
                     if($val_res_calendario > 0){
                         while($row_calendario = mysqli_fetch_assoc($res_calendario)){
                            $no_dia = $row_calendario['NumDia'];
                            $des_dia = $row_calendario['Dia'];
                            $fecha_key = $row_calendario['Fecha'];
                            $status = $row_calendario[$colum_medico];
                            $festivo = $row_calendario['Festivo'];
                            $NumDiaSemana = $row_calendario['NumDiaSemana'];
                            if($status == 0 and $festivo == 0){
                                $boton = '<button style="width: 100%;" class="btn-small waves-effect waves-light  light-green darken-4" type="submit" name="action">Abrir Agenda
                                        <i class="material-icons right">check</i>';
                                $bg = '#fff176';
                            }elseif($status == 1 and $festivo == 0){
                                $boton = '<button style="width: 100%;" class="btn-small waves-effect waves-light deep-orange darken-1" type="submit" name="action">Cerrar Agenda
                                        <i class="material-icons right">close</i>';
                                $bg = '#ccff90';
                            }elseif($festivo == 1){
                                 $boton = '<p><b>Festivo</b></b>';
                                $bg = '#bbdefb';
                            }

                            

                            if($contador != 0 and $NumDiaSemana == 1){
                                echo '<tr>';
                            }
                            
                            if($contador == 0){
                                switch ($NumDiaSemana){
                                    case 1:
                                        echo '<td class="center-align" style="background-color: '.$bg.' ;"><form action="mod_calen.php" method="post">
                                        <h4>'.$no_dia.'</h4>
                                        <input type="hidden" name="fecha" value="'.$fecha_key.'">
                                        <input type="hidden" name="estatus" value="'.$status.'">
                                        <input type="hidden" name="colum" value="'.$colum_medico.'">
                                        <input type="hidden" name="medico" value="'.$id_medico.'">
                                        <input type="hidden" name="mes" value="'.$mes.'">
                                        '.$boton.'
                                        </form></td>';
                                        break;
                                    case 2:
                                        echo '<td></td>';
                                        echo '<td class="center-align" style="background-color: '.$bg.' ;"><form action="mod_calen.php" method="post">
                                        <h4>'.$no_dia.'</h4>
                                        <input type="hidden" name="fecha" value="'.$fecha_key.'">
                                        <input type="hidden" name="estatus" value="'.$status.'">
                                        <input type="hidden" name="colum" value="'.$colum_medico.'">
                                        <input type="hidden" name="medico" value="'.$id_medico.'">
                                        <input type="hidden" name="mes" value="'.$mes.'">
                                        '.$boton.'
                                        </form></td>';
                                        break;
                                    case 3:
                                        echo '<td></td> <td></td>';
                                        echo '<td class="center-align" style="background-color: '.$bg.' ;"><form action="mod_calen.php" method="post">
                                        <h4>'.$no_dia.'</h4>
                                        <input type="hidden" name="fecha" value="'.$fecha_key.'">
                                        <input type="hidden" name="estatus" value="'.$status.'">
                                        <input type="hidden" name="colum" value="'.$colum_medico.'">
                                        <input type="hidden" name="medico" value="'.$id_medico.'">
                                        <input type="hidden" name="mes" value="'.$mes.'">
                                        '.$boton.'
                                        </form></td>';
                                        break;
                                    case 4:
                                        echo '<td></td> <td></td> <td></td>';
                                        echo '<td class="center-align" style="background-color: '.$bg.' ;"><form action="mod_calen.php" method="post">
                                        <h4>'.$no_dia.'</h4>
                                        <input type="hidden" name="fecha" value="'.$fecha_key.'">
                                        <input type="hidden" name="estatus" value="'.$status.'">
                                        <input type="hidden" name="colum" value="'.$colum_medico.'">
                                        <input type="hidden" name="medico" value="'.$id_medico.'">
                                        <input type="hidden" name="mes" value="'.$mes.'">
                                        '.$boton.'
                                        </form></td>';
                                        break;
                                    case 5:
                                        echo '<td></td> <td></td> <td></td> <td></td>';
                                        echo '<td class="center-align" style="background-color: '.$bg.' ;"><form action="mod_calen.php" method="post">
                                        <h4>'.$no_dia.'</h4>
                                        <input type="hidden" name="fecha" value="'.$fecha_key.'">
                                        <input type="hidden" name="estatus" value="'.$status.'">
                                        <input type="hidden" name="colum" value="'.$colum_medico.'">
                                        <input type="hidden" name="medico" value="'.$id_medico.'">
                                        <input type="hidden" name="mes" value="'.$mes.'">
                                        '.$boton.'
                                        </form></td>';
                                        break;
                                    case 6:
                                        echo '<td></td> <td></td> <td></td> <td></td> <td></td>';
                                        echo '<td class="center-align" style="background-color: '.$bg.' ;"><form action="mod_calen.php" method="post">
                                        <h4>'.$no_dia.'</h4>
                                        <input type="hidden" name="fecha" value="'.$fecha_key.'">
                                        <input type="hidden" name="estatus" value="'.$status.'">
                                        <input type="hidden" name="colum" value="'.$colum_medico.'">
                                        <input type="hidden" name="medico" value="'.$id_medico.'">
                                        <input type="hidden" name="mes" value="'.$mes.'">
                                        '.$boton.'
                                        </form></td>';
                                        break;
                                    case 7:
                                        echo '<td></td> <td></td> <td></td> <td></td> <td></td> <td></td>';
                                        echo '<td class="center-align" style="background-color: '.$bg.' ;"><form action="mod_calen.php" method="post">
                                        <h4>'.$no_dia.'</h4>
                                        <input type="hidden" name="fecha" value="'.$fecha_key.'">
                                        <input type="hidden" name="estatus" value="'.$status.'">
                                        <input type="hidden" name="colum" value="'.$colum_medico.'">
                                        <input type="hidden" name="medico" value="'.$id_medico.'">
                                        <input type="hidden" name="mes" value="'.$mes.'">
                                        '.$boton.'
                                        </form></td>';
                                        break;

                                }
                            }else{
                                switch ($NumDiaSemana){
                                    case 1:
                                        echo '<td class="center-align" style="background-color: '.$bg.' ;"><form action="mod_calen.php" method="post">
                                        <h4>'.$no_dia.'</h4>
                                        <input type="hidden" name="fecha" value="'.$fecha_key.'">
                                        <input type="hidden" name="estatus" value="'.$status.'">
                                        <input type="hidden" name="colum" value="'.$colum_medico.'">
                                        <input type="hidden" name="medico" value="'.$id_medico.'">
                                        <input type="hidden" name="mes" value="'.$mes.'">
                                        '.$boton.'
                                        </form></td>';
                                        break;
                                    case 2:
                                        echo '<td class="center-align" style="background-color: '.$bg.' ;"><form action="mod_calen.php" method="post">
                                        <h4>'.$no_dia.'</h4>
                                        <input type="hidden" name="fecha" value="'.$fecha_key.'">
                                        <input type="hidden" name="estatus" value="'.$status.'">
                                        <input type="hidden" name="colum" value="'.$colum_medico.'">
                                        <input type="hidden" name="medico" value="'.$id_medico.'">
                                        <input type="hidden" name="mes" value="'.$mes.'">
                                        '.$boton.'
                                        </form></td>';
                                        break;
                                    case 3:
                                        echo '<td class="center-align" style="background-color: '.$bg.' ;"><form action="mod_calen.php" method="post">
                                        <h4>'.$no_dia.'</h4>
                                        <input type="hidden" name="fecha" value="'.$fecha_key.'">
                                        <input type="hidden" name="estatus" value="'.$status.'">
                                        <input type="hidden" name="colum" value="'.$colum_medico.'">
                                        <input type="hidden" name="medico" value="'.$id_medico.'">
                                        <input type="hidden" name="mes" value="'.$mes.'">
                                        '.$boton.'
                                        </form></td>';
                                        break;
                                    case 4:
                                            echo '<td class="center-align" style="background-color: '.$bg.' ;"><form action="mod_calen.php" method="post">
                                            <h4>'.$no_dia.'</h4>
                                            <input type="hidden" name="fecha" value="'.$fecha_key.'">
                                            <input type="hidden" name="estatus" value="'.$status.'">
                                            <input type="hidden" name="colum" value="'.$colum_medico.'">
                                            <input type="hidden" name="medico" value="'.$id_medico.'">
                                            <input type="hidden" name="mes" value="'.$mes.'">
                                            '.$boton.'
                                            </form></td>';
                                            break;
                                        case 5:
                                            echo '<td class="center-align" style="background-color: '.$bg.' ;"><form action="mod_calen.php" method="post">
                                            <h4>'.$no_dia.'</h4>
                                            <input type="hidden" name="fecha" value="'.$fecha_key.'">
                                            <input type="hidden" name="estatus" value="'.$status.'">
                                            <input type="hidden" name="colum" value="'.$colum_medico.'">
                                            <input type="hidden" name="medico" value="'.$id_medico.'">
                                            <input type="hidden" name="mes" value="'.$mes.'">
                                            '.$boton.'
                                            </form></td>';
                                            break;
                                        case 6:
                                            echo '<td class="center-align" style="background-color: '.$bg.' ;"><form action="mod_calen.php" method="post">                                                <h4>'.$no_dia.'</h4>
                                            <input type="hidden" name="fecha" value="'.$fecha_key.'">
                                            <input type="hidden" name="estatus" value="'.$status.'">
                                            <input type="hidden" name="colum" value="'.$colum_medico.'">
                                            <input type="hidden" name="medico" value="'.$id_medico.'">
                                            <input type="hidden" name="mes" value="'.$mes.'">
                                           '.$boton.'
                                            </form></td>';
                                             break;
                                        case 7:
                                            echo '<td class="center-align" style="background-color: '.$bg.' ;"><form action="mod_calen.php" method="post">
                                            <h4>'.$no_dia.'</h4>
                                            <input type="hidden" name="fecha" value="'.$fecha_key.'">
                                            <input type="hidden" name="estatus" value="'.$status.'">
                                            <input type="hidden" name="colum" value="'.$colum_medico.'">
                                            <input type="hidden" name="medico" value="'.$id_medico.'">
                                            <input type="hidden" name="mes" value="'.$mes.'">
                                            '.$boton.'
                                            </form></td>
                                            </tr>';
                                            break;
                                }


                            }

                            $contador ++;
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