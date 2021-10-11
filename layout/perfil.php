
  <nav>
    <div class="sidebar-button">
      <i class='bx bx-menu sidebarBtn'></i>
      <span class="dashboard"></span>
    </div>
    <!-- <div class="search-box">
      <input type="text" placeholder="Search...">
      <i class='bx bx-search' ></i>
    </div> -->
    
    <div class="profile-details">
      <?php 
        $perfiles = obtenerdatos($db, 'usuarios', $_SESSION['sesion_aprenDigital']['id']);        
          if(!empty($perfiles) && mysqli_num_rows($perfiles) >= 1):
            while($perfil = mysqli_fetch_assoc($perfiles)):  
      ?>     
        <?php if($perfil['imagen'] != null): ?>          
          <img src="assets/files/<?php echo $perfil['carpeta_img'].'/'.$perfil['imagen']; ?>" alt="Foto de Perfil">
        <?php else : ?>
          <img src="assets/img/avatar/male.png" alt="Foto de Perfil">
        <?php endif ?>
        <a href="perfil.php" class="admin_name">
          <?php echo $perfil['nombre'] .' ' .$perfil['ape_paterno']; ?>
        </a>
      </div>
      <?php 
          endwhile;
        endif;
      ?>		       
    </div>
      
    
  </nav>