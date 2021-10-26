<?php 
	session_start();
  require_once '../../config/db.php';  
  
  if(isset($_POST['anadirusuarios'])){ 
    $items1 = ($_POST['perfil']);
    $items2 = ($_POST['institucion']);
    $items3 = ($_POST['nombre']);		
    $items4 = ($_POST['apepaterno']);		
    $items5 = ($_POST['apematerno']);  
    $items6 = ($_POST['doc']);
    $items7 = ($_POST['email']);
    $items8 = ($_POST['password']);
    $items9 = ($_POST['sexo']);
    $items10 = ($_POST['fecnac']);
    $items11 = ($_POST['celular']);
    $items12 = ($_POST['pais']);
    $items13 = $_SESSION['sesion_aprenDigital']['nombre'] .' '.$_SESSION['sesion_aprenDigital']['ape_paterno'];
    
    //$encpass = password_hash($password, PASSWORD_BCRYPT,['cost' =>4]);    
    
      while(true){
        $item1 = current($items1);
        $item2 = current($items2);
        $item3 = current($items3);		
        $item4 =  current($items4);		
        $item5 =  current($items5); 
        $item6 = current($items6);
        $item7 = current($items7);
        $item8 =  password_hash(current($items8), PASSWORD_BCRYPT,['cost' =>4]);
        $item9 =  current($items9);
        $item10 = current($items10);
        $item11 = current($items11);
        $item12 = current($items12);        

        $perfil  = (($item1 !== false) ? $item1 : '');
        $institucion  = (($item2 !== false) ? $item2 : '');
        $nombre  = (($item3 !== false) ? $item3 : '');
        $apepaterno  = (($item4 !== false) ? $item4 : '');
        $apematerno  = (($item5 !== false) ? $item5 : '');
        $docidentidad  = (($item6 !== false) ? $item6 : '');
        $email  = (($item7 !== false) ? $item7 : '');        
        $password  = (($item8 !== false) ? $item8 : '');
        $sexo  = (($item9 !== false) ? $item9 : '');
        $fecnac  = (($item10 !== false) ? $item10 : '');
        $celular  = (($item11 !== false) ? $item11 : '');
        $pais  = (($item12 !== false) ? $item12 : '');
        $usuario  = (($items13 !== false) ? $items13 : '');

        $valores = '('.$perfil.','.$institucion.',"'.$nombre.'","'.$apepaterno.'","'.$apematerno.'","'.$docidentidad.'","'.strtolower($email).'","'.$password.'","'.$sexo.'","'.$fecnac.'","'.$celular.'","'.$pais.'",NOW(),"'.$usuario.'", 1),';	

        $valores_final = substr($valores, 0, -1);
  
        $sql = "INSERT INTO usuarios (perfil_id, institucion_id, nombre, ape_paterno, ape_materno, doc_identidad, email, clave, sexo_id, fec_nacimiento, celular, pais, fechacreacion, usuario, estado_id) VALUES $valores_final";
                
        var_dump($sql);  //die();        
        
        $resul = mysqli_query($db,$sql);

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
        $item12 = next($items12);        

        if($item1  === false && $item2  === false && $item3 === false && $item4  === false && $item5  === false && $item6  === false && $item7  === false && $item8  === false && $item9  === false && $item10  === false && $item11  === false && $item12  === false ) break;

            
        if(mysqli_affected_rows($db)>0){
          $_SESSION['completado'] = "El registro se completo de forma exitosa";	
        }else{
          $_SESSION['fallo'] = "No se completo la carga; por favor volver a intentar";							
        }
        header("Location: ../../admin-usuarios.php");					
      }
  }
  header("Location: ../../admin-usuarios.php"); 
  

?>