<?php



?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenidos</title>
    <link rel="stylesheet" href="css/materialize.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
    <script src="js/materialize.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
</head>
<body style="background-image: url('img/background_login.png'); background-size: cover;">
    <div class="container">
        <div class="row" style="margin-top: 1%;">
        <div class="col s12 center-align">
        <img src="img/banner_login.png" class="responsive-img z-depth-5">
        </div>
        </div>
        <div class="row" style="margin-top: 1%;">
        <div class="col s4 offset-s2 grey lighten-3 center-align">
        <div class="divider"></div>
        <h4>Iniciar Sesión</h4>
        <div class="row">
        <form class="col s12">
        <div class="row">
            <div class="input-field col s12">
            <i class="material-icons prefix">account_circle</i>
            <input id="icon_prefix" type="text" name="user" class="validate" required>
            <label for="icon_prefix">Usuario</label>
            </div>
            <div class="input-field col s12">
            <i class="material-icons prefix">vpn_key</i>
            <input id="password" type="password" class="validate" required>
            <label for="password">Password</label>
            </div>
            <div class="col s12">
                <button class="btn" style="background-color: #2d83a0;" type="submit" name="action">Acceder
                    <i class="material-icons right">send</i>
                </button>
            </div>
        </div>
        </form>
        </div>
        <blockquote>
            ¿Olvidaste tu contraseña? Ponte en contacto con el Administrador del Sistema
        </blockquote>
        <br>
        <p style="margin-bottom: 18px;" >© Copyright 2020</p>
    </div>
           
        <div style="margin-left: 2%;" class="col s4 grey lighten-3 center-align"> 
        <iframe src="https://www.zeitverschiebung.net/clock-widget-iframe-v2?language=es&size=large&timezone=America%2FMexico_City" width="100%" height="125" frameborder="0" seamless></iframe> 
        <h2 style="color: #424242;">00 <i class="medium material-icons">check_circle</i></h2>
        <p>Citas Confirmadas</p>
        <h2 style="color: #424242;">00 <i class="medium material-icons">book</i></h2>
        <p>Citas Agendadas</p>
        <br>
        </div>
        </div>
        
    </div>
    
</body>
</html>