<?php
  $project_id = $_POST['project_id'];
  $connect = mysqli_connect("localhost", "root", "root", "fcd_decomposition_db");
  $sql = "SELECT * FROM sprint_info WHERE project_id = '".$project_id."'";
  $result = mysqli_query($connect,$sql);
  $output = '';
  $output .= '
      <li id="addNewSprint" onclick="addSprint()" style="cursor: pointer;"><a>Add New Sprint</a></li>
  ';
  if(mysqli_num_rows($result)>0){
  	 while($row = mysqli_fetch_array($result)){
  	 	$output .= '<li id="'.$row['sprint_id'].'" class="sprintNum"><a>'.$row['sprint_name'].'</a></li>';
  	 }
  }

  echo $output;
?>