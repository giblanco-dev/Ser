<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: ../index.php');
    exit();
}elseif($_SESSION['nivel'] == 1 OR $_SESSION['nivel'] == 7){
            $id_user = $_SESSION['id'];
            $usuario = $_SESSION['name_usuario'];
            $nivel = $_SESSION['nivel'];
}else{
    header('Location: ../index.php');
    exit();
}
include_once 'recep_sections.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receta Interna</title>
    <link rel="shortcut icon" href="../static/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../static/css/materialize.css">
    <link rel="stylesheet" href="../static/icons/iconfont/material-icons.css">
    
    <script type="text/javascript" src="../static/js/jquery-3.3.1.min.js"></script>
</head>
<body>
<?php echo $nav_recep;  ?>
<div class="container">
    <div class="row">
    <div class="col s4">
    <h5 style="color: #2d83a0; font-weight:bold;">RECETA INTERNA</h5>
    </div>
    <div class="col s4">
        <h6>Médico: </h6>
        <h6>Paciente: </h6>
    </div>
    <div class="col s4">
        <h6>Fecha : --/--/----</h6>
        <h6>Cita: </h6>
    </div>
    </div>
</div>
<div class="row" style="max-width: 95%;">
    <div class="col s6">
        <table>
            <thead>
                <tr>
                    <th style="width: 200px;">TERAPIAS</th>
                    <th style="width: 70px;"></th>
                    <th style="text-align: center;">INDICACIONES</th>
                </tr>
            </thead>
            <form action="" method="POST">
            <tbody>
                <tr>
                    <td>PARES MAGNÉTICOS</td>
                    <td class="center-align"><input class="browser-default" type="number" style="width: 50px;" value="0" min="0" max="9" /></td>
                    <td><input class="browser-default" type="text" style="width: 100%;"></td>
                </tr>
                <tr>
                    <td>FOTOTERAPIA</td>
                    <td class="center-align"><input class="browser-default" type="number" style="width: 50px;" value="0" min="0" max="9" /></td>
                    <td><input class="browser-default" type="text" style="width: 100%;"></td>
                </tr>
                <tr>
                    <td>TERAPIA NEUTRAL</td>
                    <td class="center-align"><input class="browser-default" type="number" style="width: 50px;" value="0" min="0" max="9" /></td>
                    <td><input class="browser-default" type="text" style="width: 100%;"></td>
                </tr>
                <tr>
                    <td>TERAPIA O</td>
                    <td class="center-align"><input class="browser-default" type="number" style="width: 50px;" value="0" min="0" max="9" /></td>
                    <td><input class="browser-default" type="text" style="width: 100%;"></td>
                </tr>
                <tr>
                    <td>MASAJE</td>
                    <td class="center-align"><input class="browser-default" type="number" style="width: 50px;" value="0" min="0" max="9" /></td>
                    <td><input class="browser-default" type="text" style="width: 100%;"></td>
                </tr>
                <tr>
                    <td>ACUPUNTURA</td>
                    <td class="center-align"><input class="browser-default" type="number" style="width: 50px;" value="0" min="0" max="9" /></td>
                    <td><input class="browser-default" type="text" style="width: 100%;"></td>
                </tr>
                <tr>
                    <td>VACUNA PROCAINA</td>
                    <td class="center-align"><input class="browser-default" type="number" style="width: 50px;" value="0" min="0" max="9" /></td>
                    <td><input class="browser-default" type="text" style="width: 100%;"></td>
                </tr>
                <tr>
                    <td>AUTOVACUNA</td>
                    <td class="center-align"><input class="browser-default" type="number" style="width: 50px;" value="0" min="0" max="9" /></td>
                    <td><input class="browser-default" type="text" style="width: 100%;"></td>
                </tr>
                <tr>
                    <td>TERAPIA DE OÍDOS</td>
                    <td class="center-align"><input class="browser-default" type="number" style="width: 50px;" value="0" min="0" max="9" /></td>
                    <td><input class="browser-default" type="text" style="width: 100%;"></td>
                </tr>
                <tr>
                    <td>BIOTOX</td>
                    <td class="center-align"><input class="browser-default" type="number" style="width: 50px;" value="0" min="0" max="9" /></td>
                    <td><input class="browser-default" type="text" style="width: 100%;"></td>
                </tr>
                <tr>
                    <td>PRESOTERAPIA</td>
                    <td class="center-align"><input class="browser-default" type="number" style="width: 50px;" value="0" min="0" max="9" /></td>
                    <td><input class="browser-default" type="text" style="width: 100%;"></td>
                </tr>
                <tr>
                    <td>HHP</td>
                    <td class="center-align"><input class="browser-default" type="number" style="width: 50px;" value="0" min="0" max="9" /></td>
                    <td><input class="browser-default" type="text" style="width: 100%;"></td>
                </tr>
                <tr>
                    <td>C. ELECTROMAGNÉTICA</td>
                    <td class="center-align"><input class="browser-default" type="number" style="width: 50px;" value="0" min="0" max="9" /></td>
                    <td><input class="browser-default" type="text" style="width: 100%;"></td>
                </tr>
                <tr>
                    <td>M. SCANNER</td>
                    <td class="center-align"><input class="browser-default" type="number" style="width: 50px;" value="0" min="0" max="9" /></td>
                    <td><input class="browser-default" type="text" style="width: 100%;"></td>
                </tr>
                <tr>
                    <td>OBSERVACIONES:</td>
                    <td colspan="2"><textarea name="" id="" cols="30" rows="3"></textarea></td>
                </tr>
            </tbody>
            </form>
        </table>
    </div>
    <!-- ************************** INICIAN SUEROS **********************************-->
    <div class="col s6">
    <table>
            <thead>
                <tr>
                    <th style="width: 200px;">SUERO BASE</th>
                    <th style="width: 70px;"></th>
                    <th style="text-align: center;">COMPLEMENTOS</th>
                </tr>
            </thead>
            <form action="" method="POST">
            <tbody>
                <tr>
                    <td>METALES</td>
                    <td class="center-align"><input class="browser-default" type="number" style="width: 50px;" value="0" min="0" max="9" /></td>
                    <td><input class="browser-default" type="text" style="width: 100%;"></td>
                </tr>
                <tr>
                    <td>SOLUCIÓN HORMONAL</td>
                    <td class="center-align"><input class="browser-default" type="number" style="width: 50px;" value="0" min="0" max="9" /></td>
                    <td><input class="browser-default" type="text" style="width: 100%;"></td>
                </tr>
                <tr>
                    <td>SET</td>
                    <td class="center-align"><input class="browser-default" type="number" style="width: 50px;" value="0" min="0" max="9" /></td>
                    <td><input class="browser-default" type="text" style="width: 100%;"></td>
                </tr>
                <tr>
                    <td>TAQUINIOCA</td>
                    <td class="center-align"><input class="browser-default" type="number" style="width: 50px;" value="0" min="0" max="9" /></td>
                    <td><input class="browser-default" type="text" style="width: 100%;"></td>
                </tr>
                <tr>
                    <td>ELEMENTOS HUMANOS</td>
                    <td class="center-align"><input class="browser-default" type="number" style="width: 50px;" value="0" min="0" max="9" /></td>
                    <td><input class="browser-default" type="text" style="width: 100%;"></td>
                </tr>
                <tr>
                    <td>ENZIMAS</td>
                    <td class="center-align"><input class="browser-default" type="number" style="width: 50px;" value="0" min="0" max="9" /></td>
                    <td><input class="browser-default" type="text" style="width: 100%;"></td>
                </tr>
                <tr>
                    <td>NEUROTRANSMISORES</td>
                    <td class="center-align"><input class="browser-default" type="number" style="width: 50px;" value="0" min="0" max="9" /></td>
                    <td><input class="browser-default" type="text" style="width: 100%;"></td>
                </tr>
                <tr>
                    <td>CUÁNTICA</td>
                    <td class="center-align"><input class="browser-default" type="number" style="width: 50px;" value="0" min="0" max="9" /></td>
                    <td><input class="browser-default" type="text" style="width: 100%;"></td>
                </tr>
                <tr>
                    <td>BIOTÓNICA</td>
                    <td class="center-align"><input class="browser-default" type="number" style="width: 50px;" value="0" min="0" max="9" /></td>
                    <td><input class="browser-default" type="text" style="width: 100%;"></td>
                </tr>
                <tr>
                    <td>EBQ</td>
                    <td class="center-align"><input class="browser-default" type="number" style="width: 50px;" value="0" min="0" max="9" /></td>
                    <td><input class="browser-default" type="text" style="width: 100%;"></td>
                </tr>
                <tr>
                    <td>ISOMEROS</td>
                    <td class="center-align"><input class="browser-default" type="number" style="width: 50px;" value="0" min="0" max="9" /></td>
                    <td><input class="browser-default" type="text" style="width: 100%;"></td>
                </tr>
                <tr>
                    <td>GIP</td>
                    <td class="center-align"><input class="browser-default" type="number" style="width: 50px;" value="0" min="0" max="9" /></td>
                    <td><input class="browser-default" type="text" style="width: 100%;"></td>
                </tr>
                <tr>
                    <td>REPOLARIZANTE</td>
                    <td class="center-align"><input class="browser-default" type="number" style="width: 50px;" value="0" min="0" max="9" /></td>
                    <td><input class="browser-default" type="text" style="width: 100%;"></td>
                </tr>
                <tr>
                    <td>VISCUM</td>
                    <td class="center-align"><input class="browser-default" type="number" style="width: 50px;" value="0" min="0" max="9" /></td>
                    <td><input class="browser-default" type="text" style="width: 100%;"></td>
                </tr>
                <tr>
                    <td>QUELACIÓN</td>
                    <td class="center-align"><input class="browser-default" type="number" style="width: 50px;" value="0" min="0" max="9" /></td>
                    <td><input class="browser-default" type="text" style="width: 100%;"></td>
                </tr>
                <tr>
                    <td>OBSERVACIONES:</td>
                    <td colspan="2"><textarea name="" id="" cols="30" rows="3"></textarea></td>
                </tr>
            </tbody>
            </form>
        </table>
    </div>
</div>

<?php echo $footer_recep;  ?>
</body>
</html>