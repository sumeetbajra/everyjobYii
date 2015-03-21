$(document).ready(function(){
	$('#sort-type').on('change', function(){
		var type = $(this).val();
		window.location = 'posts?sort='+type;
	});
});