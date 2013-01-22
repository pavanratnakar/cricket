jQuery(document).ready(function()
{
	var fixture_id=$("#matchBowlingSelect").val();
	var team_id=$("#teamBowlingSelect").val();
	$("select#matchBowlingSelect").change(function()
	{
		fixture_id=$("#matchBowlingSelect").val();
		$.getJSON("include/teamController.php?ref=teamDetailsForDate&fixture_id="+fixture_id,{id: $(this).val(), ajax: 'true'}, function(j)
		{
			var options = '';
			options += '<option value="' + j[0]['team_id1'] + '">' + j[0]['team_name1'] + '</option>';
			options += '<option value="' + j[0]['team_id2'] + '">' + j[0]['team_name2'] + '</option>';
			$("select#teamBowlingSelect").html(options);
			getScorecard();
		})
	})
	$("select#teamBowlingSelect").change(function()
	{
		getScorecard();
	});
	jQuery("#bowlingScore").jqGrid({
		url:"include/battingController.php?ref=teamBowlingStats&fixture_id="+fixture_id+"&team_id="+team_id,
		datatype: "json",
		width:770,
		colNames:['Id', 'Name','Team','Match Time', 'Overs Bowled','Wickets','Wide Balls','No Balls','Runs Conceived','Bowling Average'],
		colModel:[
			{name:'batting_id',index:'batting_id', align:'center',editable:false, sorttype:'int',key:true,hidden:true},
			{name:'firstname',index:'firstname', formoptions:{label: 'Name'},align:"center", sortable:true},
			{name:'team_name',index:'team_name', align:"center", sortable:true, hidden:false, editable: false},
			{name:'match_number',index:'match_number', align:"center", sortable:true, hidden:false},
			{name:'overs_bowled',index:'overs_bowled', align:"center",formoptions:{label: 'Overs Bowled'}, sortable:true, hidden:false, editable: true,sorttype:'number',summaryType:'sum'},
			{name:'wickets',index:'wickets', align:"center",formoptions:{label: 'Wickets'}, sortable:true, hidden:false, editable: true,sorttype:'number',summaryType:'sum'},
			{name:'wide_balls',index:'wide_balls', align:"center",formoptions:{label: 'Wide Balls'}, sortable:true, hidden:false, editable: true,sorttype:'number',summaryType:'sum'},
			{name:'no_balls',index:'no_balls', align:"center",formoptions:{label: 'No Balls'}, sortable:true, hidden:false, editable: true,sorttype:'number',summaryType:'sum'},
			{name:'runs_conceived',index:'runs_conceived', align:"center",formoptions:{label: 'Runs Conceived'}, sortable:true, hidden:false, editable: true,sorttype:'number',summaryType:'sum'},
			{name:'bowling_score',index:'bowling_score', align:"center",formoptions:{label: 'Average'}, sortable:true, hidden:false, editable: false},
		],
		rowNum:20,
		rowList:[20,40,60,100],
		height: 'auto',
		pager: '#pbowlingScore',
		sortname: 'wickets',
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
	jQuery("#bowlingScore").jqGrid('navGrid','#pbowlingScore',
		{add:false, view:false, del:false,edit:false}, 
		{top:0,closeAfterEdit:true,reloadAfterSubmit:true,closeOnEscape:true,afterSubmit: fn_replyResponse,bottominfo:'Task can only be edited by the one who created it.'}, // edit options
		{top:0,clearAfterAdd:true,reloadAfterSubmit:true,closeOnEscape:true,afterSubmit: fn_replyResponse,bottominfo:'* Mandatory fields.'}, // add options
		{top:0,reloadAfterSubmit:true,closeOnEscape:true,afterSubmit: fn_replyResponse,bottominfo:'Task can only be deleted by the one who created it.'}, // del options
		{}, // search options
		{closeOnEscape:true} 
	);
	function getScorecard()
	{
		fixture_id=$("#matchBowlingSelect").val();
		team_id=$("#teamBowlingSelect").val();
		$("#bowlingScore").jqGrid('setGridParam',{url:"include/battingController.php?ref=teamBowlingStats&fixture_id="+fixture_id+"&team_id="+team_id,page:1}).trigger("reloadGrid");
	}
});