jQuery(document).ready(function()
{
	var fixture_id=$("#matchFieldingSelect").val();
	var team_id=$("#teamFieldingSelect").val();
	$("select#matchFieldingSelect").change(function()
	{
		fixture_id=$("#matchFieldingSelect").val();
		$.getJSON("include/teamController.php?ref=teamDetailsForDate&fixture_id="+fixture_id,{id: $(this).val(), ajax: 'true'}, function(j)
		{
			var options = '';
			options += '<option value="' + j[0]['team_id1'] + '">' + j[0]['team_name1'] + '</option>';
			options += '<option value="' + j[0]['team_id2'] + '">' + j[0]['team_name2'] + '</option>';
			$("select#teamFieldingSelect").html(options);
			getScorecard();
		})
	})
	$("select#teamFieldingSelect").change(function()
	{
		getScorecard();
	});
	jQuery("#teamFieldingStatistics").jqGrid({
		url:"include/battingController.php?ref=teamFieldingStats&fixture_id="+fixture_id+"&team_id="+team_id,
		datatype: "json",
		width:770,
		colNames:['Id', 'Name','Team','Match Time','Catches Taken'],
		colModel:[
			{name:'batting_id',index:'batting_id', align:'center',editable:false, sorttype:'int',key:true,hidden:true},
			{name:'firstname',index:'firstname', formoptions:{label: 'Player'},align:"center",hidden:false,sortable:true,editable: true},
			{name:'team_name',index:'team_name', align:"center", sortable:true, hidden:false, editable: false},
			{name:'match_number',index:'match_number', align:"center", sortable:true, hidden:false, editable: true},
			{name:'catches_taken',index:'catches_taken', align:"center",formoptions:{label: 'Catches Taken'}, sortable:true, hidden:false, editable: false,sorttype:'number',summaryType:'sum'},
		],
		rowNum:20,
		rowList:[20,40,60,100],
		height: 'auto',
		pager: '#pteamFieldingStatistics',
		sortname: 'catches_taken',
		viewrecords: true,
		sortorder: "desc",
		caption:"Bowling Scorecard",
		editurl:"include/battingController.php?ref=battingOperation",
		grouping: true,
		groupingView : {
			groupField : ['team_name'],
			groupColumnShow : [true],
			groupText : ['<b>{0}</b>'],
			groupCollapse : false,
			groupOrder: ['desc'],
			groupSummary : [true],
			showSummaryOnHide: true,
			groupDataSorted : true
		},
		footerrow: false,
		userDataOnFooter: false
	});
	var fn_replyResponse=function(response,postdata)
	{
		var json=response.responseText; //in my case response text form server is "{sc:true,msg:''}"
		var result=eval("("+json+")"); //create js object from server reponse
		if(result.status==false)
		{
			alert(result.message)
		}
		return [result.sc,result.msg,null]; 
	}
	jQuery("#teamFieldingStatistics").jqGrid('navGrid','#pteamFieldingStatistics',
		{add:false, view:false, del:false,edit:false}, 
		{top:0,closeAfterEdit:true,reloadAfterSubmit:true,closeOnEscape:true,afterSubmit: fn_replyResponse,bottominfo:'Task can only be edited by the one who created it.'}, // edit options
		{top:0,clearAfterAdd:true,reloadAfterSubmit:true,closeOnEscape:true,afterSubmit: fn_replyResponse,bottominfo:'* Mandatory fields.'}, // add options
		{top:0,reloadAfterSubmit:true,closeOnEscape:true,afterSubmit: fn_replyResponse,bottominfo:'Task can only be deleted by the one who created it.'}, // del options
		{}, // search options
		{closeOnEscape:true} 
	);
	function getScorecard()
	{
		fixture_id=$("#matchFieldingSelect").val();
		team_id=$("#teamFieldingSelect").val();
		$("#teamFieldingStatistics").jqGrid('setGridParam',{url:"include/battingController.php?ref=teamFieldingStats&fixture_id="+fixture_id+"&team_id="+team_id,page:1}).trigger("reloadGrid");
	}
});