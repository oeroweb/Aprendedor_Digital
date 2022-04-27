<?php

  require_once '../../config/db.php';

  $query_values = $_POST;
  $extra_query = " ";

  if($query_values){
    $extra_query.= " AND ";
    $values = [];
    $queries = [];

    foreach ($query_values as $field_name => $field_value){
        foreach ($field_value as $value){
          $values[$field_name][] = " {$field_name} = '{$value}'";
        }
    }

    foreach ($values as $field_name => $field_values){
        $queries[$field_name] = "(".implode(" OR ", $field_values).")";
    }

    $extra_query.= " ".implode(" AND ", $queries);

  }


  $sql = "SELECT u.*, p.nombre as nombreperfil, i.nombre as nombreInstitucion, g.id as grupo_id, g.nombre as nombreGrupo FROM usuarios u 
  INNER JOIN perfil p on u.perfil_id = p.id
  INNER JOIN instituciones i on u.institucion_id = i.id
  INNER JOIN grupos_usuarios gu on u.id = gu.usuario_id
  INNER JOIN grupos g on gu.grupo_id = g.id WHERE u.estado_id = 1 " .$extra_query;

  $users = mysqli_query($db, $sql);

  $user_list = [];

  if(!empty($users) && mysqli_num_rows($users) >= 1){

    while($user = mysqli_fetch_assoc($users)){
      $user_list[$user["id"]] = $user;
    }
    echo json_encode($user_list);

  }else{
    echo 2;
  }
  