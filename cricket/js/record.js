jQuery(document).ready(function()
{
	jQuery.ajax(
	{
		url: "include/recordController.php?ref=recordStats",
		dataType: "html",
		cache: true,
		beforeSend: function()
		{
		},
		success:function(data)
		{	
			$("#recordContainter").html(data);
		}
	});
});