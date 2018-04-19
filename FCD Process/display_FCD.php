<?php
   $project_id = $_POST['project_id'];
   $sprint_id = $_POST['sprint_id'];

   $connect = mysqli_connect("localhost", "root", "root", "fcd_decomposition_db");
   $output = '';

   $sql_get_fcds = "SELECT * FROM fcd_header_table_repo WHERE project_id = '" .$project_id. "' AND sprint_id <= '" .$sprint_id. "'";
   $result_get_fcds = mysqli_query($connect,$sql_get_fcds);

   if(mysqli_num_rows($result_get_fcds)>0){
   	  while($row_get_fcds = mysqli_fetch_array($result_get_fcds)){
   	  	 $output .= '
             <div style="margin: 30px 30px 0 30px; height: 25px;">
               <div style="position: relative;">
                  <div style="position: absolute; height: 25px; border: 1px solid black; background-color: #659EC7; color: white; width: 100%; text-align: center; padding-left: 15px;" class="fcdHeaders" id = "fcd_header-'.$row_get_fcds['fcd_header_id'].'">'.$row_get_fcds['fcd_name'].'</div>
               </div>
            </div>
   	  	 ';

   	  	 $sql_get_functionality = "SELECT * FROM functionality_list_repo WHERE project_id = '" .$project_id. "' AND sprint_id <= '" .$sprint_id. "' AND fcd_id = '" .$row_get_fcds['fcd_header_id']. "'";

   	  	 $result_get_functionality = mysqli_query($connect,$sql_get_functionality);

   	  	if(mysqli_num_rows($result_get_functionality)>0){
   	  	 	$output .= '
             <div style="margin: 0px 30px 0 30px; border: 1px solid black; " class="fcdHeadersContent" id = "fcd_header_content-'.$row_get_fcds['fcd_header_id'].'">
               <table style="width: 100%">
   	  	 	';
   	  	 	while($row_get_functionality = mysqli_fetch_array($result_get_functionality)){
   	  	 		$sql_get_parent_name = "SELECT functionality_name FROM functionality_list_repo WHERE project_id = '" .$project_id. "' AND sprint_id <= '" .$sprint_id. "' AND functionality_id = '" .$row_get_functionality['parent_functionality_id']. "'";
   	  	 		$result_get_parent_name = mysqli_query($connect,$sql_get_parent_name);
   	  	 		
   	  	 		$row_get_parent_name = mysqli_fetch_array($result_get_parent_name);
   	  	 		$parent_name = $row_get_parent_name['functionality_name'];

   	  	 		if(strcmp($row_get_functionality['functionality_id'],'0')==0){
   	  	 			$parent_name = "";
   	  	 		}
   	  	
   	  	 		$output .= '
                   <tr>
               	     <td>
               	        <!-- grouping header name -->
               	        <div class="functionalityHeader" style="height: 20px; background-color: #F0EFEA; margin: 20px 20px 0 20px; padding-left: 15px; cursor: pointer;" id="functionality_header-'.$row_get_functionality['functionality_id'].'">
               	           <div style="position: relative;">
               	              <div style="position: absolute;">'.$row_get_functionality['functionality_name'].'</div>
               	           </div>
               	        </div>
               	        <!-- grouping FCD content -->
               	        <div style="margin: 0 20px 20px 20px; border: 1px solid black; display: none;" class="functionalityContent" id="functionality_content-'.$row_get_functionality['functionality_id'].'">
               	           <table style="width: 100%">
               	               <tr>
			               	     <td>
			               	        <div style="height: 20px; margin: 5px; padding-left: 15px;">
			               	           <div style="position: relative;">
			               	              <div style="position: absolute;">
			               	              Parent: '.$parent_name.'</div>
			               	           </div>
			               	        </div>
			               	     </td>
			               	  </tr>
               	           	   <tr>
			               	     <td id="functionality_usecases_td-'.$row_get_functionality['functionality_id'].'">

			               	        <!-- view usecases header -->
			               	        <div class="viewUsecases" style="height: 20px; background-color: #BCBABE; margin: 20px 20px 0 20px; padding-left: 15px; cursor:pointer;" id="functionality_usecases_header-'.$row_get_functionality['functionality_id'].'">
			               	           <div style="position: relative;">
			               	              <div style="position: absolute;">
			               	              View UseCases
			               	              </div>
			               	              <div style="position: absolute; right: 30px;">
									             <i class="material-icons addUseCase" style="font-size: 20px; right: 5px; cursor: pointer;" id="addUseCase-'.$row_get_functionality['functionality_id'].'">add</i>
									      </div>
			               	           </div>
			               	        </div>';

			            $sql_get_functionality_usecases = "SELECT * FROM functionality_usecases_repo WHERE project_id = '" .$project_id. "' AND sprint_id = '" .$sprint_id. "' AND functionality_id = '" .$row_get_functionality['functionality_id']. "'";
			            $result_get_functionality_usecases = mysqli_query($connect,$sql_get_functionality_usecases);

			            if(mysqli_num_rows($result_get_functionality_usecases)>0){
			            	while($row_get_functionality_usecases = mysqli_fetch_array($result_get_functionality_usecases)){
			            		$output .= '
                                     <div class="usecases_list-'.$row_get_functionality['functionality_id'].' usecaseDetails" style="margin: 10px 30px 0 30px; height: 25px; display:none; cursor:pointer;" id="usecase_header-'.$row_get_functionality['functionality_id'].'-'.$row_get_functionality_usecases['usecase_id'].'">
									    <div style="position: relative;">
									           <div style="position: absolute; height: 25px; border: 1px solid black; border-bottom: none; background-color: #F9E79F; width: 100%; text-align: left; padding-left: 15px;" id="usecase_name-'.$row_get_functionality['functionality_id'].'-'.$row_get_functionality_usecases['usecase_id'].'">'.$row_get_functionality_usecases['usecase_name'].'</div>
									           <div style="position: absolute; right: 5px;">
									             <i class="material-icons cancelUsecase" style="font-size: 20px; cursor: pointer;" id="cancel-'.$row_get_functionality['functionality_id'].'-'.$row_get_functionality_usecases['usecase_id'].'">cancel</i>
									           </div>
									           <div style="position: absolute; right: 30px;">
									             <i class="material-icons addStepWithinUsecase" style="font-size: 20px; cursor: pointer;" id="add-'.$row_get_functionality['functionality_id'].'-'.$row_get_functionality_usecases['usecase_id'].'">add</i>
									           </div>
									           <div style="position: absolute; right: 60px;">
									             <i class="material-icons createUsecase" style="font-size: 20px; cursor: pointer;" id="edit-'.$row_get_functionality['functionality_id'].'-'.$row_get_functionality_usecases['usecase_id'].'">create</i>
									           </div>
									    </div>
									</div>
			            		';

                                $sql_get_functionality_usecases_steps = "SELECT * FROM functionality_usecases_steps_repo WHERE project_id = '" .$project_id. "' AND sprint_id = '" .$sprint_id. "' AND functionality_id = '" .$row_get_functionality['functionality_id']. "' AND usecase_id = '" .$row_get_functionality_usecases['usecase_id']. "'";

                                //echo 'alert("'.$sql_get_functionality_usecases_steps.'")';

                                $result_get_functionality_usecases_steps = mysqli_query($connect,$sql_get_functionality_usecases_steps);
                                //echo 'alert("<br>'.$result_get_functionality_usecases_steps.'")';

                                $output .= '
		                                	<div class="usecase_steps-'.$row_get_functionality['functionality_id'].'-'.$row_get_functionality_usecases['usecase_id'].'" style="margin: 0px 30px 10px 30px; display:none;">
											    <!-- outer table wrap around container to hold steps for each usecase -->
											    <table style="width: 100%; border: 1px solid black;">
											      <tr>
											        <td>
											            <!-- table to hold steps mapped within usecase -->
											            <table style="width: 100%" id="tablesteps-'.$row_get_functionality['functionality_id'].'-'.$row_get_functionality_usecases['usecase_id'].'">';

                                if(mysqli_num_rows($result_get_functionality_usecases_steps)>0){
								    while($row_get_functionality_usecases_steps = mysqli_fetch_array($result_get_functionality_usecases_steps)){
								    	$sql_get_step_details = "SELECT * FROM steps_repo WHERE project_id = '" .$project_id. "' AND step_id = '" .$row_get_functionality_usecases_steps['usecase_mapped_step_id']. "'";
								    	$result_get_step_details = mysqli_query($connect,$sql_get_step_details);
								    	if(mysqli_num_rows($result_get_step_details)>0){
								    		$row_get_step_details = mysqli_fetch_array($result_get_step_details);
								    		$output .= '
                                                <tr id="table_steps_tr-'.$row_get_functionality['functionality_id'].'-'.$row_get_functionality_usecases['usecase_id'].'-'.$row_get_functionality_usecases_steps['usecase_step_id'].'">
								                    <td style="padding: 5px">
								                          <div style="height: 20px;">
								                            <div style="position: relative;">
								                               <div style="position: absolute; border-bottom: 1px solid black; width: 100%; text-align: left;" id="stepsHeader-'.$row_get_functionality['functionality_id'].'-'.$row_get_functionality_usecases['usecase_id'].'-'.$row_get_functionality_usecases_steps['usecase_step_id'].'">'.$row_get_step_details['step_name'].'</div>
								                               <div style="position: absolute; right: 5px;">
								                                 <i class="material-icons cancelStepsWithinUsecase" style="font-size: 20px; cursor: pointer;" id="cancel-'.$row_get_functionality['functionality_id'].'-'.$row_get_functionality_usecases['usecase_id'].'-'.$row_get_functionality_usecases_steps['usecase_step_id'].'">cancel</i>
								                               </div>
								                               <div style="position: absolute; right: 30px;">
								                                 <i class="fa fa-chevron-circle-down" style="font-size: 20px; cursor: pointer;" id="arrowDown-'.$row_get_functionality['functionality_id'].'-'.$row_get_functionality_usecases['usecase_id'].'-'.$row_get_functionality_usecases_steps['usecase_step_id'].'"></i>
								                               </div>
								                               <div style="position: absolute; right: 50px;">
								                                 <i class="fa fa-chevron-circle-up" style="font-size: 20px; cursor: pointer;" id="arrowUp-'.$row_get_functionality['functionality_id'].'-'.$row_get_functionality_usecases['usecase_id'].'-'.$row_get_functionality_usecases_steps['usecase_step_id'].'"></i>
								                               </div>
								                               <div style="position: absolute; right: 70px;">
								                                 <i class="material-icons" style="font-size: 20px; cursor: pointer;" id="edit-'.$row_get_functionality['functionality_id'].'-'.$row_get_functionality_usecases['usecase_id'].'-'.$row_get_functionality_usecases_steps['usecase_step_id'].'">create</i>
								                               </div>
								                               <div style="position: absolute; right: 95px;">
								                                 <i class="material-icons repoStepsWithinUsecase" style="font-size: 20px; cursor: pointer;" id="repo-'.$row_get_functionality['functionality_id'].'-'.$row_get_functionality_usecases['usecase_id'].'-'.$row_get_functionality_usecases_steps['usecase_step_id'].'">playlist_add</i>
								                               </div>
								                            </div>
								                          </div>
								                          <div style="padding-left: 10px; margin-left: 60px; margin-top: 10px; margin-right: 10px; height: 20px; border: 1px solid black; background-color: #F9E79F; display: block;" id="reqHeader-'.$row_get_functionality['functionality_id'].'-'.$row_get_functionality_usecases['usecase_id'].'-'.$row_get_functionality_usecases_steps['usecase_step_id'].'">
								                             <div style="position: relative;">
								                                <div style="position: absolute;">Requirements:</div>
								                             </div>
								                          </div>
								                          <div style="padding-left: 10px; margin-left: 60px; margin-right: 10px; height: 30px; border: 1px solid black; background-color: #F9E79F; display: block;" id="reqInp-'.$row_get_functionality['functionality_id'].'-'.$row_get_functionality_usecases['usecase_id'].'-'.$row_get_functionality_usecases_steps['usecase_step_id'].'">
								                                <div style="position: relative;">
								                                  <div style="position: absolute; width: 100%">
								                                    <input type="text" name="" style="height: 20px; width: 100%" value="'.$row_get_step_details['step_reqs'].'" id="req_inp-'.$row_get_functionality['functionality_id'].'-'.$row_get_functionality_usecases['usecase_id'].'-'.$row_get_functionality_usecases_steps['usecase_step_id'].'">
								                                  </div>
								                                </div>
								                          </div>
								                          <div style="padding-left: 10px; margin-left: 60px; margin-right: 10px; height: 20px; border: 1px solid black; background-color: #F9E79F; display: block;" id="methods-'.$row_get_functionality['functionality_id'].'-'.$row_get_functionality_usecases['usecase_id'].'-'.$row_get_functionality_usecases_steps['usecase_step_id'].'">
								                                <div style="position: relative;">
								                                  <div style="position: absolute;">Method Notes</div>
								                                </div>
								                          </div>
								                          <div style="padding-left: 10px; margin-left: 60px; margin-right: 10px; height: 30px; border: 1px solid black; background-color: #F9E79F; display: block;" id="methodVal-'.$row_get_functionality['functionality_id'].'-'.$row_get_functionality_usecases['usecase_id'].'-'.$row_get_functionality_usecases_steps['usecase_step_id'].'">
								                                <div style="position: relative;">
								                                  <div style="position: absolute; width: 100%">
								                                    <input type="text" name="" style="height: 20px; width: 100%;" id="method_inp-'.$row_get_functionality['functionality_id'].'-'.$row_get_functionality_usecases['usecase_id'].'-'.$row_get_functionality_usecases_steps['usecase_step_id'].'" value="'.$row_get_step_details['step_method_notes'].'">
								                                  </div>
								                                </div>
								                          </div>
								                          <div style="padding-left: 10px; margin-left: 60px; margin-right: 10px; height: 20px; border: 1px solid black; background-color: #F9E79F; display: block;" id="expHeader-'.$row_get_functionality['functionality_id'].'-'.$row_get_functionality_usecases['usecase_id'].'-'.$row_get_functionality_usecases_steps['usecase_step_id'].'">
								                                 <div style="position: relative;">
								                                    <div style="position: absolute;">Expectations:</div>
								                                 </div>
								                          </div>
								                          <div style="padding-left: 10px; margin-left: 60px; margin-right: 10px; margin-bottom: 10px; height: 30px; border: 1px solid black; background-color: #F9E79F; display: block;" id="expVal-'.$row_get_functionality['functionality_id'].'-'.$row_get_functionality_usecases['usecase_id'].'-'.$row_get_functionality_usecases_steps['usecase_step_id'].'">
								                                <div style="position: relative;">
								                                  <div style="position: absolute; width: 100%">
								                                    <input type="text" name="" style="height: 20px; width: 100%" value="'.$row_get_step_details['step_expecs'].'" id="exp_inp-'.$row_get_functionality['functionality_id'].'-'.$row_get_functionality_usecases['usecase_id'].'-'.$row_get_functionality_usecases_steps['usecase_step_id'].'">
								                                  </div>
								                                </div>
								                          </div>
								                    </td>
									            </tr>
								    	';
								    	}
								    }
                                }
                                $output .= '
                                        </table>
                                        </td>
                                        </tr>
                                        </table>
                                        </div>
								    ';
			            	} 
			            } 
			            $output .= '
                              </td>
                              </tr>
                              <tr>
                              <td id="functionality_classes_td-'.$row_get_functionality['functionality_id'].'">
                              <div class="viewClasses" id="functionality_classes_header-'.$row_get_functionality['functionality_id'].'" style="height: 20px; background-color: #BCBABE; margin: 20px 20px 0 20px; padding-left: 15px; cursor:pointer;">
		               	           <div style="position: relative;">
		               	              <div style="position: absolute;">
		               	              View Identified Classes
		               	              </div>
		               	              <div style="position: absolute; right: 30px;">
									      <i class="material-icons addClasses" style="font-size: 20px; right: 5px; cursor: pointer;" id="addClass-'.$row_get_functionality['functionality_id'].'">add</i>
									  </div>
		               	           </div>
			               	  </div>';

			            $sql_get_functionality_classes = "SELECT * FROM functionality_classes_repo WHERE project_id = '" .$project_id. "' AND sprint_id <= '" .$sprint_id. "' AND functionality_id = '" .$row_get_functionality['functionality_id']. "'";
			            $result_get_functionality_classes = mysqli_query($connect,$sql_get_functionality_classes);
			            if(mysqli_num_rows($result_get_functionality_classes)>0){
			            	while($row_get_functionality_classes = mysqli_fetch_array($result_get_functionality_classes)){
			            		$sql_get_class_details = "SELECT * FROM classes_repo WHERE project_id = '" .$project_id. "' AND class_id = '" .$row_get_functionality_classes['class_mapped_id']. "'";
			            		$result_get_class_details = mysqli_query($connect,$sql_get_class_details);
			            		if(mysqli_num_rows($result_get_class_details)>0){
			            			$row_get_class_details = mysqli_fetch_array($result_get_class_details);
			            			$class_attr = $row_get_class_details['class_attr'];
			            			$class_split_arr = explode(",", $class_attr);
			            			$class_attr_string = "";
			            			foreach ($class_split_arr as $key => $value) {
			            				$class_split_arr[$key] = trim($class_split_arr[$key]);
			            				$class_attr_string .= $class_split_arr[$key];
			            				if($key < count($class_split_arr)-1){
			            					$class_attr_string.=",".PHP_EOL;
			            				}
			            			}

			            			//echo 'alert("arr string is -- '.$class_attr_string.'\n\n")';

			            			$output .= '
                                     <div class="functinality_classes-'.$row_get_functionality['functionality_id'].' classDetails" style="margin: 10px 30px 0 30px; height: 25px; display:none; cursor: pointer;" id="functionality_class_header-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'">
									     <div style="position: relative;">
									        <div style="position: absolute; height: 25px; border: 1px solid black; border-bottom: none; background-color: #A8E5FE; width: 100%; text-align: center; padding-left: 15px;" id="class_name_header-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'">'.$row_get_class_details['class_name'].'</div>
									        <div style="position: absolute; right: 5px;">
									           <icon class="material-icons cancelClass" style="font-size: 20px; cursor: pointer;"" id="cancelClass-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'">cancel</icon>
									        </div>
									        <div style="position: absolute; right: 30px;">
									           <icon class="material-icons editClassName" style="font-size: 20px; cursor: pointer;" id="editClass-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'">create</icon>
									        </div>
									     </div>
									</div>
									<div class="class_detail-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'" style="margin: 0px 30px 0 30px; border: 1px solid black; border-bottom: none; display:none;">
									     <table style="width: 100%; background-color: #A8E5FE; padding-left: 15px;">
									        <tr>
									           <td style="padding-left: 15px;">
									               <div style="margin-bottom: 20px;">
									                 <div style="position:relative;">
									                    <div style="position:absolute; height:25px;">
									                    Attributes:
									                    </div>
									                    <div style="position:absolute; right:5px;">
									                       <icon class="material-icons addClassAttributes" style="font-size:20px; cursor:pointer;" id="classAttr-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'">create</icon>
									                    </div>
									                 </div>
									               </div>
									           </td>
									        </tr>
									     	<tr>
									     	   <td style="padding: 10px 20px 10px 20px;">
									     	      <textarea id="textArr-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'" style="width: 100%;">'.$class_attr_string.'</textarea>
									     	   </td>
									     	</tr>
									     </table>
									</div>
									<div class="class_detail-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].' methods" style="margin: 0px 30px 0 30px; height: 25px; display:none; cursor:pointer;" id="functionality_method-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'">
									     <div style="position: relative;">
									         <div style="position: absolute; height: 25px; border: 1px solid black; border-bottom: none; background-color: #A8E5FE; width: 100%; text-align: left; padding-left: 15px;">
									             Methods:
									         </div>
									         <div style="position: absolute; right: 5px;">
									            <icon class="material-icons addClassMethods" style="font-size: 20px; cursor: pointer;" id="addMethod-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'">add</icon>
									         </div>
									     </div>
									</div>
									<div class="class_detail-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'" style="margin: 0 30px 10px 30px; display:none;">
									     <table id="tableClassMethods-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'" style="width: 100%; border: 1px solid black;">
			            		';
                                $sql_get_class_methods = "SELECT * FROM functionality_classes_methods_repo WHERE project_id = '" .$project_id. "' AND class_id = '" .$row_get_functionality_classes['class_mapped_id']. "'";
                                $result_get_class_methods = mysqli_query($connect,$sql_get_class_methods);
                                if(mysqli_num_rows($result_get_class_methods)>0){
                                	while($row_get_class_methods = mysqli_fetch_array($result_get_class_methods)){
                                	  $output .= '
                                           <tr>
									          <td>
									              <table style="width: 100%;">
									                  <tr>
									                     <td style="width: 100%;">
									                        <div class="methodDetails method-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'" style="height: 20px; display:none" id="method_details-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'-'.$row_get_class_methods['class_method_id'].'">
									                            <div style="position: relative;">
									                               <div style="position: absolute; border-bottom: 1px solid black; width: 100%; text-align: left;" id="stepsHeaderWithinClass-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'-'.$row_get_class_methods['class_method_id'].'">'.$row_get_class_methods['class_method_name'].'</div>
									                               <div style="position: absolute; right: 5px;">
									                                 <i class="material-icons cancelClassMethod" style="font-size: 20px; cursor: pointer;" id="cancelStepsWithinClass-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'-'.$row_get_class_methods['class_method_id'].'">cancel</i>
									                               </div>
									                               <div style="position: absolute; right: 30px;">
									                                 <i class="fa fa-chevron-circle-down" style="font-size: 20px; cursor: pointer;" id="arrowDownWithinClass-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'-'.$row_get_class_methods['class_method_id'].'"></i>
									                               </div>
									                               <div style="position: absolute; right: 50px;">
									                                 <i class="fa fa-chevron-circle-up" style="font-size: 20px; cursor: pointer;" id="arrowUpWithinClass-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'-'.$row_get_class_methods['class_method_id'].'"></i>
									                               </div>
									                               <div style="position: absolute; right: 70px;">
									                                 <i class="material-icons editClassMethod" style="font-size: 20px; cursor: pointer;" id="editStepWithinClass-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'-'.$row_get_class_methods['class_method_id'].'">create</i>
									                               </div>
									                               <div style="position: absolute; right: 95px;">
									                                 <i class="material-icons repoClassMethod" style="font-size: 20px; cursor: pointer;" id="repoStepWithinClass-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'-'.$row_get_class_methods['class_method_id'].'">playlist_add</i>
									                               </div>
									                            </div>
									                          </div>
									                          ';
                                      $sql_get_step_details = "SELECT * FROM steps_repo WHERE project_id = '" .$project_id. "' AND step_id = '" .$row_get_class_methods['existing_step_id']. "'";
                                      $result_get_step_details = mysqli_query($connect,$sql_get_step_details);
                                      if(mysqli_num_rows($result_get_step_details)>0){
                                      	 $row_get_step_details = mysqli_fetch_array($result_get_step_details);
                                      	        $output .= '
									                          <div class="methodDetails-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'-'.$row_get_class_methods['class_method_id'].'" style="padding-left: 10px; margin-left: 60px; margin-top: 10px; margin-right: 10px; height: 20px; border: 1px solid black; background-color: #F9E79F; display: none;" id="reqHeaderStepWithinClass-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'-'.$row_get_class_methods['class_method_id'].'">
									                             <div style="position: relative;">
									                                <div style="position: absolute;">Requirements:</div>
									                             </div>
									                          </div>
									                          <div class="methodDetails-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'-'.$row_get_class_methods['class_method_id'].'" style="padding-left: 10px; margin-left: 60px; margin-right: 10px; height: 30px; border: 1px solid black; background-color: #F9E79F; display: none;" id="reqInpStepWithinClass-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'-'.$row_get_class_methods['class_method_id'].'">
									                                <div style="position: relative;">
									                                  <div style="position: absolute; width: 100%">
									                                    <input type="text" name="" style="height: 20px; width: 100%" value="'.$row_get_step_details['step_reqs'].'" id="req_inp_StepWithinClass-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'-'.$row_get_class_methods['class_method_id'].'">
									                                  </div>
									                                </div>
									                          </div>
									                          <div class="methodDetails-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'-'.$row_get_class_methods['class_method_id'].'" style="padding-left: 10px; margin-left: 60px; margin-right: 10px; height: 20px; border: 1px solid black; background-color: #F9E79F; display: none;" id="methodsStepWithinClass-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'-'.$row_get_class_methods['class_method_id'].'">
									                                <div style="position: relative;">
									                                  <div style="position: absolute;">Method Notes</div>
									                                </div>
									                          </div>
									                          <div class="methodDetails-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'-'.$row_get_class_methods['class_method_id'].'" style="padding-left: 10px; margin-left: 60px; margin-right: 10px; height: 30px; border: 1px solid black; background-color: #F9E79F; display: none;" id="methodValStepsWithinClass-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'-'.$row_get_class_methods['class_method_id'].'">
									                                <div style="position: relative;">
									                                  <div style="position: absolute; width: 100%">
									                                    <input type="text" name="" style="height: 20px; width: 100%;" id="method_inp_StepsWithinClass-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'-'.$row_get_class_methods['class_method_id'].'" value="'.$row_get_step_details['step_method_notes'].'">
									                                  </div>
									                                </div>
									                          </div>
									                          <div class="methodDetails-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'-'.$row_get_class_methods['class_method_id'].'" style="padding-left: 10px; margin-left: 60px; margin-right: 10px; height: 20px; border: 1px solid black; background-color: #F9E79F; display: none;" id="expHeaderStepsWithinClass-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'-'.$row_get_class_methods['class_method_id'].'">
									                                 <div style="position: relative;">
									                                    <div style="position: absolute;">Expectations:</div>
									                                 </div>
									                          </div>
									                          <div class="methodDetails-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'-'.$row_get_class_methods['class_method_id'].'" style="padding-left: 10px; margin-left: 60px; margin-right: 10px; margin-bottom: 10px; height: 30px; border: 1px solid black; background-color: #F9E79F; display: none;" id="expValStepWithinClass-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'-'.$row_get_class_methods['class_method_id'].'">
									                                <div style="position: relative;">
									                                  <div style="position: absolute; width: 100%">
									                                    <input type="text" name="" style="height: 20px; width: 100%" value="'.$row_get_step_details['step_expecs'].'" id="exp_inp_StepWithinClass-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'-'.$row_get_class_methods['class_method_id'].'">
									                                  </div>
									                                </div>
									                          </div>
                                      ';
                                      }
                                      else{
                                      	 $output .= '
									                          <div class="methodDetails-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'-'.$row_get_class_methods['class_method_id'].'" style="padding-left: 10px; margin-left: 60px; margin-top: 10px; margin-right: 10px; height: 20px; border: 1px solid black; background-color: #F9E79F; display: none;" id="reqHeaderStepWithinClass-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'-'.$row_get_class_methods['class_method_id'].'">
									                             <div style="position: relative;">
									                                <div style="position: absolute;">Requirements:</div>
									                             </div>
									                          </div>
									                          <div class="methodDetails-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'-'.$row_get_class_methods['class_method_id'].'" style="padding-left: 10px; margin-left: 60px; margin-right: 10px; height: 30px; border: 1px solid black; background-color: #F9E79F; display: none;" id="reqInpStepWithinClass-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'-'.$row_get_class_methods['class_method_id'].'">
									                                <div style="position: relative;">
									                                  <div style="position: absolute; width: 100%">
									                                    <input type="text" name="" style="height: 20px; width: 100%" value="" id="req_inp_StepWithinClass-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'-'.$row_get_class_methods['class_method_id'].'">
									                                  </div>
									                                </div>
									                          </div>
									                          <div class="methodDetails-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'-'.$row_get_class_methods['class_method_id'].'" style="padding-left: 10px; margin-left: 60px; margin-right: 10px; height: 20px; border: 1px solid black; background-color: #F9E79F; display: none;" id="methodsStepWithinClass-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'-'.$row_get_class_methods['class_method_id'].'">
									                                <div style="position: relative;">
									                                  <div style="position: absolute;">Method Notes</div>
									                                </div>
									                          </div>
									                          <div class="methodDetails-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'-'.$row_get_class_methods['class_method_id'].'" style="padding-left: 10px; margin-left: 60px; margin-right: 10px; height: 30px; border: 1px solid black; background-color: #F9E79F; display: none;" id="methodValStepsWithinClass-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'-'.$row_get_class_methods['class_method_id'].'">
									                                <div style="position: relative;">
									                                  <div style="position: absolute; width: 100%">
									                                    <input type="text" name="" style="height: 20px; width: 100%;" id="method_inp_StepsWithinClass-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'-'.$row_get_class_methods['class_method_id'].'" value="">
									                                  </div>
									                                </div>
									                          </div>
									                          <div class="methodDetails-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'-'.$row_get_class_methods['class_method_id'].'" style="padding-left: 10px; margin-left: 60px; margin-right: 10px; height: 20px; border: 1px solid black; background-color: #F9E79F; display: none;" id="expHeaderStepsWithinClass-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'-'.$row_get_class_methods['class_method_id'].'">
									                                 <div style="position: relative;">
									                                    <div style="position: absolute;">Expectations:</div>
									                                 </div>
									                          </div>
									                          <div class="methodDetails-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'-'.$row_get_class_methods['class_method_id'].'" style="padding-left: 10px; margin-left: 60px; margin-right: 10px; margin-bottom: 10px; height: 30px; border: 1px solid black; background-color: #F9E79F; display: none;" id="expValStepWithinClass-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'-'.$row_get_class_methods['class_method_id'].'">
									                                <div style="position: relative;">
									                                  <div style="position: absolute; width: 100%">
									                                    <input type="text" name="" style="height: 20px; width: 100%" value="" id="exp_inp_StepWithinClass-'.$row_get_functionality_classes['functionality_id'].'-'.$row_get_functionality_classes['class_id'].'-'.$row_get_class_methods['class_method_id'].'">
									                                  </div>
									                                </div>
									                          </div>
                                      ';
                                      }
                                      $output .= '
                                                         </td>
									                  </tr>
									               </table>
									          </td>
									        </tr>
                                      ';

                                	}
                                }
                                $output .= '
                                         </table>
                                         </div>
                                	';
			            		}
			            	}
			            }
			            $output .= '
			                 </td>
			                 </tr>
			                 <tr>
			               	     <td id="functionality_groupings_td-'.$row_get_functionality['functionality_id'].'">
			               	        <div class="viewGroupings" style="height: 20px; background-color: #BCBABE; margin: 20px 20px 0 20px; padding-left: 15px; cursor:pointer;" id="functionality_groupings-'.$row_get_functionality['functionality_id'].'">
			               	           <div style="position: relative;">
			               	              <div style="position: absolute;">
			               	              View Groupings
			               	              </div>
			               	              <div style="position: absolute; right: 30px;">
										      <i class="material-icons addGroupings" style="font-size: 20px; right: 5px; cursor: pointer;" id="addGroupings-'.$row_get_functionality['functionality_id'].'">add</i>
										  </div>
			               	           </div>
			               	        </div>
			            ';

			            $sql_get_functionality_groupings = "SELECT * FROM functionality_groupings_repo WHERE project_id = '" .$project_id. "' AND sprint_id <= '" .$sprint_id. "' AND functionality_id = '" .$row_get_functionality['functionality_id']. "'";
			            $result_get_functionality_groupings = mysqli_query($connect,$sql_get_functionality_groupings);
			            if(mysqli_num_rows($result_get_functionality_groupings)>0){
			            	while($row_get_functionality_groupings = mysqli_fetch_array($result_get_functionality_groupings)){
                                $output .= '
                                     <div class="functionality_groupings-'.$row_get_functionality['functionality_id'].'" style="margin: 10px 30px 0 30px; border: 1px solid black; height: 25px; display:none;">
								       <div style="position: relative;">
								          <div style="position: absolute; height: 25px; background-color: #A8E5FE; width: 100%">'.$row_get_functionality_groupings['group_name'].'</div>
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

                                $sql_get_grouping_classes = "SELECT * FROM functionality_classes_repo WHERE project_id = '" .$project_id. "' AND sprint_id <= '" .$sprint_id. "' AND functionality_id = '" .$row_get_functionality_groupings['functionality_id']. "' AND group_mapped = 'yes' AND group_mapped_id = '" .$row_get_functionality_groupings['group_id']. "'";
                                $result_get_grouping_classes = mysqli_query($connect,$sql_get_grouping_classes);
                                if(mysqli_num_rows($result_get_grouping_classes)>0){
                                	$output .= '
                                       <div class="functionality_groupings-'.$row_get_functionality['functionality_id'].'" style="margin: 0px 30px 10px 30px; display:none;">
								         <table style="width: 100%; border: 1px solid black;">
                                	';
                                	while($row_get_grouping_classes = mysqli_fetch_array($result_get_grouping_classes)){
                                        $sql_get_class_details = "SELECT class_name FROM classes_repo WHERE project_id = '" .$project_id. "' AND class_id = '" .$row_get_grouping_classes['class_mapped_id']. "'";
                                        $result_get_class_details = mysqli_query($connect,$sql_get_class_details);
                                        if(mysqli_num_rows($result_get_class_details)>0){
                                        	$row_get_class_details = mysqli_fetch_array($result_get_class_details);
                                        	$output .= '
                                                 <tr>
										       	    <td style="padding-left: 15px;">
										       	      <div style="height: 20px;">
										       	         <div style="position: relative;">
										       	            <div style="position: absolute; width: 100%;">'.$row_get_class_details['class_name'].'</div>
										       	            <div style="position: absolute; right: 5px;">
										       	              <i class="material-icons" style="font-size: 20px; cursor: pointer;">cancel</i>
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
                                }
			            	}
			            }


			            $output .= '
                              </td>
                              </tr>
			            ';

                        $output .='      
                              </table>
                              </div>
                              </td>
                              </tr>
			            ';

   	  	 	}
   	  	 	$output .= '
               </table>
               </div>
   	  	 	';
   	  	 } 
   	  }

   	  echo $output;
   }
?>