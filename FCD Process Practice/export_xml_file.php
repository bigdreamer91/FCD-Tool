<?php
  
  $project_id = $_POST['project_id'];

  if(file_exists('ShoppingCart.xml')){
  	        $xml = simplexml_load_file('ShoppingCart.xml');

  	        $highest_id = 0;
			$highest_x = 0;
			$highest_y = 0;
			$swimlane_id = array();

			foreach($xml[0]->root->mxCell as $i=>$value){
			  	 $curr_id = (int) $value->attributes()->id;
			  	 //array_push($swimlane_id,$curr_id);
			  	 if($curr_id > $highest_id){
			  	 	 $highest_id = $curr_id;
			  	 }

			  	 if($value->attributes()->parent==1){
			  	 	$style = $value->attributes()->style;
			  	 	$style = explode(";", $style);
			  	 	//$style = $style[0];
			  	 	if(strcmp($style[0], "swimlane")==0){
			  	 		array_push($swimlane_id,$curr_id);
			  	 	}
			  	 	$mxGeometry = $value->mxGeometry;

				  	$curr_x = (int)$mxGeometry->attributes()->x;
				  	if($highest_x < $curr_x){
				  		$highest_x = $curr_x;
				  	}

				  	$curr_y = (int)$mxGeometry->attributes()->y;
				  	if($highest_y < $curr_y){
				  		$highest_y = $curr_y;
				  	}
			  	 }
			}

  	        $connect = mysqli_connect("localhost", "root", "root", "fcd_decomposition_db");

  	        $sql_get_classes = "SELECT * FROM classes_repo WHERE project_id = '" .$project_id. "'";
  	        $result_get_classes = mysqli_query($connect,$sql_get_classes);
  	        $next_x = $highest_x;
  	        $next_y = $highest_y;
	    	$next_width = 230;
	    	$next_height = 210;

	    	$uml_mapped_arr_id = array();

  	        if(mysqli_num_rows($result_get_classes)>0){
  	        	while($row_get_classes = mysqli_fetch_array($result_get_classes)){
		  	        if(strcmp($row_get_classes['uml_mapped'], "yes")==0 && strcmp($row_get_classes['uml_mapped_id'], "")!=0){
		  	        	    array_push($uml_mapped_arr_id,$row_get_classes['uml_mapped_id']);
		  	        		$mxCell = $xml->xpath('//mxCell[@id="'.$row_get_classes['uml_mapped_id'].'"]');
		  	        		$cal = explode(";", $mxCell[0]['style']);

		  	        		if(strcmp($cal[0], "swimlane")==0){
		  	        			$mxCell[0]['value'] = $row_get_classes['class_name'];

		  	                    //update attributes
		  	                    $mxCellattrID = (int) ($row_get_classes['uml_mapped_id']) + 1;
		  	                    $mxCellattr = $xml->xpath('//mxCell[@id="'.$mxCellattrID.'"]');
		  	                    $all_methods = explode("\n", $mxCellattr[0]['value']);

		  	                    foreach($all_methods as $i => $all){
		  	                    	$all_methods[$i] = trim($all);

						      	 	if(strcmp($all_methods[$i], "")==0){
						      	 		array_splice($all_methods, $i);
						      	 	}
					      	    }

					      	    $new_temp_arr = array();
					      	    foreach($all_methods as $i => $all){
					      	    	array_push($new_temp_arr,$all_methods[$i]);
						      	 	$all = str_replace("+ ","", $all);
						      	 	$all = str_replace("+","", $all);
						      	 	$all_methods[$i] = $all;
					      	    }

					      	    foreach ($all_methods as $i => $all) {
						      	 	$all = explode(":", $all);
						      	 	$all_methods[$i] = $all[0];
					      	    }

		  	                    $class_attr = explode(",", $row_get_classes['class_attr']);
		  	                    foreach($class_attr as $i => $attr){
		  	                    	$class_attr[$i] = trim($class_attr[$i]);
		  	
		  	                    	if(!in_array($class_attr[$i],$all_methods)){
		  	                    		array_push($new_temp_arr, "+ ".$class_attr[$i].": type");
		  	                    	}
		  	                    }

		  	                    foreach($all_methods as $key => $value){
		  	                    	if(!in_array($all_methods[$key], $class_attr)){
		  	                    		unset($new_temp_arr[$key]);
		  	                    	}
		  	                    }
		                        
		                        $mxCellAttrValue = "";
		  	                    foreach($new_temp_arr as $j => $elem){
		  	                    	$mxCellAttrValue .= $new_temp_arr[$j]."\n";
		  	                    }

		  	                    $mxCellattr[0]['value'] = $mxCellAttrValue;

		  	                    $mxCellmethodsID = (int) ($row_get_classes['uml_mapped_id']) + 3;
		  	                    $mxCellmethods = $xml->xpath('//mxCell[@id="'.$mxCellmethodsID.'"]');

		  	                    $all_elems = explode("\n", $mxCellmethods[0]['value']);

		  	                    foreach($all_elems as $i => $all){
		  	                    	$all_elems[$i] = trim($all_elems[$i]);
		  	                    	if(strcmp($all_elems[$i], "")==0){
		  	                    		array_splice($all_elems, $i);
		  	                    	}
		  	                    }

		  	                    $new_method_arr = array();
		  	                    foreach($all_elems as $i => $all){
		  	                    	array_push($new_method_arr,$all_elems[$i]);
		  	                    	$all = str_replace("+ ", "", $all);
		  	                    	$all = str_replace("+", "", $all);
		  	                    	$all_elems[$i] = $all;
		  	                    }

		  	                    foreach($all_elems as $i => $all){
		  	                    	$all = explode(":", $all);
		  	                    	$all_elems[$i] = $all[0];
		  	                    }

		  	                    $all_reqs = array();
		  	                    foreach($all_elems as $i => $all){
		  	                    	$all = preg_match('/(.*)\((.*?)\)(.*)/', $all, $match);
		  	                    	$all_elems[$i] = $match[1];
		  	                    	$arr = array();
		  	                    	array_push($arr,$match[2]);
		  	                    	array_push($all_reqs, $arr);
		  	                    }

		  	                    $sql_class_methods = "SELECT * FROM functionality_classes_methods_repo WHERE class_id = '" .$row_get_classes['class_id']. "' AND project_id = '" .$project_id. "'";
		  	                    $result_class_methods = mysqli_query($connect,$sql_class_methods);
		  	                    $class_method = array();
		  	                    $method_reqs = array();
		  	                    if(mysqli_num_rows($result_class_methods)>0){
		  	                    	while($row_class_methods = mysqli_fetch_array($result_class_methods)){

			  	                    	$method_name = $row_class_methods['class_method_name'];
			  	                    	$method_name = trim($method_name);
			  	                    	array_push($class_method,$method_name);

			  	                    	if(!in_array($method_name, $all_elems)){
			  	                    		array_push($all_elems,$method_name);
			  	                    		$arr = array();
			  	                    		array_push($all_reqs,$arr);
			  	                    	}

			  	                    	$sql_class_get_reqs = "SELECT step_reqs FROM steps_repo WHERE step_id = '" .$row_class_methods['existing_step_id']. "' AND project_id = '" .$project_id. "'";
			  	                    	$result_class_get_reqs = mysqli_query($connect,$sql_class_get_reqs);
			  	                    	if(mysqli_num_rows($result_class_get_reqs)>0){
			  	                    		$row_class_get_reqs = mysqli_fetch_array($result_class_get_reqs);
			  	                    		$reqs = $row_class_get_reqs['step_reqs'];
			  	                    		$arr = explode(",",$reqs);
			  	                    		foreach($arr as $k => $val_r){
			  	                    			$arr[$k] = trim($arr[$k]);
			  	                    		}
			  	                    		array_push($method_reqs,$arr);
			  	                    	}
		  	                    	}
		  	                    }

		  	                    foreach($all_elems as $x => $elem){
		  	                    	if(!in_array($all_elems[$x], $class_method)){
		  	                    		unset($all_elems[$x]);
		  	                    		unset($all_reqs[$x]);
		  	                    	}
		  	                    }

		  	                    foreach($all_elems as $x => $elem){
		  	                    	$index = array_search($elem, $class_method);
		  	                    	$arr = $all_reqs[$x];
		  	                    	$arr_class = $method_reqs[$index];
		  	                    	foreach($arr_class as $t => $val){
		  	                    		if(!in_array($arr_class[$t], $arr)){
		  	                    			array_push($arr, $arr_class[$t]);
		  	                    		}
		  	                    	}

		  	                    	foreach ($arr as $key => $value) {
		  	                    		if(!in_array($arr[$key], $arr_class)){
		  	                    			unset($arr[$key]);
		  	                    		}
		  	                    	}

		  	                    	$all_reqs[$x] = $arr;
		  	                    }

		  	                    $finalval = '';

		  	                    foreach($all_reqs as $q => $reqs){
		  	                    	$finalval .= "+ " . $all_elems[$q] . "(";

		  	                    	foreach($all_reqs[$q] as $w => $reqVal){
		  	                    		$finalval .= $all_reqs[$q][$w];
		  	                    		//echo count($all_reqs[$q]);
		  	                    		if($w < count($all_reqs[$q])){
		  	                    			if(count($all_reqs[$q])!=1){
		  	                    				$finalval .= ', ';
		  	                    			}
		  	                    			
		  	                    		}
		  	                    	}

		  	                    	$finalval .= ")\n";
		  	                    }

		  	                    $mxCellmethods[0]['value'] = $finalval;

  	        		        }
  	        	    }
  	        	    else{

  	        	    	$val = $highest_id;

                        $val = $val + 1;
                        $highest_id = $val;

                        if($next_x+$next_width+40+$next_width < 1000){
                        	$next_x = $next_x+40+$next_width;
                        }
                        else{
                        	$next_x = 40;
                        	$next_y = $next_y+$next_height+40;
                        }

  	        	    	$mxCell = $xml[0]->root->addChild('mxCell');
  	        	    	$mxCell->addAttribute('id',$val);
  	        	    	$mxCell->addAttribute('value',$row_get_classes['class_name']);
  	        	    	$mxCell->addAttribute('style','swimlane;fontStyle=1;align=center;verticalAlign=top;childLayout=stackLayout;horizontal=1;startSize=26;horizontalStack=0;resizeParent=1;resizeParentMax=0;resizeLast=0;collapsible=1;marginBottom=0;swimlaneFillColor=#ffffff;');
  	        	    	$mxCell->addAttribute('parent','1');
  	        	    	$mxCell->addAttribute('vertex','1');
  	        	    	$mxGeometry = $mxCell->addChild('mxGeometry');
  	        	    	$mxGeometry->addAttribute('x',$next_x);
  	        	    	$mxGeometry->addAttribute('y',$next_y);
  	        	    	$mxGeometry->addAttribute('width',$next_width);
  	        	    	$mxGeometry->addAttribute('height',$next_height);
  	        	    	$mxGeometry->addAttribute('as','geometry');

  	        	    	$class_attr = $row_get_classes['class_attr'];
  	        	    	$class_attr = explode(',', $class_attr);
  	        	    	$class_attr_string = '';
  	        	    	foreach($class_attr as $i => $values){
  	        	    		$class_attr[$i] = trim($class_attr[$i]);
  	        	    		$class_attr_string .= '+ ' . $class_attr[$i]. ': type' . PHP_EOL;
  	        	    	}

  	        	    	$attrid = $val + 1;
  	        	    	$highest_id = $attrid;
  	        	    	$mxCell = $xml[0]->root->addChild('mxCell');
  	        	    	$mxCell->addAttribute('id',$attrid);
  	        	    	$mxCell->addAttribute('value',$class_attr_string);
  	        	    	$mxCell->addAttribute('style','text;strokeColor=none;fillColor=none;align=left;verticalAlign=top;spacingLeft=4;spacingRight=4;overflow=hidden;rotatable=0;points=[[0,0.5],[1,0.5]];portConstraint=eastwest;');
  	        	    	$mxCell->addAttribute('parent',$val);
  	        	    	$mxCell->addAttribute('vertex','1');
  	        	    	$mxGeometry = $mxCell->addChild('mxGeometry');
  	        	    	$mxGeometry->addAttribute('y','26');
  	        	    	$mxGeometry->addAttribute('width','230');
  	        	    	$mxGeometry->addAttribute('height','94');
  	        	    	$mxGeometry->addAttribute('as','geometry');

  	        	    	$lineid_1 = $val + 2;
  	        	    	$highest_id = $lineid_1;
  	        	    	$mxCell = $xml[0]->root->addChild('mxCell');
  	        	    	$mxCell->addAttribute('id',$lineid_1);
  	        	    	$mxCell->addAttribute('value','');
  	        	    	$mxCell->addAttribute('style','line;strokeWidth=1;fillColor=none;align=left;verticalAlign=middle;spacingTop=-1;spacingLeft=3;spacingRight=3;rotatable=0;labelPosition=right;points=[];portConstraint=eastwest;');
  	        	    	$mxCell->addAttribute('parent',$val);
  	        	    	$mxCell->addAttribute('vertex','1');
  	        	    	$mxGeometry = $mxCell->addChild('mxGeometry');
  	        	    	$mxGeometry->addAttribute('y','120');
  	        	    	$mxGeometry->addAttribute('width','230');
  	        	    	$mxGeometry->addAttribute('height','8');
  	        	    	$mxGeometry->addAttribute('as','geometry');

  	        	    	$methodid = $val+3;
  	        	    	$highest_id = $methodid;

  	        	    	$sql_get_class_method = "SELECT * FROM functionality_classes_methods_repo WHERE class_id = '" .$row_get_classes['class_id']. "' AND project_id = '" .$project_id. "'";
  	        	    	$result_get_class_method = mysqli_query($connect,$sql_get_class_method);
  	        	    	$method_string = '';
  	        	    	if(mysqli_num_rows($result_get_class_method)>0){
  	        	    		while($row_get_class_method = mysqli_fetch_array($result_get_class_method)){
  	        	    			$sql_get_step_reqs = "SELECT step_reqs FROM steps_repo WHERE step_id = '" . $row_get_class_method['existing_step_id'] . "' AND project_id = '" .$project_id. "'";
  	        	    			$result_get_step_reqs = mysqli_query($connect,$sql_get_step_reqs);
  	        	    			if(mysqli_num_rows($result_get_step_reqs)>0){
  	        	    				$row_get_step_reqs = mysqli_fetch_array($result_get_step_reqs);
  	        	    				$step_reqs_string = $row_get_step_reqs['step_reqs'];
  	        	    				$method_string .= '+ ' . $row_get_class_method['class_method_name'] . '(' . $step_reqs_string . ')' . PHP_EOL;
  	        	    			}
  	        	    		}
  	        	    	}
  	        	    	$mxCell = $xml[0]->root->addChild('mxCell');
  	        	    	$mxCell->addAttribute('id',$methodid);
  	        	    	$mxCell->addAttribute('value',$method_string);
  	        	    	$mxCell->addAttribute('style','"text;strokeColor=none;fillColor=none;align=left;verticalAlign=top;spacingLeft=4;spacingRight=4;overflow=hidden;rotatable=0;points=[[0,0.5],[1,0.5]];portConstraint=eastwest;');
  	        	    	$mxCell->addAttribute('parent',$val);
  	        	    	$mxCell->addAttribute('vertex','1');
  	        	    	$mxGeometry = $mxCell->addChild('mxGeometry');
  	        	    	$mxGeometry->addAttribute('y','128');
  	        	    	$mxGeometry->addAttribute('width','230');
  	        	    	$mxGeometry->addAttribute('height','82');
  	        	    	$mxGeometry->addAttribute('as','geometry');

  	        	    	$next_x = $next_x+$curr_width;

  	        	    	$sql_update_class_mapped = "UPDATE classes_repo SET uml_mapped = 'yes', uml_mapped_id = '".$val."' WHERE class_id = '".$row_get_classes['class_id']."' AND project_id = '" .$project_id. "'";
  	        	    	$result_update_class_mapped = mysqli_query($connect,$sql_update_class_mapped);

  	        	    }
  	        	}
  	        	
  	        }

  	        $indexes = array();

  	        for($i=0;$i<count($xml[0]->root->mxCell);$i++){
  	        	
  	        	if(in_array($xml[0]->root->mxCell[$i]['id'], $swimlane_id)){
  	        		if(!in_array($xml[0]->root->mxCell[$i]['id'], $uml_mapped_arr_id)){
  	        			array_push($indexes,$i);
  	        		}
  	        	}
  	        }

  	        for($i=0;$i<count($indexes);$i++){
  	        	for($j=0;$j<count($xml[0]->root->mxCell);$j++){
  	        		if($xml[0]->root->mxCell[$j]['id']==$indexes[$i]){
  	        			unset($xml[0]->root->mxCell[$j]);
  	        			unset($xml[0]->root->mxCell[$j]);
  	        			unset($xml[0]->root->mxCell[$j]);
  	        			unset($xml[0]->root->mxCell[$j]);
  	        		}
  	        	}
  	        }

  	        echo $xml->asXML('ShoppingCart.xml');

  	        if(strcmp(mysqli_error($connect),"")!=0){
  	        	echo mysqli_error($connect);
  	        }
  	        else{
  	        	//echo "Export was successful";
  	        }
  }
  else{
  	exit('Failed to open ShoppingCart.xml');
  }
?>