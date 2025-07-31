<?php
include_once '../../app/logic/conn.php';
$cita = $_GET['c'];
$usuario = $_GET['u'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../static/css/materialize.css">
    <link rel="stylesheet" href="../../static/icons/iconfont/material-icons.css">
    <title>Actualizar Signos Vitales</title>
</head>
<body>
    <div style="width: 90%; margin-left: 5%; ">
    <div class="row" style="width: 90%; margin-bottom: 10%;">
      <div class="divider" style="margin-bottom: 2%;"></div>
      <div class="col s4">
     
      <h5>Capturar importe a cobrar</h4>
      </div>
      <div class="col s6">
      <form action="env_caja.php" method="post" oninput="resultado.value=(parseInt(sub_total.value))-(parseInt(sub_total.value)*(parseInt(descuentos.value)/100))">
      <input type="number" name="sub_total" id="" placeholder="Ingrese el monto a cobrar $" min="0" style="max-width: 300px;">
         <p>Aplicar Descuento %</p>
         <input type="number" name="descuentos" min="0" max="100" step="5" style="max-width: 300px;" value="0">
         <br><br>
         <input type="text" name="comentarios" id="" placeholder="Comentarios">
         <br><br>
        <blockquote style="font-size: 16px; font-weight:bold;">
        Total a Pagar: $ 
        <output name="resultado" for="total consulta"></output>
        </blockquote>
         <div class="right-align">
          <?php
          $val_pago = "SELECT pagado FROM cita WHERE id_cita = '$cita'";
          $res_val_pago = $mysqli->query($val_pago);
          $row_val = mysqli_fetch_assoc($res_val_pago);
          $pagado = $row_val['pagado'];

        if($pagado == 0){
          echo '<button class="btn waves-effect waves-light" type="submit" name="action">Enviar para cobro
                  <i class="material-icons right">send</i>
              </button>';

        }elseif($pagado == 1){
          echo '<a class="waves-effect waves-light btn"><i class="material-icons right">check</i>Pagado</a>';
      }else{
          echo 'ERROR Favor de contactar a Sistemas CodError Status Pago no Válido';
      }
        ?>
         
         </div>
        </div>

        <input type="hidden" name="id_cita" value="<?php echo $cita ?>">
        <input type="hidden" name="user" value="<?php echo $usuario  ?>">
        <input type="hidden" name="terapias" value="0.0">
        <input type="hidden" name="sueros" value="0.0">
        <input type="hidden" name="homeopaticos" value="0">
        <input type="hidden" name="orales" value="0">
        <input type="hidden" name="consulta" value="0">
        <input type="hidden" name="flag" value="OTROS">
        
      
      </form>
      </div>
        
    </div>
</body>
</html>