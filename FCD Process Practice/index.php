<!DOCTYPE html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style type="text/css">
#navContainer{
 }

 ul{
 	list-style-type: none;
 	margin: 0;
 	padding: 0;
 	overflow: auto;
 	background-color: #2A3132;
  border: 1px solid white;
 }

 li{
 	display: inline-block;
 	border-right: 1px solid white;
 }

 li a{
 	display: block;
 	color: white;
 	text-align: center;
 	padding: 10px 10px;
 	text-decoration: none;
 }

 a:hover{
	text-decoration: none;
 }

 body{
	overflow: scroll;
 }

.modal{
     display: none;
     position: fixed;
     z-index: 1;
     left: 0;
     top: 0;
     width: 100%;
     height: 100%;
     overflow: auto;
  }

.close{
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
  }

.close:hover,
.close:focus{
     color: black;
     text-decoration: none;
     cursor: pointer;
  }

.modal-content{
     background-color: #fefefe;
     margin: 2% auto;
     padding: 20px;
     border: 1px solid #888;
     width: 80%;
     height: 90%;
     overflow: scroll;
  }
 .sprintNum{
    cursor: pointer;
  }
</style>
</head>
<body>
<div id="menuContainer">
   <ul>
    <li id="fcd" class="showFCD" style="cursor: pointer;"><a>Function Decomposition</a></li>
    <li id="classes" class="showIdentifiedClass" style="cursor: pointer;"><a>Identified Classes</a></li>
    <li id="FCD Tree" class="fcdView" style="cursor: pointer;"><a>FCD View</a></li>
    <li id="importXML" class="importToXML" style="cursor: pointer;"><a>Import to XML</a></li>
    <li id="exportXML" class="exportToXML" style="cursor: pointer;"><a>Export to XML</a></li>
  </ul>
</div>
<div id="navContainer">
  <ul id="sprintList">
    <li id="addNewSprint" onclick="addSprint()" style="cursor: pointer;"><a>Add New Sprint</a></li>
    <li id="1" class="sprintNum"><a>Reference</a></li>
  </ul>
</div>
<div id="fcdHolder">
  <div class="row">
     <div class="col-sm-12" id="entire_fcd_holder">

     </div>
  </div>
</div>
<div id="fcdView">
  <div class="row">
     <div class="col-sm-12" id="entire_fcdView_holder">

     </div>
  </div>
</div>
<div id="importXMLHeader">
  <div class="row">
     <div class="col-sm-12" id="entire_importXML_holder">

     </div>
  </div>
</div>
<div id="exportXMLHeader">
  <div class="row">
     <div class="col-sm-12" id="entire_exportXML_holder">

     </div>
  </div>
</div>
<div id="myModal" class="modal">
   <div class="modal-content">
       <div id="header1" style="overflow: hidden;">
          <span id="close1" class="close">&times;</span>
       </div>
       <div id="myModalContent">
       </div>
   </div>
</div>
<div id="myModal1" class="modal">
   <div class="modal-content">
       <div id="header1" style="overflow: hidden;">
          <span id="close2" class="close">&times;</span>
       </div>
       <div id="myModalContent1">
       </div>
   </div>
</div>

<script src="../../dist/autosize.js"></script>
<script src="../../raphael.js"></script>
<script type="text/javascript">

var sprint_id_num = 1;
var last_sprint_num = 0;
var project_id_num = 5;

