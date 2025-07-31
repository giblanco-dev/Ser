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
require_once '../app/logic/conn.php';

$id_cita = $_GET['c'];
$usuario = $_GET['u'];


$sql_caja = "SELECT caja.*,
            CONCAT(paciente.nombres,' ',paciente.a_paterno,' ',paciente.a_materno) Nom_paciente,
            DATE_FORMAT(fecha_cobro, '%H:%i') AS horario
            FROM caja
            INNER JOIN cita ON caja.id_cita = cita.id_cita
            INNER JOIN paciente ON cita.id_paciente = paciente.id_paciente
            WHERE caja.id_cita = '$id_cita'";
$res_caja = $mysqli->query($sql_caja);
$val = $res_caja->num_rows;
if($val == 1){
    $row_caja = mysqli_fetch_assoc($res_caja);
    $paciente = $row_caja['Nom_paciente'];
    $subtotal = $row_caja['subtotal'];
    $consulta = $row_caja['consulta'];
    $descuento = $row_caja['descuento'];
    $total_cobro = $row_caja['total_cobro'];
    $saldo = $row_caja['saldo'];
    $abono = $row_caja['abono'];
    $status = $row_caja['status_pago'];
    $id_cobro = $row_caja['id_cobro'];
    $medio_pago = $row_caja['medio_pago'];
    $hora_pago = $row_caja['horario'];
}else{
    
    $paciente = "ERROR CONTACTAR CON SISTEMAS";
    $subtotal = "";
    $consulta = "";
    $descuento = "";
    $total_cobro = "";
    $id_cobro = "";
    $saldo = "";
    $abono = "";
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/css/materialize.css">
    <link rel="stylesheet" href="../static/icons/iconfont/material-icons.css">
    <script type="text/javascript" src="../static/js/jquery-3.3.1.min.js"></script>
    <script src="../static/js/materialize.js"></script>
    <title>Cobro</title>
    <script>
        function abrir(url)
          { 
            open(url,'','top=0,left=100,width=650,height=500') ; 
          }
    </script>
</head>
<body>
    
    <div class="row">
    <div class="col s12">
        <h6><b>Cita: CMA<?php echo $id_cita; ?></b></h6>
        <h6 style="text-transform: capitalize;"><b>Paciente: <?php echo $paciente; ?></b></h6>
        <div class="divider"></div>
        <table style="font-size: 12px;">
        <thead>
        <tbody>
        <tr>
        <td>Sub-Total</td>
        <td>$ <?php echo $subtotal; ?></td>
        <td>Consulta</td>
        <td>$ <?php echo $consulta; ?></td>
        </tr>
        <tr>
        <td>Descuento</td>
        <td><?php echo $descuento; ?> %</td>
        <td>Pagado</td>
        <td>$ <?php echo $abono; ?></td>
        </tr>
        <tr>
        <td>Total a pagar</td>
        <td>$ <?php echo $saldo; ?></td>
        </tr>
        <?php
        if($row_caja['monto_devolucion'] > 0){
            echo '
            <td colspan = 4><b>Cobro con Devolución</b></td>
            <tr>
            <td>Monto Devolución</td>
            <td>$ '.$row_caja['monto_devolucion'].'</td>
            <td>Autoriza</td>
            <td>'.$row_caja['autoriza_devolucion'].'</td>
            </tr>
            <tr>
            <td>Motivo</td>
            <td colspan = 3>'.$row_caja['motivo_devolucion'].'</td>
            </tr>
            ';
        }
        ?>
        </tbody>
        </thead>
        </table>
        <?php 
        if($status == 'NO' and $saldo >= 0){
        ?>
        <form action="pagar.php" method="POST">
            <p><b>Pagar (Capturar importes)</b></p>
            <div class="row">
            <div class="col s6">
                <p>Monto Efectivo</p>
            </div>
            <div class="col s6">
                <input placeholder="Monto Efectivo" type="number" min="0" name="abono_efectivo" step="0.001">
            </div>
            <div class="col s6">
                <p>Monto Tarjeta</p>
            </div>
            <div class="col s6">
                <input placeholder="Monto Tarjeta" type="number" min="0" name="abono_tarjeta" step="0.001">
            </div>
            <div class="col s6">
                <p>Monto Cheque</p>
            </div>
            <div class="col s6">
                <input placeholder="Monto Cheque" type="number" min="0" name="abono_cheque" step="0.001">
            </div>
            <div class="col s6">
                <p>Otras formas de pago</p>
            </div>
            <div class="col s6">
                <input placeholder="Monto otros" type="number" min="0" name="abono_otros" step="0.001">
            </div>
            </div>
            

            <!--select name="med_pago" required>
                <option value="" disabled selected>Medio de Pago</option>
                <option value="EFECTIVO">Efectivo</option>
                <option value="TARJETA(CRED-DEB)">Tarjeta</option>
                <option value="CHEQUE">Cheque</option>
                <option value="OTRAS">Varias</option>
            </select-->
            <input type="hidden" name="id_cobro" value="<?php echo $id_cobro; ?>">
            <input type="hidden" name="user" value="<?php echo $id_user; ?>">
            <input type="hidden" name="id_cita" value="<?php echo $id_cita; ?>">
            <input type="hidden" name="saldo" value="<?php echo $saldo; ?>">
            <div class="center-align">
            <button class="btn waves-effect waves-light" type="submit" name="action">Pagar
            <i class="material-icons right">payment</i>
            </button>
            </div>
        </form>
        <?php }elseif($status == 'NO' and $saldo == 0 and $descuento == 100){
            ?>
        <form action="pagar.php" method="POST">
            <p><b>Pagar (Capturar importe)</b></p>
            <!--input type="number" name="pago" id="" value="<?php //echo $saldo; ?>"-->
            <div class="row">
            <div class="col s6">
                <p>Monto Efectivo</p>
            </div>
            <div class="col s6">
                <input placeholder="Monto Efectivo" type="number" min="0" name="abono_efectivo" step="0.001">
            </div>
            <div class="col s6">
                <p>Monto Tarjeta</p>
            </div>
            <div class="col s6">
                <input placeholder="Monto Tarjeta" type="number" min="0" name="abono_tarjeta" step="0.001">
            </div>
            <div class="col s6">
                <p>Monto Cheque</p>
            </div>
            <div class="col s6">
                <input placeholder="Monto Cheque" type="number" min="0" name="abono_cheque" step="0.001">
            </div>
            <div class="col s6">
                <p>Otras formas de pago</p>
            </div>
            <div class="col s6">
                <input placeholder="Monto otros" type="number" min="0" name="abono_otros" step="0.001">
            </div>
            </div>
            <input type="hidden" name="id_cobro" value="<?php echo $id_cobro; ?>">
            <input type="hidden" name="user" value="<?php echo $id_user; ?>">
            <input type="hidden" name="id_cita" value="<?php echo $id_cita; ?>">
            <input type="hidden" name="saldo" value="<?php echo $saldo; ?>">
            <div class="center-align">
            <button class="btn waves-effect waves-light" type="submit" name="action">Pagar
            <i class="material-icons right">payment</i>
            </button>
            </div>
        </form>

            <?php
        }elseif($status == 'SI' and $saldo == 0){
            echo '<div class="center-align">
                    <br>
                    <a class="waves-effect waves-light btn"><i class="material-icons right">check</i>Pagado</a>';
                    ?>
                    <br>
                    <br>
                    <a href="javascript:abrir('recibo.php?r=<?php echo $id_cobro; ?>')"
                        class="cyan darken-1 btn"><i class="material-icons right">print</i>Imprimir Comprobante</a>
                    <br><br>
                    <p><b>Medios de Pago: <?php echo $medio_pago; ?></b></p>
                    <p><b>Hora de Pago: <?php echo $hora_pago; ?></b></p>
                    </div>
        <?php
        }else{
            echo '<p>Error contactar con Sistemas (Código de Error SALDVAL)</p>';
        }
        ?>
    </div>
    </div>
    <script type="text/javascript">
	$(document).ready(function(){
        $('select').formSelect();
	});
</script>
</body>
</html>