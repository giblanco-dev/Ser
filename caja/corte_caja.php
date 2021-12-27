<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: ../index.php');
    exit();
}elseif($_SESSION['nivel'] == 3 OR $_SESSION['nivel'] == 7){
            $id_user = $_SESSION['id'];
            $usuario = $_SESSION['name_usuario'];
            $nivel = $_SESSION['nivel'];
}else{
    header('Location: ../index.php');
    exit();
}   
include_once 'caja_sections.php';
include_once '../app/logic/conn.php';

// Listado de Vales

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caja</title>
    <link rel="shortcut icon" href="../static/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../static/css/materialize.css">
    <link rel="stylesheet" href="../static/icons/iconfont/material-icons.css">
    <link rel="stylesheet" href="../../static/css/main.css">
    <script type="text/javascript" src="../static/js/jquery-3.3.1.min.js"></script>
    <script src="../static/js/materialize.js"></script>
</head>
<body>
<?php echo $nav_caja;  
?>
<!-- ***************************** INICIA CONTENIDO ****************************** -->
<div class="row center-align">
    <div class="col s2 grey lighten-3" style="margin-bottom: -20px;"> <!-- ***************************** INICIA BARRA LATERAL ****************************** -->
        <div class="row" style="margin-top: 65px;">
            <div class="col s12">
            <h4>Caja</h4>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
            <iframe src="../static/clock/clock.html" width="100%" frameborder="0"></iframe> 
            </div>
        </div>
        <div class="row" style="margin-top: 2em; min-height: 200px;">
            <div class="col s12">
            
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
        <div class="row">
            <div class="col s1"></div>
            <div class="col s4">
                <div class="row">
                    <div class="col s12">
                    <h5>Corte de Caja</h5>
                    <h6>Cajero: <?php echo $usuario; ?></h6>
                    <blockquote style="color: red;">
                        Recuerde que está acción no se puede revertir, sólo realice su corte de caja si está seguro
                        que su turno ha concluido
                    </blockquote>
                    </div>
                </div>
                <form action="logic_caja/save_corte.php" method="POST">
                    <input type="hidden" name="cajero" value="<?php echo $usuario; ?>">
                    <input type="hidden" name="id_cajero" value="<?php echo $id_user; ?>">
                   
                    <div class="row">
                    <div class="input-field col s12">
                    <input placeholder="Capture nombre de quien recibe" id="mont" type="text" class="validate" min="0" name="val_user" required>
                    <label for="mont">Capture su nombre de Usuario</label>
                    </div>
                    <div class="input-field col s12">
                    <input placeholder="Capture nombre de quien recibe" id="mont" type="password" class="validate" min="0" name="val_pass" required>
                    <label for="mont">Capture su contraseña del sistema</label>
                    </div>
                    <div class="col s12">
                            <button class="btn waves-effect waves-light" type="submit" name="action">Realizar corte de Caja
                                <i class="material-icons right">local_atm</i>
                            </button>
                        </div>
                    </div>
                    
                  
                        
                   
                </form>
            </div>
            <div class="col s6">
                <div class="row">
                    <div class="col s12">
                       
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ***************************** TERMINA CONTENIDO ****************************** -->
<?php echo $footer_caja;  ?>
<script>
    $(document).ready(function(){
    $('select').formSelect();
  });
</script>
</body>
</html>