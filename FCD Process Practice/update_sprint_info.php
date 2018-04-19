<?php
  $sprint_id = $_POST['sprintid'];
  $sprint_name = $_POST['sprintname'];
  $project_id = $_POST['project_id'];
  $connect = mysqli_connect("localhost", "root", "root", "fcd_decomposition_db");
  $sql = "INSERT INTO sprint_info (sprint_id,sprint_name,project_id) VALUES('".$sprint_id."', '".$sprint_name."','".$project_id."')";
  $result = mysqli_query($connect,$sql);
  if(mysqli_num_rows($result)>0){
  	echo "success";
  }
?>