jQuery(document).ready(function()
{
	jQuery("#bowlingStatistics").jqGrid({
		url:'include/battingController.php?ref=bowlingStats',
		datatype: "json",
		width:770,
		colNames:['Id', 'Name','Team','Match Time', 'Overs Bowled','Wide Balls','No Balls','Runs Conceived','Bowling Average','Catches Taken'],
		colModel:[
			{name:'batting_id',index:'batting_id', align:'center',editable:false, sorttype:'int',key:true,hidden:true},
			{name:'firstname',index:'firstname', formoptions:{label: 'Name'},align:"center", sortable:true},
			{name:'team_name',index:'team_name', align:"center", sortable:true, hidden:false, editable: false},
			{name:'match_number',index:'match_number', align:"center", sortable:true, hidden:false},
			{name:'overs_bowled',index:'overs_bowled', align:"center",formoptions:{label: 'Overs Bowled'}, sortable:true, hidden:false, editable: true},
			{name:'wide_balls',index:'wide_balls', align:"center",formoptions:{label: 'Wide Balls'}, sortable:true, hidden:false, editable: true},
			{name:'no_balls',index:'no_balls', align:"center",formoptions:{label: 'No Balls'}, sortable:true, hidden:false, editable: true},
			{name:'runs_conceived',index:'runs_conceived', align:"center",formoptions:{label: 'Runs Conceived'}, sortable:true, hidden:false, editable: true,sorttype:'number',summaryType:'sum'},
			{name:'bowling_score',index:'bowling_score', align:"center",formoptions:{label: 'Bowling Average'}, sortable:true, hidden:false, editable: false},
			{name:'catches_taken',index:'catches_taken', align:"center",formoptions:{label: 'Catches Taken'}, sortable:true, hidden:true, editable: false},
		],
		rowNum:20,
		rowList:[20,40,60,100],
		height: 'auto',
		pager: '#pbowlingStatistics',
		sortname: 'firstname',
		viewrecords: true,
		sortorder: "asc",
		caption:"Bowling Statistics",
		editurl:"include/battingController.php?ref=battingOperation",
		grouping: true,
		groupingView : {
			groupField : ['firstname'],
			groupColumnShow : [true],
			groupText : ['<b>{0}</b>'],
			groupCollapse : false,
			groupOrder: ['asc'],
			groupSummary : [true],
			showSummaryOnHide: true,
			groupDataSorted : true
		},
		footerrow: true,
		userDataOnFooter: true
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
	jQuery("#bowlingStatistics").jqGrid('navGrid','#pbowlingStatistics',
		{add:false, view:false, del:false,edit:false}, 
		{top:0,closeAfterEdit:true,reloadAfterSubmit:true,closeOnEscape:true,afterSubmit: fn_replyResponse,bottominfo:'Task can only be edited by the one who created it.'}, // edit options
		{top:0,clearAfterAdd:true,reloadAfterSubmit:true,closeOnEscape:true,afterSubmit: fn_replyResponse,bottominfo:'* Mandatory fields.'}, // add options
		{top:0,reloadAfterSubmit:true,closeOnEscape:true,afterSubmit: fn_replyResponse,bottominfo:'Task can only be deleted by the one who created it.'}, // del options
		{}, // search options
		{closeOnEscape:true} 
	);
	jQuery("#bowlingStatisticsSelect").change(function()
	{
		var vl = $(this).val();
		if(vl) 
		{
			if(vl == "clear") {
				jQuery("#bowlingStatistics").jqGrid('groupingRemove',true);
			} else {
				jQuery("#bowlingStatistics").jqGrid('groupingGroupBy',vl);
			}
		}
	});
});