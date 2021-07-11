<?php 
$id_cita = $_GET['c'];
$usuario = $_GET['u'];
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
</head>
<body>
    
    <div class="row">
    <div class="col s12">
        <h5>Cita: CSA-<?php echo $id_cita; ?></h5>
        <h5>Paciente: </h5>
        <div class="divider"></div>
        <table>
        <thead>
        <tr>
        <th colspan="2" class="center-align">Cobrar</th>
        </tr>
        <tbody>
        <tr>
        <td>Sub-Total</td>
        <td></td>
        <td>Consulta</td>
        <td></td>
        <td>Descuento</td>
        <td></td>
        </tr>
        <tr>
        <td>Abonado</td>
        <td></td>
        <td>Total a pagar</td>
        <td></td>
        </tr>
        </tbody>
        </thead>
        </table>
        <form action="">
            <input type="number" name="" id="">
            <select name="" id="">
                <option value="">Medio de Pago</option>
                <option value="">Efectivo</option>
                <option value="">Tarjeta</option>
                <option value="">Cheque</option>
            </select>
        </form>
    </div>
    </div>
   
</body>
</html>