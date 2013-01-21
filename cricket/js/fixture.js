jQuery(document).ready(function()
{ 
	var teams = $.ajax({url: "include/teamController.php?ref=teamDetails", dataType: "json", cache: true, async: false, success: function(data, result) {if (!result) alert('Failure to retrieve the Products.');}}).responseText;
	jQuery("#fixture01").jqGrid({
		url:'include/fixtureController.php?ref=fixture',
		datatype: "json",
		width:770,
		colNames:['Fixture ID', 'Planned Date', 'Team 1', 'Team 2', 'Winner', 'Fixture Type'],
		colModel:[
			{name:'fixture_id',index:'fixture_id', align:'center',editable:false, sorttype:'int',key:true,hidden:true},
			{name:'fixture_datetime',index:'fixture_datetime',formoptions:{label: 'Match Time *'}, align:'center',editable:true,editrules: { required: false}, editoptions:{size:20,dataInit:function(el){$(el).datetimepicker({showSecond: true,timeFormat: 'hh:mm:ss'});}}},
			{name:'fixture_team1',index:'fixture_team1', formoptions:{label: 'Team 1'},align:"center", sortable:true, hidden:false, editable: true,edittype: "select", editrules: { required: true }, editoptions: { size: 71,value: (teams.replace('"','')).replace('"','') }},
			{name:'fixture_team2',index:'fixture_team2', formoptions:{label: 'Team 2'},align:"center", sortable:true, hidden:false, editable: true,edittype: "select", editrules: { required: true }, editoptions: { size: 71,value: (teams.replace('"','')).replace('"','') }},
			{name:'fixture_winner',index:'fixture_winner', formoptions:{label: 'Winner'},align:"center", sortable:true, hidden:false, editable: true,edittype: "select", editrules: { required: true }, editoptions: { size: 71,value: (teams.replace('"','')).replace('"','') }},
			{name:'fixture_type',index:'fixture_type', formoptions:{label: 'Fixture Type'}, align:"center",hidden:true,editable: true,editrules: { required: true,edithidden:true } ,edittype:"select",editoptions:{value:"1:Round Robin;2:Finals"}},
		],
		rowNum:10,
		rowList:[10,20,30],
		height: 'auto',
		pager: '#pfixture01',
		sortname: 'fixture_id',
		viewrecords: true,
		sortorder: "asc",
		caption:"Match Fixtures",
		editurl:"include/fixtureController.php?ref=fixtureOperation",
		grouping: true,
		groupingView : {
			groupField : ['fixture_type'],
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
	jQuery("#fixture01").jqGrid('navGrid','#pfixture01',
		{add:false, view:true, del:false,edit:true}, 
		{top:0,closeAfterEdit:true,reloadAfterSubmit:true,closeOnEscape:true,afterSubmit: fn_replyResponse,bottominfo:'* Mandatory fields.'}, // edit options
		{top:0,clearAfterAdd:true,reloadAfterSubmit:true,closeOnEscape:true,afterSubmit: fn_replyResponse,bottominfo:'* Mandatory fields.'}, // add options
		{top:0,reloadAfterSubmit:true,closeOnEscape:true,afterSubmit: fn_replyResponse,bottominfo:'Task can only be deleted by the one who created it.'}, // del options
		{}, // search options
		{closeOnEscape:true} 
	);
});