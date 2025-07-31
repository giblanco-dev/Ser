<?php 
//echo $pago = $_GET['r'],'<br>';
//echo $carpeta = $_GET['d'];

$pago = $_GET['r'];
$ruta = 'ETIQUETAS.TXT';

//include '../../app/logic/conn.php';



$sql_ficha = "SELECT * FROM bitacora_fichas WHERE no_ref = '$pago'";
$result = $mysqli -> query($sql_ficha);
$ficha = $result -> num_rows;
if($ficha == 1){
  while($row = mysqli_fetch_assoc($result)){
    $ref = '"'.$row['referencia'].'"'.chr(13);
    $nombre_completo = '"'.$row['nombre_alum'].'"'.chr(13);
    $concepto = '"'.$row['concepto'].'"'.chr(13);
    $cantidad = $row['cantidad'].chr(13);
    $nivel = '"'.$row['nivel'].'"'.chr(13);
  }
}else{
    //echo '<script type="text/javascript" async="async">alert("Algo salió mal contactar con Soporte Técnico");window.location.href="../cobranza.php"</script>';
}


$ar_ref = fopen($ruta, "wb") or die("Hay un problema con el archivo");

fwrite($ar_ref,chr(13));
fwrite($ar_ref,$ref);
fwrite($ar_ref,$nombre_completo);
fwrite($ar_ref,$concepto);
fwrite($ar_ref, $cantidad);
fwrite($ar_ref, $nivel);
fclose($ar_ref);



//echo $ruta;



header('Content-Description: File Transfer');
header('Content-Disposition: attachment; filename='.basename($ruta));
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($ruta));
header("Content-Type: text/plain");
readfile($ruta);

?>