$(document).ready(function(){

   function fetch_data(){
   	  $.ajax({
   	  	 url:"display_FCD.php",
   	  	 method:"POST",
   	  	 data:{project_id:project_id_num,sprint_id:sprint_id_num,p:0},
   	  	 success:function(data){
          //console.log(data);
   	  	 	$('#entire_fcd_holder').html(data);
   	  	 	autosize(document.querySelectorAll('textarea'));
   	  	 	//console.log(document.getElementById("functionality_classes_td-0").innerHTML);
   	  	 }
   	  });
   	  autosize(document.querySelectorAll('textarea'));
   }

   function update_sprint(){
      	  $.ajax({
             url: "load_sprint_menu.php",
             method: "POST",
             data:{project_id:project_id_num},
             success: function(data){
                $('#sprintList').html(data);
                update_last_sprint_num();
             }
          });
      }

      function update_last_sprint_num(){
        last_sprint_num = parseInt($('#sprintList').children().last().attr('id'));
      }

   fetch_data();
   update_sprint();

   autosize(document.querySelectorAll('textarea'));

   $(document).on('click','.showFCD',function(){
       $('#fcdHolder').css({'display':''});
       $('#fcdView').css({'display':'none'});
       $('#importXMLHeader').css({'display':'none'});
       $('#exportXMLHeader').css({'display':'none'});

       fetch_data();

   });

   $(document).on('click','.fcdView',function(){
       $('#fcdHolder').css({'display':'none'});
       $('#fcdView').css({'display':''});
       $('#importXMLHeader').css({'display':'none'});
       $('#exportXMLHeader').css({'display':'none'});

       $.ajax({
         url:"fcd_view.php",
         method:"POST",
         data:{project_id:project_id_num},
         success:function(data){
           $('#entire_fcdView_holder').html(data);
         }
       });

   });

   $(document).on('click','.functionalityHeader',function(){
   	   //console.log("div clicked");
       var id = $(this).attr("id");
       console.log(id);
       var res = id.split("-");
       //console.log(document.getElementById("functionality_content-"+res[1]).style.display)


       if(document.getElementById("functionality_content-"+res[1]).style.display.localeCompare("none")==0){
          document.getElementById("functionality_content-"+res[1]).style.display = "";
       }
       else{
       	  document.getElementById("functionality_content-"+res[1]).style.display = "none";
       }
       
   });

   $(document).on('click','.viewUsecases',function(){
       var id = $(this).attr("id");
       console.log(id);
       var res = id.split("-");
       var elems = document.getElementsByClassName("usecases_list-"+res[1]);
       for(i=0; i<elems.length; i++){
       	  if(elems[i].style.display.localeCompare("none")==0){
       	  	  elems[i].style.display = "";
       	  }
       	  else{
       	  	 elems[i].style.display = "none";
       	  	 var idVal = elems[i].id;
       	  	  //console.log(idVal);
       	  	  var resVal = idVal.split("-");
       	  	  //console.log("usecase_steps-"+resVal[1]+"-"+resVal[2]);
       	  	  var innerElems = document.getElementsByClassName("usecase_steps-"+resVal[1]+"-"+resVal[2]);
       	  	  //console.log(innerElems.length);
       	  	  for(j=0; j<innerElems.length; j++){
       	  	  	 innerElems[j].style.display = "none";
       	  	  }
       	  }
       }
   });

   $(document).on('click','.usecaseDetails',function(){
       var id = $(this).attr("id");
       console.log(id);
       var res = id.split("-");
       var elems = document.getElementsByClassName("usecase_steps-"+res[1]+"-"+res[2]);
       for(i=0; i<elems.length; i++){
       	  if(elems[i].style.display.localeCompare("none")==0){
       	  	  elems[i].style.display = "";
       	  }
       	  else{
       	  	 elems[i].style.display = "none";
       	  }
       }
   });

   $(document).on('click','.viewClasses',function(){
      var id = $(this).attr("id");
      console.log(id);
      var res = id.split("-");
      var elems = document.getElementsByClassName("functinality_classes-"+res[1]);
      for(i=0; i<elems.length; i++){
       	  if(elems[i].style.display.localeCompare("none")==0){
       	  	  elems[i].style.display = "";
       	  }
       	  else{
       	  	 elems[i].style.display = "none";
       	  	 var idVal = elems[i].id;
       	  	 var resVal = idVal.split("-");
       	  	 var innerElems = document.getElementsByClassName("class_detail-"+resVal[1]+"-"+resVal[2]);
       	  	 for(j=0; j<innerElems.length; j++){
       	  	  	 innerElems[j].style.display = "none";
       	  	  }
       	  }
       }
       //console.log(document.getElementById("functionality_classes_td-0").innerHTML);
   });

   $(document).on('click','.classDetails',function(){
      var id = $(this).attr("id");
      console.log(id);
      var res = id.split("-");
      var elems = document.getElementsByClassName("class_detail-"+res[1]+"-"+res[2]);
      for(i=0; i<elems.length; i++){
       	  if(elems[i].style.display.localeCompare("none")==0){
       	  	  elems[i].style.display = "";
       	  }
       	  else{
       	  	 elems[i].style.display = "none";
       	  }
       }
       autosize(document.querySelectorAll('textarea'));
       //console.log(document.getElementById("functionality_classes_td-0").innerHTML);
   });

   $(document).on('click','.methods',function(){
      var id = $(this).attr("id");
      console.log(id);
      var res = id.split("-");
      var elems = document.getElementsByClassName("method-"+res[1]+"-"+res[2]);
      for(i=0; i<elems.length; i++){
       	  if(elems[i].style.display.localeCompare("none")==0){
       	  	  elems[i].style.display = "";
       	  }
       	  else{
       	  	 elems[i].style.display = "none";
       	  	 var idVal = elems[i].id;
       	  	 var resVal = idVal.split("-");
       	  	 var innerElems = document.getElementsByClassName("methodDetails-"+resVal[1]+"-"+resVal[2]+"-"+resVal[3]);
       	  	 for(j=0; j<innerElems.length; j++){
       	  	  	 innerElems[j].style.display = "none";
       	  	  }
       	  }
       }
       //console.log(document.getElementById("functionality_classes_td-0").innerHTML);
   });

   $(document).on('click','.methodDetails',function(){
      var id = $(this).attr("id");
      console.log(id);
      var res = id.split("-");
      var elems = document.getElementsByClassName("methodDetails-"+res[1]+"-"+res[2]+"-"+res[3]);
      for(i=0; i<elems.length; i++){
       	  if(elems[i].style.display.localeCompare("none")==0){
       	  	  elems[i].style.display = "";
       	  }
       	  else{
       	  	 elems[i].style.display = "none";
       	  }
       }
   });

   $(document).on('click','.viewGroupings',function(){
      var id = $(this).attr("id");
      console.log(id);
      var res = id.split("-");
      var elems = document.getElementsByClassName("functionality_groupings-"+res[1]);
      for(i=0; i<elems.length; i++){
       	  if(elems[i].style.display.localeCompare("none")==0){
       	  	  elems[i].style.display = "";
       	  }
       	  else{
       	  	 elems[i].style.display = "none";
       	  }
       }
   });

   $(document).on('click', '.close', function(){
          var id = $(this).attr("id");
          console.log(id);
          if(id.localeCompare("close1")==0){
             $('#myModal').hide();
          }
          else if(id.localeCompare("close2")==0){
             $('#myModal1').hide();
          }
   });

   $(document).on('click', '.addUseCase', function(){
          var id = $(this).attr("id");
          var res = id.split("-");
          console.log(id);

          $.ajax({
              url:"load_modal_content_add_usecase.php",
              method:"POST",
              data:{project_id:project_id_num,sprint_id:sprint_id_num,functionality_id:res[1]},
              success:function(data){
                 $('#myModalContent').html(data);
                 addusecaserow();
                 $('#myModal').show();
              }
          });
          event.stopImmediatePropagation();
          return false;
   });

   $(document).on('click', '.cancelClass', function(){
       var id = $(this).attr("id");
       var res = id.split("-");
       console.log(id);

       $.ajax({
       	 url:"identified_classes_event_handler.php",
       	 method:"POST",
       	 data:{p:7,project_id:project_id_num,sprint_id:sprint_id_num,functionality_id:res[1],class_id:res[2]},
       	 success:function(data){
            console.log(data);
            $('#functionality_class_header-'+res[1]+"-"+res[2]).remove();
            $('.class_detail-'+res[1]+'-'+res[2]).remove();
       	 }
       });
       event.stopImmediatePropagation();
       return false;
   });

  function addusecaserow(){
      var tableLength = document.getElementById("tableUsecasesModal").rows.length;
      var val = 0;
      if(tableLength>0){
         lastIndex = document.getElementById("tableUsecasesModal").rows[tableLength-1].id;
         val = parseInt(lastIndex);
      }
      val = val + 1;
      var tr = document.createElement("tr");
      tr.id = val.toString();
      var td = document.createElement("td");
      td.style.width = "50%";
      var inp = document.createElement("input");
      inp.type = "text";
      inp.style.width = "100%";
      inp.id = "usecase_name-"+val;
      td.appendChild(inp);
      tr.appendChild(td);

      td = document.createElement("td");
      td.style.width = "40%";
      inp = document.createElement("input");
      inp.type = "text";
      inp.style.width = "100%";
      inp.id = "usecase_desc-"+val;
      td.appendChild(inp);
      tr.appendChild(td);

      td = document.createElement("td");
      td.style.width = "10%";
      inp = document.createElement("input");
      inp.type = "submit";
      inp.value = "Delete";
      inp.className = "deleterow";
      inp.id = "delete-"+val;
      inp.style.width = "100%";
      td.appendChild(inp);
      tr.appendChild(td);

      document.getElementById("tableUsecasesModal").appendChild(tr);
  }

  $(document).on('click','#addUsecaseModal',function(){
      addusecaserow();
  });

  $(document).on('click','.deleterow',function(){
      var id = $(this).attr("id");
      console.log(id);
      var res = id.split("-");
      document.getElementById("tableUsecasesModal").removeChild(document.getElementById(res[1].toString()));
  });

  $(document).on('click','.saveUsecase',function(){
      var id = $(this).attr("id");
      var res = id.split("-");
      console.log(id);

      usecases = [];

      for(i=0; i<document.getElementById("tableUsecasesModal").rows.length; i++){
          if(document.getElementById("tableUsecasesModal").rows[i].id.localeCompare("1")!=0){
             var id = document.getElementById("tableUsecasesModal").rows[i].id;
             var usecase = document.getElementById("usecase_name-"+id).value;
             var usecase_description = document.getElementById("usecase_desc-"+id).value;

            usecases.push({
               "usecase":usecase,
               "usecase_desc":usecase_description
            });
          }
      }

      var usecase_json = JSON.stringify(usecases);

      $.ajax({
          url:"usecase_mapping_event_handler.php",
          method:"POST",
          data:{p:1,project_id:project_id_num,sprint_id:sprint_id_num,functionality_id:res[1],usecase_json:usecase_json},
          success:function(data){
             //console.log(data);
             $('#myModal').hide();
             $('#functionality_usecases_td-'+res[1]).append(data);
            //console.log(document.getElementById("functionality_usecases_td-0").innerHTML);
            var elems = document.getElementsByClassName("usecases_list-"+res[1]);
            if(elems[0].style.display.localeCompare("none")!=0){
            	for(i=0; i<elems.length; i++){
            		elems[i].style.display = "";
                }
            }
          }
      });

  });


  $(document).on('click', '.addClasses', function(){
     var id = $(this).attr("id");
     var res = id.split("-");
     console.log(id);

     $.ajax({
       url:"identified_classes_event_handler.php",
       method:"POST",
       data:{p:1,project_id:project_id_num,sprint_id:sprint_id_num,functionality_id:res[1]},
       success:function(data){
          $('#functionality_classes_td-'+res[1]).append(data);
          var elems = document.getElementsByClassName("functinality_classes-"+res[1]);
          for(i=0;i<elems.length;i++){
          	 elems[i].style.display = "";
          }
       }
     });
     event.stopImmediatePropagation();
     return false;
  });

  $(document).on('click','.addStepWithinUsecase',function(){
       var id = $(this).attr("id");
       var res = id.split("-");
       console.log(id);

       $.ajax({
          url:"load_modal_content_add_step.php",
          method:"POST",
          data:{project_id:project_id_num,sprint_id:sprint_id_num,functionality_id:res[1],usecase_id:res[2]},
          success:function(data){
             $('#myModalContent').html(data);
             $('#myModal').show();
             addsteprow();
          }
       });
       event.stopImmediatePropagation();
      return false;
  });

  function addsteprow(){
        var tableLength = document.getElementById("tableStepsModal").rows.length;
        console.log(tableLength);
        var val = 0;
        if(tableLength>0){
           lastIndex = document.getElementById("tableStepsModal").rows[tableLength-1].id;
            val = parseInt(lastIndex);
        }
        val = val+1;
        console.log("val here --- " + val);
        
        var tr = document.createElement("tr");
        tr.id = val.toString();
        var td = document.createElement("td");
        td.id = "step_id-"+val;
        td.style.width = "10%";
        tr.appendChild(td);

        td = document.createElement("td");
        td.style.width = "20%";
        inp = document.createElement("input");
        inp.type = "text";
        inp.style.width = "100%";
        inp.id = "step_name-"+val;
        td.appendChild(inp);
        tr.appendChild(td);

        td = document.createElement("td");
        td.style.width = "20%";
        inp = document.createElement("input");
        inp.type = "text";
        inp.style.width = "100%";
        inp.id = "step_reqs-"+val;
        td.appendChild(inp);
        tr.appendChild(td);

        td = document.createElement("td");
        td.style.width = "20%";
        inp = document.createElement("input");
        inp.type = "text";
        inp.style.width = "100%";
        inp.id = "step_methods-"+val;
        td.appendChild(inp);
        tr.appendChild(td);

        td = document.createElement("td");
        td.style.width = "20%";
        inp = document.createElement("input");
        inp.type = "text";
        inp.style.width = "100%";
        inp.id = "step_expecs-"+val;
        td.appendChild(inp);
        tr.appendChild(td);

        td = document.createElement("td");
        td.style.width = "5%";
        inp = document.createElement("input");
        inp.type = "submit";
        inp.style.width = "100%";
        inp.id = "stepRepo-"+val;
        inp.className = "addStepRepo";
        inp.value = "Repo";
        td.appendChild(inp);
        tr.appendChild(td);

        td = document.createElement("td");
        td.style.width = "5%";
        inp = document.createElement("input");
        inp.type = "submit";
        inp.style.width = "100%";
        inp.id = "deleteStep-"+val;
        inp.className = "deleteStepRow";
        inp.value = "Delete";
        td.appendChild(inp);
        tr.appendChild(td);

        document.getElementById("tableStepsModal").appendChild(tr);
  }

  $(document).on('click','#addStepsModal',function(){
    addsteprow();
  });

  $(document).on('click','.deleteStepRow',function(){
    var id = $(this).attr("id");
    console.log(id);
    var res = id.split("-");
    document.getElementById("tableStepsModal").removeChild(document.getElementById(res[1].toString()));
  });

  $(document).on('click','.saveStep',function(){
       var idInp = $(this).attr("id");
       console.log(idInp);
       var res = idInp.split("-");

       steps = [];

       for(i=0;i<document.getElementById("tableStepsModal").rows.length;i++){
           if(document.getElementById("tableStepsModal").rows[i].id.localeCompare("1")!=0){
              var id = document.getElementById("tableStepsModal").rows[i].id;
              var existing_step_id = document.getElementById("tableStepsModal").rows[i].cells[0].innerHTML;
              var method_name = document.getElementById("step_name-"+id).value;
              var method_reqs = document.getElementById("step_reqs-"+id).value;
              var method_notes = document.getElementById("step_methods-"+id).value;
              var method_expecs = document.getElementById("step_expecs-"+id).value;

              steps.push({
                 "existing_step_id":existing_step_id,
                 "step_name":method_name,
                 "step_reqs":method_reqs,
                 "step_methods":method_notes,
                 "step_expecs":method_expecs
              });
            }
        }

        var step_json = JSON.stringify(steps);

        $.ajax({
             url:"usecase_mapping_event_handler.php",
             method:"POST",
             data:{project_id:project_id_num,sprint_id:sprint_id_num,functionality_id:res[1],usecase_id:res[2],p:2,step_json:step_json},
             success:function(data){
                 //console.log(data);
                 $('#myModal').hide();
                 $('#tablesteps-'+res[1]+'-'+res[2]).append(data);
                 //console.log(document.getElementById("tablesteps-"+res[1]+"-"+res[2]).innerHTML);
             }
        });
  });

  $(document).on('click','.addStepRepo',function(){
      var id = $(this).attr("id");
      var res = id.split("-");
      console.log(id);

      $.ajax({
        url:"load_modal_content.php",
        method:"POST",
        data:{row_id:res[1],project_id:project_id_num,p:1},
        success:function(data){
           $('#myModalContent1').html(data);
           $('#myModal1').show();
        }
      });
  });

  $(document).on('click', '.cancelStepsWithinUsecase', function(){
      var id = $(this).attr("id");
      console.log(id);
      var res = id.split("-");
      //console.log(res.toString());

      $.ajax({
         url:"usecase_mapping_event_handler.php",
         method:"POST",
         data:{p:3,project_id:project_id_num,sprint_id:sprint_id_num,functionality_id:res[1],usecase_id:res[2],step_id:res[3]},
         success:function(data){
            $('#table_steps_tr-'+res[1]+'-'+res[2]+'-'+res[3]).remove();
         }
      });
  });

  $(document).on('click', '.cancelUsecase', function(){
      var id = $(this).attr("id");
      var res = id.split("-");
      console.log(id);

      $.ajax({
         url:"usecase_mapping_event_handler.php",
         method:"POST",
         data:{project_id:project_id_num,sprint_id:sprint_id_num,functionality_id:res[1],usecase_id:res[2],p:4},
         success:function(data){
            $('#usecase_header-'+res[1]+"-"+res[2]).remove();
            $('.usecase_steps-'+res[1]+"-"+res[2]).remove();
         }
      });
      event.stopImmediatePropagation();
      return false;
  });

  $(document).on('click','.editClassName',function(){
      var id = $(this).attr("id");
      console.log(id);
      var res = id.split("-");
      var parent = document.getElementById("class_name_header-"+res[1]+"-"+res[2]);
      var getInp = parent.getElementsByTagName("input");

      if(getInp.length>0){
      	 var value = getInp[0].value;
      	 parent.innerHTML = value;
      	 $.ajax({
      	 	url:"identified_classes_event_handler.php",
      	 	method:"POST",
      	 	data:{class_id:res[2],p:2,class_name:value,project_id:project_id_num,sprint_id:sprint_id_num,functionality_id:res[1]},
      	 	success:function(data){

      	 	}
      	 })
      }
      else{
      	 var inp = document.createElement("input");
      	 inp.type = "text";
      	 inp.style.width = "100%";
      	 inp.style.height = "20px";
      	 inp.style.textAlign = "left";
      	 inp.value = parent.innerHTML;
      	 parent.innerHTML = "";
      	 parent.appendChild(inp);
      }
      event.stopImmediatePropagation();
      return false;
  });

  $(document).on('click','.addClassAttributes',function(){
  	  var id = $(this).attr("id");
      console.log(id);
  	  var res = id.split("-");
  	  var class_attr_string = document.getElementById("textArr-"+res[1]+"-"+res[2]).value;
  	  var class_attr_arr = class_attr_string.split("\n");
  	  class_attr_string = "";
  	  
  	  for(i=0;i<class_attr_arr.length;i++){
  	  	 class_attr_arr[i] = class_attr_arr[i].trim();
  	  	 class_attr_string += class_attr_arr[i];
  	  }

  	  $.ajax({
  	  	 url:"identified_classes_event_handler.php",
  	  	 method:"POST",
  	  	 data:{p:3,project_id:project_id_num,sprint_id:sprint_id_num,class_id:res[2],functionality_id:res[1],class_attr:class_attr_string},
         success:function(data){

         }
  	  });
  });

  $(document).on('click','.addClassMethods',function(){
  	  var id = $(this).attr("id");
  	  console.log(id);
  	  var res = id.split("-");

  	  $.ajax({
  	  	 url:"identified_classes_event_handler.php",
  	  	 method:"POST",
  	  	 data:{p:4,project_id:project_id_num,sprint_id:sprint_id_num,class_id:res[2],functionality_id:res[1]},
  	  	 success:function(data){
  	  	   //console.log(data); 
           $('#tableClassMethods-'+res[1]+'-'+res[2]).append(data);
           var elems = document.getElementsByClassName("method-"+res[1]+"-"+res[2]);
           for(i=0;i<elems.length;i++){
           	  elems[i].style.display = "";
           }
           //console.log(document.getElementById("tableClassMethods-"+res[1]+"-"+res[2]).innerHTML);
  	  	 }

  	  });
  	  event.stopImmediatePropagation();
  	  return false;
  });

  $(document).on('click','.methodNameEdit',function(){
  	  var id = $(this).attr("id");
  	  console.log(id);
  	  event.stopImmediatePropagation();
  	  return false;
  });

  $(document).on('click','.editClassMethod',function(){
  	  var id = $(this).attr("id");
  	  console.log(id);
  	  var res = id.split("-");
      var parent = document.getElementById("stepsHeaderWithinClass-"+res[1]+"-"+res[2]+"-"+res[3]);
      var getInp = parent.getElementsByTagName("input");

      if(getInp.length>0){
      	 var value = getInp[0].value;
      	 parent.innerHTML = value;
      	 var req_inp = document.getElementById("req_inp_StepWithinClass-"+res[1]+"-"+res[2]+"-"+res[3]).value;
      	 var method_inp = document.getElementById("method_inp_StepsWithinClass-"+res[1]+"-"+res[2]+"-"+res[3]).value;
      	 var exp_inp = document.getElementById("exp_inp_StepWithinClass-"+res[1]+"-"+res[2]+"-"+res[3]).value;

      	 $.ajax({
  	  	 url:"identified_classes_event_handler.php",
  	  	 method:"POST",
  	  	 data:{p:5,project_id:project_id_num,sprint_id:sprint_id_num,functionality_id:res[1],class_id:res[2],class_method_id:res[3],step_name:value,step_reqs:req_inp,step_methods:method_inp,step_expecs:exp_inp},
  	  	 success:function(data){
  	  	 	 console.log(data);
             var elems = document.getElementsByClassName("methodDetails-"+res[1]+"-"+res[2]+"-"+res[3]);
          	 for(i=0;i<elems.length;i++){
          	 	elems[i].style.display = "none";
          	 }
  	  	  }
  	    });
      }
      else{
         var inp = document.createElement("input");
      	 inp.type = "text";
      	 inp.style.width = "100%";
      	 inp.style.height = "20px";
      	 inp.style.textAlign = "left";
      	 inp.value = parent.innerHTML;
      	 inp.id = "methodName-"+res[1]+"-"+res[2]+"-"+res[3];
      	 inp.className = "methodNameEdit";
      	 parent.innerHTML = "";
      	 parent.appendChild(inp);

      	 var elems = document.getElementsByClassName("methodDetails-"+res[1]+"-"+res[2]+"-"+res[3]);
      	 for(i=0;i<elems.length;i++){
      	 	elems[i].style.display = "";
      	 }
      }
      event.stopImmediatePropagation();
      return false;
  });

  $(document).on('click','.cancelClassMethod',function(){
      var id = $(this).attr("id");
      console.log(id);
      var res = id.split("-");

      $.ajax({
      	url:"identified_classes_event_handler.php",
      	method:"POST",
      	data:{p:6,project_id:project_id_num,class_id:res[2],class_method_id:res[3],sprint_id:sprint_id_num,functionality_id:res[1]},
      	success:function(data){
      	   console.log(data);
           $('#method_details-'+res[1]+'-'+res[2]+'-'+res[3]).remove();
           $('.methodDetails-'+res[1]+'-'+res[2]+'-'+res[3]).remove();
      	}
      });
      event.stopImmediatePropagation();
  	  return false;
  });

  $(document).on('click','.repoClassMethod',function(){
  	 var id = $(this).attr("id");
  	 var res = id.split("-");
     console.log(id);

  	 $.ajax({
  	 	url:"load_steps_for_class_modal.php",
  	 	method:"POST",
        data:{project_id:project_id_num,class_id:res[2],class_method_id:res[3],functionality_id:res[1]},
        success:function(data){
           $('#myModalContent1').html(data);
           $('#myModal1').show();
        }
  	 });
  	 event.stopImmediatePropagation();
  	 return false;

  });

  $(document).on('click', '.checkboxStep', function(){
      var id = $(this).attr("id");
      console.log(id);
      var res = id.split("-");

      $.ajax({
         url:"db_controller.php",
         method:"POST",
         data:{p:1,project_id:project_id_num,step_id:res[1]},
         success:function(data){
            var step_details = data;
            var json_step = JSON.parse(step_details);
            
            $('[id]').each(function(){
			  var ids = $('[id="'+this.id+'"]');
			  if(ids.length>1 && ids[0]==this)
			    console.warn('Multiple IDs #'+this.id);
			});

            //console.log(json_step["step_name"]);
            document.getElementById("step_id-"+res[2]).innerHTML = res[1];
            //document.getElementById(res[2]).cells[1].innerHTML = json_step["step_name"];
            document.getElementById("step_name-"+res[2]).value = json_step["step_name"];
            document.getElementById("step_reqs-"+res[2]).value = json_step["step_name"];
            document.getElementById("step_methods-"+res[2]).value = json_step["step_methods"];
            document.getElementById("step_expecs-"+res[2]).value = json_step["step_expecs"];
            $('#myModal1').hide();
            
            $('[id]').each(function(){
			  var ids = $('[id="'+this.id+'"]');
			  if(ids.length>1 && ids[0]==this)
			    console.warn('Multiple IDs #'+this.id);
			});

         }
      });
  });

  $(document).on('click','.checkboxClassMethod',function(){
      var id = $(this).attr("id");
      var res = id.split("-");
      console.log(id);

      $.ajax({
      	 url:"identified_classes_event_handler.php",
      	 method:"POST",
      	 data:{p:8,project_id:project_id_num,sprint_id:sprint_id_num,functionality_id:res[2],class_id:res[3],class_method_id:res[4],step_id:res[1]},
      	 success:function(data){
            var step_details = data;
            var json_step = JSON.parse(step_details);

            document.getElementById("stepsHeaderWithinClass-"+res[2]+"-"+res[3]+"-"+res[4]).innerHTML = json_step["step_name"];
            document.getElementById("req_inp_StepWithinClass-"+res[2]+"-"+res[3]+"-"+res[4]).value = json_step["step_reqs"];
            document.getElementById("method_inp_StepsWithinClass-"+res[2]+"-"+res[3]+"-"+res[4]).value = json_step["step_methods"];
            document.getElementById("exp_inp_StepWithinClass-"+res[2]+"-"+res[3]+"-"+res[4]).value = json_step["step_expecs"];

            $('#myModal1').hide();

            $('[id]').each(function(){
			  var ids = $('[id="'+this.id+'"]');
			  if(ids.length>1 && ids[0]==this)
			    console.warn('Multiple IDs #'+this.id);
			});

            var elems = document.getElementsByClassName("methodDetails-"+res[2]+"-"+res[3]+"-"+res[4]);
		      	 for(i=0;i<elems.length;i++){
		      	 	console.log("inside the elems ");
		      	 	elems[i].style.display = "";

		      	 }
      	    }
      });
      event.stopImmediatePropagation();
      return false;
  });

  $(document).on('click','.addGroupings',function(){
     var id = $(this).attr("id");
     var res = id.split("-");
     console.log(id);

     $.ajax({
     	url:"identified_groupings_event_handler.php",
     	method:"POST",
     	data:{project_id:project_id_num,sprint_id:sprint_id_num,functionality_id:res[1],p:1},
     	success:function(data){
           $('#myModalContent1').html(data);
           $('#myModal1').show();
     	}
     });
  });

  $(document).on('click','.saveGroup',function(){
  	  var id = $(this).attr("id");
  	  var res = id.split("-");
      var elems = document.getElementsByClassName("checkboxGroups");
      var arr = [];
      console.log(id);

      for(i=0;i<elems.length;i++){
      	 var elems_id = elems[i].id;
      	 console.log("id ----- " + elems_id);
      	 console.log("-------" +  elems[0].checked);
      	 if(elems[i].checked){
      	 	var res_elems_id = elems_id.split("-");
      	    arr.push(res_elems_id[2]);
      	 }
      }
      
  	  $.ajax({
	  	  url:"identified_groupings_event_handler.php",
	  	  method:"POST",
	  	  data:{project_id:project_id_num,sprint_id:sprint_id_num,functionality_id:res[1],p:2,classes:arr},
	  	  success:function(data){
	  	  	 $('#myModal1').hide();
	         $('#myModalContent').html(data);
	         $('#myModal').show();
          }
  	  });
  });

  $(document).on('click','.saveGroupIntoDB',function(){
  	  var id = $(this).attr("id");
  	  var res = id.split("-");
  	  console.log(id);

  	  var elems = document.getElementsByClassName("groupedClassesList");
  	  var elemsName = document.getElementsByClassName("groupedClassNameList");
  	  var arr = [];
  	  for(var i=0;i<elems.length;i++){
         arr.push({
         	"class_id":elems[i].innerHTML,
         	"class_name":elemsName[i].innerHTML
         });
  	  }
  	  var json_arr = JSON.stringify(arr);
  	  //console.log(json_arr);
  	  var group_name = document.getElementById("groupNameInp-"+res[1]).value;

  	  $.ajax({
  	  	url:"identified_groupings_event_handler.php",
  	  	method:"POST",
  	  	data:{p:3,project_id:project_id_num,sprint_id:sprint_id_num,functionality_id:res[1],classes:json_arr,group_name:group_name},
  	  	success:function(data){
            $('#functionality_groupings_td-'+res[1]).append(data);
            //console.log("\n\n");
            //console.log(data);
            var elems = document.getElementsByClassName("functionality_groupings-"+res[1]);
	          for(i=0;i<elems.length;i++){
	          	 elems[i].style.display = "";
	          }
	        $('#myModal').hide();
	        //console.log("\n\n");
	        //console.log(document.getElementById("functionality_groupings_td-"+res[1]).innerHTML);
	        fetch_data();
  	  	 }
  	  });
  	  event.stopImmediatePropagation();
      return false;

  });

  $(document).on('click', '.sprintNum', function(){
          var id = $(this).attr("id");
          sprint_id_num = id;
          //console.log(sprint_id_num);
          //id_num = id;
          fetch_data();
   });

  $(document).on('click', '.exportToXML', function(){
       $('#fcdHolder').css({'display':'none'});
       $('#fcdView').css({'display':'none'});
       $('#importXMLHeader').css({'display':'none'});
       $('#exportXMLHeader').css({'display':''});

          $.ajax({
          	url: "export_xml_file.php",
          	method: "POST",
          	data: {project_id:project_id_num},
          	success:function(data){
              console.log(data);
              if(data==1){
                $('#entire_exportXML_holder').html("Export was successful");
              }
              else{
                $('#entire_exportXML_holder').html("Error thrown");
              }
          	}
          });
   });

  $(document).on('click', '.importToXML', function(){
       $('#fcdHolder').css({'display':'none'});
       $('#fcdView').css({'display':'none'});
       $('#importXMLHeader').css({'display':''});
       $('#exportXMLHeader').css({'display':'none'});

          $.ajax({
          	url: "import_xml_file.php",
          	method: "POST",
          	data: {project_id:project_id_num},
          	success:function(data){
              console.log(data);
              $('#entire_importXML_holder').html(data);
          	}
          });
   });

});

  function addSprint(){
	  var ul = document.getElementById("sprintList");
	  var li = document.createElement("li");
	  li.className = "sprintNum";
	  last_sprint_num = last_sprint_num + 1;
	  li.id = last_sprint_num;
	  var a = document.createElement("a");
	  a.innerHTML = "Sprint "+last_sprint_num;
	  
	  li.appendChild(a);
	  ul.appendChild(li);
	  
	  $.ajax({
	  	url:"update_sprint_info.php",
	  	method:"POST",
	  	data:{sprintid:last_sprint_num,sprintname:a.innerHTML,project_id:project_id_num},
	  	success:function(data){

	  	}
	  });
  }


</script>
</body>