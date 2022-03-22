<?php 
	session_start();
  require_once '../../config/db.php';  

  $token = $_POST['token'];  
  $usuarioid = $_POST['usuarioId'];
  $cursoid = $_POST['cursoId'];
  
  $sql = "UPDATE grupos_usuarios_cursos set proceso_id = 7 WHERE usuario_id  = $usuarioid and curso_id = $cursoid";
  $resultado = mysqli_query($db, $sql);
  
  var_dump($sql);
  if($resultado){
    $_SESSION['completado'] = "Curso iniciado forma exitosa";      
  } else{
    $_SESSION['fallo'] = "Error; por favor volver a intentar";      
  }
  
  
  if(isset($_POST['anadircurso'])){ 
    $items1 = ($_POST['grupousuariocurso_id']);
    $items2 = ($_POST['usuario_id']);
    $items3 = ($_POST['curso_id']);		
    $items4 = ($_POST['nombrecurso']);		
    $items5 = ($_POST['cursoContenido_id']);  
    $items6 = ($_POST['nombrecapitulo']);
    $items7 = ($_POST['cursoContenidoDetale_id']);
    $items8 = ($_POST['nombre']);
    $items9 = ($_POST['video']);
    $items10 = ($_POST['url_video']);
    $items11 = ($_POST['pagina']);
    
    $items12 = $_SESSION['sesion_aprenDigital']['nombre'] .' '.$_SESSION['sesion_aprenDigital']['ape_paterno'];       
    
      while(true){
        $item1 = current($items1);
        $item2 = current($items2);
        $item3 = current($items3);		
        $item4 =  current($items4);		
        $item5 =  current($items5); 
        $item6 = current($items6);
        $item7 = current($items7);
        $item8 =  current($items8);;
        $item9 =  current($items9);
        $item10 = current($items10);              
        $item11 = current($items11);              

        $grupousuariocursoid  = (($item1 !== false) ? $item1 : '');
        $usuario_id  = (($item2 !== false) ? $item2 : '');
        $curso  = (($item3 !== false) ? $item3 : '');
        $nombrecurso  = (($item4 !== false) ? $item4 : '');
        $cursoContenidoid  = (($item5 !== false) ? $item5 : '');
        $nmobrecapitulo  = (($item6 !== false) ? $item6 : '');
        $cursoContenidoDetaleid  = (($item7 !== false) ? $item7 : '');        
        $nombre  = (($item8 !== false) ? $item8 : '');
        $video  = (($item9 !== false) ? $item9 : '');
        $urlvideo  = (($item10 !== false) ? $item10 : '');        
        $pagina  = (($item11 !== false) ? $item11 : '');
        $usuario  = (($items12 !== false) ? $items12 : '');

        $new_url = str_replace("\"","'", $urlvideo);

        $valores = '('.$grupousuariocursoid.','.$usuario_id.','.$curso.',"'.$nombrecurso.'",'.$cursoContenidoid.',"'.$nmobrecapitulo.'",'.$cursoContenidoDetaleid.',"'.$nombre.'","'.$video.'","'.$new_url.'","'.$pagina.'", NOW(),"'.$usuario.'", 1),';	

        $valores_final = substr($valores, 0, -1);
  
        $sql2 = "INSERT INTO lista_cursos_usuario (grupousuariocurso_id, usuario_id, curso_id, nombrecurso, cursocontendido_id, nombrecapitulo, cursocontendidodetalle_id, nombrecursodetalle, video, url_video, pagina, fechacreacion, usuario, estado_id) VALUES $valores_final";
                
        //var_dump($sql2); //die();        
        $resul = mysqli_query($db,$sql2);

        $item1 = next($items1);
        $item2 = next($items2);
        $item3 = next($items3);		
        $item4 =  next($items4);		
        $item5 =  next($items5); 
        $item6 = next($items6);
        $item7 = next($items7);
        $item8 = next($items8);
        $item9 =  next($items9);
        $item10 = next($items10);               
        $item11 = next($items11);               

        if($item1  === false && $item2  === false && $item3 === false && $item4  === false && $item5  === false && $item6  === false && $item7  === false && $item8  === false && $item9  === false && $item10  === false && $item11  === false ) break;
            
        if(mysqli_affected_rows($db)>0){
          $_SESSION['completado'] = "Hecho!, Bienvenido al curso.";	
        }else{
          $_SESSION['fallo'] = "No se completo la carga; por favor volver a intentar";							
        }
        header("Location: ../../clases.php?cu=".$cursoid."&t=".$token);      			
      }
  }

  header("Location: ../../cursos.php");  

?>