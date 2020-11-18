<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: ../index.php');
    exit();
} elseif ($_SESSION['nivel'] == 1 or $_SESSION['nivel'] == 7) {
    $id_user = $_SESSION['id'];
    $usuario = $_SESSION['name_usuario'];
    $nivel = $_SESSION['nivel'];
} else {
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
            <form action="" method="post">
                <p style="display:inline-block; width: 25%; font-weight:bold;">TERAPIAS</p>
                <p style="display:inline-block; width: 35%; font-weight:bold; text-align:center;">INDICACIONES</p>
                <input type="submit" value="Guardar Terapias" style="display:inline-block; width: 25%;" class="btn-small">

                <p style="margin-top: -5px; display:inline-block; width: 25%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000;">PARES MAGNÉTICOS</span>
                    </label>
                </p>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 60%; margin-left: 2%;">

                <p style="margin-top: -15px; display:inline-block; width: 25%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000;">FOTOTERAPIA</span>
                    </label>
                </p>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 60%; margin-left: 2%;">

                <p style="margin-top: -15px; display:inline-block; width: 25%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000;">TERAPIA NEUTRAL</span>
                    </label>
                </p>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 60%; margin-left: 2%;">

                <p style="margin-top: -15px; display:inline-block; width: 25%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000;">TERAPIA O</span>
                    </label>
                </p>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 60%; margin-left: 2%;">

                <p style="margin-top: -15px; display:inline-block; width: 25%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000;">MASAJE</span>
                    </label>
                </p>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 60%; margin-left: 2%;">

                <p style="margin-top: -15px; display:inline-block; width: 25%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000;">ACUPUNTURA</span>
                    </label>
                </p>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 60%; margin-left: 2%;">

                <p style="margin-top: -15px; display:inline-block; width: 25%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000;">VACUNA PROCAINA</span>
                    </label>
                </p>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 60%; margin-left: 2%;">

                <p style="margin-top: -15px; display:inline-block; width: 25%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000;">AUTOVACUNA</span>
                    </label>
                </p>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 60%; margin-left: 2%;">

                <p style="margin-top: -15px; display:inline-block; width: 25%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000;">TERAPIA DE OÍDOS</span>
                    </label>
                </p>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 60%; margin-left: 2%;">

                <p style="margin-top: -15px; display:inline-block; width: 25%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000;">PRESOTERAPIA</span>
                    </label>
                </p>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 60%; margin-left: 2%;">

                <p style="margin-top: -15px; display:inline-block; width: 25%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000;">HHP</span>
                    </label>
                </p>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 60%; margin-left: 2%;">

                <p style="margin-top: -15px; display:inline-block; width: 28%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000;">C. ELECTROMAGNÉTICA</span>
                    </label>
                </p>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 57%; margin-left: 2%;">

                <p style="margin-top: -15px; display:inline-block; width: 25%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000;">M. SCANNER</span>
                    </label>
                </p>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 60%; margin-left: 2%;">

                <p style="margin-top: -15px; display:inline-block; width: 17%; font-weight: bold; ">OBSERVACIONES</p>
                <input type="text" class="browser-default" style="width: 68%; margin-left: 2%;">
            </form>
        </div>
        <!-- ************************** INICIAN SUEROS **********************************-->
        <div class="col s6">
            <form action="" method="post">
                <p style="display:inline-block; width: 25%; font-weight:bold;">SUERO BASE</p>
                <p style="display:inline-block; width: 35%; font-weight:bold; text-align:center;">COMPLEMENTOS</p>
                <input type="submit" value="Guardar Sueros" style="display:inline-block; width: 25%;" class="btn-small">

                <p style="margin-top: -5px; display:inline-block; width: 25%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000;">METALES</span>
                    </label>
                </p>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 60%; margin-left: 2%;">

                <p style="margin-top: -15px; display:inline-block; width: 30%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000;">SOLUCIÓN HORMONAL</span>
                    </label>
                </p>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 55%; margin-left: 2%;">

                <p style="margin-top: -15px; display:inline-block; width: 25%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000;">SET</span>
                    </label>
                </p>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 60%; margin-left: 2%;">

                <p style="margin-top: -15px; display:inline-block; width: 25%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000;">TAQUINIOCA</span>
                    </label>
                </p>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 60%; margin-left: 2%;">

                <p style="margin-top: -15px; display:inline-block; width: 30%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000;">ELEMENTOS HUMANOS</span>
                    </label>
                </p>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 55%; margin-left: 2%;">

                <p style="margin-top: -15px; display:inline-block; width: 25%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000;">ENZIMAS</span>
                    </label>
                </p>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 60%; margin-left: 2%;">

                <p style="margin-top: -15px; display:inline-block; width: 25%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000;">NEUROTRANSMISORES</span>
                    </label>
                </p>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 60%; margin-left: 2%;">

                <p style="margin-top: -15px; display:inline-block; width: 25%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000;">CUÁNTICA</span>
                    </label>
                </p>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 60%; margin-left: 2%;">

                <p style="margin-top: -15px; display:inline-block; width: 25%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000;">BIOTÓNICA</span>
                    </label>
                </p>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 60%; margin-left: 2%;">

                <p style="margin-top: -15px; display:inline-block; width: 25%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000;">EBQ</span>
                    </label>
                </p>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 60%; margin-left: 2%;">

                <p style="margin-top: -15px; display:inline-block; width: 25%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000;">ISOMEROS</span>
                    </label>
                </p>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 60%; margin-left: 2%;">

                <p style="margin-top: -15px; display:inline-block; width: 28%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000;">GIP</span>
                    </label>
                </p>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 57%; margin-left: 2%;">

                <p style="margin-top: -15px; display:inline-block; width: 25%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000;">REPOLARIZANTE</span>
                    </label>
                </p>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 60%; margin-left: 2%;">

                <p style="margin-top: -15px; display:inline-block; width: 25%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000;">VISCUM</span>
                    </label>
                </p>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 60%; margin-left: 2%;">

                <p style="margin-top: -15px; display:inline-block; width: 25%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000;">QUELACIÓN</span>
                    </label>
                </p>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 60%; margin-left: 2%;">

                <p style="margin-top: -15px; display:inline-block; width: 17%; font-weight: bold; ">OBSERVACIONES</p>
                <input type="text" class="browser-default" style="width: 68%; margin-left: 2%;">
            </form>
        </div>
      
        <!-- ************************** INICIAN MEDICAMENTOS HOMEOPÁTICOS **********************************-->
        <div class="col s8">
            <form action="" method="post">
                <p style="display:inline-block; width: 65%; font-weight:bold;">MEDICAMENTO HOMEOPÁTICO</p>
                <input type="submit" value="Guardar Medicamentos H." style="display:inline-block; width: 30%;" class="btn-small">

                <p style="margin-top: -15px; display:inline-block; width: 5%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000; font-size:x-large; font-weight:bold;">1</span>
                    </label>
                </p>
                <select name="" id="" style="width: 15%; display:inline-block; margin-left: 2%;" class="browser-default">
                    <option value="">Combinación 1</option>
                    <option value="">Combinación 2</option>
                    <option value="">Combinación 3</option>
                </select>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">

                <p style="margin-top: -15px; display:inline-block; width: 5%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000; font-size:x-large; font-weight:bold;">2</span>
                    </label>
                </p>
                <select name="" id="" style="width: 15%; display:inline-block; margin-left: 2%;" class="browser-default">
                    <option value="">Combinación 1</option>
                    <option value="">Combinación 2</option>
                    <option value="">Combinación 3</option>
                </select>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">

                <p style="margin-top: -15px; display:inline-block; width: 5%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000; font-size:x-large; font-weight:bold;">3</span>
                    </label>
                </p>
                <select name="" id="" style="width: 15%; display:inline-block; margin-left: 2%;" class="browser-default">
                    <option value="">Combinación 1</option>
                    <option value="">Combinación 2</option>
                    <option value="">Combinación 3</option>
                </select>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">

                <p style="margin-top: -15px; display:inline-block; width: 5%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000; font-size:x-large; font-weight:bold;">4</span>
                    </label>
                </p>
                <select name="" id="" style="width: 15%; display:inline-block; margin-left: 2%;" class="browser-default">
                    <option value="">Combinación 1</option>
                    <option value="">Combinación 2</option>
                    <option value="">Combinación 3</option>
                </select>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">

                <p style="margin-top: -15px; display:inline-block; width: 5%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000; font-size:x-large; font-weight:bold;">5</span>
                    </label>
                </p>
                <select name="" id="" style="width: 15%; display:inline-block; margin-left: 2%;" class="browser-default">
                    <option value="">Combinación 1</option>
                    <option value="">Combinación 2</option>
                    <option value="">Combinación 3</option>
                </select>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">

                <p style="margin-top: -15px; display:inline-block; width: 5%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000; font-size:x-large; font-weight:bold;">6</span>
                    </label>
                </p>
                <select name="" id="" style="width: 15%; display:inline-block; margin-left: 2%;" class="browser-default">
                    <option value="">Combinación 1</option>
                    <option value="">Combinación 2</option>
                    <option value="">Combinación 3</option>
                </select>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">

                <p style="margin-top: -15px; display:inline-block; width: 5%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000; font-size:x-large; font-weight:bold;">7</span>
                    </label>
                </p>
                <select name="" id="" style="width: 15%; display:inline-block; margin-left: 2%;" class="browser-default">
                    <option value="">Combinación 1</option>
                    <option value="">Combinación 2</option>
                    <option value="">Combinación 3</option>
                </select>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">

                <p style="margin-top: -15px; display:inline-block; width: 5%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000; font-size:x-large; font-weight:bold;">8</span>
                    </label>
                </p>
                <select name="" id="" style="width: 15%; display:inline-block; margin-left: 2%;" class="browser-default">
                    <option value="">Combinación 1</option>
                    <option value="">Combinación 2</option>
                    <option value="">Combinación 3</option>
                </select>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">

                <p style="margin-top: -15px; display:inline-block; width: 5%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000; font-size:x-large; font-weight:bold;">9</span>
                    </label>
                </p>
                <select name="" id="" style="width: 15%; display:inline-block; margin-left: 2%;" class="browser-default">
                    <option value="">Combinación 1</option>
                    <option value="">Combinación 2</option>
                    <option value="">Combinación 3</option>
                </select>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">

                <p style="margin-top: -15px; display:inline-block; width: 5%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000; font-size:x-large; font-weight:bold;">10</span>
                    </label>
                </p>
                <select name="" id="" style="width: 15%; display:inline-block; margin-left: 2%;" class="browser-default">
                    <option value="">Combinación 1</option>
                    <option value="">Combinación 2</option>
                    <option value="">Combinación 3</option>
                </select>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 13%; margin-left: 1%;">


            </form>
        </div>
    </div>

    <?php echo $footer_recep;  ?>
</body>

</html>