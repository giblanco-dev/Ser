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
include_once '../app/logic/conn.php';

$id_paciente = $_GET['id_paciente'];

$sql_h_clin = "SELECT his_clinica_gen.*,
CONCAT(paciente.nombres,' ',paciente.a_paterno,' ',paciente.a_materno) Nombre_completo,
paciente.genero, paciente.fecha_nacimiento, paciente.id_paciente, paciente.fecha_captura,
paciente.url_firma, paciente.fecha_consetimiento,
CONCAT(user.nombre,' ',user.apellido) Medico
FROM his_clinica_gen
INNER JOIN paciente ON his_clinica_gen.id_paciente = paciente.id_paciente
INNER JOIN user ON his_clinica_gen.medico = user.usuario
where his_clinica_gen.id_paciente = '$id_paciente'";

$res_h_clin = $mysqli->query($sql_h_clin);
$val_his_clin = $res_h_clin->num_rows;

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../static/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../static/css/materialize.css">
    <title>Historia Clínica Paciente <?php echo $id_paciente; ?></title>
<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.4;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
                background: white;
            }
            
            @page {
                size: letter;
                margin: 0.75in;
            }
            
            .no-print {
                display: none !important;
            }
            
            .signature-image {
                max-height: 60px;
                min-height: 35px;
                border: none;
                padding: 0;
                background-color: transparent;
            }
        }

        .container {
            max-width: 8.5in;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
            border-bottom: 2px solid #2d83a0;
            padding-bottom: 10px;
        }

        .header-info {
            flex: 1;
            font-size: 10px;
            line-height: 1.3;
        }

        .header-clinic {
            flex: 1;
            text-align: center;
        }

        .header-clinic h3 {
            font-size: 12px;
            margin-bottom: 5px;
            color: #2d83a0;
        }

        .header-patient {
            flex: 1;
            font-size: 10px;
            line-height: 1.3;
        }

        .logo {
            width: 80px;
            height: 80px;
        }

        .title {
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            color: #2d83a0;
            margin: 15px 0 10px 0;
            page-break-after: avoid;
        }

        .section {
            margin-bottom: 10px;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 11px;
            font-weight: bold;
            background-color: #e8f4f8;
            padding: 5px 8px;
            margin-bottom: 5px;
            border-left: 3px solid #2d83a0;
        }

        .section-subtitle {
            font-size: 10px;
            font-weight: bold;
            margin-bottom: 3px;
            padding: 3px 5px;
            background-color: #f5f5f5;
            border-left: 2px solid #ccc;
        }

        .content-row {
            display: flex;
            margin-bottom: 5px;
            page-break-inside: avoid;
        }

        .content-label {
            width: 35%;
            font-weight: bold;
            padding-right: 10px;
            flex-shrink: 0;
        }

        .content-value {
            flex: 1;
            word-wrap: break-word;
        }

        .vital-signs {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 8px;
            margin-bottom: 5px;
        }

        .vital-item {
            page-break-inside: avoid;
        }

        .vital-label {
            font-weight: bold;
            font-size: 10px;
            background-color: #f5f5f5;
            padding: 3px 5px;
            margin-bottom: 2px;
        }

        .vital-value {
            font-size: 10px;
            padding: 2px 5px;
        }

        .exploration-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-bottom: 5px;
        }

        .exploration-item {
            page-break-inside: avoid;
        }

        .exploration-label {
            font-weight: bold;
            font-size: 10px;
            background-color: #f5f5f5;
            padding: 3px 5px;
            margin-bottom: 2px;
        }

        .exploration-value {
            font-size: 10px;
            padding: 2px 5px;
            line-height: 1.3;
        }

        .divider {
            border-top: 1px solid #ddd;
            margin: 8px 0;
            page-break-after: avoid;
        }

        .signature-section {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .signature-box {
            width: 45%;
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #000;
            margin-top: 15px;
            padding-top: 5px;
            font-size: 10px;
        }

        .signature-image {
            max-width: 100%;
            max-height: 80px;
            min-height: 40px;
            display: block;
            margin: 10px auto;
            object-fit: contain;
            border: 1px solid #ddd;
            padding: 5px;
            background-color: #fafafa;
            border-radius: 4px;
        }

        .no-data {
            background-color: #fff3cd;
            padding: 15px;
            border: 1px solid #ffc107;
            border-radius: 4px;
            text-align: center;
        }

        @media screen {
            .container {
                background: white;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
                margin: 20px auto;
            }
            
            .print-button {
                text-align: center;
                margin: 20px 0;
            }
            
            .print-button button {
                padding: 10px 20px;
                background-color: #2d83a0;
                color: white;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-size: 14px;
                margin: 0 5px;
            }
            
            .print-button button:hover {
                background-color: #1e5a7a;
            }
            
            .print-button .close-btn {
                background-color: #d32f2f;
            }
            
            .print-button .close-btn:hover {
                background-color: #b71c1c;
            }
        }
    </style>
</head>
<body>
<body>
    <div class="print-button no-print">
        <button onclick="window.print()">🖨️ Imprimir (Ctrl+P)</button>
        <button class="close-btn" onclick="window.close()">❌ Cerrar</button>
    </div>

    <?php 
    if($val_his_clin == 1){
        $row_h_c = mysqli_fetch_assoc($res_h_clin);
    ?>
    
    <div class="container">
        <!-- ENCABEZADO -->
        <div class="header">
            <div class="header-info">
                <strong>Clínica de Medicina Alternativa SER</strong><br>
                Elena 9, Colonia Nativitas<br>
                Del. Benito Juárez, Distrito Federal<br>
                (55) 5579-9896, 6365-8396
            </div>
            <div class="header-clinic">
                <h3>HISTORIA CLÍNICA</h3>
            </div>
            <div class="header-patient">
                <strong>Paciente:</strong> <?php echo $row_h_c['Nombre_completo']; ?><br>
                <strong>Fecha Nac.:</strong> <?php echo $row_h_c['fecha_nacimiento']; ?><br>
                <strong>Género:</strong> <?php echo $row_h_c['genero']; ?><br>
                <strong>Fecha Alta:</strong> <?php echo $row_h_c['fecha_captura']; ?>
            </div>
        </div>

        <!-- ANTECEDENTES -->
        <div class="title">ANTECEDENTES CLÍNICOS</div>

        <div class="section">
            <div class="section-title">Antecedentes Heredo Familiares</div>
            <div class="content-value"><?php echo $row_h_c['hcg2'] ?: 'No reportado'; ?></div>
        </div>

        <div class="section">
            <div class="section-title">Antecedentes Personales No Patológicos</div>
            <div class="content-value"><?php echo $row_h_c['hcg3'] ?: 'No reportado'; ?></div>
        </div>

        <div class="section">
            <div class="section-title">Antecedentes Personales Patológicos</div>
            <div class="content-value"><?php echo $row_h_c['hcg4'] ?: 'No reportado'; ?></div>
        </div>

        <div class="section">
            <div class="section-title">Antecedentes Gineco-Obstétricos</div>
            <div class="content-value"><?php echo $row_h_c['hcg5'] ?: 'No reportado'; ?></div>
        </div>

        <div class="section">
            <div class="section-title">Padecimiento Actual</div>
            <div class="content-value"><?php echo $row_h_c['hcg6'] ?: 'No reportado'; ?></div>
        </div>

        <div class="divider"></div>

        <!-- INTERROGATORIO POR APARATOS Y SISTEMAS -->
        <div class="title">INTERROGATORIO POR APARATOS Y SISTEMAS</div>

        <div class="exploration-grid">
            <div class="exploration-item">
                <div class="exploration-label">Respiratorio</div>
                <div class="exploration-value"><?php echo $row_h_c['hcg7'] ?: '—'; ?></div>
            </div>
            <div class="exploration-item">
                <div class="exploration-label">Gastrointestinal</div>
                <div class="exploration-value"><?php echo $row_h_c['hcg8'] ?: '—'; ?></div>
            </div>
            <div class="exploration-item">
                <div class="exploration-label">Genitourinario</div>
                <div class="exploration-value"><?php echo $row_h_c['hcg9'] ?: '—'; ?></div>
            </div>
            <div class="exploration-item">
                <div class="exploration-label">Hematopoyético y Linfático</div>
                <div class="exploration-value"><?php echo $row_h_c['hcg10'] ?: '—'; ?></div>
            </div>
            <div class="exploration-item">
                <div class="exploration-label">Endocrino</div>
                <div class="exploration-value"><?php echo $row_h_c['hcg11'] ?: '—'; ?></div>
            </div>
            <div class="exploration-item">
                <div class="exploration-label">Nervioso</div>
                <div class="exploration-value"><?php echo $row_h_c['hcg12'] ?: '—'; ?></div>
            </div>
            <div class="exploration-item">
                <div class="exploration-label">Músculos Esqueléticos</div>
                <div class="exploration-value"><?php echo $row_h_c['hcg13'] ?: '—'; ?></div>
            </div>
            <div class="exploration-item">
                <div class="exploration-label">Piel, Mucosa y Anexos</div>
                <div class="exploration-value"><?php echo $row_h_c['hcg14'] ?: '—'; ?></div>
            </div>
        </div>

        <div class="divider"></div>

        <!-- SIGNOS VITALES -->
        <div class="title">SIGNOS VITALES</div>

        <div class="vital-signs">
            <div class="vital-item">
                <div class="vital-label">T/A</div>
                <div class="vital-value"><?php echo $row_h_c['hcg15'] ?: '—'; ?> mm Hg</div>
            </div>
            <div class="vital-item">
                <div class="vital-label">Temperatura</div>
                <div class="vital-value"><?php echo $row_h_c['hcg16'] ?: '—'; ?> °C</div>
            </div>
            <div class="vital-item">
                <div class="vital-label">Frecuencia Cardíaca</div>
                <div class="vital-value"><?php echo $row_h_c['hcg17'] ?: '—'; ?> lpm</div>
            </div>
            <div class="vital-item">
                <div class="vital-label">Frecuencia Respiratoria</div>
                <div class="vital-value"><?php echo $row_h_c['hcg18'] ?: '—'; ?> rpm</div>
            </div>
            <div class="vital-item">
                <div class="vital-label">Peso</div>
                <div class="vital-value"><?php echo $row_h_c['hcg19'] ?: '—'; ?> Kg</div>
            </div>
            <div class="vital-item">
                <div class="vital-label">Talla</div>
                <div class="vital-value"><?php echo $row_h_c['hcg20'] ?: '—'; ?> m</div>
            </div>
        </div>

        <div class="divider"></div>

        <!-- EXPLORACIÓN FÍSICA -->
        <div class="title">EXPLORACIÓN FÍSICA</div>

        <div class="exploration-grid">
            <div class="exploration-item">
                <div class="exploration-label">Habitus Exterior</div>
                <div class="exploration-value"><?php echo $row_h_c['hcg21'] ?: '—'; ?></div>
            </div>
            <div class="exploration-item">
                <div class="exploration-label">Cabeza y Cuello</div>
                <div class="exploration-value"><?php echo $row_h_c['hcg22'] ?: '—'; ?></div>
            </div>
            <div class="exploration-item">
                <div class="exploration-label">Tórax</div>
                <div class="exploration-value"><?php echo $row_h_c['hcg23'] ?: '—'; ?></div>
            </div>
            <div class="exploration-item">
                <div class="exploration-label">Abdomen</div>
                <div class="exploration-value"><?php echo $row_h_c['hcg24'] ?: '—'; ?></div>
            </div>
            <div class="exploration-item">
                <div class="exploration-label">Genitales</div>
                <div class="exploration-value"><?php echo $row_h_c['hcg25'] ?: '—'; ?></div>
            </div>
            <div class="exploration-item">
                <div class="exploration-label">Extremidades</div>
                <div class="exploration-value"><?php echo $row_h_c['hcg26'] ?: '—'; ?></div>
            </div>
            <div class="exploration-item">
                <div class="exploration-label">Piel</div>
                <div class="exploration-value"><?php echo $row_h_c['hcg27'] ?: '—'; ?></div>
            </div>
        </div>

        <div class="divider"></div>

        <!-- RESULTADOS Y DIAGNÓSTICOS -->
        <div class="section">
            <div class="section-title">Resultados de Laboratorio, Gabinete y Otros</div>
            <div class="content-value"><?php echo $row_h_c['hcg28'] ?: 'No reportado'; ?></div>
        </div>

        <div class="section">
            <div class="section-title">Diagnósticos o Problemas Clínicos</div>
            <div class="content-value"><?php echo $row_h_c['hcg29'] ?: 'No reportado'; ?></div>
        </div>

        <div class="divider"></div>

        <!-- TERAPÉUTICA -->
        <div class="title">TRATAMIENTO FARMACOLÓGICO</div>

        <div class="section">
            <div class="section-title">Terapéutica Empleada y Resultados (Previos)</div>
            <div class="content-value"><?php echo $row_h_c['hcg30'] ?: 'No reportado'; ?></div>
        </div>

        <div class="section">
            <div class="section-title">Terapéutica Actual</div>
            <div class="content-value"><?php echo $row_h_c['hcg31'] ?: 'No reportado'; ?></div>
        </div>

        <div class="section">
            <div class="section-title">Pronósticos</div>
            <div class="content-value"><?php echo $row_h_c['hcg32'] ?: 'No reportado'; ?></div>
        </div>

        <div class="divider"></div>

        <!-- FIRMA DEL MÉDICO -->
        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-line">Médico Responsable<br/><small><?php echo $row_h_c['Medico'] ?? '____________________'; ?></small></div>
            </div>
            <div class="signature-box">
                <?php if(!empty($row_h_c['url_firma'])): ?>
                    <img src="http://localhost:8080/FirmaDocsSer/<?php echo htmlspecialchars($row_h_c['url_firma']); ?>" alt="Firma del paciente" class="signature-image">
                <?php else: ?>
                    <div style="height: 60px; margin: 10px auto; display: flex; align-items: center; justify-content: center; color: #ccc;">Sin firma registrada</div>
                <?php endif; ?>
                <div class="signature-line">Firma del Paciente</div>
                <div style="margin-top: 5px; font-size: 10px;"><small><?php echo $row_h_c['fecha_consetimiento'] ? date('d/m/Y', strtotime($row_h_c['fecha_consetimiento'])) : '—'; ?></small></div>
            </div>
        </div>

    </div>

    <?php 
    } else {
        echo '<div class="container"><div class="no-data"><h3>Error de Datos</h3><p>No se encontró historia clínica para el paciente ID: '.$id_paciente.'</p></div></div>';
    }
    ?>

</body>
</html>