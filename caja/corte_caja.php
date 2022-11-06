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
$hoy = date("Y-m-d");
// Listado de Vales
$sql_val_corte = "SELECT * FROM cortes_caja WHERE cajero_corte = '$id_user' AND fecha_corte = '$hoy'";
                        $res_val_corte = $mysqli->query($sql_val_corte);
                        $val_corte = $res_val_corte->num_rows;
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
    <script>
        function abrir(url)
          { 
            open(url,'','top=0,left=100,width=850,height=1056') ; 
          }
    </script>
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
            <?php 
                    if($val_corte == 0){
                    ?>
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
                    <input placeholder="Usuario" id="mont" type="text" class="validate" min="0" name="val_user" required>
                    <label for="mont">Capture su nombre de Usuario</label>
                    </div>
                    <div class="input-field col s12">
                    <input placeholder="Contraseña" id="mont" type="password" class="validate" min="0" name="val_pass" required>
                    <label for="mont">Capture su contraseña del sistema</label>
                    </div>
                    <div class="col s12">
                            <button class="btn waves-effect waves-light" type="submit" name="action">Realizar corte de Caja
                                <i class="material-icons right">local_atm</i>
                            </button>
                        </div>
                    </div>
                </form>
                <?php 
                }else{
                   echo'
                   <div class="row">
                   <div class="col s12">
                   <h5>Corte de Caja</h5>
                   <blockquote style="color: red;">
                        El usuario de la sesión actual ya ejecutó su corte de caja del día.
                    </blockquote>
                    </div>
                    </div>
                   ';
                }
                ?>
            </div>
            <div class="col s6">
                <div class="row">
                    <div class="col s12">
                    <?php 
                        if($val_corte == 1){
                            $corte = mysqli_fetch_assoc($res_val_corte);
                            $id_corte = $corte['id_corte'];
                    ?>
                    <h6>Corte de caja del Cajero: <?php echo $usuario; ?></h6>
                    <h6>Fecha: <?php echo date("d/m/Y"); ?></h6>
                    <table class="centered">
                        <thead>
                            <tr>
                                <th>Cobros Realizados</th>
                                <th>Monto de Cobros</th>
                                <th>Vales de Salida Registrados</th>
                                <th>Monto Vales de Salida</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $corte['cobros']; ?></td>
                                <td>$ <?php echo $corte['cobrado']; ?></td>
                                <td><?php echo $corte['vales_registrados']; ?></td>
                                <td>$ <?php echo $corte['monto_vales']; ?></td>
                            </tr>
                            <tr>
                                <td colspan="2">Total del Corte</td>
                                <td colspan="2">$ <?php echo $corte['monto_corte']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                            <div class="col s12">
                                <div class="divider"></div><br>
                                <a href="javascript:abrir('print_corte_caja.php?crcj=<?php echo $id_corte; ?>')"
                        class="cyan darken-1 btn"><i class="material-icons right">print</i>Imprimir Corte de Caja</a>
                            </div>
                    </div>
                    <?php 
                        }
                    ?>
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