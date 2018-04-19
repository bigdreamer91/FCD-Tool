<?php
  $row_id = $_POST['row_id'];
  $project_id = $_POST['project_id'];
  $pType = $_POST['p'];

  $connect = mysqli_connect("localhost", "root", "root", "fcd_decomposition_db");
  $output = '';
  $sql = "SELECT * FROM steps_repo WHERE project_id = '" .$project_id. "' AND step_mapped = 'no'";
  $result = mysqli_query($connect,$sql);

  if(mysqli_num_rows($result)){
  	while($row = mysqli_fetch_array($result)){
  		if(strcmp($row["step_mapped"], "no")==0){
             $output .= '
		          <!-- load steps into modal -->
		          <div style="width: 450px; border: 1px solid black; text-align: center; background-color: #F9E79F; margin: 20px; float: left;">
		              <div style="border-bottom: 1px solid black;">
		                 <table style="width: 100%;">
		                    <tr>
		                       <td style="vertical-align: text-top; width: 10%;">
		                          <input type="checkbox" name="" class="checkboxStep" id="checkbox-' . $row["step_id"] . '-'.$row_id.'">
		                       </td>
		                       <td style="width: 75%; text-align: center;">'
		                         . $row["step_name"] . '
		                       </td>
		                    </tr>
		                    <tr>
		                       <td style="width: 20%;">
		                        Requirements:
		                       </td>
		                       <td style="width: 80%">
		                        <input type="text" name="" style="width: 100%" value="">
		                       </td>
		                    </tr>
		                    <tr>
		                       <td style="width: 20%;">
		                        Method Notes:
		                       </td>
		                       <td style="width: 80%">
		                        <textarea maxlength="5000" rows="3" style="width: 100%;" value=""></textarea>
		                       </td>
		                    </tr>
		                    <tr>
		                       <td style="width: 20%;">
		                        Expectations:
		                       </td>
		                       <td style="width: 80%">
		                        <input type="text" name="" style="width: 100%" value="">
		                       </td>
		                    </tr>
		                 </table>
		              </div>
		          </div>
        ';
  		}
  	}
  }


  if(strcmp($pType,"1")==0){
  $sql_class = "SELECT * FROM classes_repo WHERE project_id = '" .$project_id. "'";
  $result_class = mysqli_query($connect,$sql_class);

  if(mysqli_num_rows($result_class)){
  	while($row_class = mysqli_fetch_array($result_class)){
  		$output .= '
           <!-- load classes into modal -->
	          <div style="width: 450px; border: 1px solid black; text-align: center; background-color: #A8E5FE; margin: 20px; float: left;">
	             <div style="border-bottom: 1px solid black;">
	                <table style="width: 100%">
	                  <tr>
	                    <td colspan="2" style="text-align: center;">'
	                      . $row_class["class_name"] . '
	                    </td>
	                  </tr>
	                  <tr>
	                    <td style="width: 20%">
	                      Attributes:
	                    </td>
	                    <td style="width: 80%">
	                      <input type="text" name="" style="width: 100%" value="'. $row_class["class_attr"] .'">
	                    </td>
	                  </tr>
	                  <tr>
	                    <td style="width: 20%">
	                      Methods:
	                    </td>
	                  </tr>';
        $sql_method = "SELECT * FROM functionality_classes_methods_repo WHERE class_id = '" . $row_class["class_id"] . "' AND project_id = '" .$project_id. "'";
        $result_method = mysqli_query($connect,$sql_method);

        if(mysqli_num_rows($result_method)){
        	while($row_method = mysqli_fetch_array($result_method)){
        		$output .= '
                    <tr>
                      <td>
                        <input type="checkbox" name="" class="checkboxStep" id="checkbox-'.$row_method["existing_step_id"].'-'.$row_id.'" >
                      </td>
                      <td style="text-align: left;">
                         '.$row_method["class_method_name"].'
                      </td>
                    </tr>
        		';
        	}
        }

	    $output .=  '
	                </table>
	             </div>
	          </div>
  		';
  	}
  }
}
 
  echo $output;
  
?>