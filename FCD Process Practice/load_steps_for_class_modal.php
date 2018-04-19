<?php
   $project_id = $_POST['project_id'];
   $functionality_id = $_POST['functionality_id'];
   $class_id = $_POST['class_id'];
   $class_method_id = $_POST['class_method_id'];

   $connect = mysqli_connect("localhost", "root", "root", "fcd_decomposition_db");
   $output = '';
   $sql = "SELECT * FROM steps_repo WHERE project_id = '" .$project_id. "'";
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
		                          <input type="checkbox" name="" class="checkboxClassMethod" id="checkbox-' . $row["step_id"] . '-'.$functionality_id.'-'.$class_id.'-'.$class_method_id.'">
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

  echo $output;
?>