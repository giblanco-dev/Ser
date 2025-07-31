<?php
include 'config.php';

// Numero de registros
$numero_de_registros = 10;

if(!isset($_POST['palabraClave'])){

	// Obtener registros
	$stmt = $db->prepare("SELECT * FROM busca_pacientes ORDER BY nom_paciente LIMIT :limit");
	$stmt->bindValue(':limit', (int)$numero_de_registros, PDO::PARAM_INT);
	$stmt->execute();
	$usersList = $stmt->fetchAll();

}else{

	$search = $_POST['palabraClave'];// Palabra a buscar
	// Obtener registros
	$stmt = $db->prepare("SELECT * FROM busca_pacientes WHERE nom_paciente like :nom_paciente ORDER BY nom_paciente LIMIT :limit");
	$stmt->bindValue(':nom_paciente', '%'.$search.'%', PDO::PARAM_STR);
	$stmt->bindValue(':limit', (int)$numero_de_registros, PDO::PARAM_INT);
	$stmt->execute();
	$usersList = $stmt->fetchAll();

}
	
$response = array();

// Leer la informacion
foreach($usersList as $user){
	$response[] = array(
		"id" => $user['id_paciente'],
		"text" => $user['nom_paciente']
	);
}

echo json_encode($response);
exit();