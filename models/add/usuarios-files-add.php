<?php 
  session_start();
  require_once '../../config/db.php'; 

  $fileusuarios = $_FILES['filesUsuarios'];
  $fileusuarios = file_get_contents($fileusuarios['tmp_name']);

  // separa por salto de linea
  $fileusuarios = explode("\n", $fileusuarios);
  // eliminar campos vacios
  $fileusuarios = array_filter($fileusuarios);

  //preparar usuarios (convertir en array)
  foreach ($fileusuarios as $usuarios) {    
    $usuariosList[] = explode(";", $usuarios);
  }

  $clave = 'cambiame123';
  //insertar usuarios
  foreach ($usuariosList as $usuariosData) {    
    $password_segura = password_hash($clave, PASSWORD_BCRYPT,['cost' =>4]);
    $sql = "INSERT INTO usuarios 
    (perfil_id, institucion_id, nombre, ape_paterno, ape_materno, doc_identidad, email, clave, pais, nacionalidad, profesion, fechacreacion, estado_id) 
    VALUES 
    (4, '$usuariosData[0]', '".strtolower($usuariosData[1])."','".strtolower($usuariosData[2])."', '".strtolower($usuariosData[3])."', '{$usuariosData[4]}', '".strtolower($usuariosData[5])."', '{$password_segura}','".utf8_encode(strtolower($usuariosData[6]))."', '".strtolower($usuariosData[7])."', '{$usuariosData[8]}', CURDATE(), 1)";

    $resultado = mysqli_query($db, $sql); 
    //var_dump($sql); die();    
  }

  print_r($usuariosList);

  if(mysqli_affected_rows($db)>0){
    $_SESSION['completado'] = "<i class='far fa-check-circle'></i> El registro se completo de forma exitosa"; 							
  }else{
      $_SESSION['fallo'] = "<i class='far fa-times-circle'></i> No se completo la carga; por favor volver a intentar";					
  }

?>