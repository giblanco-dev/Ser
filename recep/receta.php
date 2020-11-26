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
include_once '../app/logic/conn.php';
$sql_medicamentos = "SELECT * FROM med_homeopaticos";
$res = $mysqli->query($sql_medicamentos);
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
    <style>
        /*the container must be positioned relative:*/
.autocomplete {
  position: relative;
  display: inline-block;
}

input {
  border: 1px solid transparent;
  background-color: #f1f1f1;
  padding: 1px;
  font-size: 12px;
}

.autocomplete-items {
  position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 99;
  /*position the autocomplete items to be the same width as the container:*/
  top: 100%;
  left: 0;
  right: 0;
}

.autocomplete-items div {
  padding: 2px;
  cursor: pointer;
  background-color: #fff; 
  border-bottom: 1px solid #d4d4d4;
  max-width: 200px;
  
}

/*when hovering an item:*/
.autocomplete-items div:hover {
  background-color: #e9e9e9; 
}

/*when navigating through the items using the arrow keys:*/
.autocomplete-active {
  background-color: DodgerBlue !important; 
  color: #ffffff; 
}
    </style>
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
    </div>
    <div class="row">
        <!-- ************************** INICIAN MEDICAMENTOS HOMEOPÁTICOS **********************************-->
        <div style="width: 62%; display:inline-block; margin-left: 1%;">
            <form action="" method="post" autocomplete="off">
                <p style="display:inline-block; width: 44%; font-weight:bold;">MEDICAMENTO HOMEOPÁTICO</p>
                <input type="submit" value="Guardar Medicamentos H." style="display:inline-block; width: 30%;" class="btn-small">
                <br>
                <p style="margin-top: -15px; display:inline-block; width: 5%;">
                    <label>
                        <input type="checkbox" id="f1" />
                        <span style="color: #000; font-size:x-large; font-weight:bold;">1</span>
                    </label>
                </p>
                <select name="" id="comb1" style="width: 15%; display:inline-block; margin-left: 2%;" class="browser-default">
                    <option value="">Combinación 1</option>
                    <option value="">Combinación 2</option>
                    <option value="">Combinación 3</option>
                </select>
                <div class="autocomplete" style="display: inline-block;">
                <input type="text" id="f1-in1" name="frasco1[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                <input type="text" id="f1-in2" name="frasco1[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                <input type="text" id="f1-in3" name="frasco1[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                <input type="text" id="f1-in4" name="frasco1[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                <input type="text" id="f1-in5" name="frasco1[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                </div>
                <p style="margin-top: -15px; display:inline-block; width: 5%;">
                    <label>
                        <input type="checkbox" id="f2" />
                        <span style="color: #000; font-size:x-large; font-weight:bold;">2</span>
                    </label>
                </p>
                <select name="" id="comb2" style="width: 15%; display:inline-block; margin-left: 2%;" class="browser-default">
                    <option value="">Combinación 1</option>
                    <option value="">Combinación 2</option>
                    <option value="">Combinación 3</option>
                </select>
                <div class="autocomplete" style="display: inline-block;">
                <input type="text" id="f2-in1" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                <input type="text" id="f2-in2" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                <input type="text" id="f2-in3" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                <input type="text" id="f2-in4" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                <input type="text" id="f2-in5" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                </div>

                <p style="margin-top: -15px; display:inline-block; width: 5%;">
                    <label>
                        <input type="checkbox" id="f2" />
                        <span style="color: #000; font-size:x-large; font-weight:bold;">3</span>
                    </label>
                </p>
                <select name="" id="comb3" style="width: 15%; display:inline-block; margin-left: 2%;" class="browser-default">
                    <option value="">Combinación 1</option>
                    <option value="">Combinación 2</option>
                    <option value="">Combinación 3</option>
                </select>
                <div class="autocomplete" style="display: inline-block;">
                <input type="text" id="f3-in1" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                <input type="text" id="f3-in2" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                <input type="text" id="f3-in3" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                <input type="text" id="f3-in4" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                <input type="text" id="f3-in5" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                </div>

                <p style="margin-top: -15px; display:inline-block; width: 5%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000; font-size:x-large; font-weight:bold;">4</span>
                    </label>
                </p>
                <select name="" id="comb4" style="width: 15%; display:inline-block; margin-left: 2%;" class="browser-default">
                    <option value="">Combinación 1</option>
                    <option value="">Combinación 2</option>
                    <option value="">Combinación 3</option>
                </select>
                <div class="autocomplete" style="display: inline-block;">
                <input type="text" id="f4-in1" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                <input type="text" id="f4-in2" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                <input type="text" id="f4-in3" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                <input type="text" id="f4-in4" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                <input type="text" id="f4-in5" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                </div>

                <p style="margin-top: -15px; display:inline-block; width: 5%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000; font-size:x-large; font-weight:bold;">5</span>
                    </label>
                </p>
                <select name="" id="comb5" style="width: 15%; display:inline-block; margin-left: 2%;" class="browser-default">
                    <option value="">Combinación 1</option>
                    <option value="">Combinación 2</option>
                    <option value="">Combinación 3</option>
                </select>
                <div class="autocomplete" style="display: inline-block;">
                <input type="text" id="f5-in1" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                <input type="text" id="f5-in2" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                <input type="text" id="f5-in3" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                <input type="text" id="f5-in4" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                <input type="text" id="f5-in5" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                </div>

                <p style="margin-top: -15px; display:inline-block; width: 5%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000; font-size:x-large; font-weight:bold;">6</span>
                    </label>
                </p>
                <select name="" id="comb6" style="width: 15%; display:inline-block; margin-left: 2%;" class="browser-default">
                    <option value="">Combinación 1</option>
                    <option value="">Combinación 2</option>
                    <option value="">Combinación 3</option>
                </select>
                <div class="autocomplete" style="display: inline-block;">
                <input type="text" id="f6-in1" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                <input type="text" id="f6-in2" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                <input type="text" id="f6-in3" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                <input type="text" id="f6-in4" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                <input type="text" id="f6-in5" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                </div>

                <p style="margin-top: -15px; display:inline-block; width: 5%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000; font-size:x-large; font-weight:bold;">7</span>
                    </label>
                </p>
                <select name="" id="comb7" style="width: 15%; display:inline-block; margin-left: 2%;" class="browser-default">
                    <option value="">Combinación 1</option>
                    <option value="">Combinación 2</option>
                    <option value="">Combinación 3</option>
                </select>
                <div class="autocomplete" style="display: inline-block;">
                <input type="text" id="f7-in1" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                <input type="text" id="f7-in2" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                <input type="text" id="f7-in3" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                <input type="text" id="f7-in4" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                <input type="text" id="f7-in5" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                </div>

                <p style="margin-top: -15px; display:inline-block; width: 5%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000; font-size:x-large; font-weight:bold;">8</span>
                    </label>
                </p>
                <select name="" id="comb8" style="width: 15%; display:inline-block; margin-left: 2%;" class="browser-default">
                    <option value="">Combinación 1</option>
                    <option value="">Combinación 2</option>
                    <option value="">Combinación 3</option>
                </select>
                <div class="autocomplete" style="display: inline-block;">
                <input type="text" id="f8-in1" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                <input type="text" id="f8-in2" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                <input type="text" id="f8-in3" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                <input type="text" id="f8-in4" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                <input type="text" id="f8-in5" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                </div>

                <p style="margin-top: -15px; display:inline-block; width: 5%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000; font-size:x-large; font-weight:bold;">9</span>
                    </label>
                </p>
                <select name="" id="comb9" style="width: 15%; display:inline-block; margin-left: 2%;" class="browser-default">
                    <option value="">Combinación 1</option>
                    <option value="">Combinación 2</option>
                    <option value="">Combinación 3</option>
                </select>
                <div class="autocomplete" style="display: inline-block;">
                <input type="text" id="f9-in1" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                <input type="text" id="f9-in2" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                <input type="text" id="f9-in3" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                <input type="text" id="f9-in4" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                <input type="text" id="f9-in5" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                </div>

                <p style="margin-top: -15px; display:inline-block; width: 5%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000; font-size:x-large; font-weight:bold;">10</span>
                    </label>
                </p>
                <select name="" id="comb10" style="width: 15%; display:inline-block; margin-left: 2%;" class="browser-default">
                    <option value="">Combinación 1</option>
                    <option value="">Combinación 2</option>
                    <option value="">Combinación 3</option>
                </select>
                <div class="autocomplete" style="display: inline-block;">
                <input type="text" id="f10-in1" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                <input type="text" id="f10-in2" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                <input type="text" id="f10-in3" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                <input type="text" id="f10-in4" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                <input type="text" id="f10-in5" name="frasco2[]" class="browser-default" placeholder="--" style="width: 12%; margin-left: 1%;">
                </div>


            </form>
        </div>
        <div style="width: 36%; display: inline-block;">
        
            <form action="" method="post">
                <p style="display:inline-block; width: 40%; font-weight:bold;">MEDICAMENTOS ORALES</p>
                <input type="submit" value="Guardar Medicamentos Orales" style="display:inline-block; width: 35%;" class="btn-small">

                <p style="margin-top: -5px; display:inline-block; width: 25%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000;">ACEITE DE OZONO</span>
                    </label>
                </p>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 60%; margin-left: 2%;">

                <p style="margin-top: -15px; display:inline-block; width: 30%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000;">AMINOCEL</span>
                    </label>
                </p>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 55%; margin-left: 2%;">

                <p style="margin-top: -15px; display:inline-block; width: 25%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000;">BIOXEN</span>
                    </label>
                </p>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 60%; margin-left: 2%;">

                <p style="margin-top: -15px; display:inline-block; width: 25%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000;">BIOXEN SPRAY</span>
                    </label>
                </p>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 60%; margin-left: 2%;">

                <p style="margin-top: -15px; display:inline-block; width: 30%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000;">CELULAG</span>
                    </label>
                </p>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 55%; margin-left: 2%;">

                <p style="margin-top: -15px; display:inline-block; width: 25%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000;">CIABELAG</span>
                    </label>
                </p>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 60%; margin-left: 2%;">

                <p style="margin-top: -15px; display:inline-block; width: 25%;">
                    <label>
                        <input type="checkbox" />
                        <span style="color: #000;">DELGACEL</span>
                    </label>
                </p>
                <input type="text" class="browser-default" placeholder="Indicaciones" style="width: 60%; margin-left: 2%;">
        </div>
    </div>

    <?php echo $footer_recep;  ?>

    <script>
function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
          b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}

/*An array containing all the country names in the world:*/

var med_home = [
   <?php 
      while($med = mysqli_fetch_assoc($res)){
         echo '"'.$med['descrip_med_hom'].'",';
      }
      ?>
];

/*initiate the autocomplete function on the "myInput" element, and pass along the med_home array as possible autocomplete values:*/
autocomplete(document.getElementById("f1-in1"), med_home);
autocomplete(document.getElementById("f1-in2"), med_home);
autocomplete(document.getElementById("f1-in3"), med_home);
autocomplete(document.getElementById("f1-in4"), med_home);
autocomplete(document.getElementById("f1-in5"), med_home);

autocomplete(document.getElementById("f2-in1"), med_home);
autocomplete(document.getElementById("f2-in2"), med_home);
autocomplete(document.getElementById("f2-in3"), med_home);
autocomplete(document.getElementById("f2-in4"), med_home);
autocomplete(document.getElementById("f2-in5"), med_home);
</script>
</body>

</html>