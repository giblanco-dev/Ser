<?php
if($his_clin == 1){
    $menu_hist_clin = '<li><a href="busca_paciente.php"><i class="material-icons right">assignment</i>Captura de Historia Clínica</a></li>';
}else{
    $menu_hist_clin = '';
}

$nav_consulta = '
<header>
 <div class="navbar-fixed">
 <nav>
    <div class="nav-wrapper">
      <a href="#" class="responsive-img" class="brand-logo"><img src="../static/img/logo.png" style="max-height: 150px; margin-left: 20px;"></a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
      <li><a href="index.php"><i class="material-icons right">home</i>Inicio</a></li>
      <li><a href="all_citas_medico.php"><i class="material-icons right">av_timer</i>Todas mis Consultas</a></li>
      <li><a href="busca_paciente_recovery.php"><i class="material-icons right">people</i>Recovery</a></li>
      '.$menu_hist_clin.'
      <li><a href="../app/logic/logout.php"><i class="material-icons right">close</i>Cerrar Sistema</a></li>
      </ul>
    </div>
  </nav>
 </div>
 </header>
';

$footer_consulta = '
<style>
    html {
        height: 100%;
    }
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        margin: 0;
    }
    .page-content {
        flex: 1;
    }
    footer.page-footer {
        margin-top: auto;
    }
</style>
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

$footer_consulta_index = '
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