<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: ../index.php');
    exit();
}elseif($_SESSION['nivel'] == 1 OR $_SESSION['nivel'] == 7){
            $id_user = $_SESSION['id'];
            $usuario = $_SESSION['name_usuario'];
            $nivel = $_SESSION['nivel'];
            $his_clin = $_SESSION['hist_clin_med'];
}else{
    header('Location: ../index.php');
    exit();
}
include_once 'recep_sections.php';
include_once '../app/logic/conn_recovery.php';


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../static/img/favicon.png" type="image/x-icon">
    <title>Buscar Paciente</title>
    <link rel="stylesheet" href="../static/css/materialize.css">
    <link rel="stylesheet" href="../static/icons/iconfont/material-icons.css">
    <script type="text/javascript" src="../static/js/jquery-3.3.1.min.js"></script>
    <script src="../static/js/materialize.js"></script>
    <style>
        .search-container {
            margin: 30px 0;
            margin-top: 4%;
        }
        .search-input-field {
            margin-bottom: 20px;
        }
        .results-container {
            margin-top: 30px;
        }
        .resultado-paciente {
            margin: 10px 0;
            padding: 15px;
            background-color: #f5f5f5;
            border-left: 4px solid #2d83a0;
            border-radius: 4px;
            transition: all 0.3s ease;
        }
        .resultado-paciente:hover {
            background-color: #e8f4f8;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .resultado-paciente .nombre-paciente {
            font-weight: bold;
            color: #2d83a0;
            font-size: 16px;
            margin-bottom: 10px;
        }
        .resultado-paciente .id-paciente {
            color: #999;
            font-size: 12px;
            margin-bottom: 12px;
            display: block;
        }
        .resultado-paciente .acciones {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .resultado-paciente .btn-accion {
            flex: 1;
            min-width: 140px;
            padding: 8px 12px;
            text-align: center;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            border: none;
            transition: all 0.3s ease;
            display: inline-block;
        }
        .btn-captura {
            background-color: #2d83a0;
            color: white;
        }
        .btn-captura:hover {
            background-color: #1e5a7a;
        }
        .btn-imprimir {
            background-color: #4CAF50;
            color: white;
        }
        .btn-imprimir:hover {
            background-color: #45a049;
        }
        .loading {
            text-align: center;
            color: #2d83a0;
            margin: 20px 0;
        }
        .no-resultados {
            text-align: center;
            color: #999;
            margin: 20px 0;
            padding: 20px;
        }
        .msg-aviso {
            padding: 15px;
            margin: 10px 0;
            border-radius: 4px;
        }
        .msg-info {
            background-color: #e3f2fd;
            color: #1976d2;
            border-left: 4px solid #1976d2;
        }
    </style>
</head>
<body>
<?php echo $nav_recep; ?>
<div class="container" style="margin-bottom: 5%;">
    <div class="row center-align">
        <div class="col s12">
            <h4 style="color: #2d83a0; font-weight:bold;">Buscar Paciente para encontrar sus datos recuperados</h4>
            <br>
            <p style="color: #666;">Escribe el nombre del paciente para iniciar la búsqueda</p>
        </div>
    </div>

    <div class="row search-container">
        <div class="col s12 m8 offset-m2 l6 offset-l3">
            <div class="search-input-field">
                <div class="input-field">
                    <i class="material-icons prefix">search</i>
                    <input id="buscar_paciente" type="text" class="validate" placeholder="Ingresa nombre del paciente...">
                    <label for="buscar_paciente">Nombre del Paciente</label>
                </div>
                <small style="color: #999;">Mínimo 3 caracteres para iniciar la búsqueda</small>
            </div>
        </div>
    </div>

    <div class="row results-container">
        <div class="col s12 m8 offset-m2 l6 offset-l3">
            <div id="resultados_busqueda"></div>
        </div>
    </div>

</div>  <!-- CIERRE DE CONTAINER PRINCIPAL -->

<!-- Modal Nueva Cita -->
<div id="modal1" class="modal modal-fixed-footer" style="height: 100%;">
      <div class="modal-content">
        <h4>Nueva Cita</h4>
        <iframe frameborder="0" allowFullScreen="true" src="cita.php" style="width: 100%; height: 100%;"></iframe>

      </div>
      <div class="modal-footer">
        <a href="#" class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
      </div>
    </div>
<?php echo $footer_recep;  ?>

<script>
    $(document).ready(function(){
        $('.modal').modal();

        // Búsqueda dinámica de pacientes
        var searchTimeout;
        
        $('#buscar_paciente').on('keyup', function(){
            clearTimeout(searchTimeout);
            var busqueda = $(this).val().trim();
            var resultadosDiv = $('#resultados_busqueda');

            // Validar que tenga al menos 3 caracteres
            if(busqueda.length < 3) {
                resultadosDiv.html('');
                return;
            }

            // Mostrar loading
            resultadosDiv.html('<div class="loading"><i class="material-icons" style="font-size: 48px;">hourglass_empty</i><p>Buscando pacientes...</p></div>');

            // Hacer la búsqueda con delay para no saturar
            searchTimeout = setTimeout(function(){
                $.ajax({
                    type: 'POST',
                    url: 'logic_recep/busca_pacientes_ajax.php',
                    data: {busqueda: busqueda},
                    dataType: 'json',
                    success: function(response){
                        if(response.success){
                            if(response.resultados.length > 0){
                                var html = '<p style="color: #999; margin-bottom: 15px;">Se encontraron <strong>' + response.resultados.length + '</strong> resultado(s):</p>';
                                $.each(response.resultados, function(index, paciente){
                                    html += '<div class="resultado-paciente">';
                                    html += '<div class="nombre-paciente">' + paciente.nom_paciente + '</div>';
                                    html += '<div class="id-paciente">ID: ' + paciente.id_paciente + '</div>';
                                    html += '<div class="acciones">';
                                    html += '<button class="btn-accion btn-captura" onclick="irADetalle(' + paciente.id_paciente + ')"><i class="material-icons" style="font-size: 14px; vertical-align: middle;">visibility</i> Ver detalle</button>';
                                    html += '</div>';
                                    html += '</div>';
                                });
                                resultadosDiv.html(html);
                            } else {
                                resultadosDiv.html('<div class="no-resultados"><i class="material-icons" style="font-size: 48px; color: #ccc;">person_outline</i><p>No se encontraron pacientes</p></div>');
                            }
                        } else {
                            resultadosDiv.html('<div class="msg-aviso msg-info">Error en la búsqueda: ' + response.mensaje + '</div>');
                        }
                    },
                    error: function(){
                        resultadosDiv.html('<div class="msg-aviso msg-info">Error al conectar con el servidor</div>');
                    }
                });
            }, 300); // Espera 300ms después de que deje de escribir
        });
    });

    // Función para ir al detalle del paciente con solo el parámetro id_paciente
    function irADetalle(idPaciente){
        window.open('detalle_paciente_recovery.php?id_paciente=' + idPaciente, '_blank');
    }
</script>
</body>
</html>