<?php
require('conn.php');	
if(!empty($_POST))
{
  $usuario = mysqli_real_escape_string($mysqli,$_POST['user']);
  $password = mysqli_real_escape_string($mysqli,$_POST['password']);
  $error = '';

  $sql = "SELECT CONCAT(user.nombre,' ',user.apellido) nombre_completo, user.usuario, user.password, user.id,
        niveles.descripcion, niveles.ruta, niveles.id nivel_id, user.agenda
        FROM user INNER JOIN niveles ON user.nivel = niveles.nivel 
        WHERE user.usuario = '$usuario' and user.password = '$password'";

  $result=$mysqli->query($sql);
  $rows = $result -> num_rows;
  
  if($rows == 1 ) {
    $row = $result->fetch_assoc();
        // Evalua si tiene password generico y lo envía a la página de actualización de password
      if($row['password'] == '12345678'){
      $user =  $row['id'];
      $nombre = $row['nombre_completo'];
      echo '<script type="text/javascript">window.location.href="update_password.php?usuario=',$user,'&nombre=',$nombre,'"</script>';
      }else{
            session_start();
            $_SESSION['id'] = $row['id'];
            $_SESSION['name_usuario'] = $row['nombre_completo'];
            $_SESSION['nivel'] = $row['nivel_id'];
            $_SESSION['agenda'] = $row['agenda'];
            $ruta = $row['ruta'];
            echo "La ruta es", $ruta;
            header('Location: '.$ruta.'');
          }
    
    } else {
    $error = 1;
    echo $error;
    header("Location:../../index.php?error=$error");
    exit();
  }
}else{
    $error = 2;
    header("Location:../../index.php?error=$error");
    exit();
}