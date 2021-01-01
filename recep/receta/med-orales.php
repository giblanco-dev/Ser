<?php
include_once '../../app/logic/conn.php';
$cita = $_GET['c'];
$usuario = $_GET['u'];
$sql_med = "SELECT * FROM med_orales WHERE activo = 1";
$res_med = $mysqli->query($sql_med);
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
    <form action="save_med_oral.php" method="POST">
        <h2 style="display: inline-block;">Medicamentos Orales</h2>
        <input type="submit" class="btn" value="Guardar/Revisar Medicamentos">
        <table>
            <?php 
            $cont = 0;
            while($med_orales = mysqli_fetch_assoc($res_med)){
                $cont ++;
                if(($cont % 2) == 1){
                    echo'
                    <tr>
                    <input type="hidden" name="'.$med_orales['id_med_oral'].'[]" value="'.$med_orales['id_med_oral'].'">
                    <td><input type="checkbox" name="'.$med_orales['id_med_oral'].'[]" ></td>
                    <td>'.$med_orales['nom_med_oral'].'</td>
                    <input type="hidden" name="'.$med_orales['id_med_oral'].'[]" value="'.$med_orales['nom_med_oral'].'">
                    <td><input style="width: 25em;" type="text" name="'.$med_orales['id_med_oral'].'[]" value ="Indicaciones"></td>
                    <input type="hidden" name="'.$med_orales['id_med_oral'].'[]" value="'.$med_orales['precio'].'">
                    <input type="hidden" name="'.$med_orales['id_med_oral'].'[]" value="'.$cita.'">
                    <input type="hidden" name="'.$med_orales['id_med_oral'].'[]" value="'.$usuario.'">
                    <td></td>            
                    ';
                }else{
                    echo'
                    <input type="hidden" name="'.$med_orales['id_med_oral'].'[]" value="'.$med_orales['id_med_oral'].'">
                    <td><input type="checkbox" name="'.$med_orales['id_med_oral'].'[]" ></td>
                    <td>'.$med_orales['nom_med_oral'].'</td>
                    <input type="hidden" name="'.$med_orales['id_med_oral'].'[]" value="'.$med_orales['nom_med_oral'].'">
                    <td><input style="width: 25em;" type="text" name="'.$med_orales['id_med_oral'].'[]" value ="Indicaciones"></td>
                    <input type="hidden" name="'.$med_orales['id_med_oral'].'[]" value="'.$med_orales['precio'].'">
                    <input type="hidden" name="'.$med_orales['id_med_oral'].'[]" value="'.$cita.'">
                    <input type="hidden" name="'.$med_orales['id_med_oral'].'[]" value="'.$usuario.'">
                    </tr>      
                    ';
                }
            }
            ?>
        </table>
        <input type="hidden" name="id_cita" value="<?php echo $cita; ?>">
        </form>
    </div>
</body>
</html>