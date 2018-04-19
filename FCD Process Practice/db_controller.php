<?php
  $pType = $_POST['p'];

  if(strcmp($pType,"1")==0){
  	 $project_id = $_POST['project_id'];
  	 $step_id = $_POST['step_id'];

  	 $connect = mysqli_connect("localhost", "root", "root", "fcd_decomposition_db");
  	 $sql = "SELECT * FROM steps_repo WHERE project_id = '" .$project_id. "' AND step_id = '" .$step_id. "'";
  	 $result = mysqli_query($connect,$sql);
  	 if(mysqli_num_rows($result)>0){
  	 	$row = mysqli_fetch_array($result);
  	 	$step = array(
            "step_name" => $row['step_name'],
            "step_reqs" => $row['step_reqs'],
            "step_methods" => $row['step_method_notes'],
            "step_expecs" => $row['step_expecs']
  	 	);

  	 	echo json_encode($step);
  	 }
  }
  else if(strcmp($pType,"2")==0){
     $project_id = $_POST['project_id'];
     $functionality_id = $_POST['functionality_id'];

     $connect = mysqli_connect("127.0.0.1", "root", "rootuserpwd", "fcd_decomposition_db");
     $sql = "SELECT fcd_id FROM functionality_list_repo WHERE project_id = '".$project_id."' AND functionality_id = '".$functionality_id."'";
     $result = mysqli_query($connect,$sql);
     //echo $sql;

     if(mysqli_num_rows($result)>0){
       $row = mysqli_fetch_array($result);
       echo $row['fcd_id'];
     }
     else{
       //echo mysqli_error($connect);
     }
  }
?>
