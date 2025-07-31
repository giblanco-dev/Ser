<?php
include_once '../../app/logic/conn.php';
$cita = $_GET['c'];
$usuario = $_GET['u'];
$paciente = $_GET['p'];

$sql_fras = "SELECT * FROM rec_med_home WHERE id_cita = $cita  ORDER BY tipo_fras";
$fras = $mysqli->query($sql_fras);
$val_fras = $fras->num_rows;

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../static/css/main.css">
    <link rel="stylesheet" href="../../static/css/materialize.css">
    <link rel="stylesheet" href="../../static/icons/iconfont/material-icons.css">
    <link rel="stylesheet" type="text/css" href="../../static/css/select2.min.css">
    <script type="text/javascript" src="../../static/js/jquery-3.3.1.min.js"></script>
    <script src="../../static/js/select2.min.js"></script>
    <title>Actualiza Frascos</title>
    <style type="text/css"> 
        thead tr th { 
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: #ffffff;
        }
    
        .table-responsive-2 { 
            height: 400px; /* Mover a 400 para demostrar el scroll*/
            overflow-y:scroll;
        }
    </style>
</head>
<body>
    <div class="row">
            <div class="col s12">
            <h5>Actualización de Medicamentos Homeopáticos y Flores de Bach</h5>
            </div>
    </div>
    <div class="row">
        <?php 
        if($val_fras == 0){
            echo '<div class="col s12">
            <p>Esta cita no posee medicamentos homeopáticos.</p>
            </div>';
        }else{ ?>
            <div class="col s7 table-responsive-2">

            <?php // Inicia Inpresión de tabla con medicamentos no cancelados
            echo '
            
            <table>
            <thead>
            <tr>
                <th><b>Frasco</b></th>
                <th><b>Tipo</b></th>
                <th><b>Medicamentos</b></th>
              </tr>
              </thead>
              <tbody>
                    ';
                while($rows2 = mysqli_fetch_assoc($fras)){
                if($rows2['cancelado'] == 0){
                    $medicamentos = $rows2['med1'].' '.$rows2['med2'].' '.$rows2['med3'].' '.$rows2['med4'].' '.$rows2['med5'];
                    if($rows2['tipo_fras']== "gen"){$tipo_frasco = "Principal"; $no_frasco = $rows2['frasco'];}
                    if($rows2['tipo_fras']== "ext"){$tipo_frasco = "Extra";$no_frasco = $rows2['frasco'].' Ex';}
                    if($rows2['tipo_fras']== "flo"){$tipo_frasco = "Flor Bach";$no_frasco = ' Flor '.$rows2['frasco'];}
                    echo '<tr>
                            <td>'.$no_frasco.'</td>
                            <td>'.$tipo_frasco.'</td>
                            <td>'.$medicamentos.'</td>
                        </tr>';
                }
            }       
            echo '
            </tbody>
            </table>'
            // ********** Termina Impresión de Tabla
            ?>


            </div>
            <form action="update_frasco.php" method="post">
            <div class="col s5">
            
                
                <div class="col s8">
                <blockquote>Seleccione el Tipo de Frasco</blockquote>
                    <p>
                        <label>
                        <input name="tipo" type="radio" value="gen" />
                        <span>Principal</span>
                        </label>
                    </p>
                    <p>
                        <label>
                        <input name="tipo" type="radio" value="ext" />
                        <span>Extra</span>
                        </label>
                    </p>
                    <p>
                        <label>
                        <input name="tipo" type="radio" value="flo" />
                        <span>Flores de Bach</span>
                        </label>
                    </p>
                </div>
                <div class="col s4">
                    <blockquote>Indique el No. de Frasco</blockquote>
                    <input type="number" name="n_frasco" min="1" max="10" step="1" required>
                </div>
                <div class="col s12">
                    <p>Capture los nuevos Medicamentos</p>
                </div>
                <div class="col s6">
                <select id='buscador' style='width: 200px;' name="Med1" required>
                        <option value='0'> --- </option>
                    </select>
                    <br><br>
                    <select id='buscador2' style='width: 200px;' name="Med2">
                        <option value='0'> --- </option>
                    </select>
                    <br><br>
                    <select id='buscador3' style='width: 200px;' name="Med3">
                        <option value='0'> --- </option>
                    </select>
                </div>
                <div class="col s6">
                    <select id='buscador4' style='width: 200px;' name="Med4">
                        <option value='0'> --- </option>
                    </select>
                    <br><br>
                    <select id='buscador5' style='width: 200px;' name="Med5">
                        <option value='0'> --- </option>
                    </select>
                
                    <input type="hidden" name="c" value="<?php echo $cita; ?>">
                    <input type="hidden" name="u" value="<?php echo $usuario; ?>">
                    <input type="hidden" name="p" value="<?php echo $paciente;?>">
                    <br><br><br>
                  <input type="submit" class="btn" value="Actualizar Frasco">
                </div>
                
            
            </div>
            </form>

        
        <?php    } // *********** Cierre validación que en efecto existen med capturados
        ?>
        
         
      
    </div>


<!-- ***************** INICIA SCRIPT DE AUTOCOMPLETADO ***************************************-->
<script>
        $(document).ready(function(){
            $("#buscador").select2({
                ajax: {
                    url: "busca_med_hom.php",
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            palabraClave: params.term // search term
                        };
                    },
                    processResults: function (response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });
            
            // ***********************************
            $("#buscador2").select2({
                ajax: {
                    url: "busca_med_hom.php",
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            palabraClave: params.term // search term
                        };
                    },
                    processResults: function (response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });

            // ***********************************
            $("#buscador3").select2({
                ajax: {
                    url: "busca_med_hom.php",
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            palabraClave: params.term // search term
                        };
                    },
                    processResults: function (response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });

            // ***********************************
            $("#buscador4").select2({
                ajax: {
                    url: "busca_med_hom.php",
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            palabraClave: params.term // search term
                        };
                    },
                    processResults: function (response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });

            // ***********************************
            $("#buscador5").select2({
                ajax: {
                    url: "busca_med_hom.php",
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            palabraClave: params.term // search term
                        };
                    },
                    processResults: function (response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });
        
          });
        </script>

</body>
</html>