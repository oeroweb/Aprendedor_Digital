<?php 
  include 'layout/header.php'; 
  $mes = array("enero", "febero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "setiembre", "octubre", "noviembre", "diciembre");
?>

<body>
  <?php include 'layout/aside.php'; ?>
  <section class="home-section">
    <?php include 'layout/perfil.php';?>
    
    <div class="home-content">
      <div class="center ">				
				<div class="box-titles">
					<h1 class="title">Proximos Eventos</h1>
					<div class="box-botones">						
						<!-- <a class="btn2" href="javascript:history.back()" title="Atras"><i class="fas fa-arrow-left"></i></a>		  -->
					</div>
				</div>

        <div class="eventos-content">
          <div class="item-eventos-content">
            <?php 
							$eventos = selectactivedatos($db, 'eventos' );        
								if(!empty($eventos) && mysqli_num_rows($eventos) >= 1):
									while($evento = mysqli_fetch_assoc($eventos)):  
                    $fecha = $evento['fechaevento'];                       
                    $fechaedit = date("d", strtotime($fecha)).' de '. $mes[date("m", strtotime($fecha))-1] .' del '.date("Y", strtotime($fecha));
                    $horaedit = date("h", strtotime($fecha)).':'.date("i", strtotime($fecha)).':'.date("sa", strtotime($fecha));
							?> 
            <div class="box-evento">
              <h2 class="title"><?=$evento['titulo']?></h2>
              <img src="assets/eventos/<?=$evento['carpeta'].'/'.$evento['imagen'] ?>" alt="">
              <p class="parrafo"><?=$evento['texto']?></p>
              <div class="mg-tp20">
                <p><span class="color">Día del Evento:</span> <?=$fechaedit?></p>
                <p><span class="color">Hora del Evento:</span> <?=$horaedit?></p>
                <p><span class="color">Enlace de acceso:</span> <a href="<?=$evento['link']?>" class="link" target="_blank"><wbr> <?=$evento['link']?></a> </p>
              </div>
            </div>
            <?php endwhile;
									else : ?>
							<h2 class="">No hay Eventos que mostrar</h2>
						<?php endif; ?>
          </div>
          <div class="aside-eventos-content ">
            <div class="title">Eventos Programados</div>
            <?php 
							$eventos = selectactivedatos($db, 'eventos' );        
								if(!empty($eventos) && mysqli_num_rows($eventos) >= 1):
									while($evento = mysqli_fetch_assoc($eventos)): 
                    $fecha = $evento['fechaevento'];                       
                    $fechaedit = date("d", strtotime($fecha)).' de '. $mes[date("m", strtotime($fecha))-1] .' del '.date("Y", strtotime($fecha));
                    $horaedit = date("h", strtotime($fecha)).':'.date("i", strtotime($fecha)).':'.date("sa", strtotime($fecha));
							?> 
            <div class="box-evento-aside">
              <h3 class="title"><?=$evento['titulo']?></h3>
              <p class="fecha">Día : <?=$fechaedit?></p>
              <p class="fecha">Hora: <?=$horaedit?></p>
              <p class="parrafo">
                <?php if(strlen($evento['texto']) > 80) : ?>
                  <?=substr($evento['texto'],0,150).'..'?>
                <?php else : ?>
                  <?=$evento['texto']?>
                <?php endif ?>
              </p>
              
              <?php if($evento['archivos'] != "") : ?>
                <p><span class="color">Documentos:</span> 
                  <?php  
										$misarchivos = $evento['archivos'];																			
										$array_misarchivos = explode(', ', $misarchivos); 
										
										foreach( $array_misarchivos as $archivo) : ?>	

											<a href="assets/eventos/<?php echo $evento['carpeta'].'/'.$archivo; ?>" class="btn-file" target="_blank" download="true"> <i class="fas fa-file"></i> <?=$archivo?></a>
									<?php endforeach; ?>	
                </p>
							<?php endif; ?>
            </div>
            <?php endwhile;
									else : ?>
							<h2 class="">No hay Eventos que mostrar</h2>
						<?php endif; ?>
          </div>
        </div>
			</div>         
    </div>

  </section>

  
  <?php include 'layout/footer.php'; ?>
  </body>
</html>
