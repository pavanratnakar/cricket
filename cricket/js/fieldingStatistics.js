jQuery(document).ready(function()
{
	jQuery("#fieldingStatistics").jqGrid({
		url:'include/battingController.php?ref=fieldingStats',
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
		rowNum:30,
		rowList:[30,90,150,210],
		height: 'auto',
		pager: '#pfieldingStatistics',
		sortname: 'firstname',
		viewrecords: true,
		sortorder: "asc",
		caption:"Fielding Statistics",
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
	jQuery("#fieldingStatistics").jqGrid('navGrid','#pfieldingStatistics',
		{add:false, view:false, del:false,edit:false}, 
		{top:0,closeAfterEdit:true,reloadAfterSubmit:true,closeOnEscape:true,afterSubmit: fn_replyResponse,bottominfo:'Task can only be edited by the one who created it.'}, // edit options
		{top:0,clearAfterAdd:true,reloadAfterSubmit:true,closeOnEscape:true,afterSubmit: fn_replyResponse,bottominfo:'* Mandatory fields.'}, // add options
		{top:0,reloadAfterSubmit:true,closeOnEscape:true,afterSubmit: fn_replyResponse,bottominfo:'Task can only be deleted by the one who created it.'}, // del options
		{}, // search options
		{closeOnEscape:true} 
	);
	jQuery("#fieldingStatisticsSelect").change(function()
	{
		var vl = $(this).val();
		if(vl) 
		{
			if(vl == "clear") {
				jQuery("#fieldingStatistics").jqGrid('groupingRemove',true);
			} else {
				jQuery("#fieldingStatistics").jqGrid('groupingGroupBy',vl);
			}
		}
	});
});