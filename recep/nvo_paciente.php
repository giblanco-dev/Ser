<?php 
include_once 'recep_sections.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Paciente</title>
    <link rel="stylesheet" href="../css/materialize.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="../js/materialize.js"></script>
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
    <form class="col s12">
      <div class="row">
        <div class="input-field col s4">
          <input placeholder="Nombres" id="first_name" type="text" class="validate">
          <label for="first_name">Nombre(s)</label>
        </div>
        <div class="input-field col s4">
          <input id="last_name" type="text" class="validate">
          <label for="last_name">Apellido Paterno</label>
        </div>
        <div class="input-field col s4">
          <input id="last_name" type="text" class="validate">
          <label for="last_name">Apellido Materno</label>
        </div>
        
      </div>
      <div class="row">
      <div class="input-field col s3">
          <input id="last_name" type="date" class="validate">
          <label for="last_name">Fecha de Nacimiento</label>
        </div>
        <div class="input-field col s3">
    <select>
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
      <div class="input-field col s4">
          <input id="last_name" type="text" class="validate">
          <label for="last_name">Calle</label>
        </div>
        <div class="input-field col s2">
          <input id="last_name" type="text" class="validate">
          <label for="last_name">Número</label>
        </div>
        <div class="input-field col s4">
          <input id="last_name" type="text" class="validate">
          <label for="last_name">Colonia</label>
        </div>
        <div class="input-field col s2">
          <input id="last_name" type="text" class="validate">
          <label for="last_name">Código Postal</label>
        </div>
      </div>
      
      
      <div class="row">
      <div class="input-field col s4">
          <input id="last_name" type="text" class="validate">
          <label for="last_name">Alcaldía o Municipio</label>
        </div>
      <div class="input-field col s4">
    <select>
      <option value="" disabled selected>Estado</option>
      <option value="CDMX">Ciudad de México</option>
      <option value="Estado de México">Estado de México</option>
      <option value="Puebla">Puebla</option>
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
        <div class="input-field col s3">
          <i class="material-icons prefix">phone</i>
          <input id="icon_telephone" type="tel" class="validate">
          <label for="icon_telephone">Telefóno de Casa</label>
        </div>
        <div class="input-field col s3">
          <i class="material-icons prefix">phone</i>
          <input id="icon_telephone" type="tel" class="validate">
          <label for="icon_telephone">Telefóno Móvil</label>
        </div>
        <div class="input-field col s3">
          <i class="material-icons prefix">phone</i>
          <input id="icon_telephone" type="tel" class="validate">
          <label for="icon_telephone">Telefóno Oficina</label>
        </div>
        <div class="input-field col s3">
          <input id="last_name" type="number" class="validate">
          <label for="last_name">Extensión</label>
        </div>
      </div>
      <div class="row">
      
        
        <div class="input-field col s4">
          <i class="material-icons prefix">email</i>
          <input id="icon_telephone" type="email" class="validate">
          <label for="icon_telephone">Correo Electrónico</label>
        </div>
      </div>
      <div class="row">
      <div class="col s6">
          <blockquote><h5>Otros</h5></blockquote>
      </div>
      </div>
      <div class="row">
      <div class="input-field col s3">
          <input id="last_name" type="text" class="validate">
          <label for="last_name">Ocupación</label>
        </div>
        <div class="col s4">
            <p>
            En caso de qué el paciente sea un menor de edad o una persona con capacidades diferentes favor de proporcionar el nombre
            del titular a cargo
            </p>
        </div>
        <div class="input-field col s5">
          <input id="last_name" type="text" class="validate">
          <label for="last_name">Nombre del Titular</label>
        </div>
        
      </div>
      <div class="row center center-align">
          <div class="col s6">
              <div class="divider"></div>
              <br>
              <button class="btn waves-effect waves-light" type="submit" name="action">Guardar
                <i class="material-icons right">save</i>
            </button>
            <br>
          </div>
          <div class="col s6">
              <div class="divider"></div>
              <br>
              <button class="btn waves-effect waves-light" type="submit" name="action">Guardar y capturar nuevo paciente
                <i class="material-icons right">save</i>
            </button>
            <br>
          </div>
      </div>
    </form>
  </div>


</div>
<?php echo $footer_recep;  ?>
<script>
   $(document).ready(function(){
    $('select').formSelect();
  });
</script>
</body>
</html>