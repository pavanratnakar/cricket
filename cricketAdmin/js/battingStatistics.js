jQuery(document).ready(function()
{
	jQuery("#battingStatistics").jqGrid({
		url:'include/battingController.php?ref=battingStats',
		datatype: "json",
		width:770,
		colNames:['Id', 'Name','Team','Match Time', 'Four' , 'Six', 'Out', 'Bowls Played' ,'Score','Strike Rate'],
		colModel:[
			{name:'batting_id',index:'batting_id', align:'center',editable:false, sorttype:'int',key:true,hidden:true},
			{name:'firstname',index:'firstname', formoptions:{label: 'Player'},align:"center", sortable:true,editable: true},
			{name:'team_name',index:'team_name', align:"center", sortable:true, hidden:false, editable: false},
			{name:'match_number',index:'match_number', align:"center", sortable:true, hidden:false},
			{name:'four_count',index:'four_count',formoptions:{label: 'Number of Four\'s'}, align:"center",hidden:false,editable:true,editrules: { number: true ,edithidden:true}},
			{name:'six_count',index:'six_count', formoptions:{label: 'Number of Six\'s'},align:"center",editable: true,hidden:false,editrules: { number: true ,edithidden:true}},
			{name:'out_status',index:'out_status', formoptions:{label: 'Out'},align:"center",editable: true,hidden:false,editrules: { number: true},edittype:"select",editoptions:{value:"1:Out;2:Not Out;3:Did not play"}},
			{name:'overs_played',index:'overs_played', align:"center",formoptions:{label: 'Balls Played'}, sortable:true, hidden:false, editable: true,editrules: { number: true ,edithidden:true}},
			{name:'score',index:'score', align:"center",formoptions:{label: 'Score'}, sortable:true, hidden:false, editable: true,sorttype:'number',summaryType:'sum'},
			{name:'batting_average',index:'batting_average', align:"center",formoptions:{label: 'Strike Rate'}, sortable:true, hidden:false, editable: false},
		],
		rowNum:20,
		rowList:[20,40,60,100],
		height: 'auto',
		pager: '#pbattingStatistics',
		sortname: 'firstname',
		viewrecords: true,
		sortorder: "asc",
		caption:"Batting Statistics",
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
	jQuery("#battingStatistics").jqGrid('navGrid','#pbattingStatistics',
		{add:false, view:false, del:false,edit:false}, 
		{top:0,closeAfterEdit:true,reloadAfterSubmit:true,closeOnEscape:true,afterSubmit: fn_replyResponse,bottominfo:'Task can only be edited by the one who created it.'}, // edit options
		{top:0,clearAfterAdd:true,reloadAfterSubmit:true,closeOnEscape:true,afterSubmit: fn_replyResponse,bottominfo:'* Mandatory fields.'}, // add options
		{top:0,reloadAfterSubmit:true,closeOnEscape:true,afterSubmit: fn_replyResponse,bottominfo:'Task can only be deleted by the one who created it.'}, // del options
		{}, // search options
		{closeOnEscape:true} 
	);
	jQuery("#battingStatisticsSelect").change(function()
	{
		var vl = $(this).val();
		if(vl) 
		{
			if(vl == "clear") {
				jQuery("#battingStatistics").jqGrid('groupingRemove',true);
			} else {
				jQuery("#battingStatistics").jqGrid('groupingGroupBy',vl);
			}
		}
	});
});