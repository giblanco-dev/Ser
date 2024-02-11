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
    <title>Nuevo Paciente</title>
    <link rel="shortcut icon" href="../static/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../static/css/materialize.css">
    <link rel="stylesheet" href="../static/icons/iconfont/material-icons.css">
    <script type="text/javascript" src="../static/js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="../static/js/materialize.js"></script>
</head>
<body>
<?php echo $nav_recep;  ?>

<div class="container">
<div class="row center-align">
    <div class="col s12">
        <h4 style="color: #2d83a0; font-weight:bold;">CAPTURA DE PACIENTES</h4>
        <div class="divider"></div>
    </div>
</div>
<div class="row">
    <form action="save_paciente.php" method="POST" class="col s12" autocomplete="off">
      <div class="row">
        <div class=" col s3">
          <input style="text-transform: capitalize;" placeholder="Nombres" id="first_name" name="nombres" type="text" required autocomplete="off">
          <label for="first_name">Nombre(s)</label>
        </div>
        <div class=" col s2">
          <input style="text-transform: capitalize;" id="inputs_pac" type="text" name="a_paterno"  required>
          <label for="inputs_pac">Apellido Paterno</label>
        </div>
        <div class=" col s2">
          <input style="text-transform: capitalize;" id="inputs_pac" type="text" name="a_materno"  name="a_materno">
          <label for="inputs_pac">Apellido Materno</label>
        </div>
        <div class=" col s3">
          <input id="inputs_pac" type="date" name="fecha_nacimiento" class="validate">
          <label for="inputs_pac">Fecha de Nacimiento</label>
        </div>
        <div class=" col s2">
    <select name="genero" required>
      <option value="" disabled selected>Género</option>
      <option value="Femenino">Femenino</option>
      <option value="Masculino">Masculino</option>
    </select>
    <label>Selecciona el género</label>
  </div>
      </div>
      <div class="row">
      <div class="col s6">
          <blockquote><h5>Datos domicilio</h5></blockquote>
      </div>
      </div>
      <div class="row">
      <div class=" col s2">
          <input id="inputs_pac" type="text" name="calle" class="validate">
          <label for="inputs_pac">Calle</label>
        </div>
        <div class=" col s2">
          <input id="inputs_pac" type="text" name="num_domicilio" class="validate">
          <label for="inputs_pac">Número</label>
        </div>
        <div class=" col s2">
          <input id="inputs_pac" type="text" name="colonia" class="validate">
          <label for="inputs_pac">Colonia</label>
        </div>
        <div class=" col s2">
          <input id="inputs_pac" type="text" name="cod_postal" class="validate" maxlength="6" minlength="5">
          <label for="inputs_pac">Código Postal</label>
        </div>
      <div class=" col s2">
          <input id="inputs_pac" type="text" name="muni_alcaldia" class="validate">
          <label for="inputs_pac">Alcaldía o Municipio</label>
        </div>
      <div class=" col s2">
    <select name="estado">
      <option value="--">Estado</option>
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
      <div class="row">
      <div class="col s6">
          <blockquote><h5>Datos de Contacto</h5></blockquote>
      </div>
      </div>
      <div class="row">
        <div class=" col s2">
          
          <input id="icon_telephone" type="tel" name="tel_casa" class="validate" minlength="10" maxlength="10">
          <label for="icon_telephone"><i class="material-icons prefix">contact_phone</i>  Telefóno de Casa </label>
        </div>
        <div class=" col s2">
          <input id="icon_telephone" type="tel" name="tel_movil" class="validate" minlength="10" maxlength="10">
          <label for="icon_telephone"><i class="material-icons prefix">phone_android</i>  Telefóno Móvil</label>
        </div>
        <div class=" col s2">
          <input id="icon_telephone" type="tel" name="tel_oficina" class="validate" minlength="10">
          <label for="icon_telephone"><i class="material-icons prefix">contact_phone</i>  Telefóno Oficina</label>
        </div>
        <div class=" col s2">
          <input id="inputs_pac" type="number" name="ext_tel" class="validate">
          <label for="inputs_pac">Extensión</label>
        </div>
      
      <div class=" col s2">
          <input id="icon_telephone" type="tel" name="tel_recados" class="validate">
          <label for="icon_telephone"><i class="material-icons prefix">contact_phone</i>  Telefóno de recados</label>
        </div>
        
        <div class=" col s2">
          <input id="icon_telephone" type="email" name="email" class="validate">
          <label for="icon_telephone"><i class="material-icons prefix">email</i>  Correo Electrónico</label>
        </div>
      </div>
      <div class="row">
      <div class="col s6">
          <blockquote><h5>Otros</h5></blockquote>
      </div>
      </div>
      <div class="row">
      <div class=" col s2">
          <input id="inputs_pac" type="text" name="ocupacion" class="validate">
          <label for="inputs_pac">Ocupación</label>
        </div>
        <div class="col s3">
            <p>
            En caso de qué el paciente sea un menor de edad o una persona con capacidades diferentes favor de proporcionar el nombre
            del titular a cargo
            </p>
        </div>
        <div class=" col s4">
          <input id="inputs_pac" type="text" name="nombre_titular" class="validate">
          <label for="inputs_pac">Nombre del Titular</label>
        </div>
      
        <div class=" col s3">
          <input id="inputs_pac" type="date" name="fecha_alta" class="validate" value="<?php echo date("Y-m-d"); ?>">
          <label for="inputs_pac">Fecha de original de Alta</label>
        </div>
        </div>
      <div class="row center center-align">
          <div class="col s4 offset-s4">
              <div class="divider"></div>
              <br>
              <button class="btn waves-effect waves-light" type="submit" name="action">Guardar
                <i class="material-icons right">save</i>
            </button>
            <br>
          </div>
      </div>
      <input type="hidden" name='usuario_captura' value="<?php echo $id_user; ?>">
    </form>
  </div>

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