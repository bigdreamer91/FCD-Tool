<?php
  
  $project_id = $_POST['project_id'];

  if(file_exists('ShoppingCart.xml')){
  	        $xml = simplexml_load_file('ShoppingCart.xml');
		  	foreach($xml[0]->root->mxCell as $mxCell)
		  	{
		      	 $val = $mxCell['style'];
		      	 $id = $mxCell['id'];
		      	 $parent = $mxCell['parent'];
		      	 $res = explode(";", $val);
		      	 $connect = mysqli_connect("localhost", "root", "root", "fcd_decomposition_db");

		      	 if(strcmp($res[0], "swimlane")==0 && strcmp($parent, "1")==0){
				      	 	$sql = "SELECT uml_mapped_id FROM classes_repo WHERE uml_mapped_id = '" .$id. "' AND project_id = '" .$project_id. "'";
				      	 	$result = mysqli_query($connect,$sql);
				      	 	if(mysqli_num_rows($result)==0){
				      	 		$val = 0;
				                $sql_get_class_id = "SELECT class_id FROM classes_repo WHERE project_id = '".$project_id."' ORDER BY class_id DESC LIMIT 1";
				                $result_get_class_id = mysqli_query($connect,$sql_get_class_id);
				                if(mysqli_num_rows($result_get_class_id)>0){
				                	$row_get_class_id = mysqli_fetch_array($result_get_class_id);
				                	$val = $row_get_class_id['class_id'];
				                }
				                $val = $val + 1;
				                $sql_add_class = "INSERT INTO classes_repo (project_id,class_id,class_name,class_attr,uml_mapped,uml_mapped_id) VALUES('".$project_id."','".$val."', '".$mxCell['value']."','','yes','" .$id. "')";
				                $result_add_class = mysqli_query($connect,$sql_add_class);
				      	 	}
		      	 }
		      	 else if(strcmp($res[0], "text")==0 AND $id == ($parent + 1)){
			      	 	$all_methods = explode("\n", $mxCell['value']);
			            foreach($all_methods as $i => $all){
				      	 	if(strcmp($all, "")==0){
				      	 		array_splice($all_methods, $i);
				      	 	}
			      	    }

			      	    foreach($all_methods as $i => $all){
				      	 	$all = str_replace("+ ","", $all);
				      	 	$all = str_replace("+","", $all);
				      	 	$all_methods[$i] = $all;
			      	    }

			      	    foreach ($all_methods as $i => $all) {
				      	 	$all = explode(":", $all);
				      	 	$all_methods[$i] = $all[0];
			      	    }

			      	    $attr_str = '';
			      	    foreach($all_methods as $i => $all){
			      	    	$attr_str .= $all;
			      	    	if($i < count($all_methods) - 1){
			      	    		$attr_str .= ", ";
			      	    	}
			      	    }

			      	    $sql_get_class_id = "SELECT class_id, class_attr FROM classes_repo WHERE uml_mapped = 'yes' AND uml_mapped_id = '" .$parent. "' AND project_id = '" .$project_id. "'";
				      	$result_get_class_id = mysqli_query($connect,$sql_get_class_id);
				      	if(mysqli_num_rows($result_get_class_id)>0){
				      		$row_get_class_id = mysqli_fetch_array($result_get_class_id);
				      		if(strcmp($attr_str, $row_get_class_id['class_attr'])!=0){
				      			$sql_update_class = "UPDATE classes_repo SET class_attr = '" .$attr_str. "' WHERE class_id = '" .$row_get_class_id['class_id']. "' AND project_id = '" .$project_id. "'";
				      			$result_update_class = mysqli_query($connect,$sql_update_class);
				      		}
				      	}
				      	else{
				      		$sql_get_new_class_id = "SELECT class_id FROM classes_repo WHERE project_id = '".$project_id."' ORDER BY class_id DESC LIMIT 1";
				      		$result_get_new_class_id = mysqli_query($connect,$sql_get_new_class_id);
				      		$val = 0;
				      		if(mysqli_num_rows($result_get_new_class_id)>0){
				      			$row_get_new_class_id = mysqli_fetch_array($result_get_new_class_id);
				      			$val = $row_get_new_class_id['class_id'];
				      		}
				      		$val = $val + 1;
				      		$sql_add_class = "INSERT INTO classes_repo (project_id,class_id,class_name,class_attr,uml_mapped,uml_mapped_id) VALUES('".$project_id."','" .$val. "', '','" .$attr_str. "', 'yes', '" .$id. "')";
				      		$result_add_class = mysqli_query($connect,$sql_add_class);
				      	}
		      	 }
		      	 else if(strcmp($res[0], "text")==0 AND $id == ($parent + 3))
		      	 {
				            $all_methods = explode("\n", $mxCell['value']);
				            foreach($all_methods as $i => $all){
					      	 	if(strcmp($all, "")==0){
					      	 		array_splice($all_methods, $i);
					      	 	}
				      	    }

				      	    foreach($all_methods as $i => $all){
					      	 	$all = str_replace("+ ","", $all);
					      	 	$all = str_replace("+","", $all);
					      	 	$all_methods[$i] = $all;
				      	    }

				      	    foreach ($all_methods as $i => $all) {
					      	 	$all = explode(":", $all);
					      	 	$all_methods[$i] = $all[0];
				      	    }
				            
				            $all_reqs = array();

					      	foreach ($all_methods as $i => $all) {
					      	 	$all = preg_match('/(.*)\((.*?)\)(.*)/', $all, $match);
					      	 	////echo "this match value === > 1 " . $match[1] . "=== > 2 " . $match[2] . "=== > 3 " . $match[3] . "<br><hr><hr><hr> "; 
					      	 	    $all_methods[$i] = $match[1];
					      	 		$arr = array();
					      	 		array_push($arr, $match[2]);
					      	 		array_push($all_reqs, $arr);
					      	}

				      	 	$sql_get_class_id = "SELECT class_id FROM classes_repo WHERE uml_mapped = 'yes' AND uml_mapped_id = '" .$parent. "' WHERE project_id = '" .$project_id. "'";
				      	 	$result_get_class_id = mysqli_query($connect,$sql_get_class_id);

				      	 	if(mysqli_num_rows($result_get_class_id)>0){
				      	 		    $row_get_class_id = mysqli_fetch_array($result_get_class_id);
				      	 		    //echo "<hr>";
				      	 		    //echo $row_get_class_id['class_id'];
				      	 		    //echo "<br>";
				      	 		
				      	 		    foreach($all_methods as $i => $all){
				                    $sql_get_method_name = "SELECT class_method_name, existing_step_id FROM functionality_classes_methods_repo WHERE class_id = '" .$row_get_class_id['class_id']. "' AND class_method_name = '" .$all. "' AND project_id = '" .$project_id. "'";
				                    $result_get_method_name = mysqli_query($connect,$sql_get_method_name);

				                    if(mysqli_num_rows($result_get_method_name)>0){
				                   	  $row_get_method_name = mysqli_fetch_array($result_get_method_name);
				                   	  $attr_str = '';

				                   	  foreach($all_reqs[$i] as $j=> $req){
				                   	  	 $attr_str .= $req;
				                   	  	 if($j < count($all_reqs[$i])-1){
				                   	  	 	$attr_str .= ", ";
				                   	  	 }
				                   	  }

				                   	  //echo "debug step 1 checking if a class_method_name entry is present. Situtation (yes) --- " . $row_get_method_name['class_method_name'] . " --- " . $row_get_method_name['existing_step_id'] . " ---- " . $attr_str;
				                   	  //echo "<br>";

				                   	  $sql_get_step_attr = "SELECT step_reqs FROM steps_repo WHERE step_id = '" .$row_get_method_name['existing_step_id'] . "' AND project_id = '" .$project_id. "'";
				                   	  $result_get_step_arr = mysqli_query($connect,$sql_get_step_attr);
				                   	  if(mysqli_num_rows($result_get_step_arr)>0){
				                   	  	  $row_get_step_arr = mysqli_fetch_array($result_get_step_arr);
				                   	  	  if(strcmp($row_get_step_arr['step_reqs'], $attr_str)!=0){
				                   	  	  	 $sql_update_step = "UPDATE steps_repo SET step_reqs = '" .$attr_str. "' WHERE step_id = '" .$row_get_method_name['existing_step_id']. "' AND project_id = '" .$project_id. "'";
				                   	  	  	 $result_update_step = mysqli_query($connect,$sql_update_step);
				                   	  	  }
				                   	  }
				                    }
				                    else
				                    {//1
				                    	//echo "debug step 1 checking if a class_method_name entry is present. Situtation (no) ---- " .$all;
				                    	//echo "<br>";

					                   	  $sql_check_step_repo = "SELECT step_id, step_name, step_reqs FROM steps_repo WHERE step_name = '" .$all. "' AND step_mapped = 'no' AND project_id = '" .$project_id. "'";
					                   	  $result_check_step_repo = mysqli_query($connect,$sql_check_step_repo);
					                   	  if(mysqli_num_rows($result_check_step_repo)>0){//2
					                   	  	 $row_check_step_repo = mysqli_fetch_array($result_check_step_repo);
					                   	  	 $val_id = 0;
					                         $sql_new_class_method_id = "SELECT class_method_id FROM functionality_classes_methods_repo WHERE class_id = '" .$row_get_class_id['class_id']. "' AND project_id = '".$project_id."' ORDER BY class_method_id DESC LIMIT 1";
					                         $result_new_class_method_id = mysqli_query($connect,$sql_new_class_method_id);
					                         if(mysqli_num_rows($result_new_class_method_id)>0){
					                         	$row_new_class_method_id = mysqli_fetch_array($result_new_class_method_id);
					                         	$val_id = $row_new_class_method_id['class_method_id'];
					                         }
					                         $val_id = $val_id + 1;

					                   	  	 $sql_add_class = "INSERT INTO functionality_classes_methods_repo (project_id,class_id,class_method_id,class_method_name,existing_step_id) VALUES('".$project_id."','" .$row_get_class_id['class_id']. "', '" .$val_id. "', '" .$all. "', '" .$row_check_step_repo['step_id']. "')";
					                   	  	 $result_add_class = mysqli_query($connect,$sql_add_class);
					                   	  	 if(mysqli_num_rows($result_add_class)>0){
						                   	  	 	$attr_str = '';
								                   	foreach($all_reqs[$i] as $j => $req){
								                   	  	$attr_str .= $req;
								                   	  	if($j<count($all_reqs[$i])-1){
								                   	  		$attr_str .= ", ";
								                   	  	}
								                   	}
								                   	$sql_update_step = "UPDATE steps_repo SET step_mapped = 'yes' AND mapped_class_id = '" .$row_get_class_id['class_id']. "' WHERE step_id = '" .$row_check_step_repo['step_id']. "' AND project_id = '" .$project_id. "'";
								                   	if(strcmp($attr_str, $row_check_step_repo['step_reqs'])!=0){
								                   		$sql_update_step = "UPDATE steps_repo SET step_mapped = 'yes', mapped_class_id = '" .$row_get_class_id['class_id']. "', step_reqs = '".$row_check_step_repo['step_reqs']."' WHERE step_id = '" .$row_check_step_repo['step_id']. "' AND project_id = '" .$project_id. "'";
								                   	}
								                   	$result_update_step = mysqli_query($connect,$sql_update_step);
					                   	  	 }
					                   	  }
					                   	  else
					                   	  {
						                   	  	$val = 0;
						                   	  	$sql_get_new_step_id = "SELECT step_id FROM steps_repo WHERE project_id = '".$project_id."' ORDER BY step_id DESC LIMIT 1";
						                   	  	$result_get_new_step_id = mysqli_query($connect,$sql_get_new_step_id);
						                   	  	if(mysqli_num_rows($result_get_new_step_id)>0){
						                   	  		$row_get_new_step_id = mysqli_fetch_array($result_get_new_step_id);
						                   	  		$val = $row_get_new_step_id['step_id'];
						                   	  	}
						                   	  	$val = $val + 1;
						                   	  	$attr_str = '';
								                   	
								                   	foreach($all_reqs[$i] as $j=> $req){
								                   	  	 $attr_str .= $req;
								                   	  	 if($j < count($all_reqs[$i])-1){
								                   	  	 	$attr_str .= ", ";
								                   	  	 }
								                   	}

								                   	//echo " value of attr_str --- " . $attr_str;
								                   	//echo "<br>";

						                   	  	$sql_add_new_Step = "INSERT INTO steps_repo (project_id,step_id,step_name,step_reqs,step_method_notes,step_expecs,step_mapped,mapped_class_id) VALUES('".$project_id."','" .$val. "', '" .$all. "', '" .$attr_str. "', '','','yes','".$row_get_class_id['class_id']."')";
						                   	  	$result_add_new_step = mysqli_query($connect,$sql_add_new_Step);

						                   	  	if($result_add_new_step){
						                   	  		$sql_get_new_class_method_id = "SELECT class_method_id FROM functionality_classes_methods_repo WHERE class_id = '" .$row_get_class_id['class_id']. "' AND project_id = '".$project_id."' ORDER BY class_method_id DESC LIMIT 1";
						                   	  		$result_get_new_class_method_id = mysqli_query($connect,$sql_get_new_class_method_id);
						                   	  		$val_method_id = 0;
						                   	  		if(mysqli_num_rows($result_get_new_class_method_id)>0){
						                   	  			$row_get_new_class_method_id = mysqli_fetch_array($result_get_new_class_method_id);
						                   	  			$val_method_id = $row_get_new_class_method_id['class_method_id'];
						                   	  		}
						                   	  		$val_method_id = $val_method_id + 1;
						                   	  		$sql_add_new_class_method = "INSERT INTO class_methods_repo (project_id,class_id,class_method_id,class_method_name,existing_step_id) VALUES('".$project_id."','" .$row_get_class_id['class_id']. "', '" .$val_method_id. "', '" .$all. "', '" .$val. "')";
						                   	  		$result_add_new_class_method = mysqli_query($connect,$sql_add_new_class_method);
						                   	  		//echo "result of insert new class_method is --- " . $result_add_new_class_method;
						                   	  		//echo "<br>";
						                   	  	}
					                   	  }
				                   }
				      	 		}
				      	 	}
		      	 }
		    }
		    //echo "Import was successful";
		    //echo mysqli_error($connect);
		    if(strcmp(mysqli_error($connect),"")!=0){
		    	echo mysqli_error($connect);
		    }
		    else{
		    	echo "Import was successful";
		    }
  }
  else{
   	  exit('Failed to open Sample.xml');
   }
?>