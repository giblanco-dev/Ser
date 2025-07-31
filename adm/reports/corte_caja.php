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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../static/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../static/css/materialize.css">
    <link rel="stylesheet" href="../../static/icons/iconfont/material-icons.css">
    <script type="text/javascript" src="../../static/js/jquery-3.3.1.min.js"></script>
    <script src="../../static/js/materialize.js"></script>
    <title>Detalle Cortes</title>
</head>
<body>
    <div class="row">
        <div class="col s12 center-align">
            <h5>Cortes de Caja</h5>
        </div>
        <div class="row">
            
            <div class="col s4 offset-s1">
           <br>
                <div class="row">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div class="col s12">
                        <blockquote>Seleccione la fecha de corte</blockquote>
                        
                            <input type="date" name="fecha" id="fecha_corte">
                            
                    </div>
                    <div class="col s12 center-align">
                        <br>
                    <button class="btn waves-effect waves-light hoverable" type="submit" name="action">Buscar cortes
                            <i class="material-icons right">search</i>
                        </button>
                    </div>
                    </form>
                </div>
            </div>
            <div class="col s6">
                <?php
                if(!empty($_POST)){
                    $fecha_corte = $_POST['fecha'];
                    $fecha_corte_format = date("d/m/Y", strtotime($fecha_corte));
                    $sql_cortes = "SELECT fecha_corte, momento_corte, user_cajero, id_corte FROM cortes_caja where fecha_corte = '$fecha_corte'";
                    $res_cortes = $mysqli->query($sql_cortes);
                    $val_cortes = $res_cortes->num_rows;

                    if($val_cortes > 0){
                        ?>
                        <table class="centered">
                            <thead>
                                <tr>
                                    <th>Fecha de Corte</th>
                                    <th>Horario del Corte</th>
                                    <th>Cajero</th>
                                    <th>Consultar Corte</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                while($row_corte = mysqli_fetch_assoc($res_cortes)){
                                    // date("d/m/Y", strtotime($hoy)); h:i:s A
                                    $fecha_format = date("d/m/Y", strtotime($row_corte['fecha_corte']));
                                    $horario_format = date("d/m/Y h:i:s A", strtotime($row_corte['momento_corte']));

                                    echo '
                                    <tr>
                                    <td>'.$fecha_format.'</td>
                                    <td>'.$horario_format.'</td>
                                    <td>'.$row_corte["user_cajero"].'</td>
                                    <td><a class="center-align" href="detalle_corte.php?idcorte='.$row_corte["id_corte"].'" class="secondary-content" target="blank"><i class="material-icons">attach_money</i></a></td>
                                    </tr>
                                    ';
                                }
                                ?>

                            </tbody>
                        </table>
                    <?php   
                    }else{
                        echo '<h6 style="color: red;">No hay cortes de la fecha '.$fecha_corte_format.'</h6>';
                    }
                }

                ?>
                
            </div>
        </div>
    </div>
</body>
</html>