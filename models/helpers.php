<?php 

	function mostrarError($errores, $campo){
		$alerta = '';
		if(isset($errores[$campo]) && !empty($campo)){
			$alerta = "<div class='alerta alerta-error'>" .$errores[$campo]."</div>";			
		}
		return $alerta;
	}

	function borrarErrores(){
		$borrado = false;		

		if(isset($_SESSION['errores'])){
			$_SESSION['errores'] = null;
			$borrado = true;
		}

		if(isset($_SESSION['completado'])){
			$_SESSION['completado'] = null;
			$borrado = true;
		}

		if(isset($_SESSION['fallo'])){
			$_SESSION['fallo'] = null;
			$borrado = true;
		}

		if(isset($_SESSION['errores_usuario'])){
			$_SESSSION['errores_usuario'] = null;
			$borrado = true;
		}

		return $borrado;
	}
	
	// GENERANDO TOKEN
	function generandoTokenClave($length = 20) {
    return substr(str_shuffle(str_repeat($x='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklymopkz', ceil($length/strlen($x)) )),1,$length);
	}	

	// USUARIO
	function todosUsuarios($conexion, $perfil){
		//$sql = "SELECT * FROM usuarios where id = $perfil";
		$sql = "SELECT *, year(now()) as Año, year(CURDATE())-YEAR(fec_nacimiento)+ IF(DATE_FORMAT(CURDATE(),'%m-%d') > DATE_FORMAT(fec_nacimiento,'%m-%d'),0,-1) AS edad FROM usuarios where id = $perfil";

		$usuario = mysqli_query($conexion, $sql);
		if($usuario && mysqli_num_rows($usuario) >=1){
			$resultado = $usuario;
		}
		return $resultado;
	}
	
	// OBTENER DATOS por id
	function obtenerdatos($conexion, $tabla, $id){
		$sql = "SELECT * FROM $tabla where id = $id";

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}
	
	// OBTENER DATOS ACTIVO por id
	function obtenerdatosactivo($conexion, $tabla, $id){
		$sql = "SELECT * FROM $tabla where id = $id and estado_id = 1";

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}
	
	// OBTENER DATOS ESTADO 1
	function selectactivedatos($conexion, $tabla){
		$sql = "SELECT * FROM $tabla where estado_id = 1";

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}

	// obtener todos
	function selectalldatos($conexion, $tabla){
		$sql = "SELECT * FROM $tabla";

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}
	
	// obtener por grupo_id - grupos content
	function selecttogrupoId($conexion, $tabla, $id){
		$sql = "SELECT * FROM $tabla WHERE grupo_id = $id ORDER by fase_id ASC";

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}
	
	function selecttogrupoIdlimit($conexion, $tabla, $id){
		$sql = "SELECT * FROM $tabla WHERE grupo_id = $id ORDER by fase_id ASC limit 1";

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}
	
	// obtener todos los usuarios de un grupo
	function selectallusergrupo($conexion, $tabla, $tabla2, $id){
		$sql = "SELECT gu.*, gu.id as 'myid' ,  u.*, u.id as 'idusuario' FROM $tabla gu INNER JOIN $tabla2 u on gu.usuario_id = u.id WHERE gu.grupo_id = $id ORDER by u.ape_paterno";

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}

	// OBTENER CURSOS ACTIVOS POR FASE - Cursos
	function selectactivefasestocursos($conexion, $tabla, $tabla2, $id){
		$sql = "SELECT *, cursos.id as 'idCurso', cursos.nombre as 'nombrecurso',cursos.id as 'idcursos' 
		FROM $tabla INNER JOIN $tabla2
		on $tabla.id = $tabla2.fase_id
		WHERE $tabla.id = $id and $tabla2.estado_id = 1 ORDER BY cursos.orden";

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}
	
	// OBTENER CURSOS POR FASE - admin cursos
	function selectfasestocursos($conexion, $tabla, $tabla2, $id){
		$sql = "SELECT *, cursos.nombre as 'nombrecurso',cursos.id as 'idcursos' FROM $tabla INNER JOIN $tabla2
		on $tabla.id = $tabla2.fase_id
		WHERE $tabla.id = $id ORDER BY cursos.orden";

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}
	
	// OBTENER CLASES activas POR FASE - clases maestras / cursos
	function selectactivefasestoclases($conexion, $tabla, $tabla2, $id){
		$sql = "SELECT *, clases.id as 'idClase', clases.nombre as 'nombreclase' 
		FROM $tabla INNER JOIN $tabla2
		on $tabla.id = $tabla2.fase_id
		WHERE $tabla.id = $id and $tabla2.estado_id = 1 
		order by $tabla2.orden asc";		

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}
	
	// OBTENER CLASES POR FASE - admin clases maestras
	function selectfasestoclases($conexion, $tabla, $tabla2, $id){
		$sql = "SELECT *, clases.nombre as 'nombreclase' FROM $tabla INNER JOIN $tabla2
		on $tabla.id = $tabla2.fase_id
		WHERE $tabla.id = $id 
		order by $tabla2.orden asc";		

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}
	
	// OBTENER CLASES POR FASE  - grupo usuarios add
	function selecusuariostoinstituciones($conexion, $tabla, $tabla2){
		$sql = "SELECT t1.*, t2.nombre as nombreInstitucion FROM $tabla t1 INNER JOIN $tabla2 t2
		on t1.institucion_id = t2.id
		WHERE t1.estado_id = 1 and t1.perfil_id = 4";

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}
	
	// OBTENER ALUMNOS SIN GRUPO Y SUS INSTITUCIONES - grupo usuarios add
	function selecusuariosNotGrupo($conexion){
		$sql = "SELECT u.id, u.nombre, u.ape_paterno,u.ape_materno, u.email, gu.grupo_id, p.nombre as nombreperfil, i.nombre as nombreinstitucion FROM usuarios u 
		INNER JOIN perfil p 
		on u.perfil_id = p.id
		LEFT JOIN grupos_usuarios gu
		on u.id = gu.usuario_id
		INNER JOIN instituciones i 
		on u.institucion_id = i.id
		WHERE gu.grupo_id is null and u.perfil_id = 4 and u.estado_id = 1";

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}

	// OBTENER datos POR CURSO_ID	- admin-cursos / clases / cursos-content
	function obtenerContenidoCurso($conexion, $tabla, $id){
		$sql = "SELECT * FROM $tabla where curso_id = $id order by orden asc";

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}
	
	// OBTENER datos POR CONTENT_ID	 - clases - clasesm - cursos-content
	function obtenerdetalleContenido($conexion, $tabla, $id){
		$sql = "SELECT * FROM $tabla where cursoContenido_id = $id order by orden";

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}
	
	//OBTENER todos los Cursos por grupo y fase - grupo-cursos-add
	function obtenerallcursosporgrupoyfase($conexion, $tabla, $tabla2, $fase_id, $grupo_id){
		$sql = "SELECT * FROM $tabla gf 
	INNER JOIN $tabla2 c on gf.fase_id = c.fase_id	
	WHERE gf.fase_id = $fase_id and c.fase_id = $fase_id and grupo_id = $grupo_id";

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}
	
	//LISTAR todos los Cursos de fase por grupo
	function listarcursosxfasedeporgrupo($conexion, $tabla, $tabla2, $grupofase_id){
	 	$sql = "SELECT *, gc.id as myid FROM $tabla gc
		 INNER JOIN $tabla2 c 
		 on gc.curso_id = c.id
		 WHERE gc.grupofase_id = $grupofase_id";

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}
	
	//LISTAR todas las Clases maestras de fase por grupo - grupos-content-fases
	function listarclasesxfasedeporgrupo($conexion, $tabla, $tabla2, $grupofase_id){
	 	$sql = "SELECT *, gc.id as myid FROM $tabla gc
		 INNER JOIN $tabla2 c 
		 on gc.clase_id = c.id
		 WHERE gc.grupofase_id = $grupofase_id";

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}
	
	//LISTAR todos los usuarios y Cursos por grupo - grupo content / listadocursos-add
	function listarallusuariosycursosporgrupo($conexion, $grupo_id){
			$sql = "SELECT guc.id, guc.grupo_id, guc.fase_id, gu.acceso_id, u.nombre, u.ape_paterno, u.ape_materno, c.nombre as 'Curso'
			FROM grupos_usuarios_cursos guc 
			INNER JOIN cursos c
			on guc.curso_id = c.id
			INNER JOIN usuarios u
			on guc.usuario_id = u.id
			INNER JOIN grupos_cursos gu
			on guc.grupocurso_id = gu.id
			WHERE guc.grupo_id = $grupo_id ORDER BY u.ape_paterno ASC";

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}

	//LISTAR todos los usuarios y Cursos por grupo - grupo-content / listadocursos-add
	function listarallusuariosyclasesporgrupo($conexion, $grupo_id){
			$sql = "SELECT guc.id, guc.grupo_id, guc.fase_id, gu.acceso_id, u.nombre, u.ape_paterno, u.ape_materno, c.nombre as 'Clases'
			FROM grupos_usuarios_clases guc 
			INNER JOIN clases c
			on guc.clase_id = c.id
			INNER JOIN usuarios u
			on guc.usuario_id = u.id
			INNER JOIN grupos_clases gu
			on guc.grupoclases_id = gu.id
			WHERE guc.grupo_id = $grupo_id ORDER BY u.ape_paterno ASC";

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}

	//LISTAR todos los usuarios y Cursos por grupo - listado cursos add
	function listarallusuariosycursosporgrupoyfase($conexion, $grupo_id, $fase_id){
		$sql = "SELECT gu.grupo_id, gu.usuario_id, u.nombre, u.ape_paterno, u.ape_materno, gf.grupo_id, gf.fase_id, gdc.id as 'grupoFaseCurso_id', gdc.curso_id, gdc.grupofase_id, gdc.acceso_id as 'accesoCurso', c.nombre as 'curso' FROM grupos_usuarios gu 
		INNER JOIN grupos_fases gf
		on gu.grupo_id = gf.grupo_id
		INNER JOIN usuarios u
		on gu.usuario_id = u.id
		INNER JOIN grupos_cursos gdc
		on gf.id = gdc.grupofase_id
		INNER JOIN cursos c 
		on gdc.curso_id = c.id
		WHERE gu.grupo_id = $grupo_id and gf.fase_id = $fase_id
		ORDER BY gu.usuario_id ASC;";

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}

	//LISTAR todos los usuarios y Cursos por grupo - listado cursos all
	function listarallusuariosyallcursosporgrupo($conexion, $grupo_id){
		$sql = "SELECT gu.grupo_id, gu.usuario_id, u.nombre, u.ape_paterno, u.ape_materno, gf.grupo_id, gf.fase_id, gdc.id as 'grupoFaseCurso_id', gdc.curso_id, gdc.grupofase_id, gdc.acceso_id as 'accesoCurso', c.nombre as 'curso' FROM grupos_usuarios gu 
		INNER JOIN grupos_fases gf
		on gu.grupo_id = gf.grupo_id
		INNER JOIN usuarios u
		on gu.usuario_id = u.id
		INNER JOIN grupos_cursos gdc
		on gf.id = gdc.grupofase_id
		INNER JOIN cursos c 
		on gdc.curso_id = c.id
		WHERE gu.grupo_id = $grupo_id
		ORDER BY gu.usuario_id ASC;";

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}

	//LISTAR todos los usuarios y Cursos por grupo - listado clases add
	function listarallusuariosyclasesporgrupoyfase($conexion, $grupo_id, $fase_id){
		$sql = "SELECT gu.grupo_id, gu.usuario_id, u.nombre, u.ape_paterno, u.ape_materno, gf.grupo_id, gf.fase_id, gdc.id as 'grupoFaseClase_id', gdc.clase_id, gdc.grupofase_id, gdc.acceso_id as 'accesoClase', c.nombre as 'clasemaestra' 
		FROM grupos_usuarios gu 
		INNER JOIN grupos_fases gf
		on gu.grupo_id = gf.grupo_id
		INNER JOIN usuarios u
		on gu.usuario_id = u.id
		INNER JOIN grupos_clases gdc
		on gf.id = gdc.grupofase_id
		INNER JOIN clases c 
		on gdc.clase_id = c.id
		WHERE gu.grupo_id = $grupo_id and gf.fase_id = $fase_id 
		ORDER BY gu.usuario_id ASC;";

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}

	//LISTAR todos los usuarios y Cursos por grupo - listado clases add
	function listarallusuariosyallclasesporgrupoyfase($conexion, $grupo_id){
		$sql = "SELECT gu.grupo_id, gu.usuario_id, u.nombre, u.ape_paterno, u.ape_materno, gf.grupo_id, gf.fase_id, gdc.id as 'grupoFaseClase_id', gdc.clase_id, gdc.grupofase_id, gdc.acceso_id as 'accesoClase', c.nombre as 'clasemaestra' 
		FROM grupos_usuarios gu 
		INNER JOIN grupos_fases gf
		on gu.grupo_id = gf.grupo_id
		INNER JOIN usuarios u
		on gu.usuario_id = u.id
		INNER JOIN grupos_clases gdc
		on gf.id = gdc.grupofase_id
		INNER JOIN clases c 
		on gdc.clase_id = c.id
		WHERE gu.grupo_id = $grupo_id 
		ORDER BY gu.usuario_id ASC;";

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}

	// OBTENER DATOS por usuario_id - cursos / perfil
	function obtenerdatosusuarios($conexion, $tabla, $id){
		$sql = "SELECT * FROM $tabla where usuario_id = $id";

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}

	// OBTENER los cursos no escogidos por fase 
	function listarcursosnoescogidos($conexion, $tabla, $tabla2, $fase_id){
		$sql = "SELECT * from $tabla c
		left JOIN $tabla2 guc
		on c.id = guc.curso_id
		WHERE guc.curso_id is null and c.fase_id = $fase_id";

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}

	// OBTENER los cursos escogidos por fase -- cursos
	function listarcursosescogidos($conexion, $tabla, $tabla2, $tabla3, $usuario_id, $fase_id){
		$sql = "SELECT g.estado_id, guc.usuario_id, guc.token, c.fase_id,c.id as curso_id, c.nombre, c.imagen, guc.acceso_id FROM $tabla guc
		INNER JOIN $tabla2 c
		on guc.curso_id = c.id
    INNER JOIN $tabla3 gc
    on guc.grupocurso_id = gc.id
		INNER JOIN grupos g 
    on guc.grupo_id = g.id
		WHERE guc.usuario_id = $usuario_id and c.fase_id = $fase_id and g.estado_id = 1";

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}
	
	// OBTENER los clases escogidos por fase -- cursos
	function listarclasescogidos($conexion, $tabla, $tabla2, $tabla3, $usuario_id, $fase_id){
		$sql = "SELECT g.estado_id, guc.usuario_id, guc.token, c.fase_id, c.id as clase_id, c.nombre, c.carpeta, c.imagen, guc.acceso_id 
		FROM $tabla guc
		INNER JOIN $tabla2 c
		on guc.clase_id = c.id
    INNER JOIN $tabla3 gc
    on guc.grupoclases_id = gc.id
		INNER JOIN grupos g 
    on guc.grupo_id = g.id
		WHERE guc.usuario_id = $usuario_id and c.fase_id = $fase_id and g.estado_id = 1";

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}

	//REPRODUCION DE VIDEO
	// TRAER CURSO Y VALIDAR TOKEN
	function mostarcursosytoken($conexion, $tabla, $tabla2, $curso_id, $usuario_id, $token){
		$sql = "SELECT guc.*, c.nombre as 'nombrecurso', c.descripcion as 'descripcioncurso', c.imagen as 'imagencurso' 
		FROM $tabla guc
		INNER JOIN $tabla2 c 
		on guc.curso_id = c.id
		WHERE curso_id = $curso_id AND usuario_id = $usuario_id and token = '$token'";

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}

	// TRAER CURSO Y VALIDAR SIN TOKEN - clasesad
	function mostarcursos($conexion, $tabla, $tabla2, $curso_id, $usuario_id){
		$sql = "SELECT guc.*, c.nombre as 'nombrecurso', c.descripcion as 'descripcioncurso', c.imagen as 'imagencurso' 
		FROM $tabla guc
		INNER JOIN $tabla2 c 
		on guc.curso_id = c.id
		WHERE curso_id = $curso_id AND usuario_id = $usuario_id";

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}

	// TRAER CURSO COMPLETO
	function mostarcursoscompleto($conexion, $curso_id, $usuario_id){
		$sql = "SELECT guc.id as 'grupousuarioscurso_id', guc.usuario_id, guc.curso_id, guc.token, c.nombre as 'nombrecurso', c.imagen as 'imagencurso', cc.nombre as 'nombrecapitulo', cc.descripcion as 'descripcioncapitulo', ccd.id as 'cursoContenidoDetale_id', ccd.* FROM grupos_usuarios_cursos guc
		INNER JOIN cursos c 
		ON guc.curso_id = c.id
		INNER JOIN cursos_contenido cc 
		on c.id = cc.curso_id
		INNER JOIN cursos_contenido_detalle ccd
		on cc.id = ccd.cursoContenido_id
		WHERE guc.usuario_id = $usuario_id and guc.curso_id = $curso_id";

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}

	// TRAER CLASES MAESTRAS Y VALIDAR TOKEN
	function mostarclasescompletasytoken($conexion, $tabla, $tabla2, $clase_id, $usuario_id, $token){
		$sql = "SELECT * FROM $tabla guc
		INNER JOIN $tabla2 c 
		on guc.clase_id = c.id
		WHERE clase_id = $clase_id AND usuario_id = $usuario_id and token = '$token'";

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}

	// TRAER TODAS LAS PUBLICACIONES POR FASES
	function mostarplublicacionesxfases($conexion, $tabla, $tabla2, $fase_id, $busqueda = null ){
		$sql = "SELECT *, p.fechacreacion as 'fechapublicacion' FROM $tabla p 
		INNER JOIN $tabla2 u 
		on p.usuario_id = u.id";

		if(!empty($busqueda)){
			$sql .= " where fase_id = $fase_id AND p.estado_id = 1 and p.publicacion LIKE '%$busqueda%'";
		}else{
			$sql .= " WHERE fase_id = $fase_id AND p.estado_id = 1";
		}
		
		$sql .=" ORDER BY p.idpublicacion DESC";

		//echo $sql;
		//die();


		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}	

	// TRAER TODAS LOS COMENTARIOS
	function mostarcomentariosxpublicacione($conexion, $tabla, $tabla2, $publicacion_id ){
		$sql = "SELECT * FROM $tabla c 
		INNER JOIN $tabla2 u
		on c.usuario_id = u.id
		WHERE publicacion_id = $publicacion_id and c.estado_id = 1
		ORDER by idcomentario DESC";

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}	

	// OBTENER DATOS ACTIVO por id
	function obtenerpublicacionactivo($conexion, $tabla, $id){
		$sql = "SELECT * FROM $tabla where idpublicacion = $id and estado_id = 1";

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}

 ?>