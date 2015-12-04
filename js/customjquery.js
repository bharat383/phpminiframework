$(document).ready(function(){

	/*BEGIN INPUT VALIDATION ON KEYUP*/
		//ALPHA VALUE VALIDAITON
		if($('.alpha').length>0) {
		    $('.alpha').alpha({
		        allow: ''
		    });
		}
    
	    //NUMERIC VALUE VALIDAITON
	    if($('.numeric').length>0) {
		    $('.numeric').numeric({

		    });
		}

	    //ALPHA NUMBER VALUE VALIDAITON
	    if($('.alphanumeric').length>0) {
		    $('.alphanumeric').alphanum({
		        allow: ''
		    });
		}

	    //EMAIL INPUT VALIDAITON 
	    if($('.email').length>0) {
		    $('.email').alphanum({
		        allow: '.@_-'
		    });
		}
	/*END INPUT VALIDATION ON KEYUP*/   

	
	/*BEGIN FORM SUBMIT TIME VALIDATION*/   	
	$('form').submit(function(){
		var errorcount=0;
		$(this).find('input,select,textarea').each(function(){
			if($(this).val()=="" && $(this).attr("title")) {
				errorcount++;
				$(this).attr("placeholder",$(this).attr("title"));
	            $(this).css("border","1px solid #FF0000");
			} else {
				$(this).css("border","");	
			}
		});

	    if(errorcount>0){
	        return false;
	    } else {
	        return true;
	    }
	});
	/*END FORM SUBMIT TIME VALIDATION*/   	

	/*BEGIN SHOW PASSWORD AS TEXT*/
	if($('.show_password').length>0) {
			$('.show_password').on("change",function(){
				if($(this).is(':checked')) {
					$(this).prev('input[type="password"]').attr("type","text");
				} else { 
					$(this).prev('input[type="text"]').attr("type","password");
				}
			});
	}
	/*END SHOW PASSWORD AS TEXT*/

});