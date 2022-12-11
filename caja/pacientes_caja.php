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
include_once 'caja_sections.php';
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
    <script>
        function abrir(url)
          { 
            open(url,'','top=0,left=100,width=650,height=500') ; 
          }
    </script>
</head>
<body>
<?php echo $nav_caja;  ?>

<div style="width: 90%; margin-left:auto; margin-right:auto;">
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

            $sql_citas = "SELECT cita.id_cita, cita.id_paciente, CONCAT(user.nombre,' ',user.apellido) medico_cita, user.iniciales,
                             cita.fecha, cita.tipo, tipos_cita.descrip_cita, caja.id_cobro,caja.abono, caja.total_cobro,
			                    caja.monto_devolucion, caja.motivo_devolucion 
                             FROM cita 
                             INNER JOIN tipos_cita on cita.tipo = tipos_cita.id_tipo_cita 
                             INNER JOIN caja ON cita.id_cita = caja.id_cita 
                             LEFT JOIN user on cita.medico = user.id 
                             WHERE id_paciente = '$id_paciente' and pagado = 1 ORDER BY cita.fecha DESC";
            $result_sql_citas = $mysqli->query($sql_citas);

            

            ?>
            <div class="row">
                <div class="col s4">
                    <blockquote>Datos Generales</blockquote>
                    <p style="text-transform: capitalize;">Nombre: <?php echo $nombre_pacientec = $datos_paciente['nombres']." ".$datos_paciente['a_paterno']." ".$datos_paciente['a_materno']; ?></p>
                    <p>Fecha de Nacimiento: <?php echo $datos_paciente['fecha_nacimiento']; ?></p>
                    <p>Género: <?php echo $datos_paciente['genero']; ?> </p>
                    <p>ID Interno Paciente: <?php echo $id_paciente; ?> </p>
                    

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
                <div class="col s8">
                    <blockquote>Citas Pagadas del Paciente</blockquote>
                    <div class="table-responsive-2">
                    <table>
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Médico</th>
                                <th>Tipo Cita</th>
                                <th>Pagado</th>
                                <th>Devolución</th>
                                <th>Motivo Devolución</th>
                                <th>Recibo</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php   while($citas_pac = mysqli_fetch_assoc($result_sql_citas)){ 
                                        $id_cobro = $citas_pac['id_cobro'];
                                    ?>
                                <tr>
                                    <td><?php echo date("d/m/Y", strtotime($citas_pac['fecha'])); ?></td>
                                    <td><?php echo $citas_pac['iniciales'];   ?></td>
                                    <td><?php echo $citas_pac['descrip_cita']; ?></td>
                                    <td>$ <?php echo $citas_pac['abono']; ?></td>
                                    <td>$ <?php echo $citas_pac['monto_devolucion']; ?></td>
                                    <td><?php echo $citas_pac['motivo_devolucion']; ?></td>
                                    <td><a href="javascript:abrir('recibo.php?r=<?php echo $id_cobro; ?>')">Comprobante</a></td>
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
    
<?php echo $footer_caja;  ?>

<script>
    $(document).ready(function(){
    $('.modal').modal();
  });
</script>
<script>
        $(document).ready(function(){
            $("#buscador").select2({
                ajax: {
                    url: "../recep/proceso.php",
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