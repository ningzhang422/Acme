
$(document).ready( function() {
		var url_c;
		$("table#planning_table td.click_td").click(function(e){     //function_td
			url_c = $(this).attr('rel');
			$.ajax({
			        type: "GET",
			        url: $(this).attr('rel'),
			        cache:false,
			        success: function(response){           
			            if (response.length > 0) {  
			            	$('#form-modal .modal-body').html(response); 
			            	$('#form-modal').modal('show');
			            }
			            
			            
			            $('input .btn-primary').click(function(e){
			    			e.stopPropagation();
			    			
			    		})
			    		
			    		
			        }
			 });  
	})
			
});  