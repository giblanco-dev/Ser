<?php
include '../config.php';

// Numero de registros
$numero_de_registros = 10;

if(!isset($_POST['palabraClave'])){

	// Obtener registros
	$stmt = $db->prepare("SELECT * FROM med_homeopaticos ORDER BY descrip_med_hom LIMIT :limit");
	$stmt->bindValue(':limit', (int)$numero_de_registros, PDO::PARAM_INT);
	$stmt->execute();
	$medList = $stmt->fetchAll();

}else{

	$search = $_POST['palabraClave'];// Palabra a buscar
	// Obtener registros
	$stmt = $db->prepare("SELECT * FROM med_homeopaticos WHERE descrip_med_hom like :descrip_med_hom ORDER BY descrip_med_hom LIMIT :limit");
	$stmt->bindValue(':descrip_med_hom', '%'.$search.'%', PDO::PARAM_STR);
	$stmt->bindValue(':limit', (int)$numero_de_registros, PDO::PARAM_INT);
	$stmt->execute();
	$medList = $stmt->fetchAll();

}
	
$response = array();

// Leer la informacion
foreach($medList as $medicamento_home){
	$response[] = array(
		"id" => $medicamento_home['descrip_med_hom'],
		"text" => $medicamento_home['descrip_med_hom']
	);
}

echo json_encode($response);
exit();