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

$sql_pacientes = "SELECT id_paciente, nombres, a_paterno, a_materno, fecha_nacimiento, muni_alcaldia FROM paciente ORDER BY fecha_captura LIMIT 50";
    $result_sql_pacientes = $mysqli -> query($sql_pacientes);
    $registros = $result_sql_pacientes -> num_rows;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
    <title>Pacientes</title>
    <link rel="stylesheet" href="../css/materialize.css">
    <link rel="stylesheet" href="../icons/iconfont/material-icons.css">
    <script src="../js/materialize.js"></script>
    <script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
</head>
<body>
<?php echo $nav_recep;  ?>

<div class="container">
<div class="row center-align">
    <div class="col s8">
        <h4 style="color: #2d83a0; font-weight:bold;">PACIENTES</h4>
    </div>
        <div class="col s4">
        <div class="row">
        <div class="input-field col s12">
          <i class="material-icons prefix">search</i>
          <input id="icon_prefix" type="text" class="validate">
          <label for="icon_prefix">Buscar pacientes</label>
          </div>
        </div>
        </div>
        <div class="divider"></div>
    </div>

    <div class="row">
    <div class="col s12">
    <table>
        <thead>
          <tr>
              <th>Nombre Completo</th>
              <th>Fecha de Nacimiento</th>
              <th>Alcaldía o Municipio</th>
              <th>Historia Clínica</th>
              <th>Detalle</th>
          </tr>
        </thead>

        <tbody>
        <?php 
        if($registros > 0){ 
            while($rows = $result_sql_pacientes->fetch_assoc()){ 
                $id_paciente = $rows['id_paciente'];
                $nombre_com = $rows['nombres']." ".$rows['a_paterno']." ".$rows['a_materno'];
                $fecha_nac = $rows['fecha_nacimiento'];
                $municipio = $rows['muni_alcaldia'];

                $sql_hcg = "SELECT * FROM his_clinica_gen where id_paciente = '$id_paciente'";
                $result_sql_his = $mysqli -> query($sql_hcg);
                $hcg = $result_sql_his -> num_rows;

                if($hcg == 1){
                    $his = '<a href="">Ver historia clinica</a>';
                }elseif($hcg == 0){
                    $his = '<a href="captura_hcg.php?id_paciente='.$id_paciente.'">Capturar historia clinica</a>';
                }elseif($hcg > 1){
                    $his = '<a href="">Contacte con el Administrador del Sistema</a>';
                }
                ?>
                 <tr>
                    <td><?php echo $nombre_com ?></td>
                    <td><?php echo date("d/m/Y", strtotime($fecha_nac)); ?></td>
                    <td><?php echo $municipio ?></td>
                    <td><?php echo $his ?></td>
                    <td><a href="detalle_paciente.php?id_paciente=<?php echo $id_paciente ?>" class="btn">Detalle Paciente</a></td>
                </tr>
        <?php }
        }else{
            echo "<h3>No hay registrado ningún paciente o existe un error <br>
                        Contacte al Administrador del Sistema</h3>";
        }
        ?>
          
        </tbody>
      </table>
    </div>
    </div>

</div>  <!-- CIERRE DE CONTAINER PRINCIPAL -->
<?php echo $footer_recep;  ?>
</body>
</html>