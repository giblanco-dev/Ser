<?php 
$nav_caja = '
<header>
 <div class="navbar-fixed">
 <nav>
    <div class="nav-wrapper">
      <a href="#" class="responsive-img" class="brand-logo"><img src="../static/img/logo.png" style="max-height: 150px; margin-left: 20px;"></a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
      <li><a href="index.php"><i class="material-icons right">home</i>Inicio</a></li>
      <li><a href="vale_salida.php"><i class="material-icons right">money_off</i>Vale de Salida</a></li>
      <li><a href="corte_caja.php"><i class="material-icons right">account_balance_wallet</i>Corte de Caja</a></li>
      <li><a href="arqueo.php"><i class="material-icons right">account_balance</i>Arqueo</a></li>
      <li><a href="pacientes_caja.php"><i class="material-icons right">people</i>Pacientes</a></li>
      <li><a href="../app/logic/logout.php"><i class="material-icons right">close</i>Cerrar Sistema</a></li>
      </ul>
    </div>
  </nav>
 </div>
 </header>
';

$footer_caja = '
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