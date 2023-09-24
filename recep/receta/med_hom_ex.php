<?php
include_once '../../app/logic/conn.php';
$cita = $_GET['c'];
$usuario = $_GET['u'];
$paciente = $_GET['p'];

$result_in_med_h = '';
$mensaje_excede = '';

$sql_val_med_cap = "SELECT *, CONCAT(med1,', ',med2,', ',med3,', ',med4,', ',med5) MedFrascos FROM rec_med_home WHERE tipo_fras = 'ext' AND id_cita = '$cita' and cancelado = 0;";
        $res_val_frascos = $mysqli->query($sql_val_med_cap);
        $med_val = $res_val_frascos->num_rows;
if($med_val == 0){
  $no_frasco = $med_val +1;
}else{
  $no_frasco = $med_val +1;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../static/css/main.css">
    <link rel="stylesheet" href="../../static/css/materialize.css">
    <link rel="stylesheet" href="../../static/icons/iconfont/material-icons.css">
    <link rel="stylesheet" type="text/css" href="../../static/css/select2.min.css">
    <script type="text/javascript" src="../../static/js/jquery-3.3.1.min.js"></script>
    <script src="../../static/js/select2.min.js"></script>
    <title>Frascos Extra Med Hom</title>
</head>
<body>
    <div class="row">
      <div class="col s12">
      <?php echo $result_in_med_h; ?>
    <form action="save_frasco_ex.php" method="POST">
        <h4>Medicamentos Homeopáticos (Frascos Extra)</h4>
        <?php 
        if($no_frasco > 3){
          echo '<p>Han sido capturados todos los frascos extra posibles del tratamiento.</p>';
          ?>
          <a href="save_med_hom.php?c=<?php echo $cita ?>&u=<?php echo $usuario?>" class="waves-effect waves-light btn">Resumen Medicamentos Homeopáticos</a>
          <?php
        }else{
          ?>
          <table>
            <tbody>
                <tr style="margin-top: -2em;">
                    <td style="width: 95;"><h5>Frasco <?php echo $no_frasco ?></h5></td>
                    <td><select id='buscador' style='width: 200px;' name="Med1" required>
                        <option value='0'> --- </option>
                    </select></td>
                    <td><select id='buscador2' style='width: 200px;' name="Med2">
                        <option value='0'> --- </option>
                    </select></td>
                    <td><select id='buscador3' style='width: 200px;' name="Med3">
                        <option value='0'> --- </option>
                    </select></td>
                    <td><select id='buscador4' style='width: 200px;' name="Med4">
                        <option value='0'> --- </option>
                    </select></td>
                    <td><select id='buscador5' style='width: 200px;' name="Med5">
                        <option value='0'> --- </option>
                    </select></td>
                </tr>
                <tr>
                <td colspan="4"><input type="submit" class="btn" value="Guardar Frasco"></td>
                  <td colspan="2"><a href="save_med_hom.php?c=<?php echo $cita ?>&u=<?php echo $usuario?>" class="waves-effect waves-light btn">Resumen Medicamentos Homeopáticos</a></td>
                  
                </tr>
               
            </tbody>
        </table>
        <?php
        }
        ?>

        <input type="hidden" name="c" value="<?php echo $cita; ?>">
        <input type="hidden" name="u" value="<?php echo $usuario; ?>">
        <input type="hidden" name="tipo" value="ext">
        <input type="hidden" name="n_frasco" value="<?php echo $no_frasco;?>">
        <input type="hidden" name="p" value="<?php echo $paciente;?>">

      </form>
      <div style="margin: 20px;"></div>
      <?php 
      if($med_val == 0){
        echo '<h5>Aún no hay Frascos Capturados de esta Cita</h5>';
      }else{
        echo '<h5>Frascos Capturados</h5>';
        while($frascos = mysqli_fetch_assoc($res_val_frascos)){
          echo '<p>Frasco '.$frascos['frasco'].' Medicamentos: '.rtrim($frascos['MedFrascos'],", ").'</p>';
        }
      }
      ?>
      </div>
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