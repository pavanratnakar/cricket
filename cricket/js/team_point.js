jQuery(document).ready(function()
{ 
	jQuery("#team_point").jqGrid({
		url:'include/teamController.php?ref=teamPoints',
		datatype: "json",
		width:770,
		colNames:['Team ID', 'Team Name', 'Matches Won'],
		colModel:[
			{name:'team_id',index:'team_id', align:'center',editable:false, sorttype:'int',key:true,hidden:true},
			{name:'team_name',index:'team_name',formoptions:{label: 'Team Name *'}, align:'center',editable:false,sortable:false},
			{name:'point_count',index:'point_count', formoptions:{label: 'Points Secured'},align:"center", sortable:false},
		],
		rowNum:10,
		rowList:[10,20,30],
		height: 'auto',
		pager: '#pteam_point',
		sortname: 'point_count',
		viewrecords: true,
		sortorder: "asc",
		caption:"Team Point Table",
		editurl:"include/fixtureController.php?ref=fixtureOperation",
		grouping: false,
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
	jQuery("#team_point").jqGrid('navGrid','#pteam_point',
		{add:false, view:true, del:false,edit:false,search:false}, 
		{top:0,closeAfterEdit:true,reloadAfterSubmit:true,closeOnEscape:true,afterSubmit: fn_replyResponse,bottominfo:'* Mandatory fields.'}, // edit options
		{top:0,clearAfterAdd:true,reloadAfterSubmit:true,closeOnEscape:true,afterSubmit: fn_replyResponse,bottominfo:'* Mandatory fields.'}, // add options
		{top:0,reloadAfterSubmit:true,closeOnEscape:true,afterSubmit: fn_replyResponse,bottominfo:'Task can only be deleted by the one who created it.'}, // del options
		{}, // search options
		{closeOnEscape:true} 
	);
});