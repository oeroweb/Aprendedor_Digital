<?php 

  $useragent = $_SERVER['HTTP_USER_AGENT'];
  $ip = $_SERVER['REMOTE_ADDR'];

  //echo $useragent . '<br>';
  //echo $ip;

?>
  <nav>
    <div class="sidebar-button">
      <i class="fas fa-bars sidebarBtn"></i>
      <span class="dashboard"></span>
    </div>

    <!-- <div class="search-box">
      <input type="text" placeholder="Search...">
      <i class='bx bx-search' ></i>
    </div> -->
    
    <div class="profile-details" id="profileDetails">
      <?php 
        $perfiles = obtenerdatos($db, 'usuarios', $_SESSION['sesion_aprenDigital']['id']);        
          if(!empty($perfiles) && mysqli_num_rows($perfiles) >= 1):
            while($perfil = mysqli_fetch_assoc($perfiles)):  
      ?>
        <div class="box-notificacion" id="btnNotificacion">
          <!-- <i class="fas fa-bell"></i> -->
          <?php 
            $notificaciones = listarNotificacionesNoLeidasporUsuario($db, 'notificaciones','usuarios', $_SESSION['sesion_aprenDigital']['id']);        
              if(!empty($notificaciones) && mysqli_num_rows($notificaciones) >= 1):
                  $cantidad_noti = mysqli_num_rows($notificaciones); 
          ?>
          <div class="number" id="number">
            <?=$cantidad_noti?>               
          </div>
          <?php endif; ?>	
          <i class="ico far fa-bell"></i>

          <div class="box-perfil2" id="boxNotificacion">
            <h2 class="title">Notificaciones</h2>
            <?php 
              $notificaciones = listarNotificacionesNoLeidasporUsuario($db, 'notificaciones','usuarios', $_SESSION['sesion_aprenDigital']['id']);       
                if(!empty($notificaciones) && mysqli_num_rows($notificaciones) >= 1):
                  while($notificacion = mysqli_fetch_assoc($notificaciones)):  
            ?>
              <a href="foros.php?pubicacionId=<?=$notificacion['publicacion_id']?>&notificacion=<?=$notificacion['idnotificacion']?>" class="notificacion"> <i class="fas fa-comment-alt"></i><?= $notificacion['nombre'].' '.$notificacion['ape_paterno'].' '.$notificacion['tipo_mensaje']. '.' ?></a>                 
              
            <?php endwhile; else: ?>	          
              No tienes notificaciones sin leer.
            <?php endif; ?>	          
          </div>
        </div>
        <div class="admin_name" id="adminNane">
          <?php if($perfil['imagen'] != null): ?>          
            <img src="assets/files/<?php echo $perfil['carpeta_img'].'/'.$perfil['imagen']; ?>" alt="Foto de Perfil">
          <?php else : ?>
            <img src="assets/img/avatar/male.png" alt="Foto de Perfil">
          <?php endif ?>
          <span ><?php echo $perfil['nombre'] .' ' .$perfil['ape_paterno']; ?></span>
        </div>
        <div class="box-perfil" id="btnPerfil">
          <a href="perfil.php" class="btn-perfil"> <i class="fas fa-user"></i> Ver Perfil</a>
          <a href="contrasenna-segura.php" class="btn-perfil"> <i class="fas fa-key"></i>Cambiar Clave</a>
          <hr style="background-color:#fff; margin: 4px 0;">
          <a href="contrasenna-segura.php" class="btn-perfil"> <i class="fas fa-sign-out-alt"></i></i>Cerrar Sesión</a>
        </div>
        
      <?php 
          endwhile;
        endif;
      ?>		       
    </div>
      
    
  </nav>