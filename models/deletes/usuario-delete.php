<?php 

require_once('../../config/db.php');

$id = $_POST['id'];

$sql = "DELETE FROM usuarios WHERE id = $id";
$resultado = mysqli_query($db, $sql);

if($resultado){
	echo json_encode(array('error' => false));
}else{
	echo json_encode(array('error' => true));
}
?>
			