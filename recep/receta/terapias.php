<?php
include_once '../../app/logic/conn.php';
$cita = $_GET['c'];
$usuario = $_GET['u'];
$sql_terapias = "SELECT * FROM terapias WHERE activo = 1 ORDER BY nom_terapia";
$res_terapias = $mysqli->query($sql_terapias);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../static/css/main.css">
    <script type="text/javascript" src="../../static/js/jquery-3.3.1.min.js"></script>
    <title>Terapias</title>
    <style>
        body{
            font-family: 'Roboto', sans-serif;
        }
        input[type=checkbox] {
        transform: scale(1.5);
        }
        input[type=number] {
        transform: scale(1.3);
        width: 30px;
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
    <form action="save_terapia.php" method="POST" autocomplete="off">
        <h2 style="display: inline-block;">Terapias</h2>
        <input id="search" type="text" placeholder="Buscar" style="display: inline-block; margin-left: 30px;">
        <input type="submit" class="btn" value="Guardar/Revisar Terapias">
        <table id="mytable">
            <?php 
            $cont = 0;
            while($terapias = mysqli_fetch_assoc($res_terapias)){
                $cont ++;
                if(($cont % 2) == 1){
                    echo'
                    <tr>
                    <input type="hidden" name="'.$terapias['id_terapia'].'[]" value="'.$terapias['id_terapia'].'">
                    <td><input type="number" name="'.$terapias['id_terapia'].'[]" min="0" value="0"></td>
                    <td>'.$terapias['nom_terapia'].'</td>
                    <input type="hidden" name="'.$terapias['id_terapia'].'[]" value="'.$terapias['nom_terapia'].'">
                    <td><input style="width: 25em;" type="text" name="'.$terapias['id_terapia'].'[]" value ="-"></td>
                    <input type="hidden" name="'.$terapias['id_terapia'].'[]" value="'.$terapias['precio'].'">
                    <input type="hidden" name="'.$terapias['id_terapia'].'[]" value="'.$cita.'">
                    <input type="hidden" name="'.$terapias['id_terapia'].'[]" value="'.$usuario.'">
                    <td></td>            
                    ';
                }else{
                    echo'
                    <input type="hidden" name="'.$terapias['id_terapia'].'[]" value="'.$terapias['id_terapia'].'">
                    <td><input type="number" name="'.$terapias['id_terapia'].'[]" min="0" max="'.$terapias['max_terapias'].'" value="0"></td>
                    <td>'.$terapias['nom_terapia'].'</td>
                    <input type="hidden" name="'.$terapias['id_terapia'].'[]" value="'.$terapias['nom_terapia'].'">
                    <td><input style="width: 25em;" type="text" name="'.$terapias['id_terapia'].'[]" value ="-"></td>
                    <input type="hidden" name="'.$terapias['id_terapia'].'[]" value="'.$terapias['precio'].'">
                    <input type="hidden" name="'.$terapias['id_terapia'].'[]" value="'.$cita.'">
                    <input type="hidden" name="'.$terapias['id_terapia'].'[]" value="'.$usuario.'">
                    </tr>      
                    ';
                }
            }
            ?>
        </table>
        <input type="hidden" name="id_cita" value="<?php echo $cita; ?>">
        <input type="hidden" name="user" value="<?php echo $usuario; ?>">
        </form>
    </div>
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