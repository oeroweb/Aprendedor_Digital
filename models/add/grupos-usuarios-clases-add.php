<?php 

  require_once	('../../config/db.php');
  
  if(!isset($_SESSION)){
    session_start();
  }
        
 if(isset($_POST['usuariosyclases'])){
  $idgroup = $_POST['idgroup'];
  $items1 = ($_POST['grupo_id']);
  $items2 = ($_POST['grupofases_id']);
  $items3 = ($_POST['grupoFaseClase_id']);		
  $items4 = ($_POST['usuario_id']);		
  $items5 = ($_POST['fase_id']);  
  $items6 = ($_POST['clase_id']);
  $items7 = ($_POST['token']);
  $items8 = ($_POST['acceso']);
  $items9 = $_SESSION['sesion_aprenDigital']['nombre'] .' '.$_SESSION['sesion_aprenDigital']['ape_paterno'];

  while(true){
    $item1 = current($items1);
    $item2 = current($items2);
    $item3 = current($items3);		
    $item4 = current($items4);		
    $item5 = current($items5); 
    $item6 = current($items6);
    $item7 = current($items7);
    $item8 = current($items8);

    $grupo  = (($item1 !== false) ? $item1 : '');
    $grupofase  = (($item2 !== false) ? $item2 : '');
    $grupofaseclase  = (($item3 !== false) ? $item3 : '');
    $usuario_id  = (($item4 !== false) ? $item4 : '');
    $fase  = (($item5 !== false) ? $item5 : '');
    $clase  = (($item6 !== false) ? $item6 : '');
    $token  = (($item7 !== false) ? $item7 : '');
    $acceso  = (($item8 !== false) ? $item8 : ''); 
    $usuario  = (($items9 !== false) ? $items9 : ''); 

    $valores = '('.$grupo.','.$grupofase.','. $grupofaseclase.','.$usuario_id.','.$fase.','.$clase.','.$acceso.',"'.$token.'", NOW(),"'.$usuario.'",1),';
    
    $valores_final = substr($valores, 0, -1);

    //var_dump($valores_final); //die();

    $sql="INSERT INTO grupos_usuarios_clases (grupo_id, grupofase_id, grupoclases_id, usuario_id, fase_id, clase_id, acceso_id, token, fechacreacion, usuario, estado_id) VALUES $valores_final";
       
    $resul = mysqli_query($db,$sql);

    $item1 = next($items1);
    $item2 = next($items2);
    $item3 = next($items3);		
    $item4 = next($items4);		
    $item5 = next($items5); 
    $item6 = next($items6);
    $item7 = next($items7);
    $item8 = next($items8);

    if($item1  === false && $item2  === false && $item3 === false && $item4  === false && $item5  === false && $item6  === false && $item7  === false && $item8  === false ) break;

    if(mysqli_affected_rows($db)>0){
      $_SESSION['completado'] = "El registro se completo de forma exitosa";	
    }else{
      $_SESSION['fallo'] = "No se completo la carga; por favor volver a intentar";							
    }
    header("Location: ../../grupos-content.php?id=$idgroup");	
  }

 }
 header("Location: ../../grupos-content.php?id=$idgroup");	

?>