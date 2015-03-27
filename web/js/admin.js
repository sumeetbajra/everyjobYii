$(document).ready(function(){
	$('#sort-type').on('change', function(){
		var type = $(this).val();
		window.location = 'posts?sort='+type;
	});

	 $('#myTable').DataTable();

	 $('.admin-msg-btn').on('click', function(){
	 	var id = $(this).attr('id');
	 	$('#message-to_user').val(id);
	 	$('#admin-msg-form').attr('action', '/everyjobSite/web/admin/message/'+id);
	 });
});