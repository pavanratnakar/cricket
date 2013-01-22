jQuery("#register01").jqGrid({
	url:'include/registerController.php?ref=registerUser',
	datatype: "json",
	width:770,
	colNames:['Id', 'MindTree ID', 'Email', 'First Name', 'Last Name' , 'Gender' , 'Skill', 'Rating', 'Description','Base Price'],
	colModel:[
		{name:'uid',index:'uid', align:'center',editable:false, sorttype:'int',key:true,hidden:true},
		{name:'mindtreeid',formoptions:{label: 'MindTree ID *'},index:'mindtreeid', align:'center',editable:true,editrules: { required: true }},
		{name:'email',index:'email',width:300,formoptions:{label: 'Email *'}, align:'center',editable:true,editrules: { required: true, email:true }},
		{name:'firstname',index:'firstname',formoptions:{label: 'First Name *'}, align:"center",editable:true,editrules: { required: true}},
		{name:'lastname',index:'lastname',formoptions:{label: 'Last Name*'}, align:"center",editable:true,editrules: { required: true}},
		{name:'sexselect',index:'sexselect', formoptions:{label: 'Gender *'}, align:"center", editable: true,hidden:true,editrules: { required: true, edithidden:true } ,edittype:"select",editoptions:{value:"1:Male;2:Female"}},
		{name:'choice',index:'choice', formoptions:{label: 'Skill *'},align:"center",editable: true,hidden:true,editrules: { required: true,edithidden:true } ,edittype:"select",editoptions:{value:"1:Batting;2:Bowling;3:All Rounder"}},
		{name:'rating',index:'rating', formoptions:{label: 'Rating *'},align:"center",editable: true,hidden:true,editrules: { required: true,edithidden:true } ,edittype:"select",editoptions:{value:"1:1-Beginner;2:2-Amature;3:3-Good;4:4-Very Good;5:5-God Like"}},
		{name:'description',index:'description', align:"center", sortable:false,editable: true,hidden:true,editrules: { required: false, edithidden:true } ,edittype:"textarea", editoptions:{rows:"2",cols:"20"}},
		{name:'base_price',index:'base_price', align:"center", sortable:true, hidden:true, editable: true,editrules: { required: false, number: true, edithidden:false}},
	],
	rowNum:20,
	rowList:[20,40,60,80,100],
	height: 'auto',
	pager: '#pregister01',
	sortname: 'firstname',
	viewrecords: true,
	sortorder: "asc",
	caption:"Player Registration",
	editurl:"include/registerController.php?ref=registerUserOperation"
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
jQuery("#register01").jqGrid('navGrid','#pregister01',
	{add:false, view:false, del:false,edit:true}, 
	{top:0,closeAfterEdit:true,reloadAfterSubmit:true,closeOnEscape:true,afterSubmit: fn_replyResponse,bottominfo:'Task can only be edited by the one who created it.'}, // edit options
	{top:0,clearAfterAdd:true,reloadAfterSubmit:true,closeOnEscape:true,afterSubmit: fn_replyResponse,bottominfo:'* Mandatory fields.'}, // add options
	{top:0,reloadAfterSubmit:true,closeOnEscape:true,afterSubmit: fn_replyResponse,bottominfo:'Task can only be deleted by the one who created it.'}, // del options
	{}, // search options
	{closeOnEscape:true} 
);