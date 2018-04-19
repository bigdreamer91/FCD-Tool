<?php
  $project_id = $_POST['project_id'];
  $sprint_id = $_POST['sprint_id'];
  $functionality_id = $_POST['functionality_id'];
  $usecase_id = $_POST['usecase_id'];

  $connect = mysqli_connect("localhost", "root", "root", "fcd_decomposition_db");
  $output = '';
  $sql = "SELECT functionality_name FROM functionality_list_repo WHERE project_id = '".$project_id."' AND sprint_id <= '".$sprint_id."' AND functionality_id = '".$functionality_id."'";
  $result = mysqli_query($connect,$sql);
  if(mysqli_num_rows($result)>0){
  	 $row = mysqli_fetch_array($result);
  	 $sql_usecase = "SELECT usecase_name FROM functionality_usecases_repo WHERE project_id = '".$project_id."' AND sprint_id = '".$sprint_id."' AND functionality_id = '".$functionality_id."' AND usecase_id = '".$usecase_id."'";
  	 $result_usecase = mysqli_query($connect,$sql_usecase);
  	 if(mysqli_num_rows($result_usecase)>0){
  	 	$row_usecase = mysqli_fetch_array($result_usecase);
  	 	$output .= '
	         <div style="margin-bottom: 30px; margin-top: 20px; height: 25px; width: 100%; text-align: left;">
	                <div style="position: relative;">
	                   <div style="position: absolute;">
	                   Functionality: '.$row['functionality_name'].'
	                   </div>
	                   <div style="position: absolute; right: 5px;">
	                   <input type="submit" name="" value="Add Step" id="addStepsModal">
	                   </div>
	                </div>
	         </div>
	         <div style="margin-bottom: 30px; margin-top: 20px; height: 25px; width: 100%; text-align: left;">
	                <div style="position: relative;">
	                   <div style="position: absolute;">
	                   Usecase: '.$row_usecase['usecase_name'].'
	                   </div>
	                </div>
	        </div>
	        <div style="height: 400px; overflow: auto;">
                <table style="width: 100%" id="tableStepsModal">
                  <tr id="1">
                    <th style="width: 10%">Existing_step_id</th>
                    <th style="width: 20%;text-align:center;">Method_name</th>
                    <th style="width: 20%;text-align:center;">Method_reqs</th>
                    <th style="width: 20%;text-align:center;">Method_notes</th>
                    <th style="width: 20%;text-align:center;">Method_expecs</th>
                    <th style="width: 5%"></th>
                    <th style="width: 5%"></th>
                  </tr>
                </table>
            </div>
          <div style="margin: 10px 270px 0 270px; height: 25px;">
			    <div style="position: relative;">
			        <div style="position: absolute; height: 25px; width: 100%; text-align: left;">
			          <input class="saveStep" id="save_step-'.$functionality_id.'-'.$usecase_id.'" type="submit" value="Save" style="width:100%">
			        </div>
			    </div>
	        </div>
  	    ';
  	 }
  }

  echo $output;
?>