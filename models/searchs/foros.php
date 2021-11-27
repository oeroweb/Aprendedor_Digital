<?php

  require_once '../../config/db.php';

  $busqueda = $_POST['buscar'];

  $sql = "SELECT *, p.fechacreacion as 'fechapublicacion' FROM publicacion p 
		INNER JOIN usuarios u 
		on p.usuario_id = u.id where fase_id = $fase_id AND p.estado_id = 1 p.publicacion LIKE '%$busqueda%'";
  
  $result = mysqli_query($db, $sql);

  if(!$result){
    die("No hay referencia de la busqueda");
  }else{
    while($data = mysqli_fetch_assoc($result)){
      $arreglo['data'][]= $data;
      
    }
    echo json_encode($arreglo);
  }
mysqli_free_result($result);
mysqli_close($db);

?>