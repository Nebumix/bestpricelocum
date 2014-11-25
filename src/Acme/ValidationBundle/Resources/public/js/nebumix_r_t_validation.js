
	function check_field(name_form, name_field){
		var res = "";
		$.ajax({
			url: Routing.generate('nebumixrt_validation_check'),
			type: "POST",
			async: false,
			data: { item : $('#'+name_field+'').val(), name : name_field, nameForm : name_form },
			dataType: "html",
			success: function(msg) {
				//alert(msg);
				res = msg;
				if(msg != 1){
					$('#'+name_field+'_error').html(msg);
				}else{
					$('#'+name_field+'_error').html("");
				}
			},
			error: function(){
			alert("ERROR!");
			}
		});
		return res;	
	}



	function check_field_check(name_form, name_field){
		var res = "";
		$.ajax({
			url: Routing.generate('nebumixrt_validation_check'),
			type: "POST",
			async: false,
			data: { item : $( 'input:radio[name*='+name_field+']:checked' ).val(), name : name_field, nameForm : name_form },
			dataType: "html",
			success: function(msg) {
				//alert(msg);
				res = msg;
				if(msg != 1){
					$('#'+name_field+'_error').html(msg);
				}else{
					$('#'+name_field+'_error').html("");
				}
			},
			error: function(){
			alert("ERROR!");
			}
		});
		return res;	
	}



	function check_field_isTimebreakValid(field, field1){
		var res = "";

		$.ajax({  
	        url: Routing.generate('nebumixrt_timebreak_valid'),  
	        type: "POST",  
	        async: false,
			data: { item : $('#'+field+'').val(), item1 : $('#'+field1+'').val() },
	        dataType: "html",
	        success: function(msg) { 
	              //alert(msg);
	              res = msg;
	              
	              if(msg != 1){
	              	$('#'+field1+'_error').html(msg);
	              }else{
	              	$('#'+field1+'_error').html("");
	              }
	        },
	        error: function(){
	          alert("ERROR!");
	        } 
	      }); 	

	      return res;			
	}


	function check_field_isTimestartend(field, field1){

/*		var dateStart = $('#'+field+'').val();
*/		var dS = new Date("January 01, 1970 "+ $('#'+field+'').val() +":00");

/*		var dateEnd = $('#'+field1+'').val();
*/		var dE = new Date("January 01, 1970 "+ $('#'+field1+'').val() +":00");


		var res = "";

		$.ajax({  
	        url: Routing.generate('nebumixrt_isTimestartend_valid'),  
	        type: "POST",  
	        async: false,
			data: { item : dS, item1 : dE },
	        dataType: "html",
	        success: function(msg) { 
	              //alert(msg);
	              res = msg;
	              
	              if(msg == 1){
	              	$('#'+field+'_error').html("");
	              	$('#'+field1+'_error').html("");
	              }else if(msg == -1){

	          	  }else{
	              	$('#'+field+'_error').html(msg);
	              	$('#'+field1+'_error').html(msg);
	              }
	        },
	        error: function(){
	          alert("ERROR!");
	        } 
	      }); 	

	      return res;			
	}

