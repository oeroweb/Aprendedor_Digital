<?php 

  require_once	('../../config/db.php');
  
  if(!isset($_SESSION)){
    session_start();
  }
        
 if(isset($_POST['usuariosycursos'])){
  $items1 = ($_POST['grupo_id']);
  $items2 = ($_POST['grupodetalle_id']);
  $items3 = ($_POST['grupodetallecurso_id']);		
  $items4 = ($_POST['usuario_id']);		
  $items5 = ($_POST['fase_id']);  
  $items6 = ($_POST['curso_id']);
  $items7 = $_SESSION['sesion_aprenDigital']['nombre'] .' '.$_SESSION['sesion_aprenDigital']['ape_paterno'];

  while(true){
    $item1 = current($items1);
    $item2 = current($items2);
    $item3 = current($items3);		
    $item4 = current($items4);		
    $item5 = current($items5); 
    $item6 = current($items6);

    $grupo  = (($item1 !== false) ? $item1 : '');
    $grupodetalle  = (($item2 !== false) ? $item2 : '');
    $grupodetallecurso  = (($item3 !== false) ? $item3 : '');
    $usuario_id  = (($item4 !== false) ? $item4 : '');
    $fase  = (($item5 !== false) ? $item5 : '');
    $curso  = (($item6 !== false) ? $item6 : '');
    $usuario  = (($items7 !== false) ? $items7 : ''); 

    $valores = '('.$grupo.','.$grupodetalle.','. $grupodetallecurso.','.$usuario_id.','.$fase.','.$curso.',4 , NOW(),"'.$usuario.'",1),';
    
    $valores_final = substr($valores, 0, -1);

    var_dump($valores_final); //die();

    $sql="INSERT INTO grupos_usuarios_cursos (grupo_id, grupodetalle_id, grupodetallecurso_id, usuario_id, fase_id,curso_id, acceso_id, fechacreacion, usuario, estado_id) VALUES $valores_final";

    var_dump($sql); //die();        
    $resul = mysqli_query($db,$sql);

    $item1 = next($items1);
    $item2 = next($items2);
    $item3 = next($items3);		
    $item4 = next($items4);		
    $item5 = next($items5); 
    $item6 = next($items6);

    if($item1  === false && $item2  === false && $item3 === false && $item4  === false && $item5  === false && $item6  === false ) break;

    if(mysqli_affected_rows($db)>0){
      $_SESSION['completado'] = "El registro se completo de forma exitosa";	
    }else{
      $_SESSION['fallo'] = "No se completo la carga; por favor volver a intentar";							
    }
    header("Location: ../../admin-grupos.php");		
  }

 }
 header("Location: ../../admin-grupos.php");

?>