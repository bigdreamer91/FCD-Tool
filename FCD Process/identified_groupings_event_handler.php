<?php
   $project_id = $_POST['project_id'];
   $sprint_id = $_POST['sprint_id'];
   $functionality_id = $_POST['functionality_id'];

   $pType = $_POST['p'];
   $connect = mysqli_connect("localhost", "root", "root", "fcd_decomposition_db");

   if(strcmp($pType,"1")==0){
   	  $sql_class = "SELECT * FROM functionality_classes_repo WHERE project_id = '" .$project_id. "' AND sprint_id <= '" .$sprint_id. "' AND functionality_id = '" .$functionality_id. "' AND group_mapped <> 'yes'";
	  $result_func_class = mysqli_query($connect,$sql_class);
      
	  if(mysqli_num_rows($result_func_class)){
        $output .= '<table style="width:100%">';

	  	while($row_func_class = mysqli_fetch_array($result_func_class)){
	  		$sql_class_detail = "SELECT * FROM classes_repo WHERE project_id = '" .$project_id. "' AND class_id = '" .$row_func_class['class_mapped_id']. "'";
	  		$result_class_detail = mysqli_query($connect,$sql_class_detail);
	  		$output .= '<tr>';
	  		if(mysqli_num_rows($result_class_detail)>0){
	  			   $row_class = mysqli_fetch_array($result_class_detail);
                   $output .= '
                          <td>
			           <!-- load classes into modal -->
				          <div style="width: 450px; border: 1px solid black; text-align: center; background-color: #A8E5FE; margin: 20px;">
				             <div style="border-bottom: 1px solid black;">
				              
				                <table style="width: 100%">
				                  <tr>
				                    <td>
			                          <input type="checkbox" name="" class="checkboxGroups" id="checkboxGroupClass-'.$functionality_id.'-'.$row_class['class_id'].'" >
			                        </td>
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
				                </td>';
		    }

		    $row_func_class = mysqli_fetch_array($result_func_class);
		    $sql_class_detail = "SELECT * FROM classes_repo WHERE project_id = '" .$project_id. "' AND class_id = '" .$row_func_class['class_mapped_id']. "'";
	  		$result_class_detail = mysqli_query($connect,$sql_class_detail);
	  		if(mysqli_num_rows($result_class_detail)>0){
	  			   $row_class = mysqli_fetch_array($result_class_detail);
                   $output .= '
				                <td>
			           <!-- load classes into modal -->
				          <div style="width: 450px; border: 1px solid black; text-align: center; background-color: #A8E5FE; margin: 20px;">
				             <div style="border-bottom: 1px solid black;">
				              
				                <table style="width: 100%">
				                  <tr>
				                    <td>
			                          <input type="checkbox" name="" class="checkboxGroups" id="checkboxGroupClass-'.$functionality_id.'-'.$row_class['class_id'].'" >
			                        </td>
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
				                </td>';
		    }
		    $output .= '</tr>';
	  	}
        $output .= '</table>';
	  }

	  $output .= '
           <div style="margin: 10px 270px 0 270px; height: 25px;">
		    <div style="position: relative;">
		        <div style="position: absolute; height: 25px; width: 100%; text-align: left;">
		          <input class="saveGroup" id="save_step-'.$functionality_id.'" type="submit" value="Save" style="width:100%">
		        </div>
		    </div>
          </div>
	  ';

	  echo $output;
   }
   else if(strcmp($pType,"2")==0){
   	  $classes_list = $_POST['classes'];

   	  $output = '';
   	  $sql_functionality = "SELECT functionality_name FROM functionality_list_repo WHERE project_id = '" .$project_id. "' AND sprint_id <= '" .$sprint_id. "' AND functionality_id = '" .$functionality_id. "'";
   	  $result_functionality = mysqli_query($connect,$sql_functionality);
   	  if(mysqli_num_rows($result_functionality)>0){
   	  	$row_functionality = mysqli_fetch_array($result_functionality);
   	  	$output .='
           <table style="width:100%">
             <tr>
               <td>
                 <div style="padding-left: 10px; margin: 20px; margin-bottom:none; height: 30px; border: 1px solid black; background-color: #F9E79F;">
                        <div style="position: relative;">
                          <div style="position: absolute; width: 100%">
                            Functionality: '.$row_functionality['functionality_name'].'
                          </div>
                        </div>
				  </div>
               </td>
             </tr>
             <tr>
               <td>
                 <div style="padding-left: 10px; margin:20px; margin-top:none; height: 30px; border: 1px solid black; background-color: #F9E79F;">
                        <div style="position: relative;">
                          <div style="position: absolute; width: 100%">
                            Group Name: <input type="text" id="groupNameInp-'.$functionality_id.'" style="width:80%" value="">
                          </div>
                        </div>
				  </div>
               </td>
             </tr>
             <tr>
             <td>
             <table style="width:80%; margin: 20px;">
             <tr>
             <th>class id</th>
             <th>class name</th>
             <th></th>
             </tr>
   	  ';

	   	 foreach ($classes_list as $value) {
	   	  	 $sql = "SELECT * FROM classes_repo WHERE project_id = '" .$project_id. "' AND class_id = '" .$value. "'";
	   	  	 $result = mysqli_query($connect,$sql);
	   	  	 if(mysqli_num_rows($result)>0){
	   	  	 	$row = mysqli_fetch_array($result);
	   	  	 	$output .= '
                    <tr>
                      <td class="groupedClassesList">'.$row['class_id'].'</td>
                      <td class="groupedClassNameList">'.$row['class_name'].'</td>
                      <td><input type="submit" value="delete"></td>
                    </tr>
	   	  	 	';
	   	  	 }
	   	  }
        $output .= '</table>
                    </td>
			        </tr>
			        </table>';

	    $output .= '
           <div style="margin: 10px 270px 0 270px; height: 25px;">
		    <div style="position: relative;">
		        <div style="position: absolute; height: 25px; width: 100%; text-align: left;">
		          <input class="saveGroupIntoDB" id="save_step-'.$functionality_id.'" type="submit" value="Save" style="width:100%">
		        </div>
		    </div>
          </div>
	  ';

   	  }
   	  echo $output;
   }
   else if(strcmp($pType,"3")==0){
   	  $classes_list = json_decode($_POST['classes'],true);
   	  print_r($classes_list);
   	  $group_name = $_POST['group_name'];
   	  echo "grou_name -- " . $group_name;
   	  $output = '';

   	  $sql_group_id = "SELECT group_id FROM groups_repo WHERE project_id = '" .$project_id. "' ORDER BY group_id DESC LIMIT 1";
   	  $result_group_id = mysqli_query($connect,$sql_group_id);
   	  $val_group_id = 0;

   	  if(mysqli_num_rows($result_group_id)>0){
   	  	$row_group_id = mysqli_fetch_array($result_group_id);
   	  	$val_group_id = $row_group_id['group_id'];
   	  }

   	  $val_group_id = $val_group_id + 1;
   	  echo "new group id - " . $val_group_id;

   	  $sql_insert_group = "INSERT INTO groups_repo (project_id,group_id,group_name) VALUES('" .$project_id. "','" .$val_group_id. "','" .$group_name. "')";
   	  $result_insert_group = mysqli_query($connect,$sql_insert_group);
   	  echo mysqli_error($connect);
   	  if($result_insert_group){
         $sql_insert_into_group = "INSERT INTO functionality_groupings_repo (project_id,sprint_id,functionality_id,group_id,group_name) VALUES('" .$project_id. "','" .$sprint_id. "','" .$functionality_id. "','" .$val_group_id. "','" .$group_name. "')";
         $result_insert_into_group = mysqli_query($connect,$sql_insert_into_group);
         echo mysqli_error($connect);
         if($result_insert_into_group){
		         	$output .= '
                                 <div class="functionality_groupings-'.$functionality_id.'" style="margin: 10px 30px 0 30px; border: 1px solid black; height: 25px; display:none;">
							       <div style="position: relative;">
							          <div style="position: absolute; height: 25px; background-color: #A8E5FE; width: 100%">'.$group_name.'</div>
							          <div style="position: absolute; right: 5px;">
							          <icon class="material-icons" style="font-size: 20px; cursor: pointer;">cancel</icon>
							          </div>
							          <div style="position: absolute; right: 30px;">
							          <icon class="material-icons" style="font-size: 20px; cursor: pointer;">create</icon>
							          </div>
							          <div style="position: absolute; right: 55px;">
							          <icon class="material-icons" style="font-size: 20px; cursor: pointer;">add</icon>
							          </div>
							       </div>
							     </div>
		                       ';
		            $output .= '
                               <div class="functionality_groupings-'.$functionality_id.'" style="margin: 0px 30px 10px 30px; display:none;">
						         <table style="width: 100%; border: 1px solid black;">
                        	';
		            foreach ($classes_list as $key=>$value) {
		            	$sql_update = "UPDATE functionality_classes_repo SET group_mapped = 'yes', group_mapped_id = '" .$val_group_id. "' WHERE project_id = '" .$project_id. "' AND $sprint_id = '".$sprint_id."' AND functionality_id = '".$functionality_id."' AND class_mapped_id = '".$classes_list[$key]['class_id']."'";
		            	$result_update = mysqli_query($connect,$sql_update);
		            	if($result_update){
		                    $output .= '
                                     <tr id="group_class-'.$functionality_id.'-'.$classes_list[$key]['class_id'].'">
							       	    <td style="padding-left: 15px;">
							       	      <div style="height: 20px;">
							       	         <div style="position: relative;">
							       	            <div style="position: absolute; width: 100%;">'.$classes_list[$key]['class_name'].'</div>
							       	            <div style="position: absolute; right: 5px;">
							       	              <i class="material-icons cancelGroupClassName" id="cancelGroupClass-'.$functionality_id.'-'.$classes_list[$key]['class_id'].'" style="font-size: 20px; cursor: pointer;">cancel</i>
							       	            </div>
							       	         </div>
							       	      </div>
							       	    </td>
							       	 </tr>
		                             ';
		            	}
		            }
		            $output .= '
                                </table>
                                </div>
                        	';

			        $sql_fcd = "SELECT fcd_id FROM functionality_list_repo WHERE project_id = '" .$project_id. "' AND sprint_id <= '" .$sprint_id. "' AND functionality_id = '" .$functionality_id. "'";
			        $result_fcd = mysqli_query($connect,$sql_fcd);
			            if(mysqli_num_rows($result_fcd)>0){
			              $row_fcd = mysqli_fetch_array($result_fcd);
			              $fcd_id_val = $row_fcd['fcd_id'];
			              $fcd_id_val = $fcd_id_val + 1;

			              //echo $fcd_id_val;
			              $check_fcd = "SELECT fcd_header_id FROM fcd_header_table_repo WHERE project_id = '".$project_id."' AND sprint_id <= '".$sprint_id."' AND fcd_header_id = '".$fcd_id_val."'";
			              $result_check_fcd = mysqli_query($connect,$check_fcd);
			              echo mysqli_error($connect);
			              if(mysqli_num_rows($result_check_fcd)>0){
			                 
			              }
			              else{
			              	echo "check fcd returns 0\n";
			              	$insert_fcd = "INSERT INTO fcd_header_table_repo (project_id,sprint_id,fcd_header_id,level_num,fcd_name,fcd_description) VALUES('" .$project_id. "','" .$sprint_id. "','" .$fcd_id_val. "','" .$fcd_id_val. "','Level ".$fcd_id_val." Decomposition','')";
			                $result_fcd = mysqli_query($connect,$insert_fcd);
			              }
                          
                          $new_functionality_id = $functionality_id;
                          
                          echo $new_functionality_id."\n";

                          $sql_func = "SELECT functionality_id FROM functionality_list_repo WHERE project_id = '" .$project_id. "' AND sprint_id <= '" .$sprint_id. "' ORDER BY functionality_id DESC LIMIT 1";
                          $result_func = mysqli_query($connect,$sql_func);
                          if(mysqli_num_rows($result_func)>0){
                          	$row_func = mysqli_fetch_array($result_func);
                          	$new_functionality_id = $row_func['functionality_id'];
                          }
			              $new_functionality_id = $new_functionality_id + 1;

			              echo $new_functionality_id."\n";

			              $check_func = "SELECT functionality_id FROM functionality_list_repo WHERE project_id = '" .$project_id. "' AND sprint_id <= '" .$sprint_id. "' AND functionality_id = '" .$new_functionality_id. "'";
			              $result_check_func = mysqli_query($connect,$check_func);

			              if(mysqli_num_rows($result_check_func)>0){

			              }
			              else{
			              	$insert_func = "INSERT INTO functionality_list_repo (project_id,sprint_id,fcd_id,functionality_id,functionality_name,functionality_description,parent_functionality_id) VALUES('" .$project_id. "','" .$sprint_id. "','" .$fcd_id_val. "','" .$new_functionality_id. "','" .$group_name. "','','" .$functionality_id. "')";
			              	$result_insert_func = mysqli_query($connect,$insert_func);
			              	if($result_insert_func){

			              	}
			              	else{
			              		echo mysqli_error($result_insert_func);
			              	}
			              }
			            } 
   	     }
   	     else{ 
   	  	   echo mysqli_error($connect);
   	     }
   	 }
   	  echo $output;
   }
?>