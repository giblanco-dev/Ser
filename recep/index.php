<?php 
include_once 'recep_sections.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio Recepción</title>
    <link rel="stylesheet" href="../css/materialize.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="../js/materialize.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
</head>
<body>
<?php echo $nav_recep;  ?>
<!-- ***************************** INICIA CONTENIDO ****************************** -->
<div class="row center-align">
    <div class="col s2 grey lighten-3" style="margin-bottom: -20px;"> <!-- ***************************** INICIA BARRA LATERAL ****************************** -->
        <div class="row" style="margin-top: 100px;">
            <div class="col s12">
            <h4>Recepción</h4>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
            <iframe src="https://www.zeitverschiebung.net/clock-widget-iframe-v2?language=es&size=large&timezone=America%2FMexico_City" width="100%" height="125" frameborder="0" seamless></iframe> 
            </div>
        </div>
        <div class="row">
            <div class="col s12">
            <ul class="collection with-header">
                <li class="collection-header"><h5>Citas</h5></li>
                <li class="collection-item">Dr. 1</li>
                <li class="collection-item">Dr. 2</li>
                <li class="collection-item">Dr. 3</li>
                <li class="collection-item">Dr. 4</li>
            </ul>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
            <h2 style="color: #424242;">00 <i class="medium material-icons">check_circle</i></h2>
        <p>Citas Confirmadas</p>
        <h2 style="color: #424242;">00 <i class="medium material-icons">book</i></h2>
        <p>Citas Agendadas</p>
            </div>
        </div>
    </div>
    <div class="col s10"> <!-- ***************************** INICIA CUERPO DEL SISTEMA ****************************** -->
        <div class="row center-align">
            <div class="col s12">
                <h4 style="color: #2d83a0; font-weight:bold;">CONSULTORIO DE MEDICINA ALTERNATIVA SER</h4>
                <div class="divider"></div>
            </div>
        </div>
    </div>
</div>



<!-- ***************************** TERMINA CONTENIDO ****************************** -->
<?php echo $footer_recep;  ?>
</body>
</html>