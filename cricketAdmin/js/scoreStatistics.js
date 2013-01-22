jQuery(document).ready(function()
{
	var players = $.ajax({url: "include/registerController.php?ref=listofplayer", dataType: "json", cache: true, async: false, success: function(data, result) {if (!result) alert('Failure to retrieve the Products.');}}).responseText;
	var fixtures = $.ajax({url: "include/fixtureController.php?ref=getfixtureDates", dataType: "json", cache: true, async: false, success: function(data, result) {if (!result) alert('Failure to retrieve the Products.');}}).responseText;
	jQuery("#scoreStatistics").jqGrid({
		url:'include/battingController.php?ref=scoreStats',
		datatype: "json",
		width:770,
		colNames:['Id', 'First Name','Last Name','Team','Match Time', 'Four' , 'Six', 'Out', 'Bowls Played' ,'Score','Overs Bowled','Wickets','Wide Balls','No Balls','Extra Runs','Runs Conceived','Catches Taken'],
		colModel:[
			{name:'batting_id',index:'batting_id', align:'center',editable:false, sorttype:'int',key:true,hidden:true},
			{name:'firstname',index:'firstname', formoptions:{label: 'Player'},align:"center", sortable:false,editable: true,edittype: "select", editrules: { required: true }, editoptions: { size: 71,value: (players.replace('"','')).replace('"','') }},
			{name:'lastname',index:'lastname', align:"center", sortable:false,editable: false,hidden:false,editrules: { number: true ,edithidden:true}},
			{name:'team_name',index:'team_name', align:"center", sortable:true, hidden:false, editable: false},
			{name:'match_number',index:'match_number', align:"center", sortable:true, hidden:false, editable: true,edittype: "select", editrules: { required: true }, editoptions: { size: 71,value: (fixtures.replace('"','')).replace('"','') }},
			{name:'four_count',index:'four_count',formoptions:{label: 'Number of Four\'s'}, align:"center",hidden:false,editable:true,editrules: { number: true ,edithidden:true}},
			{name:'six_count',index:'six_count', formoptions:{label: 'Number of Six\'s'},align:"center",editable: true,hidden:false,editrules: { number: true ,edithidden:true}},
			{name:'out_status',index:'out_status', formoptions:{label: 'Out'},align:"center",editable: true,hidden:false,editrules: { number: true},edittype:"select",editoptions:{value:"1:Out;2:Not Out;3:Did not play"}},
			{name:'overs_played',index:'overs_played', align:"center",formoptions:{label: 'Balls Played'}, sortable:true, hidden:false, editable: true,editrules: { number: true ,edithidden:true}},
			{name:'score',index:'score', align:"center",formoptions:{label: 'Score'}, sortable:true, hidden:false, editable: true},
			{name:'overs_bowled',index:'overs_bowled', align:"center",formoptions:{label: 'Overs Bowled'}, sortable:true, hidden:false, editable: true},
			{name:'wickets',index:'wickets', align:"center",formoptions:{label: 'Wickets'}, sortable:true, hidden:false, editable: true},
			{name:'wide_balls',index:'wide_balls', align:"center",formoptions:{label: 'Wide Balls'}, sortable:true, hidden:false, editable: true},
			{name:'no_balls',index:'no_balls', align:"center",formoptions:{label: 'No Balls'}, sortable:true, hidden:false, editable: true},
			{name:'extra_runs',index:'extra_runs', align:"center",formoptions:{label: 'Extra Runs'}, sortable:true, hidden:true, editable: true},
			{name:'runs_conceived',index:'runs_conceived', align:"center",formoptions:{label: 'Runs Conceived'}, sortable:true, hidden:false, editable: true},
			{name:'catches_taken',index:'catches_taken', align:"center",formoptions:{label: 'Catches Taken'}, sortable:true, hidden:false, editable: true},
		],
		rowNum:20,
		rowList:[20,40,60,100],
		height: 'auto',
		pager: '#pscoreStatistics',
		sortname: 'firstname',
		viewrecords: true,
		sortorder: "asc",
		caption:"Score Statistics",
		editurl:"include/battingController.php?ref=scoreOperation",
		grouping: true,
		groupingView : {
			groupField : ['team_name'],
			groupColumnShow : [true],
			groupText : ['<b>{0}</b>'],
			groupCollapse : false,
			groupOrder: ['asc'],
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
	jQuery("#scoreStatistics").jqGrid('navGrid','#pscoreStatistics',
		{add:true, view:false, del:true,edit:true}, 
		{top:0,closeAfterEdit:true,reloadAfterSubmit:true,closeOnEscape:true,afterSubmit: fn_replyResponse,bottominfo:'Task can only be edited by the one who created it.'}, // edit options
		{top:0,clearAfterAdd:true,reloadAfterSubmit:true,closeOnEscape:true,afterSubmit: fn_replyResponse,bottominfo:'* Mandatory fields.'}, // add options
		{top:0,reloadAfterSubmit:true,closeOnEscape:true,afterSubmit: fn_replyResponse,bottominfo:'Task can only be deleted by the one who created it.'}, // del options
		{}, // search options
		{closeOnEscape:true} 
	);
});