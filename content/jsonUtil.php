<?php

function getGeneralInfofActivi($jsonFile){
  //$obj = JSON.parse($jsonFile);

  $listActi = array();
  foreach($jsonFile["activities"] as $acti){
    $simple = simplifyActivi($acti);
    /*$i=1;
    foreach($simple as $term){
      $listActi=$listActi."<tr><th scope=\"row\">".$i."</th>";
      $listActi=$listActi."<td>".$term["date"]."</td>";
      $listActi=$listActi."<td>".$term["name"]."</td>";
      $listActi=$listActi."<td>".$term["recette"]."</td>";
      $listActi=$listActi."<td>".$term["depence"]."</td>";
      $listActi=$listActi."<td>".$term["remboursement"]."</td>";
      $listActi=$listActi."<td><a href=\"javascript:;\" onclick=\"\">Detaille</a></td>";
      $listActi=$listActi."</tr>";
      $i++;
    }*/
    array_push($listActi,$simple);
  }
  $newJson = array("data"=>$listActi);
  //return json_encode($newJson);
  return json_encode($newJson);

}
function simplifyActivi($acti){
  //$simple = array("date"=>$acti.date,"name"=>$acti.name,"recette"=>$acti.recette,"depence"=>$acti.depence,"remboursement"=>$acti.remboursement);
  $simple = array_slice($acti,0,6);
  return $simple;
}

function getSingleInfoActivi($jsonFile,$name){
  //$activity={};
  $activity;
  foreach($jsonFile["data"] as $acti){
    if($acti["name"]==$name){
      $activity=$acti;
      break;
    }
  }
  return json_encode($activity);
}

function editserverRespon($data){
  $dataArray = array("DT_RowId"=>$row_id,"name"=>$data["name"],"date"=>$data["date"],"description"=>$data["description"],"recette"=>$data["recette"],"depence"=>$data["depence"],"profit"=>$data["profit"]);
  $result[]=$dataArray;
  $actiData['data'] = $result;
  $result = json_encode($actiData);
  echo $result;
}

 ?>
