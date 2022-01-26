<div class="sidebar active">
    <div class="logo-details">      
      <img src="../assets/img/logo.png" class="img-logo" alt="Logo ">
      <p class="logo_name">AD</p>      
    </div>
      <ul class="nav-links">
        <li>
          <a href="dashboard.php" title="Perfil">            
            <i class="fas fa-route"></i>
            <span class="links_name">HOJA DE RUTA</span>
          </a>
        </li>
        <li>
          <a href="perfil.php" title="Perfil">            
            <i class="fas fa-user"></i>
            <span class="links_name">PERFIL</span>
          </a>
        </li>
        <li>
          <a href="cursos.php" title="Cursos">
            <i class="fas fa-book"></i>
            <span class="links_name">CURSOS </span>
          </a>
        </li>
        <li>
          <a href="clases-maestras.php" title="Clases Maestras">            
            <i class="fas fa-chalkboard-teacher"></i>
            <span class="links_name">CLASES MAESTRAS</span>
          </a>
        </li>               
        <li>
          <a href="foros.php" title="Foros">
            <i class="fas fa-comments"></i>
            <span class="links_name">FOROS </span>
          </a>
        </li>        
        <li>
          <a href="eventos.php" title="En Vivos">
            <i class="fas fa-video"></i>        
            <span class="links_name">EVENTOS EN VIVO</span>
          </a>
        </li>
        <?php if($_SESSION['sesion_aprenDigital']['perfil_id'] <= '2'): ?>       
          <li>
            <a href="admin-cursos.php" title="Admin Cursos">
              <i class="fas fa-list-ol"></i>
              <!-- <i class="fas fa-book-medical"></i> -->
              <span class="links_name">ADMIN CURSOS</span>
            </a>
          </li>          
          <li>
            <a href="admin-clases-maestras.php" title="Admin Clases">
              <i class="fas fa-list-alt"></i>
              <span class="links_name">AD. CLASES MAESTRAS</span>
            </a>
          </li>          
          <li>
            <a href="admin-grupos.php" title="Admin Grupos">
              <i class="fas fa-boxes"></i>
              <!-- <i class="fas fa-object-ungroup"></i> -->
              <span class="links_name">ADMIN GRUPOS</span>
            </a>
          </li> 
          <li>
            <a href="admin-instituciones.php" title="Admin Instituciones">
              <i class="fas fa-hotel"></i>
              <span class="links_name">ADMIN INSTITUCIONES</span>
            </a>
          </li> 
          <li>
            <a href="admin-usuarios.php" title="Admin Usuarios">
              <i class="fas fa-users-cog"></i>
              <span class="links_name">ADMIN USUARIOS</span>
            </a>
          </li> 
          <li>
            <a href="setting.php" title="Ajustes">
              <i class="fas fa-tools"></i>
              <span class="links_name">AJUSTES</span>
            </a>
          </li>
        <?php endif; ?>	     
        <li class="log_out" title="Salir">
          <a href="cerrar.php">
            <i class="fas fa-sign-out-alt"></i>
            <span class="links_name">CERRAR SESIÓN</span>
          </a>
        </li>
      </ul>
  </div>