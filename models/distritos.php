<?php 
  require_once('../controllers/controller.php');
  require_once('../config/db.php');
 
  $IdProvincia = $_POST['IdProvincia'];  
  echo $_POST['IdProvincia'];

  $sql_d = "SELECT * FROM distritos where IdProvincia = '$IdProvincia' ORDER BY Distrito ASC;";
  $resultadod = mysqli_query($db, $sql_d);  
  
  $html = "<option value='0'>Seleccionar Distrito</option>";
  while($rowd = mysqli_fetch_assoc($resultadod)){
  // while($rowP = $resultadopro->fetch_assoc()){
  $html .= "<option value='".$rowd['IdDistrito']."'>".$rowd['Distrito']."</option>";
    //$html = "<option value=''>".$rowP['Provincia']."</option>";
  }
  echo $html;

?>