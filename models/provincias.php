<?php 
  require_once('../controllers/controller.php');
  require_once('../config/db.php');
 
  $IdDepartamento = $_POST['IdDepartamento'];
  
  echo $_POST['IdDepartamentos'];
  //SELECT * FROM `provincias` WHERE idDepartamento = 15 ORDER BY Provincia ASC
  $sql_p = "SELECT * FROM provincias where IdDepartamento = '$IdDepartamento' ORDER BY Provincia ASC";
  $resultadopro = mysqli_query($db, $sql_p);    
  
   $html = "<option value='0'>Seleccionar Provincia</option>";
  while($rowp = mysqli_fetch_assoc($resultadopro)){
    $html .= "<option value='".$rowp['IdProvincia']."'>".$rowp['Provincia']."</option>";
    //$html = "<option value=''>".$rowP['Provincia']."</option>";
  }
  echo $html;

?>