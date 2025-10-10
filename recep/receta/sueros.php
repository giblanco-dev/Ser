<?php
include_once '../../app/logic/conn.php';
$cita = $_GET['c'];
$usuario = $_GET['u'];
$sql_sueros = "SELECT * FROM sueros";
$res_sueros = $mysqli->query($sql_sueros);

$sql_sueros_cargados = "SELECT rs.id_cita, s.nom_suero, rs.id_registro, s.precio
                            FROM rec_sueros rs 
                            JOIN sueros s ON rs.suero = s.id_suero 
                            WHERE rs.id_cita = '$cita' AND rs.cancelado = 0 order by rs.id_registro desc;";
$res_sueros_cargados = $mysqli->query($sql_sueros_cargados);






?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../static/css/materialize.css">
    <script src="../../static/js/jquery-3.3.1.min.js"></script>
    <script src="../../static/js/materialize.js"></script>
    <title>Sueros</title>
</head>
<body>
    <div class="container" style="width: 100%;">
            <div class="row">
                <div class="col s12">
                <h4 style="display: inline-block;">Sueros</h4>
            </div>
              <form action="save_sueros.php" method="POST">
                <div class="col s4">
                    <label for="suero">Seleccione el suero</label>
                    <select name="suero" id="suero" class="form-control" required>
                        <?php while($suero = $res_sueros->fetch_assoc()){ ?>
                            <option value="<?php echo $suero['id_suero']; ?>"><?php echo $suero['nom_suero']; ?></option>
                        <?php } ?>
                    </select>
                
                    <input type="hidden" name="id_cita" value="<?php echo $cita; ?>">
                    <input type="hidden" name="user" value="<?php echo $usuario; ?>">
                    </div>
                    <div class="col s3" style="margin-top: 3%; padding-left: 3%;">
                            <button type="submit" class="btn btn-primary" id="envio">Guardar Suero<i class="material-icons right">save</i></button>
                    </div>
                
                </form>
                </div>
                <div class="row">
                <div class="col s12">
                <h6>Sueros Cargados</h6>
                <table>
                    <thead>
                        <tr>
                            <th></th>
                            <th>Suero</th>
                            <th>Agregar Complemento</th>
                            <th>Complementos</th>
                            <th>Total</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total_sueros_complementos = 0;
                        while($suero_cargado = $res_sueros_cargados->fetch_assoc()){ 
                            $id_regsuero = $suero_cargado['id_registro'];
                            $nom_suero = $suero_cargado['nom_suero'];
                            $id_cita = $suero_cargado['id_cita'];

                            ?>
                                
                                    <tr>
                                        <td><a href="cancelaciones.php?c=<?php echo $id_cita; ?>&u=<?php echo $usuario; ?>&c_suero=<?php echo $id_regsuero; ?>" class="btn-small">Cancelar</a></td>
                                        <td><?php echo $nom_suero; ?></td>
                                        <td>
                                            <form action="save_complemento.php" method="post">
                                            <select style="font-size: 10px;;" name="id_comple" required>
                                                <?php
                                                
                                                $sql_complementos = "SELECT concat(nom_complemento,' (',precio,')') nom_complemento, id_comple FROM complementos;";
                                                $res_complementos = $mysqli->query($sql_complementos);
                                                while($complemento = $res_complementos->fetch_assoc()){ ?>
                                                <option value="<?php echo $complemento['id_comple']; ?>"><?php echo $complemento['nom_complemento']; ?></option>
                                            <?php } ?>
                                            </select>
                                            <input type="hidden" name="id_cita" value="<?php echo $cita; ?>">
                                            <input type="hidden" name="user" value="<?php echo $usuario; ?>">
                                            <input type="hidden" name="id_regsuero" value="<?php echo $id_regsuero; ?>">
                                            <button class="btn-small" type="submit" id="envio">Guardar Complemento</button>
                                            </form>
                                        </td>
                                        <td>
                                            <?php 
                                            $sql_complementos_cargados = "SELECT DISTINCT id_registro , id_complemento 
                                                                    , c.nom_complemento , id_regsuero , c.precio
                                                            FROM rec_complementos 
                                                            INNER join complementos c on id_complemento = c.id_comple 
                                                            WHERE id_cita = '$id_cita' and id_regsuero = '$id_regsuero';";
                                                            $res_complementos_cargados = $mysqli->query($sql_complementos_cargados);
                                            $total_complementos = 0;            
                                            while($complemento_cargado = $res_complementos_cargados->fetch_assoc()){
                                                $total_complementos += $complemento_cargado['precio'];    
                                                $id_comple = $complemento_cargado['id_registro'];
                                                $nom_comple = $complemento_cargado['nom_complemento'];
                                                echo $nom_comple."(".$complemento_cargado['precio'].") - <a href='cancelaciones.php?c=$id_cita&u=$usuario&c_comple=$id_comple''>Eliminar</a><br>"; 
                                                
                                                }

                                                
                                            ?>

                                        </td>
                                        <td>
                                            Complememtos: <?php echo "$ ".number_format($total_complementos, 2); ?><br>
                                            Suero: <?php echo "$ ".$suero_cargado['precio']; ?><br>
                                            Total: <?php echo "$ ". number_format(($total_complementos + $suero_cargado['precio']), 2); ?>
                                        </td>
                                    </tr>
                        <?php
                                    $total_sueros_complementos += $total_complementos + $suero_cargado['precio'];
                        }
                        ?>
                                    <tr class="blue-grey lighten-4">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td colspan="2"><b> Total todos los sueros y complementos: <?php echo "$ ".number_format($total_sueros_complementos, 2); ?></b></td>
                                    </tr>
                    </tbody>
                </table>
                            
            </div>
            </div>
            
        
        
    </div>

    <script>
   $(document).ready(function(){
    $('select').formSelect();
    $('.modal').modal();
  });
</script>
</body>
</html>