
$(document).ready( 
		
		$("table#planning_table td").click(function(e){     //function_td
			  $(this).css("font-weight","bold");
			  $('#confirmation-modal').modal('show');
			  e.stopPropagation();
			})
	
);  