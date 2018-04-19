<?php
  $project_id = $_POST['project_id'];
  $output = '';
  //$sprint_id = $_POST['sprint_id'];

  $connect = mysqli_connect("localhost", "root", "root", "fcd_decomposition_db");
  $sql_get_fcds = "SELECT * FROM fcd_header_table_repo WHERE project_id = '" .$project_id. "'";
  $result_fcds = mysqli_query($connect,$sql_get_fcds);

  if(mysqli_num_rows($result_fcds)>0){
  	while($row_fcds = mysqli_fetch_array($result_fcds)){
       $output .= '
          <div style="margin: 30px 30px 0 30px; height: 25px;">
               <div style="position: relative;">
                  <div style="position: absolute; height: 25px; border: 1px solid black; background-color: #BCBABE; width: 100%; text-align: center; padding-left: 15px;" id = "fcd_header-'.$row_fcds['fcd_header_id'].'">'.$row_fcds['fcd_name'].'</div>
               </div>
          </div>
       ';
       
       if($row_fcds['fcd_header_id']==0){
       	  //echo "ERROR -- ";

       	  $sql_get_funcs = "SELECT * FROM functionality_list_repo WHERE project_id = '".$project_id."' AND fcd_id = '" .$row_fcds['fcd_header_id']. "'";
       	  $result_funcs = mysqli_query($connect,$sql_get_funcs);
       	  if(mysqli_num_rows($result_funcs)>0){
       	  	$output .= '
             <div style="margin: 0px 30px 0 30px; border: 1px solid black; ">
             <table style="width:100%">
          ';
       	  	$row_funcs = mysqli_fetch_array($result_funcs);

       	  	$sql_get_parent_funcs = "SELECT * FROM functionality_list_repo WHERE project_id = '" .$project_id. "' AND parent_functionality_id = '".$row_funcs['functionality_id']."'";
       	  	$result_parent_funcs = mysqli_query($connect,$sql_get_parent_funcs);

       	  	if(mysqli_num_rows($result_parent_funcs)>0){
       	  		while($row_parent_funcs = mysqli_fetch_array($result_parent_funcs)){
                    $output .= '
                       <tr>
                         <td valign="top">
                            <div style="margin: 10px 30px 0 30px; border: 1px solid black; height: 25px;">
						       <div style="position: relative;">
						          <div style="position: absolute; height: 25px; background-color: #A8E5FE; width: 100%">'.$row_parent_funcs['functionality_name'].'</div>
						       </div>
						    </div>
						    <div style="margin: 0px 30px 10px 30px;">
								<table style="width: 100%; border: 1px solid black;">
					';
                    
                    $sql_group_classes = "SELECT * FROM functionality_classes_repo WHERE project_id = '".$project_id."' AND group_mapped = 'yes' AND group_mapped_id = '".$row_parent_funcs['functionality_id']."'";
                    $result_group_classes = mysqli_query($connect,$sql_group_classes);

                    if(mysqli_num_rows($result_group_classes)>0){
                    	while($row_group_classes = mysqli_fetch_array($result_group_classes)){
                    		$sql_class_name = "SELECT class_name FROM classes_repo WHERE class_id = '".$row_group_classes['class_mapped_id']."' AND project_id = '".$project_id."'";
                    		$result_class_name = mysqli_query($connect,$sql_class_name);

                    		if(mysqli_num_rows($result_class_name)>0){
                    			$row_class_name = mysqli_fetch_array($result_class_name);
                    			$output .= '
                                 <tr>
						       	    <td style="padding-left: 15px;">
						       	      <div style="height: 20px;">
						       	         <div style="position: relative;">
						       	            <div style="position: absolute; width: 100%;">'.$row_class_name['class_name'].'</div>
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
								</div>
                         </td>
                       
                   ';

                    if($row_parent_funcs = mysqli_fetch_array($result_parent_funcs)){
		                    $output .= '
		                       
		                         <td valign="top">
		                            <div style="margin: 10px 30px 0 30px; border: 1px solid black; height: 25px;">
								       <div style="position: relative;">
								          <div style="position: absolute; height: 25px; background-color: #A8E5FE; width: 100%">'.$row_parent_funcs['functionality_name'].'</div>
								       </div>
								    </div>
								    <div style="margin: 0px 30px 10px 30px;">
										<table style="width: 100%; border: 1px solid black;">
							';
		                    
		                    $sql_group_classes = "SELECT * FROM functionality_classes_repo WHERE project_id = '".$project_id."' AND group_mapped = 'yes' AND group_mapped_id = '".$row_parent_funcs['functionality_id']."'";
		                    $result_group_classes = mysqli_query($connect,$sql_group_classes);

		                    if(mysqli_num_rows($result_group_classes)>0){
		                    	while($row_group_classes = mysqli_fetch_array($result_group_classes)){
		                    		$sql_class_name = "SELECT class_name FROM classes_repo WHERE class_id = '".$row_group_classes['class_mapped_id']."' AND project_id = '".$project_id."'";
		                    		$result_class_name = mysqli_query($connect,$sql_class_name);

		                    		if(mysqli_num_rows($result_class_name)>0){
		                    			$row_class_name = mysqli_fetch_array($result_class_name);
		                    			$output .= '
		                                 <tr>
								       	    <td style="padding-left: 15px;">
								       	      <div style="height: 20px;">
								       	         <div style="position: relative;">
								       	            <div style="position: absolute; width: 100%;">'.$row_class_name['class_name'].'</div>
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
										</div>
		                         </td>
		                    ';
                    }

                    if($row_parent_funcs = mysqli_fetch_array($result_parent_funcs)){
	                    	$output .= '
	                       
	                         <td valign="top">
	                            <div style="margin: 10px 30px 0 30px; border: 1px solid black; height: 25px;">
							       <div style="position: relative;">
							          <div style="position: absolute; height: 25px; background-color: #A8E5FE; width: 100%">'.$row_parent_funcs['functionality_name'].'</div>
							       </div>
							    </div>
							    <div style="margin: 0px 30px 10px 30px;">
									<table style="width: 100%; border: 1px solid black;">
						    ';
	                    
		                    $sql_group_classes = "SELECT * FROM functionality_classes_repo WHERE project_id = '".$project_id."' AND group_mapped = 'yes' AND group_mapped_id = '".$row_parent_funcs['functionality_id']."'";
		                    $result_group_classes = mysqli_query($connect,$sql_group_classes);

		                    if(mysqli_num_rows($result_group_classes)>0){
		                    	while($row_group_classes = mysqli_fetch_array($result_group_classes)){
		                    		$sql_class_name = "SELECT class_name FROM classes_repo WHERE class_id = '".$row_group_classes['class_mapped_id']."' AND project_id = '".$project_id."'";
		                    		$result_class_name = mysqli_query($connect,$sql_class_name);

		                    		if(mysqli_num_rows($result_class_name)>0){
		                    			$row_class_name = mysqli_fetch_array($result_class_name);
		                    			$output .= '
		                                 <tr>
								       	    <td style="padding-left: 15px;">
								       	      <div style="height: 20px;">
								       	         <div style="position: relative;">
								       	            <div style="position: absolute; width: 100%;">'.$row_class_name['class_name'].'</div>
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
										</div>
		                         </td>
		                       </tr>
		                   ';
                    }
       	  		}
       	  	}
       	  	$output .= '
               </table>
               </div>
       	  	';
       	  }
       }
       else{
       	  $select_fcd_functionality = "SELECT * FROM functionality_list_repo WHERE project_id = '".$project_id."' AND fcd_id = '".$row_fcds['fcd_header_id']."'";
       	  $result_fcd_functionality = mysqli_query($connect,$select_fcd_functionality);
          
          $output .= '
             <div style="margin: 0px 30px 0 30px; border: 1px solid black; ">
             <table style="width:100%">
          ';

       	  if(mysqli_num_rows($result_fcd_functionality)>0){
       	  	 while($row_fcd_functionality = mysqli_fetch_array($result_fcd_functionality)){
                $output .= '
                       <tr>
                         <td valign="top">
                            <div style="margin: 10px 30px 0 30px; border: 1px solid black; height: 25px;">
						       <div style="position: relative;">
						          <div style="position: absolute; height: 25px; background-color: #F0EFEA; width: 100%">'.$row_fcd_functionality['functionality_name'].'</div>
						       </div>
						    </div>
						    <div style="margin: 0px 30px 10px 30px;">
								<table style="width: 100%; border: 1px solid black;">
				';


						$sql_get_parent_funcs = "SELECT * FROM functionality_list_repo WHERE parent_functionality_id = '".$row_fcd_functionality['functionality_id']."' AND project_id = '".$project_id."'";
						$result_get_parent_funcs = mysqli_query($connect,$sql_get_parent_funcs);

						if(mysqli_num_rows($result_get_parent_funcs)>0){
							while($row_get_parent_funcs = mysqli_fetch_array($result_get_parent_funcs)){
								$output .= '
			                       <tr>
			                         <td valign="top">
			                            <div style="border: 1px solid black; margin:10px; margin-bottom: 0px; height: 25px;">
									       <div style="position: relative;">
									          <div style="position: absolute; width:100%; height: 25px; background-color: #A8E5FE;">'.$row_get_parent_funcs['functionality_name'].'</div>
									       </div>
									    </div>
									    <div style="width:100%;">
											<table style="width: 100%; border: 1px solid black;">
												</table>
										</div>
									</td>
								   </tr>
								  ';
								/*$sql_group_classes = "SELECT * FROM functionality_classes_repo WHERE project_id = '".$project_id."' AND group_mapped = 'yes' AND group_mapped_id = '".$row_get_parent_funcs['functionality_id']."'";
                                $result_group_classes = mysqli_query($connect,$sql_group_classes);

			                    if(mysqli_num_rows($result_group_classes)>0){
			                    	while($row_group_classes = mysqli_fetch_array($result_group_classes)){
			                    		$sql_class_name = "SELECT class_name FROM classes_repo WHERE class_id = '".$row_group_classes['class_mapped_id']."' AND project_id = '".$project_id."'";
			                    		$result_class_name = mysqli_query($connect,$sql_class_name);

			                    		if(mysqli_num_rows($result_class_name)>0){
			                    			$row_class_name = mysqli_fetch_array($result_class_name);
			                    			$output .= '
			                                 <tr>
									       	    <td style="padding-left: 15px;">
									       	      <div style="height: 20px;">
									       	         <div style="position: relative;">
									       	            <div style="position: absolute; width: 100%;">'.$row_class_name['class_name'].'</div>
									       	         </div>
									       	      </div>
									       	    </td>
									       	 </tr>
			                    			';
			                    		}
			                    	}
			                    }*/
					
										
							}
						}

				$output.='		</table>
							</div>
						 </td>
			    ';


                if($row_fcd_functionality = mysqli_fetch_array($result_fcd_functionality)){
                   $output .= '
                       <td valign="top">
                            <div style="margin: 10px 30px 0 30px; border: 1px solid black; height: 25px;">
						       <div style="position: relative;">
						          <div style="position: absolute; height: 25px; background-color: #F0EFEA; width: 100%">'.$row_fcd_functionality['functionality_name'].'</div>
						       </div>
						    </div>
						    <div style="margin: 0px 30px 10px 30px;">
								<table style="width: 100%; border: 1px solid black;">
								';
					    $sql_get_parent_funcs = "SELECT * FROM functionality_list_repo WHERE parent_functionality_id = '".$row_fcd_functionality['functionality_id']."' AND project_id = '".$project_id."'";
						$result_get_parent_funcs = mysqli_query($connect,$sql_get_parent_funcs);

						if(mysqli_num_rows($result_get_parent_funcs)>0){
							while($row_get_parent_funcs = mysqli_fetch_array($result_get_parent_funcs)){
								$output .= '
			                       <tr>
			                         <td valign="top">
			                            <div style="border: 1px solid black; margin:10px; margin-bottom: 0px; height: 25px;">
									       <div style="position: relative;">
									          <div style="position: absolute; width:100%; height: 25px; background-color: #A8E5FE;">'.$row_get_parent_funcs['functionality_name'].'</div>
									       </div>
									    </div>
									    <div style="width:100%">
											<table style="width: 100%; border: 1px solid black;">
											</table>
										</div>
									</td>
								   </tr>
								  ';
								/*$sql_group_classes = "SELECT * FROM functionality_classes_repo WHERE project_id = '".$project_id."' AND group_mapped = 'yes' AND group_mapped_id = '".$row_get_parent_funcs['functionality_id']."'";
                                $result_group_classes = mysqli_query($connect,$sql_group_classes);

			                    if(mysqli_num_rows($result_group_classes)>0){
			                    	while($row_group_classes = mysqli_fetch_array($result_group_classes)){
			                    		$sql_class_name = "SELECT class_name FROM classes_repo WHERE class_id = '".$row_group_classes['class_mapped_id']."' AND project_id = '".$project_id."'";
			                    		$result_class_name = mysqli_query($connect,$sql_class_name);

			                    		if(mysqli_num_rows($result_class_name)>0){
			                    			$row_class_name = mysqli_fetch_array($result_class_name);
			                    			$output .= '
			                                 <tr>
									       	    <td style="padding-left: 15px;">
									       	      <div style="height: 20px;">
									       	         <div style="position: relative;">
									       	            <div style="position: absolute; width: 100%;">'.$row_class_name['class_name'].'</div>
									       	         </div>
									       	      </div>
									       	    </td>
									       	 </tr>
			                    			';
			                    		}
			                    	}
			                    }*/
	
											
							}
						}
					$output .= ' </table>
							</div>
					   </td>
                   ';
                }

                if($row_fcd_functionality = mysqli_fetch_array($result_fcd_functionality)){
                   $output .= '
                       <td valign="top">
                            <div style="margin: 10px 30px 0 30px; border: 1px solid black; height: 25px;">
						       <div style="position: relative;">
						          <div style="position: absolute; height: 25px; background-color: #F0EFEA; width: 100%">'.$row_fcd_functionality['functionality_name'].'</div>
						       </div>
						    </div>
						    <div style="margin: 0px 30px 10px 30px;">
								<table style="width: 100%; border: 1px solid black;">
								';
					    $sql_get_parent_funcs = "SELECT * FROM functionality_list_repo WHERE parent_functionality_id = '".$row_fcd_functionality['functionality_id']."' AND project_id = '".$project_id."'";
						$result_get_parent_funcs = mysqli_query($connect,$sql_get_parent_funcs);

						if(mysqli_num_rows($result_get_parent_funcs)>0){
							while($row_get_parent_funcs = mysqli_fetch_array($result_get_parent_funcs)){
								$output .= '
			                       <tr>
			                         <td valign="top">
			                            <div style="border: 1px solid black; margin:10px; margin-bottom: 0px; height: 25px;">
									       <div style="position: relative;">
									          <div style="position: absolute; width:100%; height: 25px; background-color: #A8E5FE;">'.$row_get_parent_funcs['functionality_name'].'</div>
									       </div>
									    </div>
									    <div style="width:100%">
											<table style="width: 100%; border: 1px solid black;">
											</table>
										</div>
									</td>
								   </tr>
								  ';
								/*$sql_group_classes = "SELECT * FROM functionality_classes_repo WHERE project_id = '".$project_id."' AND group_mapped = 'yes' AND group_mapped_id = '".$row_get_parent_funcs['functionality_id']."'";
                                $result_group_classes = mysqli_query($connect,$sql_group_classes);

			                    if(mysqli_num_rows($result_group_classes)>0){
			                    	while($row_group_classes = mysqli_fetch_array($result_group_classes)){
			                    		$sql_class_name = "SELECT class_name FROM classes_repo WHERE class_id = '".$row_group_classes['class_mapped_id']."' AND project_id = '".$project_id."'";
			                    		$result_class_name = mysqli_query($connect,$sql_class_name);

			                    		if(mysqli_num_rows($result_class_name)>0){
			                    			$row_class_name = mysqli_fetch_array($result_class_name);
			                    			$output .= '
			                                 <tr>
									       	    <td style="padding-left: 15px;">
									       	      <div style="height: 20px;">
									       	         <div style="position: relative;">
									       	            <div style="position: absolute; width: 100%;">'.$row_class_name['class_name'].'</div>
									       	         </div>
									       	      </div>
									       	    </td>
									       	 </tr>
			                    			';
			                    		}
			                    	}
			                    } */

											
							}
						}
					$output .= ' </table>
							</div>
					   </td>
                   ';
                }

			    $output .= '
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
    
    //echo mysqli_error($connect);
  	echo $output;
  }
?>