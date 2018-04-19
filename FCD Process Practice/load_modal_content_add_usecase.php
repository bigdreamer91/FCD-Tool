<?php
  
  $project_id = $_POST['project_id'];
  $sprint_id = $_POST['sprint_id'];
  $functionality_id = $_POST['functionality_id'];

  $connect = mysqli_connect("localhost", "root", "root", "fcd_decomposition_db");
  $output = '';
  $sql = "SELECT functionality_name FROM functionality_list_repo WHERE project_id = '".$project_id."' AND sprint_id <= '".$sprint_id."' AND functionality_id = '".$functionality_id."'";
  $result = mysqli_query($connect,$sql);
  if(mysqli_num_rows($result)>0){
  	 $row = mysqli_fetch_array($result);
  	 $output .= '
        <div style="margin-bottom: 30px; margin-top: 20px; height: 25px; width: 100%; text-align: left;">
                <div style="position: relative;">
                   <div style="position: absolute;">
                   Functionality: '.$row['functionality_name'].'
                   </div>
                   <div style="position: absolute; right: 5px;">
                   <input type="submit" name="" value="Add Usecase" id="addUsecaseModal">
                   </div>
                </div>
        </div>
        <div style="height: 400px; overflow: auto;">
                <table style="width: 100%" id="tableUsecasesModal">
                  <tr id="1">
                    <th style="width: 50%">Usecase</th>
                    <th style="width: 40%">Usecase Description</th>
                    <th style="width: 10%"></th>
                  </tr>
                </table>
        </div>
        <div style="margin: 10px 270px 0 270px; height: 25px;">
			<div style="position: relative;">
			   <div style="position: absolute; height: 25px; width: 100%; text-align: left;">
			      <input class="saveUsecase" id="save_usecase-'.$functionality_id.'" type="submit" value="Save" style="width:100%">
			   </div>
			</div>
	    </div>
  	 ';
  }
  echo $output;
?>