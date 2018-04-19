<?php
  $pType = $_POST['p'];
  $project_id = $_POST['project_id'];
  $sprint_id = $_POST['sprint_id'];
  $functionality_id = $_POST['functionality_id'];

  if(strcmp($pType,"1")==0){
  	 $usecases = json_decode($_POST['usecase_json'],true);

  	 $connect = mysqli_connect("localhost", "root", "root", "fcd_decomposition_db");

  	 $sql_get_usecase_id = "SELECT usecase_id FROM functionality_usecases_repo WHERE project_id = '".$project_id."' AND sprint_id = '".$sprint_id."' AND functionality_id = '".$functionality_id."' ORDER BY usecase_id DESC LIMIT 1";
  	 $val = 0;
  	 $result_get_usecase_id = mysqli_query($connect,$sql_get_usecase_id);
  	 if(mysqli_num_rows($result_get_usecase_id)>0){
        $row_get_usecase_id = mysqli_fetch_array($result_get_usecase_id);
        $val = $row_get_usecase_id['usecase_id'];
  	 }

     $output = '';

     foreach ($usecases as $key => $value) {
        $val = $val + 1;
        $sql_add_usecase = "INSERT INTO functionality_usecases_repo (project_id,sprint_id,functionality_id,usecase_id,usecase_name) VALUES('" .$project_id. "', '" .$sprint_id. "', '" .$functionality_id. "', '" .$val. "', '" .$usecases[$key]['usecase']. "')";
        $result_add_usecase = mysqli_query($connect,$sql_add_usecase);
        if(!$result_add_usecase){
          echo 'Error thrown -- ' . mysqli_error($connect);
        }
        else{
          $output .= '
                  <div class="usecases_list-'.$functionality_id.' usecaseDetails" style="margin: 10px 30px 0 30px; height: 25px; display:none; cursor:pointer;" id="usecase_header-'.$functionality_id.'-'.$val.'">
                      <div style="position: relative;">
                             <div style="position: absolute; height: 25px; border: 1px solid black; border-bottom: none; background-color: #F9E79F; width: 100%; text-align: left; padding-left: 15px;" id="usecase_name-'.$functionality_id.'-'.$val.'">'.$usecases[$key]['usecase'].'</div>
                             <div style="position: absolute; right: 5px;">
                               <i class="material-icons cancelUsecase" style="font-size: 20px; cursor: pointer;" id="cancel-'.$functionality_id.'-'.$val.'">cancel</i>
                             </div>
                             <div style="position: absolute; right: 30px;">
                               <i class="material-icons addStepWithinUsecase" style="font-size: 20px; cursor: pointer;" id="add-'.$functionality_id.'-'.$val.'">add</i>
                             </div>
                             <div style="position: absolute; right: 60px;">
                               <i class="material-icons createUsecase" style="font-size: 20px; cursor: pointer;" id="edit-'.$functionality_id.'-'.$val.'">create</i>
                             </div>
                      </div>
                  </div>
                  <div class="usecase_steps-'.$functionality_id.'-'.$val.'" style="margin: 0px 30px 10px 30px; display:none;">
                          <!-- outer table wrap around container to hold steps for each usecase -->
                          <table style="width: 100%; border: 1px solid black;">
                            <tr>
                              <td id="tablestepstd-0-1">
                                  <!-- table to hold steps mapped within usecase -->
                                  <table style="width: 100%" id="tablesteps-'.$functionality_id.'-'.$val.'">
                                  </table>
                              </td>
                            </tr>
                          </table>
                  </div>
              ';
        } 
     }

  	 mysqli_close($connect);
     echo $output;
  }
  else if(strcmp($pType,"2")==0){
    $output = '';
    $usecase_id = $_POST["usecase_id"];
    $steps = json_decode($_POST['step_json'],true);

    $connect = mysqli_connect("localhost", "root", "root", "fcd_decomposition_db");
    
    $sql_step = "SELECT step_id FROM steps_repo WHERE project_id = '".$project_id."' ORDER BY step_id DESC LIMIT 1";
    $result_step = mysqli_query($connect,$sql_step);
    $val_step = 0;
    if(mysqli_num_rows($result_step)>0){
       $row_step = mysqli_fetch_array($result_step);
       $val_step = $row_step['step_id'];
    }

    $sql = "SELECT usecase_step_id FROM functionality_usecases_steps_repo WHERE project_id = '".$project_id."' AND sprint_id = '".$sprint_id."' AND functionality_id = '".$functionality_id."' AND usecase_id = '".$usecase_id."' ORDER BY usecase_step_id DESC LIMIT 1";
    $val = 0;
    $result = mysqli_query($connect,$sql);
    if(mysqli_num_rows($result)>0){
       $row = mysqli_fetch_array($result);
       $val = $row['usecase_step_id'];
    }

    foreach ($steps as $key => $value) {
       $val_step = $val_step + 1;
       $val = $val + 1;

       if(strcmp($steps[$key]['existing_step_id'],"")==0){
          $sql_insert_step = "INSERT INTO steps_repo (project_id,step_id,step_name,step_reqs,step_method_notes,step_expecs,step_mapped,mapped_class_id) VALUES('".$project_id."','".$val_step."','".$steps[$key]['step_name']."','".$steps[$key]['step_reqs']."','".$steps[$key]['step_methods']."','".$steps[$key]['step_expecs']."','no',NULL)";
          $result_insert_step = mysqli_query($connect,$sql_insert_step);
          if($result_insert_step){
            $sql_insert_into_usecase = "INSERT INTO functionality_usecases_steps_repo (project_id,sprint_id,functionality_id,usecase_id,usecase_step_id,usecase_mapped_step_id) VALUES('".$project_id."','".$sprint_id."','".$functionality_id."','".$usecase_id."','".$val."','".$val_step."')";
            $result_insert_into_usecase = mysqli_query($connect,$sql_insert_into_usecase);
            if(!$result_insert_into_usecase){
              echo 'Error thrown -- ' . mysqli_error($connect);
            }
            else{
                $output .= '
                     <tr id="table_steps_tr-'.$functionality_id.'-'.$usecase_id.'-'.$val.'">
                        <td style="padding: 5px">
                              <div style="height: 20px;">
                                <div style="position: relative;">
                                   <div style="position: absolute; border-bottom: 1px solid black; width: 100%; text-align: left;" id="stepsHeader-'.$functionality_id.'-'.$usecase_id.'-'.$val.'">'.$steps[$key]['step_name'].'</div>
                                   <div style="position: absolute; right: 5px;">
                                     <i class="material-icons" style="font-size: 20px; cursor: pointer;" id="cancel-'.$functionality_id.'-'.$usecase_id.'-'.$val.'">cancel</i>
                                   </div>
                                   <div style="position: absolute; right: 30px;">
                                     <i class="fa fa-chevron-circle-down" style="font-size: 20px; cursor: pointer;" id="arrowDown-'.$functionality_id.'-'.$usecase_id.'-'.$val.'"></i>
                                   </div>
                                   <div style="position: absolute; right: 50px;">
                                     <i class="fa fa-chevron-circle-up" style="font-size: 20px; cursor: pointer;" id="arrowUp-'.$functionality_id.'-'.$usecase_id.'-'.$val.'"></i>
                                   </div>
                                   <div style="position: absolute; right: 70px;">
                                     <i class="material-icons" style="font-size: 20px; cursor: pointer;" id="edit-'.$functionality_id.'-'.$usecase_id.'-'.$val.'">create</i>
                                   </div>
                                   <div style="position: absolute; right: 95px;">
                                     <i class="material-icons" style="font-size: 20px; cursor: pointer;" id="repo-'.$functionality_id.'-'.$usecase_id.'-'.$val.'">playlist_add</i>
                                   </div>
                                </div>
                              </div>
                              <div style="padding-left: 10px; margin-left: 60px; margin-top: 10px; margin-right: 10px; height: 20px; border: 1px solid black; background-color: #F9E79F; display: block;" id="reqHeader-'.$functionality_id.'-'.$usecase_id.'-'.$val.'">
                                 <div style="position: relative;">
                                    <div style="position: absolute;">Requirements:</div>
                                 </div>
                              </div>
                              <div style="padding-left: 10px; margin-left: 60px; margin-right: 10px; height: 30px; border: 1px solid black; background-color: #F9E79F; display: block;" id="reqInp-'.$functionality_id.'-'.$usecase_id.'-'.$val.'">
                                    <div style="position: relative;">
                                      <div style="position: absolute; width: 100%">
                                        <input type="text" name="" style="height: 20px; width: 100%" value="'.$steps[$key]['step_reqs'].'" id="req_inp-'.$functionality_id.'-'.$usecase_id.'-'.$val.'">
                                      </div>
                                    </div>
                              </div>
                              <div style="padding-left: 10px; margin-left: 60px; margin-right: 10px; height: 20px; border: 1px solid black; background-color: #F9E79F; display: block;" id="methods-'.$functionality_id.'-'.$usecase_id.'-'.$val.'">
                                    <div style="position: relative;">
                                      <div style="position: absolute;">Method Notes</div>
                                    </div>
                              </div>
                              <div style="padding-left: 10px; margin-left: 60px; margin-right: 10px; height: 30px; border: 1px solid black; background-color: #F9E79F; display: block;" id="methodVal-'.$functionality_id.'-'.$usecase_id.'-'.$val.'">
                                    <div style="position: relative;">
                                      <div style="position: absolute; width: 100%">
                                        <input type="text" name="" style="height: 20px; width: 100%;" id="method_inp-'.$functionality_id.'-'.$usecase_id.'-'.$val.'" value="'.$steps[$key]['step_methods'].'">
                                      </div>
                                    </div>
                              </div>
                              <div style="padding-left: 10px; margin-left: 60px; margin-right: 10px; height: 20px; border: 1px solid black; background-color: #F9E79F; display: block;" id="expHeader-'.$functionality_id.'-'.$usecase_id.'-'.$val.'">
                                     <div style="position: relative;">
                                        <div style="position: absolute;">Expectations:</div>
                                     </div>
                              </div>
                              <div style="padding-left: 10px; margin-left: 60px; margin-right: 10px; margin-bottom: 10px; height: 30px; border: 1px solid black; background-color: #F9E79F; display: block;" id="expVal-0-1-1">
                                    <div style="position: relative;">
                                      <div style="position: absolute; width: 100%">
                                        <input type="text" name="" style="height: 20px; width: 100%" value="'.$steps[$key]['step_expecs'].'" id="exp_inp-'.$functionality_id.'-'.$usecase_id.'-'.$val.'">
                                      </div>
                                    </div>
                              </div>
                        </td>
                     </tr>
                ';
            }

          }
          else{
            echo 'Error thrown -- ' . mysqli_error($connect);
          }
       }
       else{
          $sql_steps = "SELECT * FROM steps_repo WHERE step_id = '" .$steps[$key]['existing_step_id']. "'";
          $result_steps = mysqli_query($connect,$sql_steps);
          if(mysqli_num_rows($result_steps)>0){
             $sql_insert_into_usecase = "INSERT INTO functionality_usecases_steps_repo (project_id,sprint_id,functionality_id,usecase_id,usecase_step_id,usecase_mapped_step_id) VALUES('".$project_id."','".$sprint_id."','".$functionality_id."','".$usecase_id."','".$val."','".$steps[$key]['existing_step_id']."')";
             $result_insert_into_usecase = mysqli_query($connect,$sql_insert_into_usecase);
             if($result_insert_into_usecase){
                  $output .= '
                     <tr>
                        <td style="padding: 5px">
                              <div style="height: 20px;">
                                <div style="position: relative;">
                                   <div style="position: absolute; border-bottom: 1px solid black; width: 100%; text-align: left;" id="stepsHeader-'.$functionality_id.'-'.$usecase_id.'-'.$val.'">'.$steps[$key]['step_name'].'</div>
                                   <div style="position: absolute; right: 5px;">
                                     <i class="material-icons cancelStepsWithinUsecase" style="font-size: 20px; cursor: pointer;" id="cancel-'.$functionality_id.'-'.$usecase_id.'-'.$val.'">cancel</i>
                                   </div>
                                   <div style="position: absolute; right: 30px;">
                                     <i class="fa fa-chevron-circle-down" style="font-size: 20px; cursor: pointer;" id="arrowDown-'.$functionality_id.'-'.$usecase_id.'-'.$val.'"></i>
                                   </div>
                                   <div style="position: absolute; right: 50px;">
                                     <i class="fa fa-chevron-circle-up" style="font-size: 20px; cursor: pointer;" id="arrowUp-'.$functionality_id.'-'.$usecase_id.'-'.$val.'"></i>
                                   </div>
                                   <div style="position: absolute; right: 70px;">
                                     <i class="material-icons" style="font-size: 20px; cursor: pointer;" id="edit-'.$functionality_id.'-'.$usecase_id.'-'.$val.'">create</i>
                                   </div>
                                   <div style="position: absolute; right: 95px;">
                                     <i class="material-icons repoStepsWithinUsecase" style="font-size: 20px; cursor: pointer;" id="repo-'.$functionality_id.'-'.$usecase_id.'-'.$val.'">playlist_add</i>
                                   </div>
                                </div>
                              </div>
                              <div style="padding-left: 10px; margin-left: 60px; margin-top: 10px; margin-right: 10px; height: 20px; border: 1px solid black; background-color: #F9E79F; display: block;" id="reqHeader-'.$functionality_id.'-'.$usecase_id.'-'.$val.'">
                                 <div style="position: relative;">
                                    <div style="position: absolute;">Requirements:</div>
                                 </div>
                              </div>
                              <div style="padding-left: 10px; margin-left: 60px; margin-right: 10px; height: 30px; border: 1px solid black; background-color: #F9E79F; display: block;" id="reqInp-'.$functionality_id.'-'.$usecase_id.'-'.$val.'">
                                    <div style="position: relative;">
                                      <div style="position: absolute; width: 100%">
                                        <input type="text" name="" style="height: 20px; width: 100%" value="'.$steps[$key]['step_reqs'].'" id="req_inp-'.$functionality_id.'-'.$usecase_id.'-'.$val.'">
                                      </div>
                                    </div>
                              </div>
                              <div style="padding-left: 10px; margin-left: 60px; margin-right: 10px; height: 20px; border: 1px solid black; background-color: #F9E79F; display: block;" id="methods-'.$functionality_id.'-'.$usecase_id.'-'.$val.'">
                                    <div style="position: relative;">
                                      <div style="position: absolute;">Method Notes</div>
                                    </div>
                              </div>
                              <div style="padding-left: 10px; margin-left: 60px; margin-right: 10px; height: 30px; border: 1px solid black; background-color: #F9E79F; display: block;" id="methodVal-'.$functionality_id.'-'.$usecase_id.'-'.$val.'">
                                    <div style="position: relative;">
                                      <div style="position: absolute; width: 100%">
                                        <input type="text" name="" style="height: 20px; width: 100%;" id="method_inp-'.$functionality_id.'-'.$usecase_id.'-'.$val.'" value="'.$steps[$key]['step_methods'].'">
                                      </div>
                                    </div>
                              </div>
                              <div style="padding-left: 10px; margin-left: 60px; margin-right: 10px; height: 20px; border: 1px solid black; background-color: #F9E79F; display: block;" id="expHeader-'.$functionality_id.'-'.$usecase_id.'-'.$val.'">
                                     <div style="position: relative;">
                                        <div style="position: absolute;">Expectations:</div>
                                     </div>
                              </div>
                              <div style="padding-left: 10px; margin-left: 60px; margin-right: 10px; margin-bottom: 10px; height: 30px; border: 1px solid black; background-color: #F9E79F; display: block;" id="expVal-0-1-1">
                                    <div style="position: relative;">
                                      <div style="position: absolute; width: 100%">
                                        <input type="text" name="" style="height: 20px; width: 100%" value="'.$steps[$key]['step_expecs'].'" id="exp_inp-'.$functionality_id.'-'.$usecase_id.'-'.$val.'">
                                      </div>
                                    </div>
                              </div>
                        </td>
                     </tr>
                ';
             }
          }
       }

     }
     echo $output; 
  }
  else if(strcmp($pType, "3")==0){
    $usecase_id = $_POST['usecase_id'];
    $step_id = $_POST['step_id'];
    $connect = mysqli_connect("localhost", "root", "root", "fcd_decomposition_db");
    $sql = "DELETE FROM functionality_usecases_steps_repo WHERE project_id = '" .$project_id. "' AND sprint_id = '" .$sprint_id. "' AND functionality_id = '" .$functionality_id. "' AND usecase_id = '" .$usecase_id. "' AND usecase_step_id = '" .$step_id. "'";
    $result = mysqli_query($connect,$sql);
    if(!$result){
       echo mysqli_error($connect);
    }
  }
  else if(strcmp($pType, "4")==0){
    $usecase_id = $_POST['usecase_id'];
    $connect = mysqli_connect("localhost", "root", "root", "fcd_decomposition_db");
    $sql = "DELETE FROM functionality_usecases_repo WHERE project_id = '" .$project_id. "' AND sprint_id = '" .$sprint_id. "' AND functionality_id = '" .$functionality_id. "' AND usecase_id = '" .$usecase_id. "'";
    $result = mysqli_query($connect,$sql);
    if($result){
      $sql_delete = "DELETE FROM functionality_usecases_steps_repo WHERE project_id = '" .$project_id. "' AND sprint_id = '" .$sprint_id. "' AND functionality_id = '" .$functionality_id. "' AND usecase_id = '" .$usecase_id. "'";
      $result_delete = mysqli_query($connect,$sql_delete);
      if($result_delete){

      }
    }
  }
?>