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
    
    if($resultado){
      $destinatario = $usuariosData[5];
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
                    <h2 style="color:#1c75bc;">??FELICITACIONES! ????</h2>
                    <h2 style="color:#1c75bc; font-weight: 400; margin-bottom: 50px;">??YA EST??S DENTRO! </h2>
                  
                    <p style="margin:2px;line-height: 1.2; margin-bottom: 30px;">
                      Bienvenido, ya eres parte de nuestra escuela aprendedor digital, la primera escuela sin fines de lucro de formaci??n en emprendimiento, liderazgo y negocios digitales. 
                    </p>
                    <p style="margin:2px;line-height: 1.2; margin-bottom: 30px;">
                      Ahora perteneces a una comunidad de alumnos que al igual que t?? buscan crecer y convertirse en l??deres y emprendedores.
                    </p>
                    <p>Aqu?? tienes tu acceso a la escuela </p>
                    <ul style="margin:10px 0;line-height: 1.8; list-style: none;">
                      <li>Usuario : ' . $usuariosData[5] .'  <span></span> </li>
                      <li>Contrase??a : <span><strong> cambiame123 </strong></span></li>
                      <li>Haz click <a href="https://aprendedordigital.org/escuela/index.php" style="color:#1c75bc; font-weight: 700;">aqu??</a>  para ingresar</li>					
                    </ul>							
                  </div>
                  <div style="text-align: center; color:#1c75bc; margin-top: 50px;" >				
                    <p style="margin:2px;line-height: 1.2; margin-bottom: 30px;">
                      Estamos felices de que est??s con nosotros y empieces este nuevo camino hacia tu crecimiento personal y profesional. 
                    </p>
                    <p style="margin:2px;line-height: 1.2; margin-bottom: 30px;">
                      Cuenta con nuestro apoyo durante todo este proceso y <br> ??Manos a la obra! ????
                    </p>														
                  </div>
                  <div style="text-align: center; margin-top: 50px;" >				
                    <p style="margin:2px;line-height: 1.2; margin-bottom: 30px;">
                      NOTA: te adjuntamos un instructivo para que veas c??mo hacerlo
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
											<a style="text-decoration: none; color:#fff;" href="https://aprendedordigital.org/">Aprendedor Digital </a>	??2021 - ' . date('Y'). ' 
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
        //$_SESSION['completado'] = "Se env??o un correo a tu cuenta " . $email. " con las credenciales de sessi??n.";           
      }else{        
        $_SESSION['fallo'] = "La cuenta de correo no est?? registrada, por favor validar!";		
        header("Location: ../../admin-usuarios.php");
      }	
    }    
  }

  //print_r($usuariosList);

  if(mysqli_affected_rows($db)>0){
    $_SESSION['completado'] = "<i class='far fa-check-circle'></i> El registro se completo de forma exitosa"; 							
  }else{
      $_SESSION['fallo'] = "<i class='far fa-times-circle'></i> No se completo la carga; por favor volver a intentar";					
  }

?>