<?php
include_once '../../app/logic/conn.php';
$cita = $_GET['c'];
$usuario = $_GET['u'];
$sql_sueros = "SELECT * FROM sueros";
$res_sueros = $mysqli->query($sql_sueros);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../static/css/main.css">
    <title>Sueros</title>
    <style>
        body{
            font-family: 'Roboto', sans-serif;
        }
        input[type=checkbox] {
        transform: scale(1.5);
        }
        table{
            border-spacing: 1em;
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
    <form action="save_sueros.php" method="POST">
        <h2 style="display: inline-block;">Sueros</h2>
        <input type="submit" class="btn" value="Guardar/Revisar Sueros Capturados">
        <table>
            <?php 
            $cont = 0;
            while($sueros = mysqli_fetch_assoc($res_sueros)){
                $cont ++;
                
                    echo'
                    <tr>
                    <input type="hidden" name="'.$sueros['id_suero'].'[]" value="'.$sueros['id_suero'].'">
                    <td><input type="checkbox" name="'.$sueros['id_suero'].'[]" ></td>
                    <td style="font-size: 12px;">'.$sueros['nom_suero'].'</td>
                    ';
                    for($i = 1; $i <= 7; $i++){
                        $sql_compl = "SELECT * FROM complementos";
                        $res_compl = $mysqli->query($sql_compl);
                        echo'<td style="width: 100px;"><select style="width: 160px;" name="'.$sueros['id_suero'].'[]" style="font-size:11px;">';
                        echo'<option value="0">--</option>';
                        while($comple = mysqli_fetch_assoc($res_compl)){
                            echo '<option value="'.$comple['id_comple'].'">'.$comple['nom_complemento'].' / '.intval($comple['precio']).'</option>';
                        }
                        echo'</select></td>';
                    }
              echo '</tr>';
              echo '<input type="hidden" name="'.$sueros['id_suero'].'[]" value="'.$sueros['nom_suero'].'">';
            }
            ?>
        </table>
        <input type="hidden" name="id_cita" value="<?php echo $cita; ?>">
        <input type="hidden" name="user" value="<?php echo $usuario; ?>">
        
        </form>
    </div>
</body>
</html>