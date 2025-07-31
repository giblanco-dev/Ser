<?php
include_once '../../app/logic/conn.php';
$cita = $_GET['c'];
$usuario = $_GET['u'];
$sql_med = "SELECT * FROM med_orales WHERE activo = 1 ORDER BY tipo, nom_med_oral";
$res_med = $mysqli->query($sql_med);
$res_med2 = $mysqli->query($sql_med);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../static/css/main.css">
    <script type="text/javascript" src="../../static/js/jquery-3.3.1.min.js"></script>
    <title>Medicamentos Orales-Nutrientes</title>
    <style>
        body{
            font-family: 'Roboto', sans-serif;
        }
        input[type=checkbox] {
        transform: scale(1.5);
        }
        input[type=number] {
        transform: scale(1.5);
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
<form action="save_med_oral.php" method="POST">

<div style="width: 50%; display: inline-block;">
<input type="hidden" name="user" value="<?php echo $usuario; ?>">
    <input type="hidden" name="id_cita" value="<?php echo $cita; ?>">
    <input type="submit" class="btn" value="Guardar/Revisar Medicamentos">
</div>

    <div style="width: 50%; display: inline-block;">
        <h2 style="display: inline-block;">Medicamentos Orales</h2>
        <input id="search" type="text" placeholder="Buscar" style="display: inline-block; margin-left: 15px;">
        <table id="mytable">
            <tbody>
            <?php 
            $cont = 0;
            while($med_orales = mysqli_fetch_assoc($res_med)){
                $cont ++;
                if($med_orales['tipo']=='m'){
                if(($cont % 2) == 1){
                    echo'
                    <tr>
                    <input type="hidden" name="'.$med_orales['id_med_oral'].'[]" value="'.$med_orales['id_med_oral'].'">
                    <td><input type="number" name="'.$med_orales['id_med_oral'].'[]" min="0" value="0"></td>
                    <td>'.$med_orales['nom_med_oral'].'</td>
                    <input type="hidden" name="'.$med_orales['id_med_oral'].'[]" value="'.$med_orales['nom_med_oral'].'">
                    <input style="width: 25em;" type="hidden" name="'.$med_orales['id_med_oral'].'[]" value ="Indicaciones">
                    <input type="hidden" name="'.$med_orales['id_med_oral'].'[]" value="'.$med_orales['precio'].'">
                    <input type="hidden" name="'.$med_orales['id_med_oral'].'[]" value="'.$cita.'">
                    <input type="hidden" name="'.$med_orales['id_med_oral'].'[]" value="'.$usuario.'">
                    <td></td>            
                    ';
                }else{
                    echo'
                    <input type="hidden" name="'.$med_orales['id_med_oral'].'[]" value="'.$med_orales['id_med_oral'].'">
                    <td><input type="number" name="'.$med_orales['id_med_oral'].'[]" min="0" value="0"></td>
                    <td>'.$med_orales['nom_med_oral'].'</td>
                    <input type="hidden" name="'.$med_orales['id_med_oral'].'[]" value="'.$med_orales['nom_med_oral'].'">
                    <input style="width: 25em;" type="hidden" name="'.$med_orales['id_med_oral'].'[]" value ="Indicaciones">
                    <input type="hidden" name="'.$med_orales['id_med_oral'].'[]" value="'.$med_orales['precio'].'">
                    <input type="hidden" name="'.$med_orales['id_med_oral'].'[]" value="'.$cita.'">
                    <input type="hidden" name="'.$med_orales['id_med_oral'].'[]" value="'.$usuario.'">
                    </tr>      
                    ';
                }
            }
        }
            ?>
            </tbody>
        </table>
        
        
    </div>
    <div style=" width: 45%; display: inline-block;">
    <h2 style="display: inline-block;">Nutrientes</h2>
    <input id="search1" type="text" placeholder="Buscar" style="display: inline-block; margin-left: 15px;">
    <table id="mytable1">
        <tbody>
            <?php 
            $cont = 0;
            while($nutrientes = mysqli_fetch_assoc($res_med2)){
                $cont ++;
                if($nutrientes['tipo']=='n'){
                if(($cont % 2) == 1){
                    echo'
                    <tr>
                    <input type="hidden" name="'.$nutrientes['id_med_oral'].'[]" value="'.$nutrientes['id_med_oral'].'">
                    <td><input type="number" name="'.$nutrientes['id_med_oral'].'[]" min="0" value="0"></td>
                    <td>'.$nutrientes['nom_med_oral'].'</td>
                    <input type="hidden" name="'.$nutrientes['id_med_oral'].'[]" value="'.$nutrientes['nom_med_oral'].'">
                    <input style="width: 25em;" type="hidden" name="'.$nutrientes['id_med_oral'].'[]" value ="Indicaciones">
                    <input type="hidden" name="'.$nutrientes['id_med_oral'].'[]" value="'.$nutrientes['precio'].'">
                    <input type="hidden" name="'.$nutrientes['id_med_oral'].'[]" value="'.$cita.'">
                    <input type="hidden" name="'.$nutrientes['id_med_oral'].'[]" value="'.$usuario.'">
                    <td></td>            
                    ';
                }else{
                    echo'
                    <input type="hidden" name="'.$nutrientes['id_med_oral'].'[]" value="'.$nutrientes['id_med_oral'].'">
                    <td><input type="number" name="'.$nutrientes['id_med_oral'].'[]" min="0" value="0"></td>
                    <td>'.$nutrientes['nom_med_oral'].'</td>
                    <input type="hidden" name="'.$nutrientes['id_med_oral'].'[]" value="'.$nutrientes['nom_med_oral'].'">
                    <input style="width: 25em;" type="hidden" name="'.$nutrientes['id_med_oral'].'[]" value ="Indicaciones">
                    <input type="hidden" name="'.$nutrientes['id_med_oral'].'[]" value="'.$nutrientes['precio'].'">
                    <input type="hidden" name="'.$nutrientes['id_med_oral'].'[]" value="'.$cita.'">
                    <input type="hidden" name="'.$nutrientes['id_med_oral'].'[]" value="'.$usuario.'">
                    </tr>      
                    ';
                }
            }
        }
            ?>
            </tbody>
        </table>
    </div>
    </form>

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
 // Write on keyup event of keyword input element
 $(document).ready(function(){
 $("#search1").keyup(function(){
 _this = this;
 // Show only matching TR, hide rest of them
 $.each($("#mytable1 tbody tr"), function() {
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