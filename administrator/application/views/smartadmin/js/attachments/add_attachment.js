$(document).ready(function() {
	var i=1;
 
	$(document).on( "click", "#attach_more", function() 
	{
		i++;
		$('#image_section').append("<div id='attachment_" + i + "'><input type='file' name='image_name_" + i + "'><span style='color: red; cursor: pointer;' class='remove'>Remove <input type='hidden' value='" + i + "'></span></div>");
		$('#no_of_attachments').val(i);
        $('#no_of_colors').val(i);
	});

	$(document).on( "click", ".remove", function() 
	{
		var id = $(this).find('input').val();
		$("#image_name_" + id).remove();
        $("#image_color_" + id).remove();
		i--;
		$('#no_attach').val(i);
	});
});
