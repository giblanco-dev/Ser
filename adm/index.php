<?php 
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: ../index.php');
    exit();
}elseif($_SESSION['nivel'] == 7){
            $id_user = $_SESSION['id'];
            $usuario = $_SESSION['name_usuario'];
            $nivel = $_SESSION['nivel'];
}else{
    header('Location: ../index.php');
    exit();
}   
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración</title>
    <link rel="shortcut icon" href="../static/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../static/css/materialize.css">
    <link rel="stylesheet" href="../static/icons/iconfont/material-icons.css">
    <script type="text/javascript" src="../static/js/jquery-3.3.1.min.js"></script>
    <script src="../static/js/materialize.js"></script>
</head>
<body>
<header>
 <div class="navbar-fixed">
 <nav>
    <div class="nav-wrapper">
      <a href="#" class="responsive-img" class="brand-logo"><img src="../static/img/logo.png" style="max-height: 150px; margin-left: 20px;"></a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
      <li><a href="../app/logic/logout.php"><i class="material-icons right">close</i>Cerrar Sistema</a></li>
      </ul>
    </div>
  </nav>
 </div>
 </header>
<div class="row">
    <div class="col s3" style="margin-top: 6%;">
    <ul class="collection with-header">
        <li class="collection-header"><h4>Configuraciones</h4></li>
        <li class="collection-item"><div>Usuarios<a href="users.php" class="secondary-content"><i class="material-icons">person</i></a></div></li>
        <li class="collection-item"><div>Medicamentos<a href="#!" class="secondary-content"><i class="material-icons">local_hospital</i></a></div></li>
        <li class="collection-item"><div>Terapias<a href="#!" class="secondary-content"><i class="material-icons">airline_seat_flat</i></a></div></li>
        <li class="collection-item"><div>Sueros<a href="#!" class="secondary-content"><i class="material-icons">bubble_chart</i></a></div></li>
      </ul>
    </div>
    <div class="col s9">
        <h3 style="color: #2d83a0; font-weight:bold;">Modulos del sistema</h3>
        <div class="row">
            <div class="col s4">
                <div class="card cyan darken-4 hoverable center-align">
                <div class="card-content white-text">
                <span class="card-title">Recepción</span>
                <i class="medium material-icons">accessibility</i>
                </div>
                <div class="card-action">
                <a href="#" class="grey-text text-lighten-2">Ir al modulo de recepción</a>
                </div>
                </div>
            </div>
            <div class="col s4">
                <div class="card cyan darken-3 hoverable center-align">
                <div class="card-content white-text">
                <span class="card-title">Caja</span>
                <i class="medium material-icons">local_atm</i>
                </div>
                <div class="card-action">
                <a href="#" class="grey-text text-lighten-2">Ir al modulo de caja</a>
                </div>
                </div>
            </div>
            <div class="col s4">
                <div class="card cyan darken-2 hoverable center-align">
                <div class="card-content white-text">
                <span class="card-title">Terapias</span>
                <i class="medium material-icons">airline_seat_flat_angled</i>
                </div>
                <div class="card-action">
                <a href="#" class="grey-text text-lighten-2">Ir al modulo de terapias</a>
                </div>
                </div>
            </div>
            <div class="col s4">
                <div class="card cyan darken-1 hoverable center-align">
                <div class="card-content white-text">
                <span class="card-title">Farmacia</span>
                <i class="medium material-icons">local_pharmacy</i>
                </div>
                <div class="card-action">
                <a href="#" class="grey-text text-lighten-2">Ir al modulo de farmacia</a>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
 <footer class="page-footer">
          <div class="container">
            <div class="row">
              <div class="col l6 s12 center-align">
                <h5 class="white-text">Usuario Activo <br><?php echo $usuario; ?></h5>
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
</body>
</html>