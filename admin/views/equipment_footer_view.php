<script>
	$().ready(function() {
    	$("#equipmentdiv").hide();
    	$("#assignedto").hide();
    	$("#facility").hide();
    	$("#county").hide();
    	$("#partner").hide();
    	$("#equipmentserial").hide();
    	$("#printerserial").hide();
    	$("#assignto").hide();
	});

	var json_equipment 	= '<?php echo json_encode($equipment_1);?>';
	var equipment 		=	JSON.parse(json_equipment);	

	$("#cat").change(function(){ 
    	var eq_type 	= $("#cat").val();     	
    	var options ='<option value="">*Select an Equipment*</option>';
    	for (i = 0; i < equipment.length; ++i) {  		
    		if(equipment[i]["equipment_category_id"]==eq_type){
    			options += '<option value="'+equipment[i]["id"]+'">'+equipment[i]["description"]+'</option>';
    		}
		}
		$("#equipment").html(options);

		if(!$("#cat").val()){
			$("#equipmentdiv").hide();
			$("#facility").hide();
			$("#equipmentserial").hide();
    	    $("#printerserial").hide();
		}else{
			$("#equipmentdiv").show();
			$("#facility").show();
			$("#equipmentserial").show();
			$("#printerserial").show();
		}


 	});
</script>