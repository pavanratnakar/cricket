jQuery(document).ready(function()
{
	jQuery.ajax(
	{
		url: "include/recordController.php?ref=tournamentStats",
		dataType: "html",
		cache: true,
		beforeSend: function()
		{
		},
		success:function(data)
		{	
			$("#tournamentContainter").html(data);
		}
	});
});