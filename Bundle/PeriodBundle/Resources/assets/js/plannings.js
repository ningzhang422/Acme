
$(document).ready( function() {
		var url_c;
		$("table#planning_table td").click(function(e){     //function_td
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
			    		
			    		$( "form.form-horizontal" ).on( "submit", function( event ) {
			    			event.preventDefault();
			    			$.ajax({
			                    type: 'POST',
			                    url: url_c,
			                    data: $( this ).serializeArray(),              
			                    success: function(data) {
			                       alert('success !!!' + data);
			                    }
			                 });	
			    			//console.log( $( this ).serializeArray() );
			    			});
			        }
			 });  
	})
			
});  