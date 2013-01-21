jQuery("#statistics01").jqGrid({
	url:'include/registerController.php?ref=registerUser',
	datatype: "json",
	width:770,
	colNames:['Id', 'MindTree ID', 'Email', 'First Name', 'Last Name' , 'Gender' , 'Skill', 'Rating', 'Description', 'Base Price'],
	colModel:[
		{name:'uid',index:'uid', align:'center',editable:false, sorttype:'int',key:true,hidden:true},
		{name:'mindtreeid',formoptions:{label: 'MindTree ID *'},width:90,index:'mindtreeid', align:'center',editable:true,editrules: { required: true },summaryType:'count', summaryTpl : '({0}) Count'},
		{name:'email',index:'email',formoptions:{label: 'Email *'}, align:'center',editable:true, hidden:true, editrules: { required: true, email:true }},
		{name:'firstname',index:'firstname',formoptions:{label: 'First Name *'},width:100, align:"center",editable:true,editrules: { required: true}},
		{name:'lastname',index:'lastname', formoptions:{label: 'Last Name*'},width:100, align:"center",editable:true,hidden:false,editrules: { required: true}},
		{name:'sexselect',index:'sexselect', formoptions:{label: 'Gender *'},width:55,align:"center", editable: true,editrules: { required: true, edithidden:true } ,edittype:"select",editoptions:{value:"1:Male;2:Female"}},
		{name:'choice',index:'choice', formoptions:{label: 'Skill *'}, width:85,align:"center",editable: true,editrules: { required: true} ,edittype:"select",editoptions:{value:"1:Batting;2:Bowling;3:All Rounder"}},
		{name:'rating',index:'rating', formoptions:{label: 'Rating *'},width:55,align:"center",editable: true,editrules: { required: true} ,edittype:"select",editoptions:{value:"1:1-Beginner;2:2-Amature;3:3-Good;4:4-Very Good;5:5-God Like"}},
		{name:'description',index:'description', width:400, align:"left", sortable:false,editable: true,editrules: { required: false} ,edittype:"textarea", editoptions:{rows:"2",cols:"20"}},
		{name:'base_price',index:'base_price', align:"center", width:80,sortable:true,editable: true,editrules: { required: true},sorttype:'number',summaryType:'sum'},
	],
	rowNum:20,
	rowList:[20,40,60,80,100],
	height: 'auto',
	pager: '#pstatistics01',
	sortname: 'base_price',
	viewrecords: true,
	sortorder: "desc",
	caption:"Player Details",
	editurl:"include/registerController.php?ref=registerUserOperation",
	grouping: true,
	groupingView : {
		groupField : ['choice'],
		groupColumnShow : [true],
		groupText : ['<b>{0}</b>'],
		groupCollapse : false,
		groupOrder: ['asc'],
		groupSummary : [true],
		showSummaryOnHide: true,
		groupDataSorted : true
	},
	footerrow: true,
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
jQuery("#statistics01").jqGrid('navGrid','#pstatistics01',
	{add:false, view:true, del:false,edit:false}, 
	{top:0,closeAfterEdit:true,reloadAfterSubmit:true,closeOnEscape:true,afterSubmit: fn_replyResponse,bottominfo:'Task can only be edited by the one who created it.'}, // edit options
	{top:0,clearAfterAdd:true,reloadAfterSubmit:true,closeOnEscape:true}, // add options
	{top:0,reloadAfterSubmit:true,closeOnEscape:true,afterSubmit: fn_replyResponse,bottominfo:'Task can only be deleted by the one who created it.'}, // del options
	{}, // search options
	{closeOnEscape:true} 
);
jQuery("#chnStatistics").change(function()
{
	var vl = $(this).val();
	if(vl) 
	{
		if(vl == "clear") {
			jQuery("#statistics01").jqGrid('groupingRemove',true);
		} else {
			jQuery("#statistics01").jqGrid('groupingGroupBy',vl);
		}
	}
});