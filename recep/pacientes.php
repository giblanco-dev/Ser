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
include_once '../app/logic/conn.php';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../static/img/favicon.png" type="image/x-icon">
    <title>Pacientes</title>
    <link rel="stylesheet" href="../static/css/materialize.css">
    <link rel="stylesheet" href="../static/icons/iconfont/material-icons.css">
    <link rel="stylesheet" type="text/css" href="../static/css/select2.min.css">
    <script type="text/javascript" src="../static/js/jquery-3.3.1.min.js"></script>
    <script src="../static/js/select2.min.js"></script>
    <script src="../static/js/materialize.js"></script>
    <style type="text/css"> 
        thead tr th { 
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: #ffffff;
        }
    
        .table-responsive-2 { 
            height: 500px; /* Mover a 400 para demostrar el scroll*/
            overflow-y:scroll;
        }
    </style>
</head>
<body>
<?php echo $nav_recep;  ?>

<div class="container">
<div class="row center-align">
    <div class="col s6">
        <h4 style="color: #2d83a0; font-weight:bold;">BÚSQUEDA DE PACIENTES</h4>
    </div>
    <div class="col s6">
        <div class="row">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <div class="col s8" style="margin-top: 20px;">
                <select id='buscador' style='width: 300px;' name="paciente">
                <option value='0'> Buscar paciente </option>
                </select>
                </div>
                <div class="col s4" style="margin-top: 15px;">
                <button class="btn waves-effect waves-light" type="submit" name="action" style="margin-top: 5%;">Cargar
                    <i class="material-icons right">search</i>
                </button>
                </div>
            </form>
        </div>
    </div>
        <div class="divider"></div>
    </div>
    
    <div class="row">
    <div class="col s12">
        <?php

        if(!empty($_POST))
        {
           $id_paciente = $_POST['paciente'];

           $sql_paciente = "SELECT * FROM paciente WHERE id_paciente = '$id_paciente'";
            $res_sql_paciente = $mysqli -> query($sql_paciente);
            $paciente_val = $res_sql_paciente -> num_rows;

            if($paciente_val == 1){
                $datos_paciente = $res_sql_paciente -> fetch_assoc();
            }else {
                echo "Hay un error";
            }

            $sql_citas = "SELECT cita.id_cita, cita.id_paciente, CONCAT(user.nombre,' ',user.apellido) medico_cita, cita.fecha, cita.tipo, tipos_cita.descrip_cita 
            FROM cita INNER JOIN tipos_cita on cita.tipo = tipos_cita.id_tipo_cita 
            LEFT JOIN user on cita.medico = user.id WHERE id_paciente = '$id_paciente' and pagado = 1 ORDER BY cita.fecha DESC";
            $result_sql_citas = $mysqli->query($sql_citas);

            $sql_hcg = "SELECT * FROM his_clinica_gen where id_paciente = '$id_paciente'";
                $result_sql_his = $mysqli -> query($sql_hcg);
                $hcg = $result_sql_his -> num_rows;

            ?>
            <div class="row">
                <div class="col s6">
                    <blockquote>Datos Generales</blockquote>
                    <p style="text-transform: capitalize;">Nombre: <?php echo $nombre_pacientec = $datos_paciente['nombres']." ".$datos_paciente['a_paterno']." ".$datos_paciente['a_materno']; ?></p>
                    <p>Fecha de Nacimiento: <?php echo $datos_paciente['fecha_nacimiento']; ?></p>
                    <p>Género: <?php echo $datos_paciente['genero']; ?> </p>
                    <p>ID Interno Paciente: <?php echo $id_paciente; ?> </p>
                    
                    <blockquote>
                        Historia Clínica
                    </blockquote>
                    <?php 
                    if($hcg == 1){
                        echo '<a href="print_h_clinica.php?id_paciente='.$id_paciente.'" target="blank">Ver historia clinica</a><br>';
                        echo '<a href="captura_hcg.php?id_paciente='.$id_paciente.'" target="_blank">Actualizar historia clinica</a>';
                    }elseif($hcg == 0){
                        echo '<p style="color: red; font-size: 20px;"><b>Sin Historia Clínica</b></p>
                                <a href="captura_hcg.php?id_paciente='.$id_paciente.'&ori=8" target="blank" class="btn">Capturar historia clinica</a>';
                    }elseif($hcg > 1){
                        echo '<a href="">Contacte con el Administrador del Sistema</a>';
                    }
                    ?>

                    <blockquote>Domicilio</blockquote>
                    <p style="text-transform: capitalize;">Calle <?php echo $datos_paciente['calle']; ?>
                    No. <?php echo $datos_paciente['num_domicilio']; ?>
                    Colonia <?php echo $datos_paciente['colonia']; ?>
                    CP. <?php echo $datos_paciente['cod_postal']; ?>, <?php echo $datos_paciente['muni_alcaldia']; ?>.
                    <?php echo $datos_paciente['estado']; ?>
                    </p>
                    <blockquote>Contacto</blockquote>
                    <p>Telefóno de Casa: <?php echo $datos_paciente['tel_casa']; ?></p>
                    <p>Telefóno de Móvil: <?php echo $datos_paciente['tel_movil']; ?></p>
                    <p>Telefóno de Oficina: <?php echo $datos_paciente['tel_oficina']; ?> Ext: <?php echo $datos_paciente['ext_tel']; ?></p>
                    <p>Telefóno de Recados: <?php echo $datos_paciente['tel_recados']; ?></p>
                    <p>Correo electrónico: <?php echo $datos_paciente['email']; ?></p>
                    <blockquote>Otros</blockquote>
                    <p style="text-transform: capitalize;">Ocupación: <?php echo $datos_paciente['ocupacion']; ?></p>
                    <p style="text-transform: capitalize;">Titular: <?php echo $datos_paciente['nombre_titular']; ?></p>
                    
                </div>
                <div class="col s6">
                    <a href="upd_paciente.php?idpac=<?php echo $id_paciente; ?>" target="blank">Actualizar Información del Paciente</a><br>
                    <hr>
                    <a href="hoja_enfermeria.php?idp=<?php echo $id_paciente; ?>&nom_paciente=<?php echo $nombre_pacientec; ?>" target="blank">Ver/Imprimir Hoja Enfermería</a>
                    <hr><br>    
                    <blockquote>Citas Pagadas del Paciente</blockquote>
                    <div class="table-responsive-2">
                    <table>
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Médico</th>
                                <th></th>
                                <th>Detalle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php   while($citas_pac = mysqli_fetch_assoc($result_sql_citas)){ ?>
                                <tr>
                                    <td><?php echo date("d/m/Y", strtotime($citas_pac['fecha'])); ?></td>
                                    <td><?php echo $citas_pac['medico_cita'];   ?></td>
                                    <td><?php echo $citas_pac['descrip_cita']; ?></td>
                                    <td><a href="detalle_cita_recep.php?c=<?php echo $citas_pac['id_cita']; ?>&p=<?php echo $id_paciente; ?>" target="blank">Ver detalle</a></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    </div>
                </div>
                </div>

           

<?php
        }else{
            echo '<h5 style="height: 500px;">No ha seleccionado ningún paciente</h5>';
        }
        ?>
          
      
      </div>
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
  });
</script>
<script>
        $(document).ready(function(){
            $("#buscador").select2({
                ajax: {
                    url: "proceso.php",
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