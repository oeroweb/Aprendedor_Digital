<?php 

  if(isset($_GET)){
    
    if(!isset($_SESSION)){
      session_start();
    }
    require_once	'../../config/db.php';	
  
    $id = $_POST['idEstado']; 
   
    $sql = "UPDATE solicitudalumno set estado_id = 5, otros = 'Leido' WHERE id = $id";
    $resultado = mysqli_query($db, $sql);
    
    if($resultado){
			echo json_encode(array('error' => false));
		}else{
			echo json_encode(array('error' => true));
		}
  }
?>
