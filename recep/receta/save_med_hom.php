<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardar Med.Homeopáticos</title>
    <style>
        body{
            font-family: 'Roboto', sans-serif;
        }
        table{
            width: 100%;
            border-spacing: 1em;
        }
        
    </style>
</head>
<body style="background-color: #e0e0e0;">
<div style="width: 100%; display:inline-block;">
<?php 
if($_POST['tipo'] == 'gen'){
    for($i = 1; $i <= 10; $i++){
        $itera = "frasco".$i;
        echo "medicamentos del frasco".$i;
        $ar_frasco = $_POST[$itera];
        print_r($ar_frasco);
        echo "<br>";
    }
}
?>

</div>
</body>
</html>