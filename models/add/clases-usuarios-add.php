<?php 
	session_start();
  require_once '../../config/db.php';  

  $token = $_POST['token'];  
  $usuarioid = $_POST['usuarioId'];
  $claseid = $_POST['cursoId'];
  
  $sql = "UPDATE grupos_usuarios_clases set acceso_id = 3, proceso_id = 7 WHERE usuario_id  = $usuarioid and clase_id = $claseid";
  $resultado = mysqli_query($db, $sql);
  
  if($resultado){
    $_SESSION['completado'] = "Curso iniciado forma exitosa";      
  } else{
    $_SESSION['fallo'] = "Error; por favor volver a intentar";      
  }
  
  if(isset($_POST['anadirclase'])){ 
    $items1 = ($_POST['grupousuarioclase_id']);
    $items2 = ($_POST['usuario_id']);
    $items3 = ($_POST['clase_id']);		
    $items4 = ($_POST['fase_id']);		
    $items5 = ($_POST['nombreclase']);    
    $items6 = ($_POST['video']);
    $items7 = ($_POST['url_video']);    
    
    $items8 = $_SESSION['sesion_aprenDigital']['nombre'] .' '.$_SESSION['sesion_aprenDigital']['ape_paterno'];       
    
      while(true){
        $item1 = current($items1);
        $item2 = current($items2);
        $item3 = current($items3);		
        $item4 =  current($items4);		
        $item5 =  current($items5); 
        $item6 = current($items6);
        $item7 = current($items7);                     

        $grupousuarioclaseid  = (($item1 !== false) ? $item1 : '');
        $usuario_id  = (($item2 !== false) ? $item2 : '');
        $claseid  = (($item3 !== false) ? $item3 : '');
        $faseid  = (($item4 !== false) ? $item4 : '');
        $nombreclase  = (($item5 !== false) ? $item5 : '');
        $video  = (($item6 !== false) ? $item6 : '');
        $urlvideo  = (($item7 !== false) ? $item7 : '');

        $usuario  = (($items8 !== false) ? $items8 : '');
        $new_url = str_replace("\"","'", $urlvideo);

        $valores = '('.$grupousuarioclaseid.','.$usuario_id.','.$claseid.','.$faseid.',"'.$nombreclase.'","'.$video.'","'.$new_url.'", NOW(),"'.$usuario.'", 1),';	

        $valores_final = substr($valores, 0, -1);
  
        $sql2 = "INSERT INTO lista_clases_usuario (grupousuarioclase_id, usuario_id, clase_id, fase_id, nombreclase, video, url_video, fechacreacion, usuario, estado_id) VALUES $valores_final";
                     
        $resul = mysqli_query($db,$sql2);

        $item1 = next($items1);
        $item2 = next($items2);
        $item3 = next($items3);		
        $item4 =  next($items4);		
        $item5 =  next($items5); 
        $item6 = next($items6);
        $item7 = next($items7);                      

        if($item1  === false && $item2  === false && $item3 === false && $item4  === false && $item5  === false && $item6  === false && $item7  === false ) break;
            
        if(mysqli_affected_rows($db)>0){
          $_SESSION['completado'] = "Hecho!, Bienvenido al curso.";	
        }else{
          $_SESSION['fallo'] = "No se completo la carga; por favor volver a intentar";						
        }
        header("Location: ../../clasesm.php?cu=".$claseid."&t=".$token);      			
      }
  }


  header("Location: ../../clasesm.php");  

?>