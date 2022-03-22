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
                     
        $resul = mysqli_query($db,$sql);

        if($resul){
          $destinatario = $email;
			    $asunto = "Bienvenido a la escuela Aprendedor Digital";
		
          $cuerpo = '
            <!DOCTYPE html>
            <html lang="es">
              <head>
                <title>Bienvenida a la escuela</title>
                <link rel="stylesheet" href="assets/css/css/all.min.css">';
          $cuerpo .= '
              </head>
              <body>
                <table style="max-width:800px; padding: 10px; margin:0 auto; border-collapse: collapse;">			
                  <tr>
                    <td style="width: 100%; text-align: center; height:180px; box-sizing: border-box; ">
                      <img width="auto" height="110px" style="display:block; margin:20px auto;" src="https://aprendedordigital.org/assets/img/logo.png">			
                    </td>
                  </tr>
                  <tr>
                    <td style="font-family: sans-serif; font-size: 18px; box-sizing: border-box;">
                    <div style="text-align: center; padding: 10px 25px; " >
                      <h2 style="color:#1c75bc;">¡FELICITACIONES! 🤩</h2>
                      <h2 style="color:#1c75bc; font-weight: 400; margin-bottom: 50px;">¡YA ESTÁS DENTRO! </h2>
                      
                      <p style="margin:2px;line-height: 1.2; margin-bottom: 30px;">
                        Bienvenido, ya eres parte de nuestra escuela aprendedor digital, la primera escuela sin fines de lucro de formación en emprendimiento, liderazgo y negocios digitales. 
                      </p>
                      <p style="margin:2px;line-height: 1.2; margin-bottom: 30px;">
                        Ahora perteneces a una comunidad de alumnos que al igual que tú buscan crecer y convertirse en líderes y emprendedores.
                      </p>
                      <p>Aquí tienes tu acceso a la escuela </p>
                      <ul style="margin:10px 0;line-height: 1.8; list-style: none;">
                        <li>Usuario : ' . $email .'  <span></span> </li>
                        <li>Contraseña : <span><strong> cambiame123 </strong></span></li>
                        <li>Haz click <a href="https://aprendedordigital.org/escuela/index.php" style="color:#1c75bc; font-weight: 700;">aquí</a>  para ingresar</li>					
                      </ul>							
                    </div>
                    <div style="text-align: center; color:#1c75bc; margin-top: 50px;" >				
                      <p style="margin:2px;line-height: 1.2; margin-bottom: 30px;">
                        Estamos felices de que estés con nosotros y empieces este nuevo camino hacia tu crecimiento personal y profesional. 
                      </p>
                      <p style="margin:2px;line-height: 1.2; margin-bottom: 30px;">
                        Cuenta con nuestro apoyo durante todo este proceso y <br> ¡Manos a la obra! 💪
                      </p>														
                    </div>
                    <div style="text-align: center; margin-top: 50px;" >				
                      <p style="margin:2px;line-height: 1.2; margin-bottom: 30px;">
                        NOTA: te adjuntamos un instructivo para que veas cómo hacerlo
                      </p>
                      <p style="margin:2px;line-height: 1.2; margin-bottom: 30px;">
                        P.D.  Para cualquier consulta siempre puedes escribirnos a: <a href="mailto:info@aprendedordigital.org">info@aprendedordigital.org</a>
                      </p>														
                    </div>
                    <div style="width:100%; padding: 30px 20px; box-sizing: border-box; text-align: center;background-color: darkgray; color:#000; border-radius:0 0 6px 6px;">				
										<a style="padding: 6px; margin-right: 10px; color:#fff; font-size: 24px;" href="https://www.facebook.com/Aprendedor-Digital-110587471240379" target="_blank"><img src="https://aprendedordigital.org/assets/img/facebook.png" style="width:30px; height: 30px;" alt=""></a>
										<a style="padding: 6px; margin-right: 10px; color:#fff; font-size: 24px;" href="https://www.instagram.com/escuela.aprendedordigital/" target="_blank">
										<img src="https://aprendedordigital.org/assets/img/instagram.png" style="width:30px; height: 30px;" alt=""></a>
										<a style="padding: 6px; margin-right: 10px; color:#fff; font-size: 24px;" href="https://www.youtube.com/channel/UC7c-NHW2US8ukag2l8AWhJA" target="_blank">
											<img src="https://aprendedordigital.org/assets/img/youtube.png" style="width:30px; height: 30px;" alt=""></a>
										<a style="padding: 6px; margin-right: 10px; color:#fff; font-size: 24px;" href="https://www.linkedin.com/company/aprendedor-digital" target="_blank">
										<img src="https://aprendedordigital.org/assets/img/linkedin.png" style="width:30px; height: 30px;" alt=""></a>
										<div style="padding: 20px 0; color:#000; font-size: 20px;"> 
											<a style="text-decoration: none; color:#fff;" href="https://aprendedordigital.org/">Aprendedor Digital </a>	©2021 - ' . date('Y'). ' 
										</div>
									</div>	
                      												
                    </td>
                  </tr>		
                </table>
              </body>
          </html>
          ';
          $headers  = "MIME-Version: 1.0\r\n"; 
          $headers .= "Content-type: text/html; charset=utf-8\r\n"; 
          $headers .= "From: Info - Aprendedor Digital <info@aprendedordigital.org>\r\n"; 
            
          if(mail($destinatario,$asunto,$cuerpo,$headers)){            
            //$_SESSION['completado'] = "Se envío un correo a tu cuenta " . $email. " con las credenciales de sessión.";           
          }else{        
            $_SESSION['fallo'] = "La cuenta de correo no está registrada, por favor validar!";		
            header("Location: ../../admin-usuarios.php");
          }	
        }

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
            
        if(mysqli_affected_rows($db) > 0){  
          $_SESSION['completado'] = "El registro se completo de forma exitosa";
        }elseif(mysqli_affected_rows($db) > 1){  
            $_SESSION['completado'] = "Los registros se completarón de forma exitosa";
        }else{
          $_SESSION['fallo'] = "No se completo la carga; por favor volver a intentar";			
        }
        header("Location: ../../admin-usuarios.php");					
      }
  }
  header("Location: ../../admin-usuarios.php"); 
  

?>