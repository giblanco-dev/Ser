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
    <link rel="stylesheet" href="../../static/css/main.css">
    <title>Terapias</title>
    <style>
        body{
            font-family: 'Roboto', sans-serif;
        }
        
        table{
            border-spacing: 1em;
        }

        .ancho{
            width: 80px;
        }
        .btn{
            color: #FFF; 
            background: #2d83a0;
            float: right; 
            margin-right: 1.5em; 
            margin-top: 1.5em;
            border: 2px solid #2d83a0;
            border-radius: 3px;
            padding: 5px;
        }
        .btn:hover{
            background-color: #008CBA;
        }
    </style>
</head>
<body>
    <div style="width: 100%;">
        <h2 style="display: inline-block;">Signos Vitales </h2>
        <table>
            <thead>
            <tr>
                    <th>T/A</th>
                    <th>TEMP</th>
                    <th>FRE C</th>
                    <th>FRE R</th>
                    <th>Peso</th>
                    <th>Talla</th>
                    <th></th>
                </tr>
            </thead>
            
                <?php 
                if($val == 1){ 
                    $svitales = mysqli_fetch_assoc($res_consulta);
                    ?>
                <form action="update_svita.php" method="POST">
                <tbody>
                    <tr>
                        <td><input class="ancho" type="text" name="ta" value="<?php echo $svitales['ta'] ?>"></td>
                        <td><input class="ancho" type="text" name="temp" value="<?php echo $svitales['temp'] ?>"></td>
                        <td><input class="ancho" type="text" name="fre_c" value="<?php echo $svitales['fre_c'] ?>"></td>
                        <td><input class="ancho" type="text" name="fre_r" value="<?php echo $svitales['fre_r'] ?>"></td>
                        <td><input class="ancho" type="text" name="peso" value="<?php echo $svitales['peso'] ?>"></td>
                        <td><input class="ancho" type="text" name="talla" value="<?php echo $svitales['talla'] ?>"></td>
                        <input type="hidden" name="user" value="<?php echo $usuario; ?>">
                        <input type="hidden" name="cita2" value="<?php echo $cita; ?>">
                        <td><input style="margin-top: 0;" type="submit" class="btn" value="Actualizar Signos"></td>
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