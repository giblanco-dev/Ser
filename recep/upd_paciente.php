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
include_once 'recep_sections.php';
$id_paciente = $_GET['idpac'];


$sql_paciente = "SELECT * FROM paciente WHERE id_paciente = '$id_paciente'";
$res_sql_paciente = $mysqli -> query($sql_paciente);
$paciente_val = $res_sql_paciente -> num_rows;

if($paciente_val == 1){
    $datos_paciente = $res_sql_paciente -> fetch_assoc();
}else {
    echo "Hay un error";
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Paciente <?php echo $id_paciente ?></title>
    <link rel="shortcut icon" href="../static/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../static/css/materialize.css">
    <link rel="stylesheet" href="../static/icons/iconfont/material-icons.css">
    <script type="text/javascript" src="../static/js/jquery-3.3.1.min.js"></script>
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
<header>
 <div class="navbar-fixed">
 <nav>
    <div class="nav-wrapper">
      <a href="#" class="responsive-img" class="brand-logo"><img src="../static/img/logo.png" style="max-height: 150px; margin-left: 20px;"></a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
      <li><a onclick="window.close();"><i class="material-icons right">close</i>Cerrar Actualización</a></li>
      </ul>
    </div>
  </nav>
 </div>
 </header>
<div class="container">
<div class="row center-align">
    <div class="col s12">
    <h5 style="color: #2d83a0; font-weight:bold;">Actualización del Paciente
        <span style="text-transform: capitalize;"><?php echo $datos_paciente['nombres']." ".$datos_paciente['a_paterno']; ?></span></h5>
                <div class="divider"></div>
    </div>
</div>
</div>
<div class="row">
<div class="col s4 offset-s1">
    <blockquote>Datos Generales</blockquote>
    <p style="text-transform: capitalize;">Nombre: <?php echo $datos_paciente['nombres']." ".$datos_paciente['a_paterno']." ".$datos_paciente['a_materno']; ?></p>
    <p>Fecha de Nacimiento: <?php echo $datos_paciente['fecha_nacimiento']; ?></p>
    <p>Género: <?php echo $datos_paciente['genero']; ?> </p>
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
<div class="col s7 table-responsive-2 ">
  <form action="act_paciente.php" method="post">
    <blockquote>Actualizar Información</blockquote>
    <div class="row">
        <div class=" col s4">
          <input style="text-transform: capitalize;" placeholder="Nombres" id="first_name" name="nombres" type="text" required value="<?php echo $datos_paciente['nombres'] ?>">
          <label for="first_name">Nombre(s)</label>
        </div>
        <div class=" col s4">
          <input style="text-transform: capitalize;" id="inputs_pac" type="text" name="a_paterno"  required value="<?php echo $datos_paciente['a_paterno'] ?>">
          <label for="inputs_pac">Apellido Paterno</label>
        </div>
        <div class=" col s3">
          <input style="text-transform: capitalize;" id="inputs_pac" type="text" name="a_materno"  name="a_materno" value="<?php echo $datos_paciente['a_materno'] ?>">
          <label for="inputs_pac">Apellido Materno</label>
        </div>
    </div>
    <div class="row">
    <div class=" col s3">
          <input id="inputs_pac" type="date" name="fecha_nacimiento" class="validate" value="<?php echo $datos_paciente['fecha_nacimiento']; ?>">
          <label for="inputs_pac">Fecha de Nacimiento</label>
        </div>
            <div class=" col s6">
        <select name="genero" required>
        <option value="<?php echo $datos_paciente['genero'] ?>" selected>Genero Capturado Anteriormente: <?php echo $datos_paciente['genero'] ?></option>
        <option value="Femenino">Femenino</option>
        <option value="Masculino">Masculino</option>
        </select>
        </div>
    </div>
    
    <div class="divider"></div>
    <p>Dirección</p>
    <div class="row">
    <div class=" col s3">
          <input id="inputs_pac" type="text" name="calle" class="validate" value="<?php echo $datos_paciente['calle'];?>">
          <label for="inputs_pac">Calle</label>
        </div>
        <div class=" col s2">
          <input id="inputs_pac" type="text" name="num_domicilio" class="validate" value="<?php echo $datos_paciente['num_domicilio']; ?>">
          <label for="inputs_pac">Número</label>
        </div>
        <div class=" col s3">
          <input id="inputs_pac" type="text" name="colonia" class="validate" value="<?php echo $datos_paciente['colonia']; ?>">
          <label for="inputs_pac">Colonia</label>
        </div>
        <div class=" col s2">
          <input id="inputs_pac" type="text" name="cod_postal" class="validate" maxlength="6" minlength="5" value="<?php echo $datos_paciente['cod_postal']; ?>">
          <label for="inputs_pac">Código Postal</label>
        </div>
    </div>
    <div class="row">
    <div class=" col s4">
          <input id="inputs_pac" type="text" name="muni_alcaldia" class="validate" value="<?php echo $datos_paciente['muni_alcaldia']; ?>">
          <label for="inputs_pac">Alcaldía o Municipio</label>
        </div>
        <div class=" col s6">
            <select name="estado">
            <option value="<?php echo $datos_paciente['estado']; ?>" selected >Estado Capturado Previemente: <?php echo $datos_paciente['estado']; ?></option>
            <option value="Aguascalientes">Aguascalientes</option>
            <option value="Baja California">Baja California</option>
            <option value="Baja California Sur">Baja California Sur</option>
            <option value="Campeche">Campeche</option>
            <option value="Coahuila">Coahuila</option>
            <option value="Colima">Colima</option>
            <option value="Chiapas">Chiapas</option>
            <option value="Chihuahua">Chihuahua</option>
            <option value="Ciudad de México">CDMX</option>
            <option value="Durango">Durango</option>
            <option value="Guanajuato">Guanajuato</option>
            <option value="Guerrero">Guerrero</option>
            <option value="Hidalgo">Hidalgo</option>
            <option value="Jalisco">Jalisco</option>
            <option value="México">México</option>
            <option value="Michoacán de Ocampo">Michoacán de Ocampo</option>
            <option value="Morelos">Morelos</option>
            <option value="Nayarit">Nayarit</option>
            <option value="Nuevo León">Nuevo León</option>
            <option value="Oaxaca">Oaxaca</option>
            <option value="Puebla">Puebla</option>
            <option value="Querétaro">Querétaro</option>
            <option value="Quintana Roo">Quintana Roo</option>
            <option value="San Luis Potosí">San Luis Potosí</option>
            <option value="Sinaloa">Sinaloa</option>
            <option value="Sonora">Sonora</option>
            <option value="Tabasco">Tabasco</option>
            <option value="Tamaulipas">Tamaulipas</option>
            <option value="Tlaxcala">Tlaxcala</option>
            <option value="Veracruz">Veracruz</option>
            <option value="Yucatán">Yucatán</option>
            <option value="Zacatecas">Zacatecas</option>

            </select>
            <label>Selecciona el estado</label>
        </div>
    </div>
    <div class="divider"></div>
    <p>Datos de Contacto</p>
    <div class="row">
    <div class=" col s3">
          <input id="icon_telephone" type="tel" name="tel_casa" class="validate" minlength="10" maxlength="10" value="<?php echo $datos_paciente['tel_casa']; ?>">
          <label for="icon_telephone"><i class="material-icons prefix">contact_phone</i>  Telefóno de Casa </label>
        </div>
        <div class=" col s3">
          <input id="icon_telephone" type="tel" name="tel_movil" class="validate" minlength="10" maxlength="10" required value="<?php echo $datos_paciente['tel_movil']; ?>">
          <label for="icon_telephone"><i class="material-icons prefix">phone_android</i>  Telefóno Móvil</label>
        </div>
        <div class=" col s3">
          <input id="icon_telephone" type="tel" name="tel_oficina" class="validate" minlength="10" value="<?php echo $datos_paciente['tel_oficina']; ?>">
          <label for="icon_telephone"><i class="material-icons prefix">contact_phone</i>  Telefóno Oficina</label>
        </div>
        <div class=" col s2">
          <input id="inputs_pac" type="number" name="ext_tel" class="validate" value="<?php echo $datos_paciente['ext_tel']; ?>">
          <label for="inputs_pac">Extensión</label>
        </div>
    </div>
    <div class="row">
    <div class=" col s4">
          <input id="icon_telephone" type="tel" name="tel_recados" class="validate" value="<?php echo $datos_paciente['tel_recados']; ?>">
          <label for="icon_telephone"><i class="material-icons prefix">contact_phone</i>  Telefóno de recados</label>
        </div>
        
        <div class=" col s5">
          <input id="icon_telephone" type="email" name="email" class="validate" value="<?php echo $datos_paciente['email']; ?>">
          <label for="icon_telephone"><i class="material-icons prefix">email</i>  Correo Electrónico</label>
        </div>
    </div>
    <div class="divider"></div>
    <p>Otros</p>
    <div class="row">
    <div class=" col s2">
          <input id="inputs_pac" type="text" name="ocupacion" class="validate" value="<?php echo $datos_paciente['ocupacion']; ?>">
          <label for="inputs_pac">Ocupación</label>
        </div>
        <div class="col s5">
            <p style="font-size: 10px;">
            En caso de qué el paciente sea un menor de edad o una persona con capacidades diferentes favor de proporcionar el nombre
            del titular a cargo
            </p>
        </div>
        <div class=" col s4">
          <input id="inputs_pac" type="text" name="nombre_titular" class="validate" value="<?php echo $datos_paciente['nombre_titular']; ?>">
          <label for="inputs_pac">Nombre del Titular</label>
        </div>
    </div>
    <input type="hidden" name="usuario_captura" value="<?php echo $id_user; ?>">
    <input type="hidden" name="id_paciente" value="<?php echo $id_paciente; ?>">
    <div class="row">
        <div class="col s12 center-align">
        <button class="btn waves-effect waves-light" type="submit" name="action">Actualizar Datos de Paciente
                <i class="material-icons right">save</i>
            </button>
        </div>
    </div>
    </form>
</div> <!-- ********* CIERRE COLUMNA DE FORMULARIO DE ACTUALIZACIÓN -->
</div> <!-- ********* CIERRE FILA PRINCIPAL -->
<div class="container">


</div>

<?php echo $footer_recep;  ?>
<script>
   $(document).ready(function(){
    $('select').formSelect();
    $('.modal').modal();
  });
</script>
</body>
</html>