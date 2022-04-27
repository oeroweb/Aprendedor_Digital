<div class="sidebar">
    <div class="logo-details">      
      <img src="../assets/img/logo.ico" class="img-logo" alt="Logo ">
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
            <a href="admin-multi-accesos.php" title="Accesos Rapidos">
            <i class="fa fa-th" aria-hidden="true"></i>              
              <span class="links_name">MULTI ACCESOS</span>
            </a>
          </li>                  
          <li>
            <a href="admin-grupos.php" title="Admin Grupos">
              <i class="fas fa-boxes"></i>              
              <span class="links_name">ADMIN GRUPOS</span>
            </a>
          </li>          
          <li>
            <a href="admin-usuarios.php" title="Admin Usuarios Alumnos">
            <i class="fa fa-user-graduate"></i>
              <span class="links_name">ADMIN ALUMNOS</span>
            </a>
          </li> 
          <li>
            <a href="envio-correos.php" title="Admin Correos">
              <i class="fa fa-envelope"></i>              
              <span class="links_name">ENVIAR CORREOS</span>
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