$(document).ready(function(){
	$('#sort-type').on('change', function(){
		var type = $(this).val();
		window.location = 'posts?sort='+type;
	});

	 $('#myTable').DataTable();

	 $('.admin-msg-btn').on('click', function(){
	 	var id = $(this).attr('id');
	 	$('#message-to_user').val(id);
	 	$('#admin-msg-form').attr('action', '/college/everyjobSite/web/admin/message/'+id);
	 });

	 $('.go').on('click', function(){
	 	var checkbox = $('input[name="postsCheck[]"]:checked');
	 	var posts = [];
	 	checkbox.each(function(i, j){
 			id = $(j).attr('id').split('_')[1];
 			posts[i] = id;
	 	});
	 	var action = $('select[name="actions"]').val();
	 	if(action && posts.length){
	 		bootbox.confirm('Are you sure?', function(response){
	 			if(response){
	 				$.ajax({
	 					type: 'GET',
	 					url: 'deletepost',
	 					data: {posts: posts, action: action},
	 					success: function(response){
	 						if(response == "true"){
	 							location.reload();
	 						}else{
	 							console.log(response);
	 						}
	 					}
	 				});
	 			}
	 		});
	 	}
	 });

	 $('input[name="postsCheckAll"]').on('click', function(){
	 	var checkbox = $('input[name="postsCheck[]"]');
	 	if($(this).is(':checked')){
	 		$('input[name="postsCheckAll"]').each(function(){
	 			this.checked = true;
	 		});
	 		checkbox.each(function() { //loop through each checkbox
		           	this.checked = true; //deselect all checkboxes with class "checkbox1"                       
		           });
	 	}else{
	 		$('input[name="postsCheckAll"]').each(function(){
	 			this.checked = false;
	 		});
	 		checkbox.each(function() { //loop through each checkbox
		           	this.checked = false; //deselect all checkboxes with class "checkbox1"                       
		           });
	 	}
	 });
});

