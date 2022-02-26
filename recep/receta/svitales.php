<?php
include_once '../../app/logic/conn.php';
$cita = $_GET['c'];
$usuario = $_GET['u'];
$sql_consulta = "SELECT * FROM consulta WHERE id_cita = '$cita'";
$res_consulta = $mysqli->query($sql_consulta);
$val = $res_consulta->num_rows;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../static/css/materialize.css">
    <link rel="stylesheet" href="../../static/icons/iconfont/material-icons.css">
    <title>Actualizar Signos Vitales</title>
</head>
<body>
    <div style="width: 90%; margin-left: 5%; ">
    <br>
        <h5 style="display: inline-block;">Actualización de Signos Vitales </h5>
        <table>
            <thead>
            <tr>
                    <th>T/A</th>
                    <th>TEMP</th>
                    <th>FRE C</th>
                    <th>FRE R</th>
                    <th>Oxígeno</th>
                    <th>Peso</th>
                    <th>Talla</th>
                    <th>Edad</th>
                </tr>
            </thead>
            
                <?php 
                if($val == 1){ 
                    $svitales = mysqli_fetch_assoc($res_consulta);
                    $ta = explode("/",$svitales['ta']);
                    ?>
                <form action="update_svita.php" method="POST" autocomplete="off">
                <tbody>
                    <tr>
                        <td>
                        <div class="row">
                                <div class="col s5">
                                <input class="ancho" type="number" min="1" name="ta1" value="<?php echo $ta[0]; ?>">
                            </div>
                            <div class="col s2"><p>/</p></div>
                            <div class="col s5">
                            <input class="ancho" type="number" min="1" name="ta2" value="<?php echo $ta[1]; ?>">
                            </div>
                        </div>
                        </td>
                        <td><input class="ancho" type="number" min="1" step="0.1" name="temp" value="<?php echo $svitales['temp'] ?>"></td>
                        <td><input class="ancho" type="number" min="1" name="fre_c" value="<?php echo $svitales['fre_c'] ?>"></td>
                        <td><input class="ancho" type="number" min="1" name="fre_r" value="<?php echo $svitales['fre_r'] ?>"></td>
                        <td><input class="ancho" type="number" min="1" name="oxi" value="<?php echo $svitales['oxi'] ?>"></td>
                        <td><input class="ancho" type="number" min="1" name="peso" value="<?php echo $svitales['peso'] ?>"></td>
                        <td><input class="ancho" type="number" min="1" name="talla" step="0.01" value="<?php echo $svitales['talla'] ?>"></td>
                        <td><input class="ancho" type="number" min="1" name="edad" value="<?php echo $svitales['edad'] ?>"></td>
                        <input type="hidden" name="user" value="<?php echo $usuario; ?>">
                        <input type="hidden" name="cita2" value="<?php echo $cita; ?>">
                    </tr>
                    <tr>
                        <th colspan="3">Alergias</th>
                    </tr>
                    <tr>
                        <td colspan="3"><input class="ancho" type="text" name="alergias" value="<?php echo $svitales['alergias'] ?>"></td>
                    </tr>
                    <tr>
                    <td colspan="6" class="center-align">
                    <button class="btn waves-effect waves-light" type="submit" name="action">Actualizar
                        <i class="material-icons right">send</i>
                    </button>
                    </td>
                    </tr>
                </form>
                </tbody>
            <?php    }else{
                    echo '<h2 style="color: red;">Hay un error con el registro de consulta, hay que contactar al administrador del sistema.</h2>';
                }
                ?>
            
        </table>
       <br>

    </div>
</body>
</html>