<?php 

require_once('../../config/db.php');
if(!isset($_SESSION)){
	session_start();
}

$id = $_GET['id'];

$sql = "DELETE FROM grupos WHERE id = $id";
$resultado = mysqli_query($db, $sql);

if($resultado){
	$_SESSION['completado'] = "<i class='far fa-check-circle'></i> El registro se elimino de forma exitosa"; 
	header("Location: ../../admin-grupos.php");	
} else{
	$_SESSION['fallo'] = "<i class='far fa-times-circle'></i> Error al eliminar el registro; por favor volver a intentar";
	header("Location: ../../admin-grupos.php");	
}
?>