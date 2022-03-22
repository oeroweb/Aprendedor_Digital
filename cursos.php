<?php 
  include 'layout/header.php'; 
  $usuario_id = $_SESSION['sesion_aprenDigital']['id'];
  //$usuario_perfil = $_SESSION['sesion_aprenDigital']['perfil_id'];
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
        
        <?php if($_SESSION['sesion_aprenDigital']['perfil_id'] == 4) : ?>
					<div class="inner-content mg-bt20 w70">					 			
						<div class="inner-content-cursos"> 
              <?php 
                $sql = "SELECT nombrecursodetalle FROM lista_cursos_usuario WHERE porcentaje = 100 and usuario_id = $usuario_id";
                $dataCursosProceso = mysqli_query($db, $sql);
                $cantDataCursosProceso = mysqli_num_rows($dataCursosProceso);
            
                $sql2 = "SELECT nombre FROM cursos_contenido_detalle";
                $dataCursosContenido = mysqli_query($db, $sql2);
                $cantDataCursosContenido = mysqli_num_rows($dataCursosContenido);

                $sql3 = "SELECT nombre FROM cursos";
                $dataCursos = mysqli_query($db, $sql3);
                $cantDataCursos = mysqli_num_rows($dataCursos);

                $sql4 = "SELECT nombre FROM fases";
                $dataFases = mysqli_query($db, $sql4);
                $cantDataFases = mysqli_num_rows($dataFases);

                $sql5 = "SELECT * FROM `grupos_usuarios_cursos` WHERE proceso_id = 9 and usuario_id = $usuario_id";
                $dataCursosCompletados = mysqli_query($db, $sql5);
                $cantDataCursosCompletados = mysqli_num_rows($dataCursosCompletados);

                $progreso_avance = ($cantDataCursosProceso * 100) / $cantDataCursosContenido;
                $progreso_avance = round($progreso_avance, 2);

                $cursos_avance = ($cantDataCursosCompletados * 100) / $cantDataCursos;
                $cursos_avance = round($cursos_avance, 2);
                //echo $cantDataCursosCompletados;
              ?>             
              <div class="item-cursos">
                <h2 class="title">Porcentaje del Programa</h2>
                <?php if(isset($progreso_avance)) : ?>
                  <input type="text" value="<?=$progreso_avance?>" class="porcentaje_programa">
                <?php else: ?>
                  <input type="text" value="0" class="porcentaje_programa">
                <?php endif; ?>
              </div>
              <div class="item-cursos">                
                <h2 class="title">Porcentaje <?=$progreso_avance?>% de avance de Cursos</h2>     
                <?php 
                  $cursos = obtenerdatosusuarios($db, 'grupos_usuarios_cursos', $_SESSION['sesion_aprenDigital']['id']);										
                    if(!empty($cursos) && mysqli_num_rows($cursos) >= 1):												  
                ?> 
                <ul class="list-avance">
                  <li>
                    <h3 class="title">Cursos Completados : <?= $cursos_avance ?>% </h3>
                  </li>
                  <li>
                    <h3 class="title">Fases : 0% </h3>
                  </li>
                  <!-- <li>
                    <h3 class="title">Foros : </h3>
                  </li> -->
                </ul>
                <?php 
                  else: ?>
                      <div class="inner-content mg-bt20">
                      <h2 class="title">No tienes cursos registrados aún. </h2>
                    </div>
                <?php endif; ?>
              </div>
						</div>							
					</div>
				<?php endif; ?>

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

            <!-- LISTA DE CURSOS DE ALUMNOS - PERFIL 4 -->
            <?php if($_SESSION['sesion_aprenDigital']['perfil_id'] == 4) : ?>
              <div class="tabs-nav"> 
                <?php 
                  $fases = selectactivedatos($db, 'fases');        
                    if(!empty($fases) && mysqli_num_rows($fases) >= 1):
                      while($fase = mysqli_fetch_assoc($fases)):  
                ?>  
                  <label for="fase<?=$fase['id']?>" class="fase<?=$fase['id']?>"><?php echo $fase['nombre']; ?>                
                  <br><span class="smalltext"> <?php echo $fase['descripcion']; ?></span></label> 
                <?php                
                endwhile; endif; 
                ?>                                
              </div>
              <section>
                <?php for($i = 1; $i <= 6; $i++ ): ?> 
                <div class="content content-<?=$i?>">
                <?php 
                  $_SESSION['fase_actual'] = $i;
                  $faseID = $_SESSION['fase_actual'];
                  //echo 'fase actual -> '.$faseID;
                  
                  $sql6 ="SELECT * FROM `grupos_usuarios_cursos` WHERE usuario_id = $usuario_id and fase_id = $faseID";
                  $listarCursos = mysqli_query($db, $sql6);
                  $cantCursos = mysqli_num_rows($listarCursos);

                  $sql8 ="SELECT * FROM `grupos_usuarios_cursos` WHERE usuario_id = $usuario_id and fase_id = $faseID and proceso_id = 9";
                  $listarCursosProceso = mysqli_query($db, $sql8);
                  $cantCursosProceso = mysqli_num_rows($listarCursosProceso);

                  // $sql7 ="SELECT * FROM `grupos_usuarios_clases` WHERE usuario_id = 27 and fase_id = $faseID";
                  // $listarClases = mysqli_query($db, $sql7);
                  // $cantClases = mysqli_num_rows($listarClases);                  

                  if( $cantCursos == $cantCursosProceso){
                    $accesoClase = true;
                    //echo $accesoClase;
                  }else{
                    $accesoClase = false;
                    //echo $accesoClase;
                  }

                ?>
                  <div class="container-wrap">
                    <!-- LISTADO DE CURSOS -->
                    <?php   
                      // CURSO SELECCIONADOS                    
                      $cursos = listarcursosescogidos($db, 'grupos_usuarios_cursos', 'cursos', 'grupos_cursos', $usuario_id ,$i);        
                      if(!empty($cursos) && mysqli_num_rows($cursos) >= 1):                        
                        while($curso = mysqli_fetch_assoc($cursos)):  
                    ?>                  
                    <?php if($curso['acceso_id'] == 3): ?>
                      <div class="item-clases">
                        <h2 class="title">Curso : <?php echo $curso['nombre'] ?> </h2>
                        <?php  if($curso['imagen'] != ""): ?>
                          <img src="assets/img/cursos/<?php echo $curso['imagen'] ?>" alt="">
                        <?php  else: ?>
                          <img src="assets/img/cursos/example.PNG" alt="">
                        <?php  endif; ?>
                        <a href="clases.php?cu=<?=$curso['curso_id']?>&t=<?=$curso['token']?>&f=<?=$faseID?>" class="btn">Entrar al Curso</a>
                      </div>
                      <?php else : ?>
                      <div class="item-clases bloqueado">
                        <div class="box-overlay">
                          <p class="text">Aún no tienes acceso, <br> termina el curso anterior <i class="fas fa-thumbs-up"></i></p>
                        </div>
                        <h2 class="title">Curso : <?php echo $curso['nombre'] ?> </h2>
                        <?php  if($curso['imagen'] != ""): ?>
                          <img src="assets/img/cursos/<?php echo $curso['imagen'] ?>" alt="">
                        <?php  else: ?>
                          <img src="assets/img/cursos/example.PNG" alt="">
                        <?php endif; ?>
                        <a href="clases.php?cu=<?=$curso['curso_id']?>&t=<?=$curso['token']?>&f=<?=$faseID?>" class="btn btn-gris">Entrar al Curso</a>
                      </div>
                    <?php endif;             
                      endwhile;  else:
                    ?>
                      <h2>Aún no tienes cursos asignados, por favor espera...!</h2>
                    <?php endif; ?>
                    
                    <!-- LISTADO DE CLASES -->
                    <?php   
                      // CLASES SELECCIONADAS                    
                      $clases = listarclasescogidos($db, 'grupos_usuarios_clases', 'clases', 'grupos_clases', $usuario_id ,$i);        
                      if(!empty($clases) && mysqli_num_rows($clases) >= 1):
                        //echo  'cantidad' . mysqli_num_rows($cursos);
                        while($clase = mysqli_fetch_assoc($clases)):  
                    ?>    
                    <?php if($clase['acceso_id'] == 3): ?>               
                      <div class="item-clases">
                        <h2 class="title">Clase Maestra : <?php echo $clase['nombre'] ?> </h2>
                        <?php if($clase['imagen'] != null) : ?>
                          <img src="assets/clases/<?=$clase['carpeta'].'/'.$clase['imagen']?>" alt="Imagen de la Clases <?=$clase['nombre']?>">
                        <?php else : ?>
                          <img src="assets/img/example_clases.jpg" alt="Imagen de la Clase <?=$clase['nombre']?>">
                        <?php endif ?>	
                        <a href="clasesm.php?cl=<?=$clase['clase_id']?>&t=<?=$clase['token']?>" class="btn">Entrar a la Clase</a>
                      </div>                    
                      <?php elseif($accesoClase == 1) : ?>
                        <div class="item-clases">
                        <h2 class="title">Clase Maestra : <?php echo $clase['nombre'] ?> </h2>
                        <?php if($clase['imagen'] != null) : ?>
                          <img src="assets/clases/<?=$clase['carpeta'].'/'.$clase['imagen']?>" alt="Imagen de la Clases <?=$clase['nombre']?>">
                        <?php else : ?>
                          <img src="assets/img/example_clases.jpg" alt="Imagen de la Clase <?=$clase['nombre']?>">
                        <?php endif ?>	
                        <a href="clasesm.php?cl=<?=$clase['clase_id']?>&t=<?=$clase['token']?>" class="btn">Entrar a la Clase</a>
                      </div> 
                      <?php else : ?> 
                        <div class="item-clases bloqueado">
                          <div class="box-overlay">
                            <p class="text">Aún no tienes acceso, <br> termina el curso anterior para acceder a la clase maestra <i class="fas fa-thumbs-up"></i></p>
                          </div>
                          <h2 class="title">Clase Maestra : <?php echo $clase['nombre'] ?> </h2>
                          <?php if($clase['imagen']) : ?>
                            
                            <img src="assets/clases/<?=$clase['carpeta'].'/'.$clase['imagen']?>" alt="Imagen de la Clases <?=$clase['nombre']?>">
                          <?php else : ?>
                            <img src="assets/img/example_clases.jpg" alt="Imagen de la Clase <?=$clase['nombre']?>">
                          <?php endif ?>	
                          <a href="clasesm.php?cl=<?=$clase['clase_id']?>&t=<?=$clase['token']?>" class="btn btn-gris">Entrar a la Clase</a>
                        </div>           
                      <?php endif;
                      endwhile; endif; 
                    ?>		 
                  </div>
                  <!-- container -->
                </div>
                <!-- content -->
                <?php endfor; ?>	
              </section> 

            <?php else: ?>
               <!-- LISTA DE TODOS CURSOS PERFIL LIBRE -->
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
                <div class="container-wrap">
               
              <?php                   
                $cursos = selectactivefasestocursos($db, 'fases', 'cursos', $i);        
                if(!empty($cursos) && mysqli_num_rows($cursos) >= 1):
                  while($curso = mysqli_fetch_assoc($cursos)):  
              ?>  
                <div class="item-clases">
                  <h2 class="title">Curso : <?php echo $curso['nombrecurso'] ?> </h2>
                  <?php  if($curso['imagen'] != ""): ?>
                    <img src="assets/img/cursos/<?php echo $curso['imagen'] ?>" alt="">
                  <?php  else: ?>
                    <img src="assets/img/cursos/example.PNG" alt="">
                  <?php  endif; ?>
                  <a href="clasesad.php?cu=<?=$curso['idCurso']?>" class="btn">Entrar al Curso</a>
                  <!-- <a href="clases.php?cu=<?//=$curso['idCurso']?>&t=<?//=$curso['token']?>" class="btn">Inicio</a> -->
                </div>                            
              <?php endwhile;
                endif; ?>		               
              <?php                   
                $clases = selectactivefasestoclases($db, 'fases', 'clases', $i);        
                if(!empty($clases) && mysqli_num_rows($clases) >= 1):
                  while($clase = mysqli_fetch_assoc($clases)):  
              ?>    
                <div class="item-clases">
                  <h2 class="title">Clase Maestra : <?php echo $clase['nombreclase'] ?> </h2>
                  <?php if($clase['imagen'] != null) : ?>
                    <img src="assets/clases/<?=$clase['carpeta'].'/'.$clase['imagen']?>" alt="Imagen de la Clases <?=$clase['nombre']?>">
                  <?php else : ?>
                    <img src="assets/img/example_clases.jpg" alt="Imagen de la Clase <?=$clase['nombre']?>">
                  <?php endif ?>	
                  <a href="clasesadm.php?cl=<?=$clase['idClase']?>" class="btn">Entrar a la Clase</a>
                  <!-- <a href="clasesm.php?cl=<?//=$clase['idClase']?>&t=<?//=$clase['token']?>" class="btn">Inicio</a> -->
                </div>      
              <?php endwhile;
                endif; ?>		               
              </div>
              </div>
              <?php endfor; ?>	
            </section>	
            <?php endif; ?>
          </div>
        </div>
        
				
			<!--fin center  -->
			<?php borrarErrores(); ?>		
		</div>

  </section>

  
  <?php include 'layout/footer.php'; ?>
  </body>
</html>

<script>
  $(document).ready(function() {
    //$(".dial").knob();
    $('.porcentaje_programa').knob({
      'min':0,
      'max':100,
      'width':220,
      'height':220,
      'displayInput':true,
      'fgColor':"#1c75bc",
      'bgColor':"#a6a6a6",
      'release':function(v) {$(".p").text(v);},
      'readOnly':true
    });
  });
</script>
