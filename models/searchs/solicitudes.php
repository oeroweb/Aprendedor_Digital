<?php

  require_once '../../config/db.php';
  $sql = "SELECT *, Year(fechasolicitud) as 'anno', Month(fechasolicitud) as 'mes', Day(fechasolicitud) as 'dia' FROM solicitudalumno";

  // SELECT *, concat(Day(fechasolicitud),"-", Month(fechasolicitud),"-", Year(fechasolicitud)) as 'fechaEditada' FROM solicitudalumno

  $result = mysqli_query($db, $sql);

  if(!$result){
    die("Error! Fallo de Comunicación");
  }else{
    while($data = mysqli_fetch_assoc($result)){
      $arreglo['data'][]= $data;
      
    }
    echo json_encode($arreglo);
  }
mysqli_free_result($result);
mysqli_close($db);

?>