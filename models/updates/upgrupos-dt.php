<?php 

  if(isset($_POST)){
		require_once('../../config/db.php');
	
		if(!isset($_SESSION)){
			session_start();
		}

		$id = isset($_POST['id']) ? $_POST['id'] : false;		
    $fase = isset($_POST['fase']) ? $_POST['fase'] : false;	
    $fecinicio = isset($_POST['fecinicio']) ? $_POST['fecinicio'] : false;	
    $fecfin = isset($_POST['fecfin']) ? $_POST['fecfin'] : false;	
    $acceso = isset($_POST['acceso']) ? $_POST['acceso'] : false;
				
		$usuario = $_SESSION['sesion_aprenDigital']['nombre'].$_SESSION['sesion_aprenDigital']['ape_paterno'];

		$sql= "UPDATE grupos_detalle SET fase_id = '$fase', fec_inicio='$fecinicio', fec_fin='$fecfin', acceso_id='$acceso', fechamodificacion = NOW(), usuario = '$usuario' where id = $id";	
		
		$resultado = mysqli_query($db,$sql);	

		if($resultado){
			$_SESSION['completado'] = "El registro se modificó de forma exitosa";
			header("Location: ../../admin-grupos.php");
		} else{
			$_SESSION['fallo'] = "Error no se completo la carga; por favor volver a intentar";
			header("Location: ../../admin-grupos.php");
		}
	}
?>
			