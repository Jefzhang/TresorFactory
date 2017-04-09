<?php
  require ("jsonUtil.php");
  $action = $_POST['action'];
  $row_id = key($_POST['data']);
  $data = $_POST['data']["$row_id"];
  if($action=="edit"){
    updateData($data);
    $response = editserverRespon($data);

  }else if($action=="remove"){

  }else if($action=="create"){


  }
  echo $response;

  file_put_contents("http.txt", $response, FILE_APPEND | LOCK_EX);

?>
