jQuery("#team02").jqGrid({
	url:'include/teamController.php?ref=teamRegister',
	datatype: "json",
	width:770,
	colNames:['Team ID', 'MindTree ID', 'Email ID', 'First Name', 'Last Name' , 'Team Name' , 'Role'],
	colModel:[
		{name:'team_id',index:'team_id', align:'center',editable:false, sorttype:'int',key:true,hidden:true},
		{name:'owner_mindtree_id',formoptions:{label: 'MindTree ID *'},index:'owner_mindtree_id', align:'center',editable:true,editrules: { required: true }},
		{name:'owner_email',index:'owner_email',width:300,formoptions:{label: 'Email *'}, align:'center',editable:true,hidden:false, editrules: { required: true, email:true }},
		{name:'owner_firstname',index:'owner_firstname',formoptions:{label: 'First Name *'}, align:"center",editable:true,editrules: { required: true}},
		{name:'owner_lastname',index:'owner_lastname', formoptions:{label: 'Last Name*'}, align:"center",editable:true,editrules: { required: true}},
		{name:'team_name',index:'team_name', formoptions:{label: 'Team Name *'}, align:"center",editable: true,hidden:false,editrules: { required: true, edithidden:true }},
		{name:'role',index:'role', formoptions:{label: 'Role *'}, align:"center",editable: true,hidden:false,editrules: { required: true, edithidden:true }}
	],
	rowNum:12,
	rowList:[12,24,36],
	height: 'auto',
	pager: '#pteam02',
	sortname: 'role',
	viewrecords: true,
	sortorder: "asc",
	caption:"Team Owner / Team Details",
	editurl:"include/teamController.php?ref=teamOperation",
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
jQuery("#team02").jqGrid('navGrid','#pteam02',
	{add:false, view:true, del:false,edit:false}, 
	{top:0,closeAfterEdit:true,reloadAfterSubmit:true,closeOnEscape:true,afterSubmit: fn_replyResponse,bottominfo:'* Mandatory fields.'}, // edit options
	{top:0,clearAfterAdd:true,reloadAfterSubmit:true,closeOnEscape:true,afterSubmit: fn_replyResponse,bottominfo:'* Mandatory fields.'}, // add options
	{top:0,reloadAfterSubmit:true,closeOnEscape:true,afterSubmit: fn_replyResponse,bottominfo:'Task can only be deleted by the one who created it.'}, // del options
	{}, // search options
	{closeOnEscape:true} 
);