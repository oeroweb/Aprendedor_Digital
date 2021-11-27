<?php 
  include 'layout/header.php';
  $usuario_id = $_SESSION['sesion_aprenDigital']['id'];
  $mes = array("enero", "febero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "setiembre", "octubre", "noviembre", "diciembre");

  if(isset($_GET['buscar'])){
    $busqueda = $_GET['buscar'];
  }else{
    $busqueda = null;
  }

?>

<body>
  <?php include 'layout/aside.php'; ?>
  <section class="home-section">
    <?php include 'layout/perfil.php';?>
    
    <div class="home-content">
      <div class="center">				
				<div class="box-titles">
					<h1 class="title">Foros</h1>					
				</div>

        <div class="foros-content-home mg-bt20 ">
          <div class="tabs-foros-home">
            <div class="container-wrap">    
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
                  <label for="fase<?=$fase['id']?>" class="fase<?=$fase['id']?>">
                    <?php echo $fase['nombre']; ?>    
                  </label>              
                  <?php endwhile;
                endif; ?>	                          
              </div>
              <section>
                <?php for($i = 1; $i <= 6; $i++ ): ?> 
                  <div class="content content-<?=$i?>">             	               
                    <div class="container-wrap">                                       
                      <div class="item-foros "> 
                        <div class="box-title mg-bt20">
                          <h2>Preguntas y Respuestas</h2>
                        </div>
                        <div id="info"></div>				
                        <div class="container-wrap">
                          <div class="box-botones w50">
                            <input type="hidden" name="fase_id" id="fase_id" value="<?=$i?>">
                            <a href="#" class="btn nuevaPregunta">Crear Nueva Pregunta</a>
                          </div>
                          <div class="box-searchs w50">
                            <form action="foros.php" method="get" class="box-formulario" id="frm_buscar">            
                              <input type="search" name="buscar" id="buscar" placeholder="Buscar pregunta ...? "> 
                              <button type="submit" class="" id="btnsearchs"> 
                                <?php if($busqueda != null) : ?>
                                  <i class="fas fa-search-minus"></i>
                                <?php else : ?>
                                  <i class="fas fa-search"></i>
                                <?php endif; ?>
                              </button>
                            </form>
                          </div>
                        </div>
                        <hr>
                        <div class="post-preguntas" id="postPreguntas">
                          <ul>
                            <?php 
                              $publicaciones = mostarplublicacionesxfases($db, 'publicacion','usuarios', $i, $busqueda);
                              if(!empty($publicaciones) && mysqli_num_rows($publicaciones) >= 1):
                                while($publicacion = mysqli_fetch_assoc($publicaciones)):
                                  $fecha = $publicacion['fechapublicacion'];                       
                                  $fechaedit = date("d", strtotime($fecha)).' de '. $mes[date("m", strtotime($fecha))-1] .' del '.date("Y", strtotime($fecha));
                            ?>	
                              <li class="item-pregunta">
                                <div class="box-preguntas">  
                                  <?php if($publicacion['imagen']) : ?>
                                    <img src="assets/files/<?=$publicacion['carpeta_img'] .'/'.$publicacion['imagen']?>" class="img-32" alt="">
                                  <?php else: ?>
                                    <img src="assets/img/avatar/male.png" class="img-32" alt="avatar">
                                  <?php endif; ?>
                                  <div class="preguntas">
                                    <div>
                                      <div class="nombre">
                                        <?=$publicacion['nombre'].' '.$publicacion['ape_paterno']?>
                                      </div>  
                                      <div class="fecha"><?=$fechaedit?></div>  
                                    </div>
                                    <p class="pregunta"> <?=$publicacion['publicacion'] ?> </p> 
                                  </div>
                                </div>
                                <div class="respuestas"> 
                                  <ul>
                                    <?php 
                                      $comentarios = mostarcomentariosxpublicacione($db, 'comentarios','usuarios', $publicacion['idpublicacion']);
                                      if(!empty($comentarios) && mysqli_num_rows($comentarios) >= 1):
                                        while($comentario = mysqli_fetch_assoc($comentarios)): 
                                    ?>	
                                      <li class="box-comentarios ">
                                        <?php if($comentario['imagen']) : ?>
                                          <img src="assets/files/<?=$comentario['carpeta_img'] .'/'.$comentario['imagen'] ?>" class="img-32" alt="">
                                        <?php else: ?>
                                          <img src="assets/img/avatar/male.png" class="img-32" alt="avatar">
                                        <?php endif; ?>
                                        <div class="comentarios">
                                          <div class="nombre">
                                            <?=$comentario['nombre'] .' '. $comentario['ape_paterno']?>
                                          </div>
                                          <p class="comentario"><?=$comentario['comentario'] ?></p> 
                                        </div> 
                                      </li>
                                    <?php endwhile; endif; ?>
                                  </ul>

                                  <form action="models/add/foros-comentarios-add.php" method="post" class="box-formulario">
                                    <input type="hidden" name="publicacion_id" value="<?=$publicacion['idpublicacion'] ?>">
                                    <input type="hidden" name="usuario_id" value="<?=$_SESSION['sesion_aprenDigital']['id']?>" id="usuario_id">
                                    <textarea name="comentario" id="comentario" class="comentario" placeholder="Escribe una respuesta..." maxlength="400" required></textarea>
                                    <button type="submit" id="btnagregarComentario"  class="btn-submit btnagregarComentario"><i class="fas fa-paper-plane"></i> </button>
                                  </form>
                                  <div id="info3" class="info3"></div>                              
                                </div>
                              </li>
                            <?php endwhile; else: ?>
                              <li class="item-pregunta">
                                <div class="box-preguntas">
                                  <?php if($busqueda != null) : ?>
                                    <div class="preguntas">                                  
                                      <p class="pregunta"> No hay resultados de la búsqueda...</p> 
                                    </div>
                                  <?php else : ?>
                                    <div class="preguntas">                                  
                                      <p class="pregunta"> No hay preguntas en está fase...</p> 
                                    </div>
                                  <?php endif; ?>                           
                                  
                                </div>                              
                              </li>
                            <?php endif; ?>                            
                          </ul>                          
                        </div>
                      </div>

                      <div class="item-foros hidden"> 
                        <H1>ZONA CHAT</H1>
                      </div>

                    </div>       
                  </div>
                <?php endfor; ?>	
              </section>	
              
            </div>            	
			    </div>
        </div>

			</div>
       <!--center  -->
    </div>
    <!-- hom-content -->
  </section>

  
  
 
<!-- ----- MODAL 1 ----- -->
<!-- ----- AÑADIR  ----- -->
  <div class="modal" id="modal1">
    <div class="body-modal">
      <form action="" class="frmbody" method="post">
        <h2 class="title">Crear una pregunta</h2>

        <div class="w100 container-wrap mg-bt10" >
          <input type="hidden" name="usuario_id" value="<?=$_SESSION['sesion_aprenDigital']['id']?>" id="usuario_id">
          <div class="w50 box-input">
            <label for="">Seleccionar Fase: </label>
            <select class="w70" name="faseid" id="faseid">
              <?php 
                $datos = selectalldatos($db, 'fases');
                if(!empty($datos) && mysqli_num_rows($datos) >= 1):
                  while($dato = mysqli_fetch_assoc($datos)):
              ?>
                <option value="<?=$dato['id']?>" >
                  <?=$dato['nombre']?>								
                </option>
              <?php endwhile; endif; ?>																
            </select>									
          </div>
          <div class="box-input w100">
            <label for="publicacion">Escribe aquí tu pregunta : </label>
            <textarea name="publicacion" class="publicacion" id="publicacion" maxlength="500" required></textarea>
            <span class="counter-2 counterpublicacion">500 caracteres</span>
          </div>
          <div id="info2"></div>				
                                    
          <div class="box-input hidden">
            <label for="imagen">Subir Imagen: </label>
            <input type="file" name="imagen" id="imagen">
          </div>							
        </div>			
        <button id="btnagregar" type="button" class="btn">Añadir Pregunta</button>
        <button id="btncancelar" type="button" class="btn" onclick="cerrarmodal();">Cancelar</button>
        
      </form>	
    </div>
  </div>

  <div class="modal" id="modal2">
    <div class="body-modal">
      <form action="" class="frmbody" method="post">
        <?php 
            $datos = obtenerpublicacionactivo($db, 'publicacion', $config);
            if(!empty($datos) && mysqli_num_rows($datos) >= 1):
              while($dato = mysqli_fetch_assoc($datos)):
          ?>
        <h2 class="title">Cambia tu pregunta</h2>
        <div class="w100 container-wrap mg-bt10" >
          <input type="hidden" name="usuario_id" value="<?=$_SESSION['sesion_aprenDigital']['id']?>" id="usuario_id">
          <div class="w50 box-input">
            <label for="">Seleccionar Fase: </label>
            <select class="w70" name="faseid" id="faseid">
              <?php 
                $fases = selectalldatos($db, 'fases');
                if(!empty($fases) && mysqli_num_rows($fases) >= 1):
                  while($fase = mysqli_fetch_assoc($fases)):
              ?>
                <option value="<?=$fase['id']?>" <?=($fase['id']) == $dato['fase_id'] ? 'selected="selected"': '' ?>>
                  <?=$fase['nombre']?>
                </option>
              <?php endwhile; endif; ?>																
            </select>									
          </div>
          <div class="box-input w100">
            <label for="publicacion">Escribe aquí tu pregunta : </label>
            <textarea name="publicacion" class="publicacion" id="publicacion" maxlength="500" required> <?=$dato['publicacion']?> 	 </textarea>
            <span class="counter-2 counterpublicacion">500 caracteres</span>
          </div>
          <div id="info2"></div>				
                                    
          <div class="box-input hidden">
            <label for="imagen">Subir Imagen: </label>
            <input type="file" name="imagen" id="imagen">
          </div>							
        </div>
        <?php endwhile; endif; ?>			
        <button id="btnagregar" type="button" class="btn">Añadir Pregunta</button>
        <button id="btncancelar" type="button" class="btn" onclick="cerrarmodal();">Cancelar</button>
        
      </form>	
    </div>
  </div>

  <script>
    const textarea = document.querySelectorAll("textarea");
    
    textarea.forEach((item, i) => {
      textarea[i].addEventListener("keyup", e => {
        textarea[i].style.height = "50px";
        let scheight = e.target.scrollHeight;
        //console.log(scheight);
        textarea[i].style.height = `${scheight}px`;
      });    
    });

    const comentario = document.querySelector("form .comentario"), 
    //maxlength = comentario.getAttribute("maxlength"),
    publicacion = document.querySelector(".frmbody .publicacion"), 
    maxlengtharea = publicacion.getAttribute("maxlength"),
    counterpublicacion = document.querySelector(".frmbody .counterpublicacion"); 

    publicacion.onkeyup = () =>{
      counterpublicacion.innerText = maxlengtharea - publicacion.value.length + ' caracteres.';
    }

    // comentario.onkeyup = () =>{    
    //   if(comentario.value.length > 400){
    //     return false;
    //   }
    // }

    $(document).ready(function(){    

      $('.nuevaPregunta').click(function(e){
        console.log("click");
        e.preventDefault();
        $("#modal1").fadeIn();
      });

    });

    
    $('#btnagregar').click(function(){
      if($("#publicacion").val() == ''){
        $("#info2").html("<div class='alerta-error'>Por favor ingresar una pregunta!</div>");
        $("#publicacion").focus;
        return false;
      }
      insert();
    });
    
    $('#buscar').keyup(function(){
      var busqueda = $("#buscar").val();
      //console.log(busqueda);    
      
      if(busqueda.length >= 1){
        //$("#info").html("<div class='alerta-error'></div>");
        $("#btnsearchs").html('<i class="fas fa-search-plus"></i>');
        $("#btnsearchs").css('color','#1c75bc');
      }else{
        $("#btnsearchs").css('color','#000');
      }
      
    });
  
    function reset(){	
      $(".frmbody")[0].reset();
    };

    function cerrarmodal(){
      $("#modal1").fadeOut();
      $("#modal2").fadeOut();
      reset();
    };

    function recarga(){
      location.reload();
    };

    // INSERTAR PUBLICACION
    function insert(){
      var datos = new FormData();
      datos.append('faseID', $("#faseid").val());
      datos.append('usuarioID', $("#usuario_id").val());
      datos.append('publicacion', $("#publicacion").val());
      datos.append('imagen', $("#imagen").val());
      // console.log(datos.get('faseID'));
      // console.log(datos.get('usuarioID'));
      // console.log(datos.get('publicacion'));

      $.ajax({
        type: "post",
        url : "models/add/foros-publicaciones-add.php",
        data : datos,
        processData:false,
        contentType:false,
        success: function(response){				
            $("#info").html("<div class='alerta-exito'>Tu pregunta a sido publicada!</div>");         
            reset();
            cerrarmodal();
            setInterval("recarga()",1000);   
        }
      });
    }

  </script>

  <?php include 'layout/footer.php'; ?>

</body>
</html>