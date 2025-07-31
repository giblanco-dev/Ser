<?php
$nav_recep = '
<header>
 <div class="navbar-fixed">
 <nav>
    <div class="nav-wrapper">
      <a href="#" class="responsive-img" class="brand-logo"><img src="../static/img/logo.png" style="max-height: 150px; margin-left: 20px;"></a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
      <li><a href="index.php"><i class="material-icons right">home</i>Inicio</a></li>
      <li><a class="waves-effect waves-light modal-trigger" href="#modal1"><i class="material-icons right">assignment_turned_in</i>Nueva Cita</a></li>
      <li><a href="nvo_paciente.php"><i class="material-icons right">add_box</i>Nuevo Paciente</a></li>
      <li><a href="pacientes.php"><i class="material-icons right">people</i>Pacientes</a></li>
      <li><a href="all_citas.php"><i class="material-icons right">format_list_bulleted</i>Citas</a></li>
      <li><a href="agenda/" target="_blank"><i class="material-icons right">perm_contact_calendar</i>Agenda</a></li>
      <li><a href="../app/logic/logout.php"><i class="material-icons right">close</i>Cerrar Sistema</a></li>
      </ul>
    </div>
  </nav>
 </div>
 </header>
';

$footer_recep = '
<footer class="page-footer">
          <div class="container">
            <div class="row">
              <div class="col l6 s12 center-align">
                <h5 class="white-text">Usuario Activo <br>'.$usuario.'</h5>
              </div>
              <div class="col l4 offset-l2 s12">
                <h5 class="white-text">Contacto</h5>
              </div>
            </div>
          </div>
          <div class="footer-copyright">
            <div class="container">
            © 2020 Copyright
            </div>
          </div>
        </footer>
';
?>