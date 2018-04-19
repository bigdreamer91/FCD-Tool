<?php
  $project_id = $_POST['project_id'];
  $sprint_id = $_POST['sprint_id'];
  $functionality_id = $_POST['functionality_id'];
  $pType = $_POST['p'];
  $connect = mysqli_connect("localhost", "root", "root", "fcd_decomposition_db");

  if(strcmp($pType,"1")==0){
  	 $val = 0;
     $sql = "SELECT class_id FROM functionality_classes_repo WHERE project_id = '" .$project_id. "' AND sprint_id <= '" .$sprint_id. "' AND functionality_id = '" .$functionality_id. "' ORDER BY class_id DESC LIMIT 1";
     $result = mysqli_query($connect,$sql);
     $output = '';

     if(!$result){
     	echo mysqli_error($connect);
     }

     if(mysqli_num_rows($result)>0){
     	$row = mysqli_fetch_array($result);
     	$val = $row["class_id"];
     }

     $val = $val + 1;

     $val_class_id = 0;
     $sql_class_id = "SELECT class_id FROM classes_repo WHERE project_id = '" .$project_id. "' ORDER BY class_id DESC LIMIT 1";
     $result_class_id = mysqli_query($connect,$sql_class_id);
     if(mysqli_num_rows($result_class_id)>0){
     	$row_class_id = mysqli_fetch_array($result_class_id);
     	$val_class_id = $row_class_id['class_id'];
     }

     $val_class_id = $val_class_id + 1;

     $sql_insert_class = "INSERT INTO classes_repo (project_id,class_id,class_name,class_attr,uml_mapped,uml_mapped_id) VALUES('" .$project_id. "', '" .$val_class_id. "', '','','',NULL)";
     $result_insert_class = mysqli_query($connect,$sql_insert_class);
     if($result_insert_class){
         $sql_insert_func = "INSERT INTO functionality_classes_repo (project_id,sprint_id,functionality_id,class_id,class_mapped_id,group_mapped,group_mapped_id) VALUES('".$project_id."','".$sprint_id."','".$functionality_id."','".$val."','".$val_class_id."','',NULL)";
	     $result_insert_func = mysqli_query($connect,$sql_insert_func);
	     if($result_insert_func){
	        $output .= '
	                <div class="functinality_classes-'.$functionality_id.' classDetails" style="margin: 10px 30px 0 30px; height: 25px; display:none; cursor: pointer;" id="functionality_class_header-'.$functionality_id.'-'.$val.'">
						<div style="position: relative;">
							<div style="position: absolute; height: 25px; border: 1px solid black; border-bottom: none; background-color: #A8E5FE; width: 100%; text-align: center; padding-left: 15px;" id="class_name_header-'.$functionality_id.'-'.$val.'"></div>
							<div style="position: absolute; right: 5px;">
							    <icon class="material-icons cancelClass" style="font-size: 20px; cursor: pointer;"" id="cancelClass-'.$functionality_id.'-'.$val.'">cancel</icon>
							</div>
							<div style="position: absolute; right: 30px;">
								<icon class="material-icons editClassName" style="font-size: 20px; cursor: pointer;" id="editClass-'.$functionality_id.'-'.$val.'">create</icon>
							</div>
						</div>
					</div>
					<div class="class_detail-'.$functionality_id.'-'.$val.'" style="margin: 0px 30px 0 30px; border: 1px solid black; border-bottom: none; display:none;" id="class_attr-'.$functionality_id.'-'.$val.'">
						<table style="width: 100%; background-color: #A8E5FE; padding-left: 15px;">
					        <tr>
					           <td style="padding-left: 15px;">
                                  <div style="margin-bottom: 20px;">
					                 <div style="position:relative;">
					                    <div style="position:absolute; height:25px;">
					                    Attributes:
					                    </div>
					                    <div style="position:absolute; right:5px;">
					                       <icon class="material-icons addClassAttributes" style="font-size:20px; cursor:pointer;" id="classAttr-'.$functionality_id.'-'.$val.'">create</icon>
					                    </div>
					                 </div>
					               </div>
					           </td>
					        </tr>
					     	<tr>
					     	   <td style="padding: 10px 20px 10px 20px;">
					     	      <textarea id="textArr-'.$functionality_id.'-'.$val.'" style="width: 100%;"></textarea>
					     	   </td>
					     	</tr>
						</table>
					</div>
				    <div class="class_detail-'.$functionality_id.'-'.$val.' methods" style="margin: 0px 30px 0 30px; height: 25px; display:none;" id="functionality_method-'.$functionality_id.'-'.$val.'">
						<div style="position: relative;">
					        <div style="position: absolute; height: 25px; border: 1px solid black; border-bottom: none; background-color: #A8E5FE; width: 100%; text-align: left; padding-left: 15px;">
					             Methods:
					        </div>
					        <div style="position: absolute; right: 5px;">
					            <icon class="material-icons addClassMethods" style="font-size: 20px; cursor: pointer;" id="addMethod-'.$functionality_id.'-'.$val.'">add</icon>
					        </div>
				        </div>
					</div>
					<div class="class_detail-'.$functionality_id.'-'.$val.'" style="margin: 0 30px 10px 30px; display:none;">
						<table id="tableClassMethods-'.$functionality_id.'-'.$val.'" style="width: 100%; border: 1px solid black;">
						</table>
					</div>
	        ';
	     }
	     else{
	       echo mysqli_error($connect);
	     }
     }

     echo $output;
  }
  else if(strcmp($pType,"2")==0){
  	 $class_id = $_POST['class_id'];
  	 $class_name = $_POST['class_name'];

  	 $sql = "SELECT class_mapped_id FROM functionality_classes_repo WHERE project_id = '" .$project_id. "' AND sprint_id <= '" .$sprint_id. "' AND functionality_id = '" .$functionality_id. "' AND class_id = '" .$class_id. "'";
  	 $result = mysqli_query($connect,$sql);
  	 if(mysqli_num_rows($result)>0){
  	 	$row = mysqli_fetch_array($result);
  	 	$sql_update = "UPDATE classes_repo SET class_name = '" .$class_name. "' WHERE project_id = '" .$project_id. "' AND class_id = '" .$row['class_mapped_id']. "'";
  	 	$result_update = mysqli_query($connect,$sql_update);
  	 	if($result_update){

  	 	}
  	 }
  }
  else if(strcmp($pType,"3")==0){
  	 $class_id = $_POST['class_id'];
  	 $class_attr = $_POST['class_attr'];

  	 $sql = "SELECT class_mapped_id FROM functionality_classes_repo WHERE project_id = '" .$project_id. "' AND sprint_id <= '" .$sprint_id. "' AND functionality_id = '" .$functionality_id. "' AND class_id = '" .$class_id. "'";
  	 $result = mysqli_query($connect,$sql);
  	 if(mysqli_num_rows($result)>0){
  	 	$row = mysqli_fetch_array($result);
  	 	$sql_update = "UPDATE classes_repo SET class_attr = '" .$class_attr. "' WHERE project_id = '" .$project_id. "' AND class_id = '" .$row['class_mapped_id']. "'";
  	 	$result_update = mysqli_query($connect,$sql_update);
  	 	if($result_update){

  	 	}
  	 }
  }
  else if(strcmp($pType,"4")==0){
  	 $class_id = $_POST['class_id'];
  	 $output = '';
     
     $sql_get_class_mapped = "SELECT class_mapped_id FROM functionality_classes_repo WHERE project_id = '" .$project_id. "' AND sprint_id <= '" .$sprint_id. "' AND functionality_id = '" .$functionality_id. "' AND class_id = '" .$class_id. "'";
     $result_get_class_mapped = mysqli_query($connect,$sql_get_class_mapped);

     if(mysqli_num_rows($result_get_class_mapped)>0){
     	$row_get_class_mapped = mysqli_fetch_array($result_get_class_mapped);
     	$class_repo_id = $row_get_class_mapped['class_mapped_id'];
     	$sql_get_class_method_id = "SELECT class_method_id FROM functionality_classes_methods_repo WHERE project_id = '" .$project_id. "' AND class_id = '" .$class_repo_id. "' ORDER BY class_method_id DESC LIMIT 1";
	  	 $result_get_class_method_id = mysqli_query($connect,$sql_get_class_method_id);
	  	 $val = 0;
	  	 if(mysqli_num_rows($result_get_class_method_id)>0){
	  	 	$row_get_class_method_id = mysqli_fetch_array($result_get_class_method_id);
	        $val = $row_get_class_method_id['class_method_id'];
	  	 }
	  	 $val = $val + 1;

	  	 $sql_insert = "INSERT INTO functionality_classes_methods_repo (project_id,class_id,class_method_id,class_method_name,existing_step_id) VALUES('" .$project_id. "', '" .$class_repo_id. "', '" .$val. "', '', NULL)";
	  	 $result_insert = mysqli_query($connect,$sql_insert);
	  	 if($result_insert){
	  	 	$output .= '
	            <tr>
		          <td>
		              <table style="width: 100%;">
		                  <tr>
		                     <td style="width: 100%;">
		                        <div class="methodDetails method-'.$functionality_id.'-'.$class_id.'" style="height: 20px; display:none" id="method_details-'.$functionality_id.'-'.$class_id.'-'.$val.'">
		                            <div style="position: relative;">
		                               <div style="position: absolute; border-bottom: 1px solid black; width: 100%; text-align: left;" id="stepsHeaderWithinClass-'.$functionality_id.'-'.$class_id.'-'.$val.'"></div>
		                               <div style="position: absolute; right: 5px;">
		                                 <i class="material-icons cancelClassMethod" style="font-size: 20px; cursor: pointer;" id="cancelStepsWithinClass-'.$functionality_id.'-'.$class_id.'-'.$val.'">cancel</i>
		                               </div>
		                               <div style="position: absolute; right: 30px;">
		                                 <i class="fa fa-chevron-circle-down" style="font-size: 20px; cursor: pointer;" id="arrowDownWithinClass-'.$functionality_id.'-'.$class_id.'-'.$val.'"></i>
		                               </div>
		                               <div style="position: absolute; right: 50px;">
		                                 <i class="fa fa-chevron-circle-up" style="font-size: 20px; cursor: pointer;" id="arrowUpWithinClass-'.$functionality_id.'-'.$class_id.'-'.$val.'"></i>
		                               </div>
		                               <div style="position: absolute; right: 70px;">
		                                 <i class="material-icons editClassMethod" style="font-size: 20px; cursor: pointer;" id="editStepWithinClass-'.$functionality_id.'-'.$class_id.'-'.$val.'">create</i>
		                               </div>
		                               <div style="position: absolute; right: 95px;">
		                                 <i class="material-icons repoClassMethod" style="font-size: 20px; cursor: pointer;" id="repoStepWithinClass-'.$functionality_id.'-'.$class_id.'-'.$val.'">playlist_add</i>
		                               </div>
		                            </div>
		                          </div>
		                          <div class="methodDetails-'.$functionality_id.'-'.$class_id.'-'.$val.'" style="padding-left: 10px; margin-left: 60px; margin-top: 10px; margin-right: 10px; height: 20px; border: 1px solid black; background-color: #F9E79F; display: none;" id="reqHeaderStepWithinClass-'.$functionality_id.'-'.$class_id.'-'.$val.'">
		                             <div style="position: relative;">
		                                <div style="position: absolute;">Requirements:</div>
		                             </div>
		                          </div>
		                          <div class="methodDetails-'.$functionality_id.'-'.$class_id.'-'.$val.'" style="padding-left: 10px; margin-left: 60px; margin-right: 10px; height: 30px; border: 1px solid black; background-color: #F9E79F; display: none;" id="reqInpStepWithinClass-'.$functionality_id.'-'.$class_id.'-'.$val.'">
		                                <div style="position: relative;">
		                                  <div style="position: absolute; width: 100%">
		                                    <input type="text" name="" style="height: 20px; width: 100%" value="" id="req_inp_StepWithinClass-'.$functionality_id.'-'.$class_id.'-'.$val.'">
		                                  </div>
		                                </div>
		                          </div>
		                          <div class="methodDetails-'.$functionality_id.'-'.$class_id.'-'.$val.'" style="padding-left: 10px; margin-left: 60px; margin-right: 10px; height: 20px; border: 1px solid black; background-color: #F9E79F; display: none;" id="methodsStepWithinClass-'.$functionality_id.'-'.$class_id.'-'.$val.'">
		                                <div style="position: relative;">
		                                  <div style="position: absolute;">Method Notes</div>
		                                </div>
		                          </div>
		                          <div class="methodDetails-'.$functionality_id.'-'.$class_id.'-'.$val.'" style="padding-left: 10px; margin-left: 60px; margin-right: 10px; height: 30px; border: 1px solid black; background-color: #F9E79F; display: none;" id="methodValStepsWithinClass-'.$functionality_id.'-'.$class_id.'-'.$val.'">
		                                <div style="position: relative;">
		                                  <div style="position: absolute; width: 100%">
		                                    <input type="text" name="" style="height: 20px; width: 100%;" id="method_inp_StepsWithinClass-'.$functionality_id.'-'.$class_id.'-'.$val.'" value="">
		                                  </div>
		                                </div>
		                          </div>
		                          <div class="methodDetails-'.$functionality_id.'-'.$class_id.'-'.$val.'" style="padding-left: 10px; margin-left: 60px; margin-right: 10px; height: 20px; border: 1px solid black; background-color: #F9E79F; display: none;" id="expHeaderStepsWithinClass-'.$functionality_id.'-'.$class_id.'-'.$val.'">
		                                 <div style="position: relative;">
		                                    <div style="position: absolute;">Expectations:</div>
		                                 </div>
		                          </div>
		                          <div class="methodDetails-'.$functionality_id.'-'.$class_id.'-'.$val.'" style="padding-left: 10px; margin-left: 60px; margin-right: 10px; margin-bottom: 10px; height: 30px; border: 1px solid black; background-color: #F9E79F; display: none;" id="expValStepWithinClass-'.$functionality_id.'-'.$class_id.'-'.$val.'">
		                                <div style="position: relative;">
		                                  <div style="position: absolute; width: 100%">
		                                    <input type="text" name="" style="height: 20px; width: 100%" value="" id="exp_inp_StepWithinClass-'.$functionality_id.'-'.$class_id.'-'.$val.'">
		                                  </div>
		                                </div>
		                          </div>
		                     </td>
		                  </tr>
		               </table>
		          </td>
				</tr>
	  	 	';
	  	 }
	  	 else{
	  	 	echo mysqli_error($connect);
	  	 }

     }

  	echo $output;
  }
  else if(strcmp($pType,"5")==0){
  	 $class_id = $_POST['class_id'];
  	 $class_method_id = $_POST['class_method_id'];

  	 $step_name = $_POST['step_name'];
  	 $step_reqs = $_POST['step_reqs'];
  	 $step_methods = $_POST['step_methods'];
  	 $step_expecs = $_POST['step_expecs'];

  	 echo "\n step_name: '" .$step_name. "'\n step_reqs: '" .$step_reqs. "'\n step_methods: '" .$step_methods. "'\n step_expecs: '" .$step_expecs. "'\n";

  	 $sql_get_class_mapped = "SELECT class_mapped_id FROM functionality_classes_repo WHERE project_id = '" .$project_id. "' AND sprint_id <= '" .$sprint_id. "' AND functionality_id = '" .$functionality_id. "' AND class_id = '" .$class_id. "'";
     $result_get_class_mapped = mysqli_query($connect,$sql_get_class_mapped);

     if(mysqli_num_rows($result_get_class_mapped)>0){
     	$row_get_class_mapped = mysqli_fetch_array($result_get_class_mapped);
     	$class_repo_id = $row_get_class_mapped['class_mapped_id'];
        
        $sql_get_existing_step_id = "SELECT existing_step_id FROM functionality_classes_methods_repo WHERE project_id = '" .$project_id. "' AND class_id = '" .$class_repo_id. "' AND class_method_id = '" .$class_method_id. "'";
	  	 $result_get_existing_step_id = mysqli_query($connect,$sql_get_existing_step_id);
	  	 if(mysqli_num_rows($result_get_existing_step_id)>0){
	  	 	$row_get_existing_step_id = mysqli_fetch_array($result_get_existing_step_id);
	  	 	$existing_id = $row_get_existing_step_id['existing_step_id'];
	        
	        if($existing_id!==NULL){
	        	echo "error thrown existing_id is not null";
	        	$sql_check_step = "SELECT step_id FROM steps_repo WHERE project_id = '" .$project_id. "' AND step_id = '" .$existing_id. "' AND step_mapped = 'yes' AND mapped_class_id = '" .$class_repo_id. "'";
	            $result_check_step = mysqli_query($connect,$sql_check_step);

	            if($result_check_step){
	  	 		   $update_step = "UPDATE steps_repo SET step_name = '" .$step_name. "', step_reqs = '" .$step_reqs. "', step_method_notes = '" .$step_methods. "', step_expecs = '" .$step_expecs. "' WHERE step_id = '" .$existing_id. "' AND project_id = '" .$project_id. "'";
	  	 		   $result_update_step = mysqli_query($connect,$update_step);

	  	 	    }
	        }
	        else{
	        	echo "inside this else block\n";
	        	$sql_new_step = "SELECT step_id FROM steps_repo WHERE project_id = '" .$project_id. "' ORDER BY step_id DESC LIMIT 1";
	        	$result_new_step = mysqli_query($connect,$sql_new_step);
	        	$val_step_id = 0;
	        	if(mysqli_num_rows($result_new_step)>0){
	        		$row_step_id = mysqli_fetch_array($result_new_step);
	        		$val_step_id = $row_step_id['step_id'];
	        	}
	        	else{
	        		echo mysqli_error($connect);
	        	}
	        	$val_step_id = $val_step_id + 1;
	        	echo $val_step_id;

	        	$sql_insert = "INSERT INTO steps_repo (project_id,step_id,step_name,step_reqs,step_method_notes,step_expecs,step_mapped,mapped_class_id) VALUES('" .$project_id. "','" .$val_step_id. "','" .$step_name. "','" .$step_reqs. "','" .$step_methods. "','" .$step_expecs. "','yes','" .$class_repo_id. "')";
	        	$result_insert = mysqli_query($connect,$sql_insert);
	        	if($result_insert){
	               $sql_update_methods_repo = "UPDATE functionality_classes_methods_repo SET existing_step_id = '" .$val_step_id. "', class_method_name = '".$step_name."' WHERE project_id = '" .$project_id. "' AND class_id = '" .$class_repo_id. "' AND class_method_id = '" .$class_method_id. "'";
	               $result_update_methods = mysqli_query($connect,$sql_update_methods_repo);
	               if($result_update_methods){

	               }
	               else{
	               	 echo mysqli_error($connect);
	               }
	        	}
	        	else{
	        		echo mysqli_error($connect);
	        	}
	        } 
	  	 }
	     }
  	 //echo mysqli_error($connect);
  }
  else if(strcmp($pType,"6")==0){
  	 $class_id = $_POST['class_id'];
  	 $class_method_id = $_POST['class_method_id'];

  	 $sql_get_class_mapped = "SELECT class_mapped_id FROM functionality_classes_repo WHERE project_id = '" .$project_id. "' AND sprint_id <= '" .$sprint_id. "' AND functionality_id = '" .$functionality_id. "' AND class_id = '" .$class_id. "'";
     $result_get_class_mapped = mysqli_query($connect,$sql_get_class_mapped);

     if(mysqli_num_rows($result_get_class_mapped)>0){
     	$row_get_class_mapped = mysqli_fetch_array($result_get_class_mapped);
     	$class_repo_id = $row_get_class_mapped['class_mapped_id'];
     	echo $class_repo_id;

     	$sql_select_step_id = "SELECT existing_step_id FROM functionality_classes_methods_repo WHERE project_id = '" .$project_id. "' AND class_id = '" .$class_repo_id. "' AND class_method_id = '" .$class_method_id. "'";
	  	$result_step_id = mysqli_query($connect,$sql_select_step_id);
	  	 	
	  	if(mysqli_num_rows($result_step_id)>0){
	  	  $row_step_id = mysqli_fetch_array($result_step_id);
          $sql_update_steps = "UPDATE steps_repo SET step_mapped = 'no', mapped_class_id = NULL WHERE project_id = '" .$project_id. "' AND step_id = '" .$row_step_id['existing_step_id']. "'";
          $result_update_steps = mysqli_query($connect,$sql_update_steps);

          if($result_update_steps){
             $sql = "DELETE FROM functionality_classes_methods_repo WHERE project_id = '" .$project_id. "' AND class_id = '" .$class_repo_id. "' AND class_method_id = '" .$class_method_id. "'";
	  	     $result = mysqli_query($connect,$sql);
	  	     if(!$result){
	           echo mysqli_error($connect);
	  	     }
	  	     else{
	  	 	   $sql_select_step_id = "SELECT existing_step_id FROM functionality_classes_methods_repo WHERE project_id = '" .$project_id. "' AND class_id = '" .$class_repo_id. "' AND class_method_id = '" .$class_method_id. "'";
	  	 	   $result_step_id = mysqli_query($connect,$sql_select_step_id);
	  	 	   if(mysqli_num_rows($result_step_id)>0){
	  	 	      $row_step_id = mysqli_fetch_array($result_step_id);
	  	 	      if($row_step_id['existing_step_id']!==NULL){
                  $sql_update_steps = "UPDATE steps_repo SET step_mapped = 'no', mapped_class_id = NULL WHERE project_id = '" .$project_id. "' AND step_id = '" .$row_step_id['existing_step_id']. "'";
                  $result_update_steps = mysqli_query($connect,$sql_update_steps);
                  } 
                  if($result_update_steps){

                  }
                  else{
                  	echo mysqli_error($connect);
                  }
	  	 	    }
	  	     }
          }
         }
         else{
     	   echo mysqli_error($connect);
         }
      }
  }
  else if(strcmp($pType,"7")==0){
  	 $class_id = $_POST['class_id'];

  	 $sql_get_class_mapped = "SELECT class_mapped_id FROM functionality_classes_repo WHERE project_id = '" .$project_id. "' AND sprint_id <= '" .$sprint_id. "' AND functionality_id = '" .$functionality_id. "' AND class_id = '" .$class_id. "'";
     $result_get_class_mapped = mysqli_query($connect,$sql_get_class_mapped);

     if(mysqli_num_rows($result_get_class_mapped)>0){
     	$row_get_class_mapped = mysqli_fetch_array($result_get_class_mapped);
     	$class_repo_id = $row_get_class_mapped['class_mapped_id'];

     	/*$sql_existing_step = "SELECT existing_step_id FROM functionality_classes_methods_repo WHERE project_id = '" .$project_id. "' AND class_id = '" .$class_repo_id. "'";
     	$result_existing_step = mysqli_query($connect,$sql_existing_step);
     	if(mysqli_num_rows($result_existing_step)>0){
     		while($row_existing_step = mysqli_fetch_array($result_existing_step)){
     			 $sql = "DELETE FROM functionality_classes_methods_repo WHERE project_id = '" .$project_id. "' AND class_id = '" .$class_repo_id. "'";
			  	 $result = mysqli_query($connect,$sql);
			  	 if($result){
			  	 	
			  	 		$sql_class_del = "DELETE FROM classes_repo WHERE project_id = '" .$project_id. "' AND class_id = '" .$class_repo_id. "'";
			  	 		$result_class_del = mysqli_query($connect,$sql_class_del);
			  	 		if($result_class_del){
			  	 			$sql_func_class_del = "DELETE FROM functionality_classes_repo WHERE project_id = '" .$project_id. "' AND sprint_id <= '" .$sprint_id. "' AND functionality_id = '" .$functionality_id. "' AND class_id = '" .$class_id. "'";
			  	 			$result_func_class = mysqli_query($connect,$sql_func_class_del);
			  	 			if($result_func_class){
                               $sql_update_step = "UPDATE steps_repo SET step_mapped = 'no' AND mapped_class_id = NULL WHERE step_id = '" .$row_existing_step['existing_step_id']. "'";
                               $result_update_step = mysqli_query($connect,$sql_update_step);
			  	 			}
			  	 			else{
			  	 				echo mysqli_error($result_func_class);
			  	 			}
			  	 		}
			  	 		else{
			  	 			echo mysqli_error($result_class_del);
			  	 		}
			  	 }
			  	 else{
			  	 	echo mysqli_error($result);
			  	 }
     		}
     	} */

     	$sql_existing_step = "SELECT existing_step_id FROM functionality_classes_methods_repo WHERE project_id = '" .$project_id. "' AND class_id = '" .$class_repo_id. "'";
     	$result_existing_step = mysqli_query($connect,$sql_existing_step);
     	if(mysqli_num_rows($result_existing_step)>0){
     		while($row_existing_step = mysqli_fetch_array($result_existing_step)){
     		$sql_update_step = "UPDATE steps_repo SET step_mapped = 'no', mapped_class_id = NULL WHERE step_id = '" .$row_existing_step['existing_step_id']. "' AND project_id = '" .$project_id. "'";
            $result_update_step = mysqli_query($connect,$sql_update_step);
            if(!$result_update_step){
            	echo mysqli_error($connect);
            }
            }
     	}

     	$sql = "DELETE FROM functionality_classes_methods_repo WHERE project_id = '" .$project_id. "' AND class_id = '" .$class_repo_id. "'";
	    $result = mysqli_query($connect,$sql);
	    if($result){
			  	 	
  	 		$sql_class_del = "DELETE FROM classes_repo WHERE project_id = '" .$project_id. "' AND class_id = '" .$class_repo_id. "'";
  	 		$result_class_del = mysqli_query($connect,$sql_class_del);
  	 		if($result_class_del){
  	 			$sql_func_class_del = "DELETE FROM functionality_classes_repo WHERE project_id = '" .$project_id. "' AND sprint_id <= '" .$sprint_id. "' AND functionality_id = '" .$functionality_id. "' AND class_id = '" .$class_id. "'";
  	 			$result_func_class = mysqli_query($connect,$sql_func_class_del);
  	 		}
  	 	}
     } 


  }
  else if(strcmp($pType,"8")==0){
  	 $step_id = $_POST['step_id'];
  	 $class_id = $_POST['class_id'];
  	 $class_method_id = $_POST['class_method_id'];

  	 $sql_get_class_mapped = "SELECT class_mapped_id FROM functionality_classes_repo WHERE project_id = '" .$project_id. "' AND sprint_id <= '" .$sprint_id. "' AND functionality_id = '" .$functionality_id. "' AND class_id = '" .$class_id. "'";
  	 $result_get_class_mapped = mysqli_query($connect,$sql_get_class_mapped);

  	 if(mysqli_num_rows($result_get_class_mapped)>0){
  	 	$row_get_class_mapped = mysqli_fetch_array($result_get_class_mapped);
  	 	$class_mapped_id = $row_get_class_mapped['class_mapped_id'];

  	 	$sql_step_name = "SELECT step_name FROM steps_repo WHERE project_id = '" .$project_id. "' AND step_id = '" .$step_id. "'";
  	 	$result_step_name = mysqli_query($connect,$sql_step_name);
  	 	if(mysqli_num_rows($result_step_name)>0){
  	 		$row_step_name = mysqli_fetch_array($result_step_name);
            $existing_step_id_update = "UPDATE functionality_classes_methods_repo SET existing_step_id = '" .$step_id. "', class_method_name = '".$row_step_name['step_name']."' WHERE project_id = '" .$project_id. "' AND class_id = '" .$class_mapped_id. "' AND class_method_id = '" .$class_method_id. "'";
  	 	    $result_existing_update = mysqli_query($connect,$existing_step_id_update);

	  	 	if($result_existing_update){
	  	 		$step_update = "UPDATE steps_repo SET step_mapped = 'yes', mapped_class_id = '" .$class_mapped_id. "' WHERE project_id = '" .$project_id. "' AND step_id = '" .$step_id. "'";
	  	 		$result_step_update = mysqli_query($connect,$step_update);
	  	 		if($result_step_update){
	  	 			$get_step_details = "SELECT * FROM steps_repo WHERE project_id = '" .$project_id. "' AND step_id = '" .$step_id. "'";
	  	 			$result_step_details = mysqli_query($connect,$get_step_details);
	  	 			if(mysqli_num_rows($result_step_details)>0){
	  	 				$row_step_details = mysqli_fetch_array($result_step_details);
	  	 				$step = array(
	                        "step_name"=>$row_step_details['step_name'],
	                        "step_reqs" => $row_step_details['step_reqs'],
	                        "step_methods" => $row_step_details['step_method_notes'],
	                        "step_expecs" => $row_step_details['step_expecs']  
	  	 					);
	  	 				echo json_encode($step);
	  	 			}
	  	 		}
	  	 	}
  	 	}
  	 }
  }
?>