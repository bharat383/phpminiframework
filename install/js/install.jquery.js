$(document).ready(function(){

	/*STEP 1 : DATABASE SETUP*/
	$("#database-setup-form").submit(function(){
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

		if(errorcount==0) {
			if(confirm("Are You Sure to submit the data ?")) {
			    var formdata = $("#database-setup-form").serializeArray();
			    $.post("install.process.php?step=1", formdata, function(msg) {
			    	if(msg.length>0) {
			                $("#step-1").html("");
			                $("#step-1").addClass("hide");
			                $("#step-1").after(msg);
			                $("#step-2").removeClass("hide");
			        }
			    });
			}
		}
		return false;
	});

	/*STEP 2 : SITE DATA SETUP */
	$("#site-setup-form").submit(function(){
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

		if(errorcount==0) {
		    var formdata = $("#site-setup-form").serializeArray();
		    $.post("install.process.php?step=2", formdata, function(msg) {
		    	if(msg.length>0) {	
		                $("#step-2").html("");
		                $("#step-2").addClass("hide");
		                $("#step-2").after(msg);
		                $("#step-3").removeClass("hide");
		        }
		    });
		}
	    return false;		
	});

	/*STEP 3 : ADMIN DATA SETUP */
	$("#admin-setup-form").submit(function(){
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

		if(errorcount==0) {
		    var formdata = $("#admin-setup-form").serializeArray();
		    $.post("install.process.php?step=3", formdata, function(msg) {
		    	if(msg.length>0) {
		                $("#step-3").html("");
		                $("#step-3").addClass("hide");
		                $(".alert").remove();
		                $("#step-4").removeClass("hide");
		                $("#step-4").html(msg);
		    	}
		    });
		}
	    return false;		
	});

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