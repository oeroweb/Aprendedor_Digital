<?php 
  include 'layout/header.php'; 
?>

<body>
  <?php include 'layout/aside.php'; ?>
  <section class="home-section">
    <?php include 'layout/perfil.php';?>
    
    <div class="home-content">
			<div class="center ">				
				<div class="box-titles">
					<h1 class="title">Todos los Cursos</h1>
					<div class="box-botones">						
						<!-- <a class="btn2" href="javascript:history.back()" title="Atras"><i class="fas fa-arrow-left"></i></a>		  -->
					</div>
				</div>
				<?php if(isset($_SESSION['completado'])): ?>
					<div class="alerta-exito">
						<?=$_SESSION['completado']?>  
					</div>
				<?php elseif(isset($_SESSION['fallo'])): ?>
					<div class="alerta-error">
						<?=$_SESSION['fallo']?>
					</div>
				<?php endif; ?> 

				<div class="cursos-content-home mg-bt20 ">
          <div class="tabs-cursos-home">
            <input type="radio" name="slider" id="fase1" checked>
            <input type="radio" name="slider" id="fase2">
            <input type="radio" name="slider" id="fase3">
            <input type="radio" name="slider" id="fase4">
            <input type="radio" name="slider" id="fase5">
            <input type="radio" name="slider" id="fase6">
            <div class="tabs-nav"> 
              <?php 
                $fases = selectactivedatos($db, 'fases');        
                  if(!empty($fases) && mysqli_num_rows($fases) >= 1):
                    while($fase = mysqli_fetch_assoc($fases)):  
              ?>                 
                <label for="fase<?=$fase['id']?>" class="fase<?=$fase['id']?>"><?php echo $fase['nombre']; ?>                
                <br><span class="smalltext"> <?php echo $fase['descripcion']; ?></span></label>              
                <?php endwhile;
              endif; ?>	 
              <div class="slider"></div>                
            </div>
            <section>
              <?php for($i = 1; $i <= 6; $i++ ): ?> 
                <div class="content content-<?=$i?>">
              <?php                   
                $cursos = selectactivefasestocursos($db, 'fases', 'cursos', $i);        
                if(!empty($cursos) && mysqli_num_rows($cursos) >= 1):
                  while($curso = mysqli_fetch_assoc($cursos)):  
              ?>                 
                <a href="cursos.php" class="item-clases">
                  <h2 class="title">Curso : <?php echo $curso['nombrecurso'] ?> </h2>
                  <?php  if($curso['imagen'] != ""): ?>
                    <img src="assets/img/cursos/<?php echo $curso['imagen'] ?>" alt="">
                  <?php  else: ?>
                    <img src="assets/img/cursos/example.PNG" alt="">
                  <?php  endif; ?>
                </a>               
              <?php endwhile;
                endif; ?>		               
              <?php                   
                $clases = selectactivefasestoclases($db, 'fases', 'clases', $i);        
                if(!empty($clases) && mysqli_num_rows($clases) >= 1):
                  while($clase = mysqli_fetch_assoc($clases)):  
              ?>                 
                <a href="clases-maestras.php" class="item-clases">
                  <h2 class="title">Clase Maestra : <?php echo $clase['nombre'] ?> </h2>
                  <?php  if($clase['imagen'] != ""): ?>
                    <img src="assets/clases/<?php echo $clase['carpeta'].'/'.$clase['imagen'] ?>">
                  <?php  else: ?>
                    <img src="assets/img/clases/curso.PNG" alt="">
                  <?php  endif; ?>
                </a>               
              <?php endwhile;
                endif; ?>		               
              </div>
              <?php endfor; ?>	
            </section>	
            	
			    </div>
        </div>			
				
			<!--fin center  -->
			<?php borrarErrores(); ?>		
		</div>

  </section>

  
  <?php include 'layout/footer.php'; ?>
  </body>
</html>
