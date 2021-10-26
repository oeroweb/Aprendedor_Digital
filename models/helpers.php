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
	
	//DEPARTAMENTOS 
	function todosDepartamentos($conexion){
		$sql = "Select IdDepartamento, Departamento from departamentos ORDER BY Departamento ASC";

		$departamentos = mysqli_query($conexion, $sql);		
		if($departamentos && mysqli_num_rows($departamentos) >=1){
			$resultado = $departamentos;
		}
		return $resultado;
	}

	//PROVINCIAS 
	function todosProvincias($conexion){
		$sql = "Select IdProvincia, idDepartamento, Provincia from provincias ORDER BY provincia ASC";

		$provincias = mysqli_query($conexion, $sql);		
		if($provincias && mysqli_num_rows($provincias) >=1){
			$resultado = $provincias;
		}
		return $resultado;
	}

	//DEPARTAMENTOS 
	function todosDistritos($conexion){
		$sql = "Select IdDistrito, idprovincia, distrito from distritos ORDER BY distrito ASC";

		$distritos = mysqli_query($conexion, $sql);		
		if($distritos && mysqli_num_rows($distritos) >=1){
			$resultado = $distritos;
		}
		return $resultado;
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
	
	// obtener por grupo_id
	function selecttogrupoId($conexion, $tabla, $id){
		$sql = "SELECT * FROM $tabla WHERE grupo_id = $id ORDER by fase_id ASC";

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

	// obtener 1 usuarios de un grupo
	function selectuseringrupo($conexion, $tabla, $tabla2, $id){
		$sql = "SELECT * FROM $tabla gu INNER JOIN $tabla2 gd on gu.grupo_id = gd.grupo_id WHERE gu.usuario_id = $id 
		ORDER by gd.fase_id DESC LIMIT 1";

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}

	// OBTENER CURSOS ACTIVOS POR FASE
	function selectactivefasestocursos($conexion, $tabla, $tabla2, $id){
		$sql = "SELECT *, cursos.nombre as 'nombrecurso',cursos.id as 'idcursos' FROM $tabla INNER JOIN $tabla2
		on $tabla.id = $tabla2.fase_id
		WHERE $tabla.id = $id and $tabla2.estado_id = 1 ORDER BY cursos.orden";

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}
	
	// OBTENER CURSOS POR FASE
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
	
	// OBTENER CLASES activas POR FASE
	function selectactivefasestoclases($conexion, $tabla, $tabla2, $id){
		$sql = "SELECT *, clases.nombre as 'nombreclase' FROM $tabla INNER JOIN $tabla2
		on $tabla.id = $tabla2.fase_id
		WHERE $tabla.id = $id and $tabla2.estado_id = 1 
		order by $tabla2.orden asc";		

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}
	
	// OBTENER CLASES POR FASE
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
	
	// OBTENER CLASES POR FASE
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
	
	// OBTENER ALUMNOS SIN GRUPO Y SUS INSTITUCIONES
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

	// OBTENER datos POR CURSO_ID	
	function obtenerContenidoCurso($conexion, $tabla, $id){
		$sql = "SELECT * FROM $tabla where curso_id = $id order by orden asc";

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}
	
	// OBTENER datos POR CONTENT_ID	
	function obtenerdetalleContenido($conexion, $tabla, $id){
		$sql = "SELECT * FROM $tabla where cursoContenido_id = $id order by orden";

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}

	//OBTENER datos completos curso
	function obteneralldatoscursos($conexion, $id){
		$sql = "SELECT * FROM cursos c 
	INNER JOIN cursos_contenido cc on c.id = cc.curso_id
	INNER JOIN cursos_contenido_detalle ccd on cc.id = ccd.cursoContenido_id
	WHERE c.id = $id";

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}
	
	//OBTENER todos los Cursos por grupo y fase
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
	
	//OBTENER todos los Cursos de fase por grupo 
	function consultarcursosporgrupoyfase($conexion, $tabla, $tabla2, $curso_id, $grupo_id){
		$sql = "SELECT * FROM $tabla gd
		INNER join $tabla2 gdc
		on gd.id = gdc.grupoDetalle_id
		WHERE gdc.curso_id = $curso_id and gdc.grupoDetalle_id = $grupo_id";

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
	
	//LISTAR todos los usuarios y Cursos por grupo
	function listarallusuariosycursosporgrupo($conexion, $grupo_id){
		$sql = "SELECT gu.grupo_id, gu.usuario_id, gd.grupo_id, gd.fase_id, gdc.curso_id FROM grupos_usuarios gu 
		 INNER JOIN grupos_detalle gd
		 on gu.grupo_id = gd.grupo_id
		 INNER JOIN grupos_detalle_cursos gdc
		 on gd.id = gdc.grupoDetalle_id
		 WHERE gu.grupo_id = $grupo_id ORDER BY gu.usuario_id ASC";

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}

	//LISTAR todos los usuarios y Cursos por grupo
	function listarallusuariosycursosporgrupoyfase($conexion, $grupo_id, $fase_id){
		$sql = "SELECT gu.grupo_id, gu.usuario_id, u.nombre, u.ape_paterno, gd.grupo_id, gd.fase_id, gdc.id as 'grupodtcurso_id', gdc.curso_id, gdc.grupoDetalle_id, c.nombre as 'curso' FROM grupos_usuarios gu 
		INNER JOIN grupos_detalle gd
		on gu.grupo_id = gd.grupo_id
		INNER JOIN usuarios u
		on gu.usuario_id = u.id
		INNER JOIN grupos_detalle_cursos gdc
		on gd.id = gdc.grupoDetalle_id
		INNER JOIN cursos c 
		on gdc.curso_id = c.id
		WHERE gu.grupo_id = $grupo_id and gd.fase_id = $fase_id
		ORDER BY gu.usuario_id ASC;";

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}

	// OBTENER DATOS por usuario_id
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

	// OBTENER los cursos escogidos por fase
	function listarcursosescogidos($conexion, $tabla, $tabla2, $usuario_id, $fase_id){
		$sql = "SELECT * FROM $tabla gc
		INNER JOIN $tabla2 c
		on gc.curso_id = c.id
		WHERE usuario_id = $usuario_id and c.fase_id = $fase_id";

		$datos = mysqli_query($conexion, $sql);
		if($datos && mysqli_num_rows($datos) >=1){
			$resultado = $datos;
		}
		return $resultado;
	}


 ?>