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

// Información de citas del día

$hoy = date("Y-m-d");

// Listado de Vales
$sql_vales = "SELECT * FROM vales_salida WHERE fecha_vale = '$hoy' AND id_user = '$id_user'";
$res_vales = $mysqli->query($sql_vales);
$val_vales = $res_vales->num_rows;

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
            <div class="col s5">
                <?php 
                if($val_corte == 0){
                ?>
                <div class="row">
                    <div class="col s12">
                    <h5>Generar vale de Salida</h5>
                    </div>
                </div>
                <form action="logic_caja/save_vale.php" method="POST">
                    <input type="hidden" name="fecha_vale" value="<?php echo $hoy; ?>">
                    <input type="hidden" name="cajero" value="<?php echo $usuario; ?>">
                    <input type="hidden" name="id_cajero" value="<?php echo $id_user; ?>">
                    <div class="row">
                    <div class="input-field col s6">
                    <input placeholder="Capture la cantidad del vale" id="mont" type="number" class="validate" min="0" name="cantidad">
                    <label for="mont">Cantidad</label>
                    </div>
                    <div class="input-field col s6">
                        <select name="autoriza">
                        <option value="" disabled selected>Eliga Autorizador</option>
                        <option value="Dra. Mónica">Dra. Mónica Martinez</option>
                        <option value="Dr. Enrique">Dr. Enrique Martinez</option>
                        <option value="Admin">Administrador</option>
                        </select>
                        <label>Autoriza</label>
                    </div>
                    </div>
                    <div class="row">
                    <div class="input-field col s4">
                    <input placeholder="Capture nombre de quien recibe" id="mont" type="text" class="validate" min="0" name="recibe">
                    <label for="mont">Nombre Beneficiario</label>
                    </div>
                    <div class="input-field col s8">
                    <textarea id="textarea1" class="materialize-textarea" name="concepto"></textarea>
                    <label for="textarea1">Concepto</label>
                    </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <button class="btn waves-effect waves-light" type="submit" name="action">Guardar Vale
                                <i class="material-icons right">save</i>
                            </button>
                        </div>
                    </div>
                </form>
                <?php 
                }else{
                    echo'
                   <div class="row">
                   <div class="col s12">
                   <h5>Generar vale de Salida</h5>
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
                        <h5>Vales de Salida del día</h5>
                        <?php
                        if($val_vales > 0){
                            ?>
                        <table>
                        <thead>
                            <tr>
                                <th>Concepto</th>
                                <th>Cantidad</th>
                                <th>Recibe</th>
                                <th>Autoriza</th>
                                <th>Registra</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php   while($vales_reg = mysqli_fetch_assoc($res_vales)){ ?>
                                <tr>
                                    <td><?php echo $vales_reg['concepto']; ?></td>
                                    <td><?php echo $vales_reg['cantidad'];   ?></td>
                                    <td><?php echo $vales_reg['beneficiario']; ?></td>
                                    <td><?php echo $vales_reg['autorizador']; ?></td>
                                    <td><?php echo $vales_reg['user']; ?></td>
                                </tr>
                            <?php
                            }
            ?>
        </tbody>
    </table>

                        <?php
                        }else{
                            echo '<blockquote>No hay vales de salida registrados del día</blockquote>';
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